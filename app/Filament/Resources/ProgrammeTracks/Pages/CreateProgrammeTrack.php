<?php

namespace App\Filament\Resources\ProgrammeTracks\Pages;

use App\Filament\Resources\ProgrammeTracks\ProgrammeTrackResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgrammeTrack extends CreateRecord
{
    protected static string $resource = ProgrammeTrackResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
