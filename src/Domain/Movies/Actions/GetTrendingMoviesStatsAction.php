<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Data\TrendingMoviesStats;
use Domain\Movies\Enums\MovieTimeWindow;
use Domain\Movies\Models\Movie;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTrendingMoviesStatsAction
{
    use AsAction;

    public function handle(): TrendingMoviesStats
    {
        return TrendingMoviesStats::from([
            'dailyMovieCount' => Movie::query()->where('time_window', MovieTimeWindow::WEEK->value)->count(),
            'weeklyMovieCount' => Movie::query()->where('time_window', MovieTimeWindow::DAY->value)->count(),
        ]);
    }
}
