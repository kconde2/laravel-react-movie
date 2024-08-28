<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Domain\Movies\Actions\GetTrendingMovies;
use Domain\Movies\Data\GetTrendingMoviesFilters;
use Domain\Movies\Data\Output\MovieResourceData;
use Domain\Movies\Enums\MovieTimeWindow;
use Illuminate\Http\Request;

class GetTrendingMoviesController extends Controller
{
    public function __construct(
        private GetTrendingMovies $getTrendingMovies
    ) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $timeWindow = $request->route('timeWindow');
        $timeWindow = MovieTimeWindow::from($timeWindow);
        $search = $request->input('search', '');

        $trendingMoviesQuery = $this->getTrendingMovies->handle(GetTrendingMoviesFilters::from([
            'time_window' => $timeWindow,
            'search' => $search,
        ]));

        $trendingMovies = $trendingMoviesQuery->paginate($perPage);

        return inertia('Movies/Trending', [
            'trendingMovies' => MovieResourceData::collect($trendingMovies),
            'timeWindow' => $timeWindow->value,
            'search' => $search,
        ]);
    }
}
