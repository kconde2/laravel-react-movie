<?php

namespace Domain\Movies\Database\DataProvider\Api;

use Domain\Movies\Interfaces\MovieApiDataProviderInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MovieApiProvider implements MovieApiDataProviderInterface
{
    public function getTrendingMovies(string $timeWindow, $language = 'en-US'): array
    {
        $cacheKey = "trending_movies_{$timeWindow}_lang_{$language}";

        $data = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($timeWindow, $language) {
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::tmdbApi()->get("/trending/movie/{$timeWindow}", [
                'language' => $language,
            ]);

            if ($response->successful()) {
                return $response->json('results', []);
            }

            Log::error("Error fetching trending movies for time window {$timeWindow} and language {$language}: {$response->body()}");

            return [];
        });

        return (array) $data;
    }

    public function getMovieDetails(int $movieId): array
    {
        $cacheKey = "movie_details_{$movieId}";

        $data = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($movieId) {
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::tmdbApi()->get("/movie/$movieId", [
                'language' => 'fr-FR',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("Error fetching movie details for movie ID {$movieId}: {$response->body()}");

            return [];
        });

        return (array) $data;
    }
}
