<?php

namespace App\Filament\Resources\CohortMembers\Pages;

use App\Filament\Resources\CohortMembers\CohortMemberResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCohortMember extends ViewRecord
{
    protected static string $resource = CohortMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
