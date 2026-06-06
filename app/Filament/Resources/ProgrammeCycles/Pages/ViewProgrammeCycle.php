<?php

namespace App\Filament\Resources\ProgrammeCycles\Pages;

use App\Filament\Resources\ProgrammeCycles\ProgrammeCycleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProgrammeCycle extends ViewRecord
{
    protected static string $resource = ProgrammeCycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
