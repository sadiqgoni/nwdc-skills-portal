<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('phone')->nullable()->unique()->after('email');
            $table->string('nin')->nullable()->unique()->after('phone');
            $table->string('role')->default('applicant')->after('password');
            $table->boolean('is_active')->default(true)->after('role');
        });

        Schema::create('states', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 10)->unique();
            $table->boolean('is_north_west')->default(true);
            $table->timestamps();
        });

        Schema::create('lgas', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['state_id', 'name']);
        });

        Schema::create('programme_cycles', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('year', 20)->default(date('Y'));
            $table->date('application_opens_on')->nullable();
            $table->date('application_closes_on')->nullable();
            $table->unsignedTinyInteger('minimum_age')->default(18);
            $table->unsignedTinyInteger('maximum_age')->default(35);
            $table->string('status')->default('draft');
            $table->unsignedInteger('total_capacity')->default(0);
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        Schema::create('programme_categories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('programme_cycle_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['programme_cycle_id', 'slug']);
        });

        Schema::create('programme_tracks', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('programme_category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedInteger('capacity')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['programme_category_id', 'slug']);
        });

        Schema::create('training_hubs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('state_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('city');
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->unsignedInteger('capacity')->default(0);
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('programme_track_training_hub', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('programme_track_id')->constrained()->cascadeOnDelete();
            $table->foreignId('training_hub_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('capacity')->default(0);
            $table->timestamps();

            $table->unique(['programme_track_id', 'training_hub_id'], 'track_hub_unique');
        });

        Schema::create('applications', function (Blueprint $table): void {
            $table->id();
            $table->string('application_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('programme_cycle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('programme_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('programme_track_id')->constrained()->cascadeOnDelete();
            $table->foreignId('state_of_origin_id')->constrained('states')->cascadeOnDelete();
            $table->foreignId('lga_of_origin_id')->nullable()->constrained('lgas')->nullOnDelete();
            $table->foreignId('residence_state_id')->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('preferred_training_hub_id')->nullable()->constrained('training_hubs')->nullOnDelete();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('nin');
            $table->string('education_level')->nullable();
            $table->string('institution')->nullable();
            $table->string('qualification')->nullable();
            $table->year('graduation_year')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('eligibility_passed')->default(false);
            $table->unsignedSmallInteger('screening_score')->default(0);
            $table->timestamp('submitted_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index(['programme_cycle_id', 'status']);
            $table->index(['state_of_origin_id', 'programme_track_id']);
        });

        Schema::create('application_documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('document_type');
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('verification_status')->default('pending');
            $table->text('review_note')->nullable();
            $table->timestamps();

            $table->unique(['application_id', 'document_type']);
        });

        Schema::create('screening_reviews', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('decision')->default('pending');
            $table->unsignedSmallInteger('score')->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('admissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('training_hub_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('pending');
            $table->date('reporting_date')->nullable();
            $table->text('reporting_instructions')->nullable();
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('cohorts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('programme_cycle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('programme_track_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('training_hub_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->unsignedInteger('capacity')->default(0);
            $table->string('status')->default('planned');
            $table->timestamps();
        });

        Schema::create('cohort_members', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('cohort_id')->constrained()->cascadeOnDelete();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('assigned');
            $table->date('onboarded_on')->nullable();
            $table->timestamps();

            $table->unique(['cohort_id', 'application_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cohort_members');
        Schema::dropIfExists('cohorts');
        Schema::dropIfExists('admissions');
        Schema::dropIfExists('screening_reviews');
        Schema::dropIfExists('application_documents');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('programme_track_training_hub');
        Schema::dropIfExists('training_hubs');
        Schema::dropIfExists('programme_tracks');
        Schema::dropIfExists('programme_categories');
        Schema::dropIfExists('programme_cycles');
        Schema::dropIfExists('lgas');
        Schema::dropIfExists('states');

        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['phone', 'nin', 'role', 'is_active']);
        });
    }
};
