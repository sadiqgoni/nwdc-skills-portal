<?php

namespace App\Filament\Resources\Admissions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Admission record')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('application_id')
                                ->relationship('application', 'application_number')
                                ->searchable()
                                ->required(),
                            Select::make('training_hub_id')
                                ->relationship('trainingHub', 'name')
                                ->searchable(),
                            Select::make('status')
                                ->options([
                                    'pending' => 'Pending',
                                    'admitted' => 'Admitted',
                                    'accepted' => 'Accepted',
                                    'declined' => 'Declined',
                                    'deferred' => 'Deferred',
                                    'withdrawn' => 'Withdrawn',
                                ])
                                ->required()
                                ->default('pending'),
                            DatePicker::make('reporting_date'),
                            DateTimePicker::make('notified_at'),
                            Textarea::make('reporting_instructions')
                                ->rows(4)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
