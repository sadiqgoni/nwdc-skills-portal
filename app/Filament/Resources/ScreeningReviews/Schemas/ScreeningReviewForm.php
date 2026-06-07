<?php

namespace App\Filament\Resources\ScreeningReviews\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ScreeningReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Screening review')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('application_id')
                                ->relationship('application', 'application_number')
                                ->searchable()
                                ->required(),
                            Select::make('reviewer_id')
                                ->relationship('reviewer', 'name', fn ($query) => $query->where('role', 'admin')->where('is_active', true))
                                ->searchable(),
                            Select::make('decision')
                                ->options([
                                    'pending' => 'Pending',
                                    'under_review' => 'Under Review',
                                    'eligible' => 'Eligible',
                                    'ineligible' => 'Ineligible',
                                    'shortlisted' => 'Shortlisted',
                                    'waitlisted' => 'Waitlisted',
                                    'rejected' => 'Rejected',
                                ])
                                ->required()
                                ->default('pending'),
                            TextInput::make('score')
                                ->required()
                                ->numeric()
                                ->default(0),
                            DateTimePicker::make('reviewed_at'),
                            Textarea::make('notes')
                                ->rows(4)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
