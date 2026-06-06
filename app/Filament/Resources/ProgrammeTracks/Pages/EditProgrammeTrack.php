<?php

namespace App\Filament\Resources\ProgrammeTracks\Pages;

use App\Filament\Resources\ProgrammeTracks\ProgrammeTrackResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProgrammeTrack extends EditRecord
{
    protected static string $resource = ProgrammeTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
