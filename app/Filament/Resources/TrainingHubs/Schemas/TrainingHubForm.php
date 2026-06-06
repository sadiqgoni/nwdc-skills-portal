<?php

namespace App\Filament\Resources\TrainingHubs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingHubForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Training hub')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('state_id')
                                ->relationship('state', 'name'),
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('city')
                                ->required(),
                            TextInput::make('capacity')
                                ->required()
                                ->numeric()
                                ->default(0),
                            TextInput::make('contact_person'),
                            TextInput::make('contact_phone')
                                ->tel(),
                            Toggle::make('is_active')
                                ->required(),
                            Textarea::make('address')
                                ->rows(4)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
