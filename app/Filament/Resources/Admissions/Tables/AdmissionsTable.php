<?php

namespace App\Filament\Resources\Admissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AdmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application.application_number')
                    ->searchable(),
                TextColumn::make('trainingHub.name')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admitted', 'accepted' => 'success',
                        'pending', 'deferred' => 'warning',
                        'declined', 'withdrawn' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('reporting_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('notified_at')
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
                        'pending' => 'Pending',
                        'admitted' => 'Admitted',
                        'accepted' => 'Accepted',
                        'declined' => 'Declined',
                        'deferred' => 'Deferred',
                        'withdrawn' => 'Withdrawn',
                    ]),
                SelectFilter::make('training_hub_id')
                    ->relationship('trainingHub', 'name'),
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
