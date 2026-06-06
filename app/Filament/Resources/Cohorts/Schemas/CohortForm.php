<?php

namespace App\Filament\Resources\Cohorts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CohortForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cohort details')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('code')
                                ->required(),
                            TextInput::make('capacity')
                                ->required()
                                ->numeric()
                                ->default(0),
                            Select::make('programme_cycle_id')
                                ->relationship('programmeCycle', 'name')
                                ->required(),
                            Select::make('programme_track_id')
                                ->relationship('programmeTrack', 'name'),
                            Select::make('training_hub_id')
                                ->relationship('trainingHub', 'name'),
                            DatePicker::make('starts_on'),
                            DatePicker::make('ends_on'),
                            Select::make('status')
                                ->options([
                                    'planned' => 'Planned',
                                    'active' => 'Active',
                                    'completed' => 'Completed',
                                    'paused' => 'Paused',
                                    'cancelled' => 'Cancelled',
                                ])
                                ->required()
                                ->default('planned'),
                        ]),
                    ]),
            ]);
    }
}
