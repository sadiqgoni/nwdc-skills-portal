<?php

namespace App\Filament\Resources\Cohorts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CohortInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('programmeCycle.name')
                    ->label('Programme cycle'),
                TextEntry::make('programmeTrack.name')
                    ->label('Programme track')
                    ->placeholder('-'),
                TextEntry::make('trainingHub.name')
                    ->label('Training hub')
                    ->placeholder('-'),
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('starts_on')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('ends_on')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('capacity')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
