<?php

namespace App\Filament\Resources\ApplicationNotifications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicationNotificationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('application.application_number')
                    ->label('Application'),
                TextEntry::make('channel')
                    ->badge(),
                TextEntry::make('recipient'),
                TextEntry::make('subject')
                    ->placeholder('-'),
                TextEntry::make('body')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('provider_response')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('sent_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime(),
            ]);
    }
}
