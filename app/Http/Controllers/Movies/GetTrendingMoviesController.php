<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Domain\Movies\Actions\GetTrendingMovies;
use Domain\Movies\Data\GetTrendingMoviesFilters;
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
        $perPage = $request->input('per_page', 15);
        $timeWindow = $request->input('time_window');

        $trendingMoviesQuery = $this->getTrendingMovies->handle(GetTrendingMoviesFilters::from([
            'time_window' => $timeWindow,
        ]));

        $trendingMoviesQuery->paginate($perPage);

        return inertia('Movies/Trending', [
            $trendingMovies,
        ]);
    }
}
