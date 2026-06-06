<?php

namespace App\Filament\Resources\ScreeningReviews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ScreeningReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application.application_number')
                    ->searchable(),
                TextColumn::make('reviewer.name')
                    ->searchable(),
                TextColumn::make('decision')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'eligible', 'shortlisted' => 'success',
                        'waitlisted' => 'info',
                        'under_review', 'pending' => 'warning',
                        'ineligible', 'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reviewed_at')
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
                SelectFilter::make('decision')
                    ->options([
                        'pending' => 'Pending',
                        'under_review' => 'Under Review',
                        'eligible' => 'Eligible',
                        'ineligible' => 'Ineligible',
                        'shortlisted' => 'Shortlisted',
                        'waitlisted' => 'Waitlisted',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
