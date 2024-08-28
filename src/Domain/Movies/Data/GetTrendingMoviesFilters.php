<?php

namespace Domain\Movies\Data;

use Domain\Movies\Enums\MovieTimeWindow;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class GetTrendingMoviesFilters extends Data
{
    public function __construct(
        public MovieTimeWindow $timeWindow,
        public ?string $search,
    ) {}
}
