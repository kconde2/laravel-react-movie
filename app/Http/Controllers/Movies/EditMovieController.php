<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Domain\Movies\Actions\GetMovieDetailAction;
use Domain\Movies\Data\Output\MovieResourceData;
use Illuminate\Http\Request;

class EditMovieController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetMovieDetailAction $getMovieDetailAction, int $movieId)
    {
        $movie = $getMovieDetailAction->handle($movieId);

        abort_if($movie === null, 404);

        return inertia('Movies/EditMovie', [
            'movie' => MovieResourceData::from($movie),
        ]);
    }
}
