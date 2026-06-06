<?php

namespace App\Filament\Resources\TrainingHubs;

use App\Filament\Resources\TrainingHubs\Pages\CreateTrainingHub;
use App\Filament\Resources\TrainingHubs\Pages\EditTrainingHub;
use App\Filament\Resources\TrainingHubs\Pages\ListTrainingHubs;
use App\Filament\Resources\TrainingHubs\Pages\ViewTrainingHub;
use App\Filament\Resources\TrainingHubs\Schemas\TrainingHubForm;
use App\Filament\Resources\TrainingHubs\Schemas\TrainingHubInfolist;
use App\Filament\Resources\TrainingHubs\Tables\TrainingHubsTable;
use App\Models\TrainingHub;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainingHubResource extends Resource
{
    protected static ?string $model = TrainingHub::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;
    protected static string|\UnitEnum|null $navigationGroup = 'Programme Management';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return TrainingHubForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrainingHubInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingHubsTable::configure($table);
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
            'index' => ListTrainingHubs::route('/'),
            'create' => CreateTrainingHub::route('/create'),
            'view' => ViewTrainingHub::route('/{record}'),
            'edit' => EditTrainingHub::route('/{record}/edit'),
        ];
    }
}
