<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Domain\Movies\Actions\UpdateMovieAction;
use Domain\Movies\Data\MovieData;
use Domain\Movies\Interfaces\MovieApiDataProviderInterface;
use Domain\Movies\Models\Movie;
use Illuminate\Http\Request;

class UpdateMovieController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        UpdateMovieAction $updateMovieAction,
        MovieApiDataProviderInterface $movieApiDataProvider,
        int $movieId
    ) {
        $movie = Movie::query()->findOrFail($movieId);

        $movieDetails = $movieApiDataProvider->getMovieDetails($movie->tmdb_id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'overview' => 'nullable|string',
        ]);

        $updateMovieAction->handle($movie, MovieData::from(
            array_merge($movie->toArray(),
                $movieDetails,
                $validated,
                [
                    'adult' => $movie->is_adult,
                    'video' => $movie->is_video,
                ]
            )
        ));

        return redirect()
            ->route('movies.detail', $movie->id)
            ->with('success', 'Movie updated successfully.');
    }
}
