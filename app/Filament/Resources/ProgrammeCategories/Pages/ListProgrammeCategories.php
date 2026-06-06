<?php

namespace App\Filament\Resources\ProgrammeCategories\Pages;

use App\Filament\Resources\ProgrammeCategories\ProgrammeCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProgrammeCategories extends ListRecords
{
    protected static string $resource = ProgrammeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
