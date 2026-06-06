<?php

namespace App\Filament\Resources\CohortMembers\Pages;

use App\Filament\Resources\CohortMembers\CohortMemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCohortMember extends CreateRecord
{
    protected static string $resource = CohortMemberResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
