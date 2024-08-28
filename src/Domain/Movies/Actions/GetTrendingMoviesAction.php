<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Data\GetTrendingMoviesFilters;
use Domain\Movies\Enums\MovieTimeWindow;
use Domain\Movies\Models\Movie;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTrendingMoviesAction
{
    use AsAction;

    public function handle(GetTrendingMoviesFilters $filters): Builder
    {
        $query = Movie::query();

        $query
            ->when($filters->search, function (Builder $query) use ($filters) {
                $query
                    ->where('title', 'like', "%{$filters->search}%")
                    ->orWhere('original_title', 'like', "%{$filters->search}%");
            })
            ->when($filters->timeWindow === MovieTimeWindow::DAY, function (Builder $query) {
                $query->where('time_window', '=', MovieTimeWindow::DAY->value);
            })
            ->when($filters->timeWindow === MovieTimeWindow::WEEK, function (Builder $query) {
                $query->where('time_window', '=', MovieTimeWindow::WEEK->value);
            });

        return $query;
    }
}
