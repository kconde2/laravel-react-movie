<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Data\TrendingMoviesStats;
use Domain\Movies\Enums\MovieTimeWindow;
use Domain\Movies\Models\Movie;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTrendingMoviesStats
{
    use AsAction;

    public function handle(): TrendingMoviesStats
    {
        return TrendingMoviesStats::from([
            'dailyMovieCount' => Movie::query()->whereJsonContains('time_windows', MovieTimeWindow::WEEK->value)->count(),
            'weeklyMovieCount' => Movie::query()->whereJsonContains('time_windows', MovieTimeWindow::DAY->value)->count(),
        ]);
    }
}
