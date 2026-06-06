<?php

namespace App\Filament\Resources\ProgrammeCycles\Pages;

use App\Filament\Resources\ProgrammeCycles\ProgrammeCycleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProgrammeCycles extends ListRecords
{
    protected static string $resource = ProgrammeCycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
