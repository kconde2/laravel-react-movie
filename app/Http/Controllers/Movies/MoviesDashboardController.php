<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Domain\Movies\Actions\GetTrendingMoviesStatsAction;
use Illuminate\Http\Request;

class MoviesDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetTrendingMoviesStatsAction $getTrendingMoviesStatsAction)
    {
        $data = $getTrendingMoviesStatsAction->handle();

        return inertia('Dashboard', ['stats' => $data]);
    }
}
