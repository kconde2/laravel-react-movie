<?php

namespace Domain\Movies\Data\Output;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class MovieResourceData extends Data
{
    public function __construct(
        public int $id,
        public int $tmdbId,
        public string $title,
        public string $originalTitle,
        public ?string $overview,
        public string $posterPath,
        public string $posterUrl,
        public string $mediaType,
        public string $backdropPath,
        public string $backdropUrl,
        public bool $isAdult,
        public string $originalLanguage,
        public float $popularity,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public Carbon $releaseDate,
        public bool $isVideo,
        public float $voteAverage,
        public int $voteCount,
        public string $timeWindow,
        public string $createdAt,
        public string $updatedAt,
    ) {}
}
