<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Domain\Movies\Actions\DeleteMovieAction;
use Domain\Movies\Models\Movie;
use Illuminate\Http\Request;

class DeleteMovieController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DeleteMovieAction $deleteMovieAction, int $movieId)
    {
        $movie = Movie::query()->findOrFail($movieId);

        $deleteMovieAction->handle($movie);

        return redirect()->back()->with('success', 'Movie deleted successfully.');
    }
}
