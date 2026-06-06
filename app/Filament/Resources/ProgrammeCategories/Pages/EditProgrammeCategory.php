<?php

namespace App\Filament\Resources\ProgrammeCategories\Pages;

use App\Filament\Resources\ProgrammeCategories\ProgrammeCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProgrammeCategory extends EditRecord
{
    protected static string $resource = ProgrammeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
