<?php

namespace App\Filament\Resources\TrainingHubs\Pages;

use App\Filament\Resources\TrainingHubs\TrainingHubResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingHubs extends ListRecords
{
    protected static string $resource = TrainingHubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
