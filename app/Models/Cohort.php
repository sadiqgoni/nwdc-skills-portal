<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cohort extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'starts_on' => 'date',
            'ends_on' => 'date',
        ];
    }

    public function programmeCycle(): BelongsTo
    {
        return $this->belongsTo(ProgrammeCycle::class);
    }

    public function programmeTrack(): BelongsTo
    {
        return $this->belongsTo(ProgrammeTrack::class);
    }

    public function trainingHub(): BelongsTo
    {
        return $this->belongsTo(TrainingHub::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(CohortMember::class);
    }
}
