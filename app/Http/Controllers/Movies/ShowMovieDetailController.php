<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Domain\Movies\Actions\GetMovieDetail;
use Domain\Movies\Data\Output\MovieResourceData;
use Illuminate\Http\Request;

class ShowMovieDetailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetMovieDetail $getMovieDetail, int $movieId)
    {
        $movie = $getMovieDetail->handle($movieId);

        abort_if(null === $movie, 404);

        return inertia('Movies/Show', [
            'movie' => MovieResourceData::from($movie),
        ]);
    }
}
