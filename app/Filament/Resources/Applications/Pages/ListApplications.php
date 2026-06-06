<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use App\Models\State;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    public ?string $stateName = null;

    public function mount(): void
    {
        parent::mount();

        $stateCode = request()->query('state');

        if (! $stateCode) {
            return;
        }

        $state = State::query()
            ->where('code', $stateCode)
            ->where('is_north_west', true)
            ->first();

        if (! $state) {
            return;
        }

        $this->stateName = $state->name;
        $this->tableFilters ??= [];
        $this->tableFilters['state_of_origin_id']['value'] = (string) $state->id;
    }

    public function getTitle(): string|Htmlable
    {
        return $this->stateName
            ? $this->stateName . ' Applications'
            : 'All Applications';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Application')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
