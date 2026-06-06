<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgrammeCycle extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'application_opens_on' => 'date',
            'application_closes_on' => 'date',
        ];
    }

    public function categories(): HasMany
    {
        return $this->hasMany(ProgrammeCategory::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function cohorts(): HasMany
    {
        return $this->hasMany(Cohort::class);
    }
}
