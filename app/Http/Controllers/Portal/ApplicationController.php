<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\Lga;
use App\Models\ProgrammeCategory;
use App\Models\ProgrammeCycle;
use App\Models\ProgrammeTrack;
use App\Models\State;
use App\Models\TrainingHub;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
    public function dashboard()
    {
        return view('portal.dashboard', [
            'application' => $this->currentApplication()?->load([
                'programmeCycle',
                'programmeCategory',
                'programmeTrack',
                'stateOfOrigin',
                'preferredTrainingHub',
                'documents',
                'admission.trainingHub',
                'latestScreeningReview.reviewer',
            ]),
            'cycle' => $this->activeCycle(),
        ]);
    }

    public function edit()
    {
        $cycle = $this->activeCycle();

        if (! $cycle) {
            return redirect()->route('portal.dashboard')->with('error', 'No active programme cycle is currently open.');
        }

        $application = $this->currentApplication();
        $user = Auth::user();
        $eligibility = session('eligibility');
        $stateOfOriginId = data_get($eligibility, 'state_id') ?? $application?->state_of_origin_id;

        return view('portal.application', [
            'application' => $application,
            'cycle' => $cycle,
            'identity' => [
                'full_name' => $user->name,
                'date_of_birth' => data_get($eligibility, 'date_of_birth') ?? $application?->date_of_birth?->format('Y-m-d'),
                'phone' => $user->phone,
                'email' => $user->email,
                'nin' => $user->nin,
                'state_of_origin_id' => $stateOfOriginId,
                'state_of_origin' => $stateOfOriginId ? State::query()->find($stateOfOriginId)?->name : null,
            ],
            'categories' => ProgrammeCategory::query()
                ->where('programme_cycle_id', $cycle->id)
                ->where('is_active', true)
                ->with(['tracks' => fn ($query) => $query->where('is_active', true)->orderBy('name')])
                ->orderBy('name')
                ->get(),
            'tracks' => ProgrammeTrack::query()
                ->whereHas('programmeCategory', fn ($query) => $query->where('programme_cycle_id', $cycle->id))
                ->where('is_active', true)
                ->with(['programmeCategory', 'trainingHubs:id,state_id,name,city'])
                ->orderBy('name')
                ->get(),
            'states' => State::query()->where('is_north_west', true)->orderBy('name')->get(),
            'lgas' => Lga::query()
                ->when($stateOfOriginId, fn ($query) => $query->where('state_id', $stateOfOriginId))
                ->orderBy('name')
                ->get(),
            'hubs' => TrainingHub::query()->where('is_active', true)->with('state')->orderBy('city')->get(),
            'eligibility' => $eligibility,
        ]);
    }

    public function save(Request $request)
    {
        $cycle = $this->activeCycle();

        if (! $cycle) {
            return redirect()->route('portal.dashboard')->with('error', 'No active programme cycle is currently open.');
        }

        $application = $this->currentApplication();
        $user = Auth::user();
        $eligibility = session('eligibility');
        $nameParts = $this->splitFullName($user->name);
        $lockedDateOfBirth = data_get($eligibility, 'date_of_birth') ?? $application?->date_of_birth?->format('Y-m-d') ?? $request->input('date_of_birth');
        $lockedStateOfOriginId = data_get($eligibility, 'state_id') ?? $application?->state_of_origin_id ?? $request->input('state_of_origin_id');

        if ($application?->is_submitted) {
            return redirect()->route('portal.dashboard')->with('error', 'Submitted applications cannot be edited from the applicant portal.');
        }

        $request->merge([
            'first_name' => $nameParts['first_name'],
            'middle_name' => $nameParts['middle_name'],
            'last_name' => $nameParts['last_name'],
            'date_of_birth' => $lockedDateOfBirth,
            'phone' => $user->phone,
            'email' => $user->email,
            'nin' => $user->nin,
            'state_of_origin_id' => $lockedStateOfOriginId,
        ]);

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'middle_name' => ['nullable', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::in(['male', 'female', 'prefer_not_to_say'])],
            'phone' => ['required', 'digits_between:10,15', Rule::unique('users', 'phone')->ignore(Auth::id())],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(Auth::id())],
            'nin' => ['required', 'digits:11', Rule::unique('users', 'nin')->ignore(Auth::id())],
            'state_of_origin_id' => ['required', 'exists:states,id'],
            'lga_of_origin_id' => ['required', 'exists:lgas,id'],
            'residence_state_id' => ['nullable', 'exists:states,id'],
            'address' => ['required', 'string', 'max:1000'],
            'education_level' => ['required', 'string', 'max:120'],
            'institution' => ['nullable', 'string', 'max:180'],
            'qualification' => ['nullable', 'string', 'max:180'],
            'graduation_year' => ['nullable', 'integer', 'min:1970', 'max:' . now()->year],
            'programme_category_id' => [
                'required',
                Rule::exists('programme_categories', 'id')
                    ->where('programme_cycle_id', $cycle->id)
                    ->where('is_active', true),
            ],
            'programme_track_id' => ['required', 'exists:programme_tracks,id'],
            'preferred_training_hub_id' => ['required', 'exists:training_hubs,id'],
        ]);

        $state = State::query()->findOrFail($data['state_of_origin_id']);
        $age = Carbon::parse($data['date_of_birth'])->age;
        $eligibilityPassed = $state->is_north_west && $age >= $cycle->minimum_age && $age <= $cycle->maximum_age;

        if (! $eligibilityPassed) {
            throw ValidationException::withMessages([
                'date_of_birth' => 'Applicants must be aged ' . $cycle->minimum_age . '-' . $cycle->maximum_age . ' and from a North-West state for this cycle.',
            ]);
        }

        if (! Lga::query()->whereKey($data['lga_of_origin_id'])->where('state_id', $state->id)->exists()) {
            throw ValidationException::withMessages([
                'lga_of_origin_id' => 'Select an LGA that belongs to your state of origin.',
            ]);
        }

        $track = ProgrammeTrack::query()
            ->whereKey($data['programme_track_id'])
            ->where('programme_category_id', $data['programme_category_id'])
            ->where('is_active', true)
            ->first();

        if (! $track) {
            throw ValidationException::withMessages([
                'programme_track_id' => 'Select a track under the chosen programme category.',
            ]);
        }

        $stateHubId = $track->trainingHubs()
            ->where('training_hubs.is_active', true)
            ->where('training_hubs.state_id', $state->id)
            ->orderBy('training_hubs.city')
            ->value('training_hubs.id');

        if (! $stateHubId) {
            throw ValidationException::withMessages([
                'preferred_training_hub_id' => 'No training hub in your state currently offers the selected track.',
            ]);
        }

        $data['preferred_training_hub_id'] = $stateHubId;

        if (! $track->trainingHubs()->whereKey($data['preferred_training_hub_id'])->exists()) {
            throw ValidationException::withMessages([
                'preferred_training_hub_id' => 'Select a hub that offers your selected track.',
            ]);
        }

        $payload = [
            ...$data,
            'user_id' => Auth::id(),
            'programme_cycle_id' => $cycle->id,
            'status' => 'draft',
            'eligibility_passed' => true,
        ];

        $application = Application::query()->updateOrCreate(
            ['user_id' => Auth::id(), 'programme_cycle_id' => $cycle->id],
            [
                ...$payload,
                'application_number' => $application?->application_number ?? $this->generateApplicationNumber($cycle),
            ]
        );

        session()->put('eligibility', [
            'date_of_birth' => $data['date_of_birth'],
            'state_id' => (int) $data['state_of_origin_id'],
            'age' => $age,
        ]);

        return redirect()->route('portal.documents')->with('success', 'Application draft saved. Upload the required documents before submission.');
    }

    public function documents()
    {
        $application = $this->currentApplication()?->load('documents');

        if (! $application) {
            return redirect()->route('portal.application.edit')->with('error', 'Complete your application details before uploading documents.');
        }

        return view('portal.documents', [
            'application' => $application,
            'documentTypes' => $this->documentTypes(),
        ]);
    }

    public function uploadDocument(Request $request, string $type)
    {
        $documentTypes = $this->documentTypes();

        if (! array_key_exists($type, $documentTypes)) {
            abort(404);
        }

        $application = $this->currentApplication();

        if (! $application) {
            return redirect()->route('portal.application.edit')->with('error', 'Complete your application details before uploading documents.');
        }

        if ($application->is_submitted) {
            return redirect()->route('portal.documents')->with('error', 'Submitted application documents cannot be changed from the applicant portal.');
        }

        $request->validate([
            'document' => [
                'required',
                'file',
                $type === 'passport_photo' ? 'mimes:jpg,jpeg,png' : 'mimes:pdf,jpg,jpeg,png',
                'max:' . ($type === 'passport_photo' ? 2048 : 4096),
            ],
        ]);

        $file = $request->file('document');
        $existing = $application->documents()->where('document_type', $type)->first();

        if ($existing) {
            Storage::disk('local')->delete($existing->file_path);
        }

        $path = $file->store('applications/' . $application->application_number, 'local');

        ApplicationDocument::query()->updateOrCreate(
            ['application_id' => $application->id, 'document_type' => $type],
            [
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'verification_status' => 'pending',
                'review_note' => null,
            ]
        );

        return redirect()->route('portal.documents')->with('success', $documentTypes[$type]['label'] . ' uploaded.');
    }

    public function viewDocument(string $type)
    {
        if (! array_key_exists($type, $this->documentTypes())) {
            abort(404);
        }

        $application = $this->currentApplication();

        if (! $application) {
            abort(404);
        }

        $document = $application->documents()
            ->where('document_type', $type)
            ->firstOrFail();

        if (! Storage::disk('local')->exists($document->file_path)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($document->file_path), [
            'Content-Type' => $document->mime_type ?: 'application/octet-stream',
        ]);
    }

    public function submit()
    {
        $application = $this->currentApplication()?->load('documents');

        if (! $application) {
            return redirect()->route('portal.application.edit')->with('error', 'Complete your application details before submission.');
        }

        if ($application->is_submitted) {
            return redirect()->route('portal.acknowledgement')->with('success', 'Your application has already been submitted.');
        }

        if (! $application->eligibility_passed) {
            return redirect()->route('portal.application.edit')->with('error', 'Eligibility must pass before submission.');
        }

        if (! $application->hasRequiredDocuments()) {
            return redirect()->route('portal.documents')->with('error', 'Upload all required documents before submitting.');
        }

        $application->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        $application = $application->fresh();

        $this->assignScreeningReview($application);
        $this->queueAcknowledgements($application);

        return redirect()->route('portal.acknowledgement')->with('success', 'Application submitted. Your acknowledgement has been generated.');
    }

    public function acknowledgement()
    {
        $application = $this->currentApplication()?->load([
            'programmeCycle',
            'programmeCategory',
            'programmeTrack',
            'stateOfOrigin',
            'lgaOfOrigin',
            'preferredTrainingHub',
            'documents',
            'notifications',
            'latestScreeningReview.reviewer',
            'admission.trainingHub',
        ]);

        if (! $application || ! $application->submitted_at) {
            return redirect()->route('portal.dashboard')->with('error', 'Submit your application before viewing acknowledgement.');
        }

        return view('portal.acknowledgement', [
            'application' => $application,
        ]);
    }

    private function activeCycle(): ?ProgrammeCycle
    {
        return ProgrammeCycle::query()->where('status', 'active')->latest('id')->first();
    }

    private function currentApplication(): ?Application
    {
        $cycle = $this->activeCycle();

        if (! $cycle) {
            return null;
        }

        return Application::query()
            ->where('user_id', Auth::id())
            ->where('programme_cycle_id', $cycle->id)
            ->latest('id')
            ->first();
    }

    private function generateApplicationNumber(ProgrammeCycle $cycle): string
    {
        do {
            $number = 'NWDC-' . $cycle->year . '-' . Str::upper(Str::random(6));
        } while (Application::query()->where('application_number', $number)->exists());

        return $number;
    }

    private function assignScreeningReview(Application $application): void
    {
        if ($application->screeningReviews()->exists()) {
            return;
        }

        $reviewer = User::query()
            ->where('role', 'admin')
            ->where('is_active', true)
            ->withCount([
                'assignedScreeningReviews as open_screening_reviews_count' => fn ($query) => $query
                    ->whereIn('decision', ['pending', 'under_review']),
            ])
            ->orderBy('open_screening_reviews_count')
            ->orderBy('id')
            ->first();

        $application->screeningReviews()->create([
            'reviewer_id' => $reviewer?->id,
            'decision' => 'pending',
            'score' => 0,
            'notes' => $reviewer
                ? 'Automatically assigned for screening.'
                : 'Pending assignment because no active admin reviewer is available.',
        ]);
    }

    private function documentTypes(): array
    {
        return [
            'identity_document' => [
                'label' => 'Identity',
                'hint' => 'NIN slip, voter card, licence, or passport.',
            ],
            'certificate' => [
                'label' => 'Certificate',
                'hint' => 'Result, certificate, or trade evidence.',
            ],
            'passport_photo' => [
                'label' => 'Passport photo',
                'hint' => 'Recent JPG or PNG passport photo.',
            ],
        ];
    }

    private function queueAcknowledgements(Application $application): void
    {
        $message = 'Your NWDC application ' . $application->application_number . ' has been received. Log in to the portal for screening and admission updates.';

        $application->notifications()->updateOrCreate(
            ['channel' => 'sms'],
            [
                'recipient' => $application->phone,
                'body' => $message,
                'status' => 'queued',
            ]
        );

        if ($application->email) {
            $application->notifications()->updateOrCreate(
                ['channel' => 'email'],
                [
                    'recipient' => $application->email,
                    'subject' => 'NWDC application received',
                    'body' => $message,
                    'status' => 'queued',
                ]
            );
        }
    }

    private function splitFullName(string $name): array
    {
        $parts = collect(preg_split('/\s+/', trim($name)) ?: [])
            ->filter()
            ->values();

        $firstName = $parts->first() ?: $name;
        $lastName = $parts->count() > 1 ? $parts->last() : $firstName;
        $middleName = $parts->count() > 2
            ? $parts->slice(1, -1)->implode(' ')
            : null;

        return [
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
        ];
    }
}
