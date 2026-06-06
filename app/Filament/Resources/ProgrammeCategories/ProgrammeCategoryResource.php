<?php

namespace App\Filament\Resources\ProgrammeCategories;

use App\Filament\Resources\ProgrammeCategories\Pages\CreateProgrammeCategory;
use App\Filament\Resources\ProgrammeCategories\Pages\EditProgrammeCategory;
use App\Filament\Resources\ProgrammeCategories\Pages\ListProgrammeCategories;
use App\Filament\Resources\ProgrammeCategories\Pages\ViewProgrammeCategory;
use App\Filament\Resources\ProgrammeCategories\Schemas\ProgrammeCategoryForm;
use App\Filament\Resources\ProgrammeCategories\Schemas\ProgrammeCategoryInfolist;
use App\Filament\Resources\ProgrammeCategories\Tables\ProgrammeCategoriesTable;
use App\Models\ProgrammeCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgrammeCategoryResource extends Resource
{
    protected static ?string $model = ProgrammeCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
    protected static string|\UnitEnum|null $navigationGroup = 'Programme Management';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ProgrammeCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProgrammeCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgrammeCategoriesTable::configure($table);
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
            'index' => ListProgrammeCategories::route('/'),
            'create' => CreateProgrammeCategory::route('/create'),
            'view' => ViewProgrammeCategory::route('/{record}'),
            'edit' => EditProgrammeCategory::route('/{record}/edit'),
        ];
    }
}
