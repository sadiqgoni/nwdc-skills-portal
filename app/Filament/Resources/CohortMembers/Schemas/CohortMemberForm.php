<?php

namespace App\Filament\Resources\CohortMembers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CohortMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cohort assignment')
                    ->icon('heroicon-o-users')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('cohort_id')
                                ->relationship('cohort', 'name')
                                ->searchable()
                                ->required(),
                            Select::make('application_id')
                                ->relationship('application', 'application_number')
                                ->searchable()
                                ->required(),
                            Select::make('status')
                                ->options([
                                    'assigned' => 'Assigned',
                                    'onboarded' => 'Onboarded',
                                    'deferred' => 'Deferred',
                                    'dropped' => 'Dropped',
                                    'completed' => 'Completed',
                                ])
                                ->required()
                                ->default('assigned'),
                            DatePicker::make('onboarded_on'),
                        ]),
                    ]),
            ]);
    }
}
