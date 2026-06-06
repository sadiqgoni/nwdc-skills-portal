<?php

namespace App\Filament\Resources\ProgrammeTracks;

use App\Filament\Resources\ProgrammeTracks\Pages\CreateProgrammeTrack;
use App\Filament\Resources\ProgrammeTracks\Pages\EditProgrammeTrack;
use App\Filament\Resources\ProgrammeTracks\Pages\ListProgrammeTracks;
use App\Filament\Resources\ProgrammeTracks\Pages\ViewProgrammeTrack;
use App\Filament\Resources\ProgrammeTracks\Schemas\ProgrammeTrackForm;
use App\Filament\Resources\ProgrammeTracks\Schemas\ProgrammeTrackInfolist;
use App\Filament\Resources\ProgrammeTracks\Tables\ProgrammeTracksTable;
use App\Models\ProgrammeTrack;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgrammeTrackResource extends Resource
{
    protected static ?string $model = ProgrammeTrack::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static string|\UnitEnum|null $navigationGroup = 'Programme Management';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ProgrammeTrackForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProgrammeTrackInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgrammeTracksTable::configure($table);
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
            'index' => ListProgrammeTracks::route('/'),
            'create' => CreateProgrammeTrack::route('/create'),
            'view' => ViewProgrammeTrack::route('/{record}'),
            'edit' => EditProgrammeTrack::route('/{record}/edit'),
        ];
    }
}
