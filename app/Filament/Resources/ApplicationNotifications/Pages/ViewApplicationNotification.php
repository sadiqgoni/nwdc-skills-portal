<?php

namespace App\Filament\Resources\ApplicationNotifications\Pages;

use App\Filament\Resources\ApplicationNotifications\ApplicationNotificationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewApplicationNotification extends ViewRecord
{
    protected static string $resource = ApplicationNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
