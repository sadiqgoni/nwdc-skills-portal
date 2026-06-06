<?php

namespace App\Filament\Resources\TrainingHubs\Pages;

use App\Filament\Resources\TrainingHubs\TrainingHubResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTrainingHub extends CreateRecord
{
    protected static string $resource = TrainingHubResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
