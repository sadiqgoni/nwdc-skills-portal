<?php

namespace App\Filament\Resources\ApplicationNotifications\Pages;

use App\Filament\Resources\ApplicationNotifications\ApplicationNotificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApplicationNotifications extends ListRecords
{
    protected static string $resource = ApplicationNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
