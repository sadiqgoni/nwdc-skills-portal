<?php

namespace App\Filament\Resources\TrainingHubs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TrainingHubInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('state.name')
                    ->label('State')
                    ->placeholder('-'),
                TextEntry::make('name'),
                TextEntry::make('city'),
                TextEntry::make('contact_person')
                    ->placeholder('-'),
                TextEntry::make('contact_phone')
                    ->placeholder('-'),
                TextEntry::make('capacity')
                    ->numeric(),
                TextEntry::make('address')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
