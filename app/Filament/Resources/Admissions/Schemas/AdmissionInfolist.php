<?php

namespace App\Filament\Resources\Admissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AdmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('application.id')
                    ->label('Application'),
                TextEntry::make('trainingHub.name')
                    ->label('Training hub')
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('reporting_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('reporting_instructions')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('notified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
