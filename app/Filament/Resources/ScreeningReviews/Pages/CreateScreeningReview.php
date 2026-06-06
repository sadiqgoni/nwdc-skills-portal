<?php

namespace App\Filament\Resources\ScreeningReviews\Pages;

use App\Filament\Resources\ScreeningReviews\ScreeningReviewResource;
use Filament\Resources\Pages\CreateRecord;

class CreateScreeningReview extends CreateRecord
{
    protected static string $resource = ScreeningReviewResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
