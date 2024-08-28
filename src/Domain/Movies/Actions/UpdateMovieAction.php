<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Data\MovieData;
use Domain\Movies\Models\Movie;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateMovieAction
{
    use AsAction;

    public function handle(Movie $movie, MovieData $data): Movie
    {
        $movie->update($data->toArray());

        return $movie;
    }
}
