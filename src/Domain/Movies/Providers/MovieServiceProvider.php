<?php

namespace Domain\Movies\Providers;

use Domain\Movies\Database\DataProvider\Api\MovieApiProvider;
use Domain\Movies\Interfaces\MovieApiDataProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MovieApiDataProviderInterface::class, MovieApiProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Http::macro('tmdbApi', function () {
            return Http::withHeaders([
                'Authorization' => 'Bearer '.config('movie.tmdb.key'),
                'Accept' => 'application/json',
            ])->baseUrl(config('movie.tmdb.url'));
        });
    }
}
