<?php

namespace App\Filament\Resources\CohortMembers\Pages;

use App\Filament\Resources\CohortMembers\CohortMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCohortMembers extends ListRecords
{
    protected static string $resource = CohortMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
