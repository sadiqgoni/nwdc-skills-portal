<?php

namespace App\Filament\Resources\Applications;

use App\Filament\Resources\Applications\Pages\CreateApplication;
use App\Filament\Resources\Applications\Pages\EditApplication;
use App\Filament\Resources\Applications\Pages\ListApplications;
use App\Filament\Resources\Applications\Pages\ViewApplication;
use App\Filament\Resources\Applications\Schemas\ApplicationForm;
use App\Filament\Resources\Applications\Schemas\ApplicationInfolist;
use App\Filament\Resources\Applications\Tables\ApplicationsTable;
use App\Models\Application;
use App\Models\State;
use BackedEnum;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static string|\UnitEnum|null $navigationGroup = 'Applications by State';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'All Applications';

    public static function getNavigationBadge(): ?string
    {
        $count = Application::query()
            ->where('status', 'submitted')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'New submitted applications in the last 24 hours';
    }

    public static function getNavigationItems(): array
    {
        $items = parent::getNavigationItems();

        $stateItems = State::query()
            ->where('is_north_west', true)
            ->orderBy('name')
            ->get()
            ->map(fn (State $state): NavigationItem => NavigationItem::make($state->name . ' Applications')
                ->group('Applications by State')
                ->icon(Heroicon::OutlinedMapPin)
                ->url(static::getUrl('index', ['state' => $state->code]))
                ->badge(fn (): ?string => ($count = Application::query()
                    ->where('state_of_origin_id', $state->id)
                    ->where('status', 'submitted')
                    ->count()) > 0 ? (string) $count : null, 'success')
                ->isActiveWhen(fn (): bool => request()->query('state') === $state->code)
                ->sort(10 + $state->id))
            ->all();

        return [
            ...$items,
            ...$stateItems,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return ApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationsTable::configure($table);
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
            'index' => ListApplications::route('/'),
            'create' => CreateApplication::route('/create'),
            'view' => ViewApplication::route('/{record}'),
            'edit' => EditApplication::route('/{record}/edit'),
        ];
    }
}
