<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Models\Movie;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteMovieAction
{
    use AsAction;

    public function handle(Movie $movie)
    {
        $movie->delete();
    }
}
