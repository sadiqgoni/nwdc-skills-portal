<?php

namespace App\Filament\Resources\CohortMembers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CohortMemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('cohort.name')
                    ->label('Cohort'),
                TextEntry::make('application.id')
                    ->label('Application'),
                TextEntry::make('status'),
                TextEntry::make('onboarded_on')
                    ->date()
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
