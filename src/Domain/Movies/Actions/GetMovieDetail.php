<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Models\Movie;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMovieDetail
{
    use AsAction;

    public function handle(int $movieId): ?Movie
    {
        return Movie::find($movieId);
    }
}
