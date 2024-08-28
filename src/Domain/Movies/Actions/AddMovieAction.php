<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Data\MovieData;
use Domain\Movies\Models\Movie;
use Lorisleiva\Actions\Concerns\AsAction;

class AddMovieAction
{
    use AsAction;

    public function handle(MovieData $data): Movie
    {
        return Movie::create($data->toArray());
    }
}
