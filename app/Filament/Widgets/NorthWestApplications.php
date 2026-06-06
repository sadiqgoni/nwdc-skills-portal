<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\State;
use App\Models\TrainingHub;
use Filament\Widgets\Widget;

class NorthWestApplications extends Widget
{
    protected string $view = 'filament.widgets.north-west-applications';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getViewData(): array
    {
        $states = State::query()
            ->where('is_north_west', true)
            ->withCount('lgas')
            ->orderBy('name')
            ->get()
            ->map(function (State $state): array {
                $applicationCount = Application::query()->where('state_of_origin_id', $state->id)->count();
                $submittedCount = Application::query()->where('state_of_origin_id', $state->id)->where('status', 'submitted')->count();
                $hubCount = TrainingHub::query()->where('state_id', $state->id)->where('is_active', true)->count();

                return [
                    'name' => $state->name,
                    'code' => $state->code,
                    'applications' => $applicationCount,
                    'submitted' => $submittedCount,
                    'lgas' => $state->lgas_count,
                    'hubs' => $hubCount,
                ];
            });

        $maximumApplications = max(1, $states->max('applications') ?? 1);

        return [
            'states' => $states,
            'maximumApplications' => $maximumApplications,
            'totalApplications' => Application::query()->count(),
            'submittedApplications' => Application::query()->where('status', 'submitted')->count(),
            'activeHubs' => TrainingHub::query()->where('is_active', true)->count(),
        ];
    }
}
