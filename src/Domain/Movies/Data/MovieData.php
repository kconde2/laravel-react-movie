<?php

namespace Domain\Movies\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
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

        #[BooleanType]
        public bool $adult,

        #[StringType]
        public string $originalLanguage,

        #[FloatType]
        public float $popularity,

        #[Nullable, Date]
        public ?string $releaseDate,

        #[BooleanType]
        public bool $video,

        #[FloatType]
        public float $voteAverage,

        #[IntegerType]
        public int $voteCount
    ) {}
}
