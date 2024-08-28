<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Data\GetTrendingMoviesFilters;
use Domain\Movies\Enums\MovieTimeWindow;
use Domain\Movies\Models\Movie;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTrendingMovies
{
    use AsAction;

    public function handle(GetTrendingMoviesFilters $filters): Builder
    {
        $query = Movie::query();

        $query
            ->when($filters->timeWindow === MovieTimeWindow::DAY, function (Builder $query) {
                $query->where('timeWindow', '=', MovieTimeWindow::DAY);
            })
            ->when($filters->timeWindow === MovieTimeWindow::WEEK, function (Builder $query) {
                $query->where('timeWindow', '=', MovieTimeWindow::WEEK);
            });

        return $query;
    }
}
