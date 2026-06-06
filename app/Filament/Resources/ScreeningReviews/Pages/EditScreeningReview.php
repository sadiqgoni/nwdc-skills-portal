<?php

namespace App\Filament\Resources\ScreeningReviews\Pages;

use App\Filament\Resources\ScreeningReviews\ScreeningReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditScreeningReview extends EditRecord
{
    protected static string $resource = ScreeningReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
