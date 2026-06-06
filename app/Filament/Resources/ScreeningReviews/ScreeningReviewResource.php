<?php

namespace App\Filament\Resources\ScreeningReviews;

use App\Filament\Resources\ScreeningReviews\Pages\CreateScreeningReview;
use App\Filament\Resources\ScreeningReviews\Pages\EditScreeningReview;
use App\Filament\Resources\ScreeningReviews\Pages\ListScreeningReviews;
use App\Filament\Resources\ScreeningReviews\Pages\ViewScreeningReview;
use App\Filament\Resources\ScreeningReviews\Schemas\ScreeningReviewForm;
use App\Filament\Resources\ScreeningReviews\Schemas\ScreeningReviewInfolist;
use App\Filament\Resources\ScreeningReviews\Tables\ScreeningReviewsTable;
use App\Models\ScreeningReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ScreeningReviewResource extends Resource
{
    protected static ?string $model = ScreeningReview::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;
    protected static string|\UnitEnum|null $navigationGroup = 'Screening & Admissions';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ScreeningReviewForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ScreeningReviewInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScreeningReviewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScreeningReviews::route('/'),
            'create' => CreateScreeningReview::route('/create'),
            'view' => ViewScreeningReview::route('/{record}'),
            'edit' => EditScreeningReview::route('/{record}/edit'),
        ];
    }
}
