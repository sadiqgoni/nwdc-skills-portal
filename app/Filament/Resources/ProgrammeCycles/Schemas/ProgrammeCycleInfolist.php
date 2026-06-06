<?php

namespace App\Filament\Resources\ProgrammeCycles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProgrammeCycleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('year'),
                TextEntry::make('application_opens_on')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('application_closes_on')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('minimum_age')
                    ->numeric(),
                TextEntry::make('maximum_age')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('total_capacity')
                    ->numeric(),
                TextEntry::make('summary')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
