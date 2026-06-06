<?php

namespace App\Filament\Resources\ProgrammeCycles;

use App\Filament\Resources\ProgrammeCycles\Pages\CreateProgrammeCycle;
use App\Filament\Resources\ProgrammeCycles\Pages\EditProgrammeCycle;
use App\Filament\Resources\ProgrammeCycles\Pages\ListProgrammeCycles;
use App\Filament\Resources\ProgrammeCycles\Pages\ViewProgrammeCycle;
use App\Filament\Resources\ProgrammeCycles\Schemas\ProgrammeCycleForm;
use App\Filament\Resources\ProgrammeCycles\Schemas\ProgrammeCycleInfolist;
use App\Filament\Resources\ProgrammeCycles\Tables\ProgrammeCyclesTable;
use App\Models\ProgrammeCycle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgrammeCycleResource extends Resource
{
    protected static ?string $model = ProgrammeCycle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;
    protected static string|\UnitEnum|null $navigationGroup = 'Programme Management';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ProgrammeCycleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProgrammeCycleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgrammeCyclesTable::configure($table);
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
            'index' => ListProgrammeCycles::route('/'),
            'create' => CreateProgrammeCycle::route('/create'),
            'view' => ViewProgrammeCycle::route('/{record}'),
            'edit' => EditProgrammeCycle::route('/{record}/edit'),
        ];
    }
}
