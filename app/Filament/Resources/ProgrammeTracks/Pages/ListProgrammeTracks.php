<?php

namespace App\Filament\Resources\ProgrammeTracks\Pages;

use App\Filament\Resources\ProgrammeTracks\ProgrammeTrackResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProgrammeTracks extends ListRecords
{
    protected static string $resource = ProgrammeTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
