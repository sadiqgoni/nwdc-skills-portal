<?php

namespace App\Filament\Resources\ApplicationNotifications;

use App\Filament\Resources\ApplicationNotifications\Pages\CreateApplicationNotification;
use App\Filament\Resources\ApplicationNotifications\Pages\EditApplicationNotification;
use App\Filament\Resources\ApplicationNotifications\Pages\ListApplicationNotifications;
use App\Filament\Resources\ApplicationNotifications\Pages\ViewApplicationNotification;
use App\Filament\Resources\ApplicationNotifications\Schemas\ApplicationNotificationForm;
use App\Filament\Resources\ApplicationNotifications\Schemas\ApplicationNotificationInfolist;
use App\Filament\Resources\ApplicationNotifications\Tables\ApplicationNotificationsTable;
use App\Models\ApplicationNotification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApplicationNotificationResource extends Resource
{
    protected static ?string $model = ApplicationNotification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBellAlert;

    protected static string|\UnitEnum|null $navigationGroup = 'Screening & Admissions';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ApplicationNotificationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApplicationNotificationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationNotificationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApplicationNotifications::route('/'),
            'create' => CreateApplicationNotification::route('/create'),
            'view' => ViewApplicationNotification::route('/{record}'),
            'edit' => EditApplicationNotification::route('/{record}/edit'),
        ];
    }
}
