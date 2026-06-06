<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Models\User;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static string|\UnitEnum|null $navigationGroup = 'Administration';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Users & Admins';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone', 'nin'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('User account')
                ->description('Create applicant and staff accounts. Use admin role only for trusted staff.')
                ->icon('heroicon-o-user')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(15),
                        TextInput::make('nin')
                            ->label('NIN')
                            ->unique(ignoreRecord: true)
                            ->maxLength(11),
                        Select::make('role')
                            ->options([
                                'admin' => 'Administrator',
                                'applicant' => 'Applicant',
                            ])
                            ->required()
                            ->default('applicant'),
                        Toggle::make('is_active')
                            ->label('Active account')
                            ->default(true)
                            ->required(),
                    ]),
                ]),

            Section::make('Security')
                ->description('Set a password for new users. Leave blank when editing to keep the current password.')
                ->icon('heroicon-o-lock-closed')
                ->schema([
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->minLength(8)
                        ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn (?string $state): bool => filled($state)),
                ]),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('User details')
                ->icon('heroicon-o-user')
                ->schema([
                    Grid::make(3)->schema([
                        TextEntry::make('name')
                            ->weight(FontWeight::Bold),
                        TextEntry::make('email')
                            ->label('Email address')
                            ->copyable(),
                        TextEntry::make('phone')
                            ->copyable(),
                        TextEntry::make('nin')
                            ->label('NIN')
                            ->copyable()
                            ->placeholder('-'),
                        TextEntry::make('role')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'admin' ? 'success' : 'gray'),
                        IconEntry::make('is_active')
                            ->boolean(),
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'admin' ? 'success' : 'gray')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Administrator',
                        'applicant' => 'Applicant',
                    ]),
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()->label('View user')->icon('heroicon-o-eye'),
                    EditAction::make()->label('Edit user')->icon('heroicon-o-pencil-square'),
                ])
                    ->label('Actions')
                    ->button()
                    ->icon('heroicon-o-ellipsis-horizontal-circle'),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
