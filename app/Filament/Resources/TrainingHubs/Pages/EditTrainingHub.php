<?php

namespace App\Filament\Resources\TrainingHubs\Pages;

use App\Filament\Resources\TrainingHubs\TrainingHubResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingHub extends EditRecord
{
    protected static string $resource = TrainingHubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
