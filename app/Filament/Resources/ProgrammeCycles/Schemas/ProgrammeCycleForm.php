<?php

namespace App\Filament\Resources\ProgrammeCycles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgrammeCycleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Programme cycle')
                    ->icon('heroicon-o-calendar-date-range')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('slug')
                                ->required(),
                            TextInput::make('year')
                                ->required()
                                ->default('2026'),
                            DatePicker::make('application_opens_on'),
                            DatePicker::make('application_closes_on'),
                            TextInput::make('status')
                                ->required()
                                ->default('draft'),
                            TextInput::make('minimum_age')
                                ->required()
                                ->numeric()
                                ->default(18),
                            TextInput::make('maximum_age')
                                ->required()
                                ->numeric()
                                ->default(35),
                            TextInput::make('total_capacity')
                                ->required()
                                ->numeric()
                                ->default(0),
                            Textarea::make('summary')
                                ->rows(3)
                                ->columnSpanFull(),
                            Textarea::make('description')
                                ->rows(5)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
