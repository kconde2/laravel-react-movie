<?php

namespace Domain\Movies\Actions;

use Domain\Movies\Data\MovieData;
use Domain\Movies\Models\Movie;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateMovie
{
    use AsAction;

    public function handle(Movie $movie, MovieData $data): Movie
    {
        $movie->fill($data->except('time_window')->toArray());
        $movie->syncTimeWindows([$data->timeWindow]);
        $movie->save();

        return $movie;
    }
}
