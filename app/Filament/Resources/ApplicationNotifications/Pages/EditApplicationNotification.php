<?php

namespace App\Filament\Resources\ApplicationNotifications\Pages;

use App\Filament\Resources\ApplicationNotifications\ApplicationNotificationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicationNotification extends EditRecord
{
    protected static string $resource = ApplicationNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
