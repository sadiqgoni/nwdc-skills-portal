<?php

namespace App\Filament\Resources\ProgrammeTracks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgrammeTrackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Programme track')
                    ->icon('heroicon-o-book-open')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('programme_category_id')
                                ->relationship('programmeCategory', 'name')
                                ->required(),
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('slug')
                                ->required(),
                            TextInput::make('capacity')
                                ->required()
                                ->numeric()
                                ->default(0),
                            Toggle::make('is_active')
                                ->required(),
                            Textarea::make('description')
                                ->rows(4)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
