<?php

namespace Domain\Movies\Interfaces;

interface MovieApiDataProviderInterface
{
    public function getTrendingMovies(string $timeWindow, $language = 'en-US'): array;

    public function getMovieDetails(int $movieId): array;
}
