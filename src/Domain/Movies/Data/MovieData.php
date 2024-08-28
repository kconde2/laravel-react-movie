<?php

namespace Domain\Movies\Data;

use Domain\Movies\Enums\MovieTimeWindow;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class MovieData extends Data
{
    public function __construct(
        #[StringType]
        public string $backdropPath,

        #[IntegerType]
        #[MapInputName('id')]
        public int $tmdbId,

        #[StringType]
        public string $title,

        #[StringType]
        public string $originalTitle,

        #[Nullable, StringType]
        public ?string $overview,

        #[Nullable, StringType]
        public ?string $posterPath,

        #[StringType]
        public string $mediaType,

        #[MapInputName('adult')]
        #[BooleanType]
        public bool $isAdult,

        #[StringType]
        public string $originalLanguage,

        #[FloatType]
        public float $popularity,

        #[Nullable, Date]
        public ?string $releaseDate,

        #[MapInputName('video')]
        #[BooleanType]
        public bool $isVideo,

        #[FloatType]
        public float $voteAverage,

        #[IntegerType]
        public int $voteCount,

        #[Enum(MovieTimeWindow::class)]
        public string $timeWindow,
    ) {}
}
