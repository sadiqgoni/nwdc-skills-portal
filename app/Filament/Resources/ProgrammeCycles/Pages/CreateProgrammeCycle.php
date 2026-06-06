<?php

namespace App\Filament\Resources\ProgrammeCycles\Pages;

use App\Filament\Resources\ProgrammeCycles\ProgrammeCycleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgrammeCycle extends CreateRecord
{
    protected static string $resource = ProgrammeCycleResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
