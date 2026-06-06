<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgrammeTrack extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function programmeCategory(): BelongsTo
    {
        return $this->belongsTo(ProgrammeCategory::class);
    }

    public function trainingHubs(): BelongsToMany
    {
        return $this->belongsToMany(TrainingHub::class)
            ->withPivot('capacity')
            ->withTimestamps();
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
