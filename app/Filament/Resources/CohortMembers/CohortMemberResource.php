<?php

namespace App\Filament\Resources\CohortMembers;

use App\Filament\Resources\CohortMembers\Pages\CreateCohortMember;
use App\Filament\Resources\CohortMembers\Pages\EditCohortMember;
use App\Filament\Resources\CohortMembers\Pages\ListCohortMembers;
use App\Filament\Resources\CohortMembers\Pages\ViewCohortMember;
use App\Filament\Resources\CohortMembers\Schemas\CohortMemberForm;
use App\Filament\Resources\CohortMembers\Schemas\CohortMemberInfolist;
use App\Filament\Resources\CohortMembers\Tables\CohortMembersTable;
use App\Models\CohortMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CohortMemberResource extends Resource
{
    protected static ?string $model = CohortMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static string|\UnitEnum|null $navigationGroup = 'Screening & Admissions';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CohortMemberForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CohortMemberInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CohortMembersTable::configure($table);
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
            'index' => ListCohortMembers::route('/'),
            'create' => CreateCohortMember::route('/create'),
            'view' => ViewCohortMember::route('/{record}'),
            'edit' => EditCohortMember::route('/{record}/edit'),
        ];
    }
}
