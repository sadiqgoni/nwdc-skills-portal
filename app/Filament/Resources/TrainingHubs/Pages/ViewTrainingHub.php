<?php

namespace App\Filament\Resources\TrainingHubs\Pages;

use App\Filament\Resources\TrainingHubs\TrainingHubResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrainingHub extends ViewRecord
{
    protected static string $resource = TrainingHubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
