<?php

namespace App\Filament\Resources\ProgrammeCycles\Pages;

use App\Filament\Resources\ProgrammeCycles\ProgrammeCycleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProgrammeCycle extends EditRecord
{
    protected static string $resource = ProgrammeCycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
