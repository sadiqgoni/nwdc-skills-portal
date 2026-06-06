<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admission extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'reporting_date' => 'date',
            'notified_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function trainingHub(): BelongsTo
    {
        return $this->belongsTo(TrainingHub::class);
    }
}
