<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'submitted_at' => 'datetime',
            'eligibility_passed' => 'boolean',
        ];
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(fn (): string => trim(implode(' ', array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
        ]))));
    }

    public function getIsSubmittedAttribute(): bool
    {
        return $this->submitted_at !== null && $this->status !== 'draft';
    }

    public function hasRequiredDocuments(): bool
    {
        $documentTypes = $this->documents->pluck('document_type')->all();

        return count(array_intersect(['identity_document', 'certificate', 'passport_photo'], $documentTypes)) === 3;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function programmeCycle(): BelongsTo
    {
        return $this->belongsTo(ProgrammeCycle::class);
    }

    public function programmeCategory(): BelongsTo
    {
        return $this->belongsTo(ProgrammeCategory::class);
    }

    public function programmeTrack(): BelongsTo
    {
        return $this->belongsTo(ProgrammeTrack::class);
    }

    public function stateOfOrigin(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_of_origin_id');
    }

    public function lgaOfOrigin(): BelongsTo
    {
        return $this->belongsTo(Lga::class, 'lga_of_origin_id');
    }

    public function residenceState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'residence_state_id');
    }

    public function preferredTrainingHub(): BelongsTo
    {
        return $this->belongsTo(TrainingHub::class, 'preferred_training_hub_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function screeningReviews(): HasMany
    {
        return $this->hasMany(ScreeningReview::class);
    }

    public function admission(): HasOne
    {
        return $this->hasOne(Admission::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(ApplicationNotification::class);
    }
}
