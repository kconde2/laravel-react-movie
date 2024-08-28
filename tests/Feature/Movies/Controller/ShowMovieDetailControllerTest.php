<?php

use App\Models\User;
use Domain\Movies\Enums\MovieTimeWindow;
use Domain\Movies\Models\Movie;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\actingAs;

it('redirects to movie details page when clicking on a movie', function () {
    // Arrange
    /** @var Illuminate\Contracts\Auth\Authenticatable */
    $user = User::factory()->create();
    $movie = Movie::factory()->create(['time_window' => MovieTimeWindow::WEEK->value]);

    // Act
    $response = actingAs($user)->get("/dashboard/movies/trending/detail/$movie->id");

    // Assert
    $response->assertStatus(200);
    $response->assertInertia(fn (Assert $page) => $page->component('Movies/ShowMovie')
        ->has('movie', fn (Assert $movieData) => $movieData
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
            ->has('updatedAt')
            ->where('id', $movie->id)
            ->where('title', $movie->title)
            ->where('originalTitle', $movie->original_title)
            ->where('overview', $movie->overview)
            ->where('posterPath', $movie->poster_path)
            ->where('posterUrl', $movie->poster_url)
            ->where('mediaType', $movie->media_type)
            ->where('backdropPath', $movie->backdrop_path)
            ->where('backdropUrl', $movie->backdrop_url)
            ->where('isAdult', $movie->is_adult)
            ->where('originalLanguage', $movie->original_language)
            ->where('popularity', $movie->popularity)
            ->where('releaseDate', $movie->release_date->format('Y-m-d'))
            ->where('isVideo', $movie->is_video)
            ->where('voteAverage', $movie->vote_average)
            ->where('voteCount', $movie->vote_count)
            ->where('timeWindow', $movie->time_window)
            ->where('createdAt', $movie->created_at->format('Y-m-d H:i:s'))
            ->where('updatedAt', $movie->updated_at->format('Y-m-d H:i:s'))
        )
    );
});

it('returns 404 when accessing a non-existent movie', function () {
    // Arrange
    /** @var Illuminate\Contracts\Auth\Authenticatable */
    $user = User::factory()->create();
    $nonExistentMovieId = 99999; // Un ID qui n'existe pas dans la base de données

    // Act
    $response = actingAs($user)->get("/dashboard/movies/trending/detail/$nonExistentMovieId");

    // Assert
    $response->assertStatus(404);
});

it('returns 404 when accessing with an invalid movie ID', function () {
    // Arrange
    /** @var Illuminate\Contracts\Auth\Authenticatable */
    $user = User::factory()->create();
    $invalidMovieId = 'invalid'; // Un ID non numérique

    // Act
    $response = actingAs($user)->get("/dashboard/movies/trending/detail/$invalidMovieId");

    // Assert
    $response->assertStatus(404);
});
