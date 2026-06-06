<?php

namespace App\Filament\Resources\CohortMembers\Pages;

use App\Filament\Resources\CohortMembers\CohortMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCohortMember extends EditRecord
{
    protected static string $resource = CohortMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
