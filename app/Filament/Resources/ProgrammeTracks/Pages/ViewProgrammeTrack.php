<?php

namespace App\Filament\Resources\ProgrammeTracks\Pages;

use App\Filament\Resources\ProgrammeTracks\ProgrammeTrackResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProgrammeTrack extends ViewRecord
{
    protected static string $resource = ProgrammeTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
