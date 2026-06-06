<?php

namespace App\Filament\Resources\ApplicationNotifications\Pages;

use App\Filament\Resources\ApplicationNotifications\ApplicationNotificationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicationNotification extends CreateRecord
{
    protected static string $resource = ApplicationNotificationResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
