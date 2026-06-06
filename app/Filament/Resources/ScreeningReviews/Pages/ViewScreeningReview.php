<?php

namespace App\Filament\Resources\ScreeningReviews\Pages;

use App\Filament\Resources\ScreeningReviews\ScreeningReviewResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewScreeningReview extends ViewRecord
{
    protected static string $resource = ScreeningReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
