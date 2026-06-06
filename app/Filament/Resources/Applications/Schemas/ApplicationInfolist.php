<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Application overview')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(4)->schema([
                            TextEntry::make('application_number')
                                ->label('Application No.')
                                ->copyable()
                                ->weight(FontWeight::Bold),
                            TextEntry::make('status')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'submitted', 'under_review' => 'warning',
                                    'eligible', 'shortlisted', 'admitted', 'onboarded' => 'success',
                                    'waitlisted' => 'info',
                                    'ineligible', 'rejected' => 'danger',
                                    default => 'gray',
                                }),
                            IconEntry::make('eligibility_passed')
                                ->label('Eligibility')
                                ->boolean(),
                            TextEntry::make('screening_score')
                                ->numeric()
                                ->suffix('/100'),
                            TextEntry::make('programmeCycle.name')
                                ->label('Programme cycle'),
                            TextEntry::make('programmeCategory.name')
                                ->label('Programme category'),
                            TextEntry::make('programmeTrack.name')
                                ->label('Programme track'),
                            TextEntry::make('preferredTrainingHub.name')
                                ->label('Preferred hub')
                                ->placeholder('-'),
                        ]),
                    ]),

                Section::make('Applicant identity')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('full_name')
                                ->label('Full name')
                                ->weight(FontWeight::Bold),
                            TextEntry::make('date_of_birth')
                                ->date(),
                            TextEntry::make('gender')
                                ->placeholder('-'),
                            TextEntry::make('phone')
                                ->copyable(),
                            TextEntry::make('email')
                                ->label('Email address')
                                ->copyable()
                                ->placeholder('-'),
                            TextEntry::make('nin')
                                ->label('NIN')
                                ->copyable(),
                        ]),
                    ]),

                Section::make('Origin, residence & education')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('stateOfOrigin.name')
                                ->label('State of origin'),
                            TextEntry::make('lgaOfOrigin.name')
                                ->label('LGA of origin')
                                ->placeholder('-'),
                            TextEntry::make('residenceState.name')
                                ->label('Residence state')
                                ->placeholder('-'),
                            TextEntry::make('education_level')
                                ->placeholder('-'),
                            TextEntry::make('institution')
                                ->placeholder('-'),
                            TextEntry::make('qualification')
                                ->placeholder('-'),
                            TextEntry::make('graduation_year')
                                ->numeric()
                                ->placeholder('-'),
                            TextEntry::make('address')
                                ->placeholder('-')
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make('Admin notes & timestamps')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('submitted_at')
                                ->dateTime()
                                ->placeholder('-'),
                            TextEntry::make('created_at')
                                ->dateTime()
                                ->placeholder('-'),
                            TextEntry::make('updated_at')
                                ->dateTime()
                                ->placeholder('-'),
                            TextEntry::make('admin_notes')
                                ->placeholder('-')
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
