<?php

namespace Domain\Movies\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TrendingMoviesStats extends Data
{
    public function __construct(
        public int $dailyMovieCount,
        public int $weeklyMovieCount,
    ) {}
}
