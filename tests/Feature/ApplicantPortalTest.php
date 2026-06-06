<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Lga;
use App\Models\ProgrammeTrack;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApplicantPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_applicant_can_register_complete_upload_and_submit_application(): void
    {
        Storage::fake('local');
        $this->seed();

        $state = State::query()->where('name', 'Kano')->firstOrFail();
        $lga = Lga::query()->where('state_id', $state->id)->firstOrFail();
        $track = ProgrammeTrack::query()->with(['programmeCategory', 'trainingHubs'])->firstOrFail();
        $hub = $track->trainingHubs->first();

        $this->post(route('register.store'), [
            'name' => 'Amina Yusuf',
            'email' => 'amina@example.test',
            'phone' => '08030000001',
            'nin' => '12345678901',
            'date_of_birth' => '2000-01-01',
            'state_id' => $state->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('portal.application.edit'));

        $this->assertAuthenticated();

        $this->post(route('portal.application.save'), [
            'first_name' => 'Amina',
            'middle_name' => null,
            'last_name' => 'Yusuf',
            'date_of_birth' => '2000-01-01',
            'gender' => 'female',
            'phone' => '08030000001',
            'email' => 'amina@example.test',
            'nin' => '12345678901',
            'state_of_origin_id' => $state->id,
            'lga_of_origin_id' => $lga->id,
            'residence_state_id' => $state->id,
            'address' => 'No. 10 Training Road, Kano',
            'education_level' => 'Secondary',
            'institution' => 'Government Secondary School',
            'qualification' => 'SSCE',
            'graduation_year' => 2020,
            'programme_category_id' => $track->programme_category_id,
            'programme_track_id' => $track->id,
            'preferred_training_hub_id' => $hub->id,
        ])->assertRedirect(route('portal.documents'));

        $this->post(route('portal.documents.upload', 'identity_document'), [
            'document' => UploadedFile::fake()->create('identity.pdf', 128, 'application/pdf'),
        ])->assertRedirect(route('portal.documents'));

        $this->post(route('portal.documents.upload', 'certificate'), [
            'document' => UploadedFile::fake()->create('certificate.pdf', 128, 'application/pdf'),
        ])->assertRedirect(route('portal.documents'));

        $this->post(route('portal.documents.upload', 'passport_photo'), [
            'document' => UploadedFile::fake()->create('passport.jpg', 128, 'image/jpeg'),
        ])->assertRedirect(route('portal.documents'));

        $this->get(route('portal.documents.view', 'identity_document'))
            ->assertOk();

        $this->post(route('portal.application.submit'))
            ->assertRedirect(route('portal.acknowledgement'));

        $application = Application::query()->firstOrFail();

        $this->assertSame('submitted', $application->status);
        $this->assertNotNull($application->submitted_at);
        $this->assertDatabaseCount('application_documents', 3);
        $this->assertDatabaseCount('application_notifications', 2);
    }

    public function test_registration_requires_valid_contact_and_nin_details(): void
    {
        $this->seed();

        $state = State::query()->where('name', 'Kano')->firstOrFail();

        $this->from(route('register'))->post(route('register.store'), [
            'name' => 'Amina Yusuf',
            'email' => 'not-an-email',
            'phone' => '0803abc0001',
            'nin' => '123456789012',
            'date_of_birth' => '2000-01-01',
            'state_id' => $state->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('register'))
            ->assertSessionHasErrors(['email', 'phone', 'nin']);
    }

    public function test_registration_uses_eligibility_date_and_state_when_session_exists(): void
    {
        $this->seed();

        $kano = State::query()->where('name', 'Kano')->firstOrFail();
        $kaduna = State::query()->where('name', 'Kaduna')->firstOrFail();

        $this->withSession([
            'eligibility' => [
                'date_of_birth' => '2000-01-01',
                'state_id' => $kano->id,
                'age' => 26,
            ],
        ])->post(route('register.store'), [
            'name' => 'Amina Yusuf',
            'email' => 'amina@example.test',
            'phone' => '08030000001',
            'nin' => '12345678901',
            'date_of_birth' => '1970-01-01',
            'state_id' => $kaduna->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('portal.application.edit'));

        $this->assertSame([
            'date_of_birth' => '2000-01-01',
            'state_id' => $kano->id,
            'age' => 26,
        ], session('eligibility'));
    }
}
