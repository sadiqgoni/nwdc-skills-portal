<?php

use App\Http\Controllers\Portal\ApplicationController;
use App\Http\Controllers\Portal\AuthController;
use App\Models\ProgrammeCycle;
use App\Models\ProgrammeTrack;
use App\Models\State;
use App\Models\TrainingHub;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $cycle = ProgrammeCycle::query()->where('status', 'active')->latest('id')->first();

    return view('welcome', [
        'cycle' => $cycle,
        'trackCount' => ProgrammeTrack::query()->where('is_active', true)->count(),
        'hubCount' => TrainingHub::query()->where('is_active', true)->count(),
        'stateCount' => State::query()->where('is_north_west', true)->count(),
    ]);
})->name('home');

Route::get('/eligibility', function () {
    $cycle = ProgrammeCycle::query()->where('status', 'active')->latest('id')->first();
    $minimumAge = $cycle?->minimum_age ?? 18;
    $maximumAge = $cycle?->maximum_age ?? 35;

    return view('eligibility', [
        'states' => State::query()->where('is_north_west', true)->orderBy('name')->get(),
        'result' => null,
        'minimumDateOfBirth' => now()->subYears($maximumAge + 1)->addDay()->toDateString(),
        'maximumDateOfBirth' => now()->subYears($minimumAge)->toDateString(),
        'minimumAge' => $minimumAge,
        'maximumAge' => $maximumAge,
    ]);
})->name('eligibility');

Route::post('/eligibility', function (Request $request) {
    $data = $request->validate([
        'date_of_birth' => ['required', 'date', 'before:today'],
        'state_id' => ['required', 'exists:states,id'],
    ], [
        'date_of_birth.before' => 'Enter your real date of birth. Applicants for this cycle must already be within the approved age range.',
        'date_of_birth.required' => 'Please select your date of birth.',
        'state_id.required' => 'Please select your state of origin.',
    ]);

    $age = Carbon::parse($data['date_of_birth'])->age;
    $state = State::query()->findOrFail($data['state_id']);
    $cycle = ProgrammeCycle::query()->where('status', 'active')->latest('id')->first();
    $minimumAge = $cycle?->minimum_age ?? 18;
    $maximumAge = $cycle?->maximum_age ?? 35;
    $passed = $state->is_north_west && $age >= $minimumAge && $age <= $maximumAge;

    if ($passed) {
        session()->put('eligibility', [
            'date_of_birth' => $data['date_of_birth'],
            'state_id' => (int) $data['state_id'],
            'age' => $age,
        ]);
    }

    $result = [
        'passed' => $passed,
        'age' => $age,
        'state' => $state->name,
        'message' => $passed
            ? 'Your details meet the first-stage requirements for this programme cycle.'
            : 'Applications in this cycle are restricted to eligible applicants aged ' . $minimumAge . '-' . $maximumAge . ' from participating states.',
        'redirect' => $passed
            ? (auth()->check() ? route('portal.application.edit') : route('register'))
            : null,
    ];

    if ($request->expectsJson()) {
        return response()->json($result);
    }

    return view('eligibility', [
        'states' => State::query()->where('is_north_west', true)->orderBy('name')->get(),
        'result' => $result,
        'minimumDateOfBirth' => now()->subYears($maximumAge + 1)->addDay()->toDateString(),
        'maximumDateOfBirth' => now()->subYears($minimumAge)->toDateString(),
        'minimumAge' => $minimumAge,
        'maximumAge' => $maximumAge,
    ]);
})->name('eligibility.check');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('portal')->name('portal.')->group(function (): void {
    Route::get('/', [ApplicationController::class, 'dashboard'])->name('dashboard');
    Route::get('/application', [ApplicationController::class, 'edit'])->name('application.edit');
    Route::post('/application', [ApplicationController::class, 'save'])->name('application.save');
    Route::get('/documents', [ApplicationController::class, 'documents'])->name('documents');
    Route::get('/documents/{type}/view', [ApplicationController::class, 'viewDocument'])->name('documents.view');
    Route::post('/documents/{type}', [ApplicationController::class, 'uploadDocument'])->name('documents.upload');
    Route::post('/submit', [ApplicationController::class, 'submit'])->name('application.submit');
    Route::get('/acknowledgement', [ApplicationController::class, 'acknowledgement'])->name('acknowledgement');
});
