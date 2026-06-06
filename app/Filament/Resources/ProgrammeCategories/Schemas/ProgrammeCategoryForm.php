<?php

namespace App\Filament\Resources\ProgrammeCategories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgrammeCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Programme category')
                    ->icon('heroicon-o-squares-2x2')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('programme_cycle_id')
                                ->relationship('programmeCycle', 'name')
                                ->required(),
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('slug')
                                ->required(),
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
