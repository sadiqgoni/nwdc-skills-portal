<?php

namespace App\Filament\Resources\Applications\Tables;

use App\Models\Application;
use App\Models\Lga;
use App\Models\State;
use App\Models\TrainingHub;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application_number')
                    ->label('Application No.')
                    ->searchable(),
                TextColumn::make('full_name')
                    ->label('Applicant')
                    ->searchable(['first_name', 'middle_name', 'last_name']),
                TextColumn::make('programmeCycle.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('programmeCategory.name')
                    ->searchable(),
                TextColumn::make('programmeTrack.name')
                    ->searchable(),
                TextColumn::make('stateOfOrigin.name')
                    ->label('State')
                    ->searchable(),
                TextColumn::make('lgaOfOrigin.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('residenceState.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('preferredTrainingHub.name')
                    ->searchable(),
                TextColumn::make('latestScreeningReview.reviewer.name')
                    ->label('Assigned reviewer')
                    ->placeholder('Unassigned')
                    ->searchable(),
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nin')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('education_level')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('institution')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('qualification')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('graduation_year')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'submitted', 'under_review' => 'warning',
                        'eligible', 'shortlisted', 'admitted', 'onboarded' => 'success',
                        'waitlisted' => 'info',
                        'ineligible', 'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                IconColumn::make('eligibility_passed')
                    ->label('Eligibility')
                    ->boolean(),
                TextColumn::make('screening_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
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
                    ]),
                SelectFilter::make('programme_category_id')
                    ->relationship('programmeCategory', 'name'),
                SelectFilter::make('programme_track_id')
                    ->relationship('programmeTrack', 'name'),
                SelectFilter::make('state_of_origin_id')
                    ->label('State')
                    ->options(fn (): array => State::query()->where('is_north_west', true)->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable(),
                SelectFilter::make('lga_of_origin_id')
                    ->label('LGA')
                    ->options(fn (): array => Lga::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable(),
                SelectFilter::make('preferred_training_hub_id')
                    ->relationship('preferredTrainingHub', 'name'),
            ])
            ->recordActions([
                ActionGroup::make([
                ViewAction::make()
                    ->label('View details')
                    ->icon('heroicon-o-eye'),
                EditAction::make()
                    ->label('Edit record')
                    ->icon('heroicon-o-pencil-square'),
                Action::make('screen')
                    ->label('Screen')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('warning')
                    ->modalHeading('Screen application')
                    ->modalDescription('Record a screening decision and score for this applicant.')
                    ->visible(fn (Application $record): bool => $record->status !== 'draft')
                    ->form([
                        Select::make('decision')
                            ->options([
                                'under_review' => 'Under review',
                                'eligible' => 'Eligible',
                                'ineligible' => 'Ineligible',
                                'shortlisted' => 'Shortlisted',
                                'waitlisted' => 'Waitlisted',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('under_review'),
                        TextInput::make('score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->default(0),
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ])
                    ->action(function (Application $record, array $data): void {
                        $review = $record->screeningReviews()
                            ->whereIn('decision', ['pending', 'under_review'])
                            ->latest('id')
                            ->first();

                        if ($review) {
                            $review->update([
                                'reviewer_id' => $review->reviewer_id ?: auth()->id(),
                                'decision' => $data['decision'],
                                'score' => $data['score'],
                                'notes' => $data['notes'] ?? $review->notes,
                                'reviewed_at' => now(),
                            ]);
                        } else {
                            $record->screeningReviews()->create([
                                'reviewer_id' => auth()->id(),
                                'decision' => $data['decision'],
                                'score' => $data['score'],
                                'notes' => $data['notes'] ?? null,
                                'reviewed_at' => now(),
                            ]);
                        }

                        $record->update([
                            'status' => $data['decision'],
                            'screening_score' => $data['score'],
                        ]);
                    }),
                Action::make('admit')
                    ->label('Admit')
                    ->icon('heroicon-o-academic-cap')
                    ->color('success')
                    ->modalHeading('Admit applicant')
                    ->modalDescription('Assign reporting hub and instructions for the admitted applicant.')
                    ->visible(fn (Application $record): bool => in_array($record->status, ['eligible', 'shortlisted', 'admitted'], true))
                    ->form([
                        Select::make('training_hub_id')
                            ->options(fn (Application $record): array => TrainingHub::query()
                                ->where('is_active', true)
                                ->whereHas('programmeTracks', fn ($query) => $query->whereKey($record->programme_track_id))
                                ->with('state')
                                ->get()
                                ->sortBy(fn (TrainingHub $hub): string => ($hub->state_id === $record->state_of_origin_id ? '0' : '1') . $hub->city . $hub->name)
                                ->mapWithKeys(fn (TrainingHub $hub): array => [
                                    $hub->id => trim(($hub->state?->name ? $hub->state->name . ' - ' : '') . $hub->name),
                                ])
                                ->all())
                            ->default(fn (Application $record): ?int => TrainingHub::query()
                                ->where('is_active', true)
                                ->whereHas('programmeTracks', fn ($query) => $query->whereKey($record->programme_track_id))
                                ->where('state_id', $record->state_of_origin_id)
                                ->orderBy('city')
                                ->value('id') ?? TrainingHub::query()
                                    ->where('is_active', true)
                                    ->whereHas('programmeTracks', fn ($query) => $query->whereKey($record->programme_track_id))
                                    ->orderBy('city')
                                    ->value('id'))
                            ->required(),
                        DatePicker::make('reporting_date'),
                        Textarea::make('reporting_instructions')
                            ->default('Report with your acknowledgement slip, original credentials, valid ID, and two passport photographs.')
                            ->columnSpanFull(),
                    ])
                    ->requiresConfirmation()
                    ->action(function (Application $record, array $data): void {
                        $record->admission()->updateOrCreate(
                            [],
                            [
                                'training_hub_id' => $data['training_hub_id'],
                                'status' => 'admitted',
                                'reporting_date' => $data['reporting_date'] ?? null,
                                'reporting_instructions' => $data['reporting_instructions'] ?? null,
                                'notified_at' => now(),
                            ]
                        );

                        $record->update(['status' => 'admitted']);

                        $body = 'Congratulations. Your NWDC application ' . $record->application_number . ' has been admitted. Log in for reporting instructions.';

                        $record->notifications()->create([
                            'channel' => 'sms',
                            'recipient' => $record->phone,
                            'body' => $body,
                            'status' => 'queued',
                        ]);

                        if ($record->email) {
                            $record->notifications()->create([
                                'channel' => 'email',
                                'recipient' => $record->email,
                                'subject' => 'NWDC admission notification',
                                'body' => $body,
                                'status' => 'queued',
                            ]);
                        }
                    }),
                ])
                    ->label('Actions')
                    ->icon('heroicon-o-ellipsis-horizontal-circle')
                    ->button()
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
