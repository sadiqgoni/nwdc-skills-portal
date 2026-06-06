<?php

namespace App\Filament\Widgets;

use App\Models\Admission;
use App\Models\Application;
use App\Models\Cohort;
use App\Models\ProgrammeTrack;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortalOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Applications', number_format(Application::query()->count()))
                ->description('Total records received')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Eligible Applicants', number_format(Application::query()->where('eligibility_passed', true)->count()))
                ->description('Passed first eligibility checks')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Admissions', number_format(Admission::query()->whereIn('status', ['admitted', 'accepted'])->count()))
                ->description('Applicants moved to admission')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning'),

            Stat::make('Tracks & Cohorts', ProgrammeTrack::query()->count() . ' / ' . Cohort::query()->count())
                ->description('Training tracks and batches')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('info'),
        ];
    }
}
