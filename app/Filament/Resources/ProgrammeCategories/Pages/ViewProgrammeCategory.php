<?php

namespace App\Filament\Resources\ProgrammeCategories\Pages;

use App\Filament\Resources\ProgrammeCategories\ProgrammeCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProgrammeCategory extends ViewRecord
{
    protected static string $resource = ProgrammeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
