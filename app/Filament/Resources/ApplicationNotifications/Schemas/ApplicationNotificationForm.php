<?php

namespace App\Filament\Resources\ApplicationNotifications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ApplicationNotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Notification message')
                    ->icon('heroicon-o-bell-alert')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('application_id')
                                ->relationship('application', 'application_number')
                                ->searchable()
                                ->required(),
                            Select::make('channel')
                                ->options([
                                    'sms' => 'SMS',
                                    'email' => 'Email',
                                ])
                                ->required(),
                            TextInput::make('recipient')
                                ->required(),
                            TextInput::make('subject'),
                            Textarea::make('body')
                                ->required()
                                ->rows(4)
                                ->columnSpanFull(),
                        ]),
                    ]),
                Section::make('Delivery status')
                    ->icon('heroicon-o-inbox-stack')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('status')
                                ->options([
                                    'queued' => 'Queued',
                                    'sent' => 'Sent',
                                    'failed' => 'Failed',
                                    'cancelled' => 'Cancelled',
                                ])
                                ->required()
                                ->default('queued'),
                            DateTimePicker::make('sent_at'),
                            Textarea::make('provider_response')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
