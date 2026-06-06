<?php

namespace App\Filament\Resources\ScreeningReviews\Pages;

use App\Filament\Resources\ScreeningReviews\ScreeningReviewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScreeningReviews extends ListRecords
{
    protected static string $resource = ScreeningReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
