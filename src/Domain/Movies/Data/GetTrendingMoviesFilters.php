<?php

namespace Domain\Movies\Data;

use Spatie\LaravelData\Data;

class GetTrendingMoviesFilters extends Data
{
    public function __construct(
        public ?enum $timeWindow = null,
    ) {}
}
