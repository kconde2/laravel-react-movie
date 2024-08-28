<?php

use App\Models\User;
use Domain\Movies\Enums\MovieTimeWindow;
use Domain\Movies\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

beforeEach(function () {

    /** @var Illuminate\Contracts\Auth\Authenticatable */
    $user = User::factory()->createOne();
    actingAs($user);
});

it('renders the trending movies page with valid time window and verifies movie data', function (string $timeWindow) {
    // Arrange
    Movie::factory()->count(5)->create(['time_window' => $timeWindow]);

    // Act
    $response = $this->get("/dashboard/movies/trending/$timeWindow");

    // Assert
    $response->assertStatus(200);
    $response->assertInertia(function (AssertableInertia $page) use ($timeWindow) {
        $page
            ->component('Movies/Trending')
            ->has('trendingMovies.data', 5)
            ->has('trendingMovies.data.0', function (AssertableInertia $movie) {
                $movie
                    ->has('id')
                    ->has('tmdbId')
                    ->has('title')
                    ->has('originalTitle')
                    ->has('overview')
                    ->has('posterPath')
                    ->has('posterUrl')
                    ->has('mediaType')
                    ->has('backdropPath')
                    ->has('backdropUrl')
                    ->has('isAdult')
                    ->has('originalLanguage')
                    ->has('popularity')
                    ->has('releaseDate')
                    ->has('isVideo')
                    ->has('voteAverage')
                    ->has('voteCount')
                    ->has('timeWindow')
                    ->has('createdAt')
                    ->has('updatedAt');
            })
            ->has('trendingMovies.current_page')
            ->has('trendingMovies.per_page')
            ->has('trendingMovies.total')
            ->where('timeWindow', $timeWindow);
    });
})->with([
    'day time window' => MovieTimeWindow::DAY->value,
    'week time window' => MovieTimeWindow::WEEK->value,
]);

it('returns a 404 error for an invalid time window', function (string $timeWindow) {
    // Act
    $response = get("/movies/trending/$timeWindow");

    // Assert
    $response->assertStatus(404);
})->with(['invalid', '123']);

it('paginates trending movies correctly on the second page', function () {
    // Arrange
    $moviesCount = 25;
    $perPage = 10;
    Movie::factory()->count($moviesCount)->create(['time_window' => MovieTimeWindow::WEEK->value]);

    // Act
    $response = $this->get("/dashboard/movies/trending/week?page=2&per_page=$perPage");

    // Assert
    $response->assertStatus(200);
    $response->assertInertia(function (AssertableInertia $page) use ($perPage, $moviesCount) {
        $page
            ->component('Movies/Trending')
            ->has('trendingMovies.data', $perPage)
            ->where('trendingMovies.current_page', 2)
            ->where('trendingMovies.per_page', $perPage)
            ->where('trendingMovies.total', $moviesCount)
            ->where('trendingMovies.last_page', intval(ceil($moviesCount / $perPage)))
            ->has('trendingMovies.data.0', function (AssertableInertia $movie) {
                $movie
                    ->has('id')
                    ->has('tmdbId')
                    ->has('title')
                    ->has('originalTitle')
                    ->has('overview')
                    ->has('posterPath')
                    ->has('posterUrl')
                    ->has('mediaType')
                    ->has('backdropPath')
                    ->has('backdropUrl')
                    ->has('isAdult')
                    ->has('originalLanguage')
                    ->has('popularity')
                    ->has('releaseDate')
                    ->has('isVideo')
                    ->has('voteAverage')
                    ->has('voteCount')
                    ->has('timeWindow')
                    ->has('createdAt')
                    ->has('updatedAt');
            })
            ->where('timeWindow', MovieTimeWindow::WEEK->value);
    });
});
