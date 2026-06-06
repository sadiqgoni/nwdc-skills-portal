<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Record & programme')
                    ->description('Application number, applicant account, programme cycle, and preferred pathway.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('application_number')
                                ->required()
                                ->maxLength(60),
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('programme_cycle_id')
                                ->relationship('programmeCycle', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('programme_category_id')
                                ->relationship('programmeCategory', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('programme_track_id')
                                ->relationship('programmeTrack', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('preferred_training_hub_id')
                                ->relationship('preferredTrainingHub', 'name')
                                ->searchable()
                                ->preload(),
                        ]),
                    ]),

                Section::make('Applicant identity')
                    ->description('Personal details submitted by the applicant.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('first_name')
                                ->required()
                                ->maxLength(120),
                            TextInput::make('middle_name')
                                ->maxLength(120),
                            TextInput::make('last_name')
                                ->required()
                                ->maxLength(120),
                            DatePicker::make('date_of_birth')
                                ->required(),
                            TextInput::make('gender')
                                ->maxLength(60),
                            TextInput::make('nin')
                                ->label('NIN')
                                ->required()
                                ->maxLength(11),
                            TextInput::make('phone')
                                ->tel()
                                ->required()
                                ->maxLength(15),
                            TextInput::make('email')
                                ->label('Email address')
                                ->email()
                                ->maxLength(255),
                        ]),
                    ]),

                Section::make('Origin, residence & education')
                    ->description('Location and educational background used for screening.')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('state_of_origin_id')
                                ->relationship('stateOfOrigin', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('lga_of_origin_id')
                                ->relationship('lgaOfOrigin', 'name')
                                ->searchable()
                                ->preload(),
                            Select::make('residence_state_id')
                                ->relationship('residenceState', 'name')
                                ->searchable()
                                ->preload(),
                            TextInput::make('education_level')
                                ->maxLength(120),
                            TextInput::make('institution')
                                ->maxLength(180),
                            TextInput::make('qualification')
                                ->maxLength(180),
                            TextInput::make('graduation_year')
                                ->numeric()
                                ->minValue(1970)
                                ->maxValue(now()->year),
                            Textarea::make('address')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make('Screening workflow')
                    ->description('Review outcome, scoring, submission timestamp, and internal notes.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'submitted' => 'Submitted',
                                    'under_review' => 'Under Review',
                                    'eligible' => 'Eligible',
                                    'ineligible' => 'Ineligible',
                                    'shortlisted' => 'Shortlisted',
                                    'waitlisted' => 'Waitlisted',
                                    'admitted' => 'Admitted',
                                    'rejected' => 'Rejected',
                                    'onboarded' => 'Onboarded',
                                ])
                                ->required()
                                ->default('draft'),
                            Toggle::make('eligibility_passed')
                                ->label('Eligibility passed')
                                ->required(),
                            TextInput::make('screening_score')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->required()
                                ->default(0),
                            DateTimePicker::make('submitted_at'),
                            Textarea::make('admin_notes')
                                ->rows(4)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
