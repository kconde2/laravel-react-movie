<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Domain\Movies\Actions\GetTrendingMoviesStats;
use Illuminate\Http\Request;

class MoviesDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetTrendingMoviesStats $getTrendingMoviesStats)
    {
        $data = $getTrendingMoviesStats->handle();

        return inertia('Dashboard', ['stats' => $data]);
    }
}
