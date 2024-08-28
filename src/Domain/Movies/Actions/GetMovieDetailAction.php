<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Models\Movie;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMovieDetailAction
{
    use AsAction;

    public function handle(int $movieId): ?Movie
    {
        return Movie::find($movieId);
    }
}
