<?php

namespace App\Filament\Resources\ProgrammeCategories\Pages;

use App\Filament\Resources\ProgrammeCategories\ProgrammeCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgrammeCategory extends CreateRecord
{
    protected static string $resource = ProgrammeCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
