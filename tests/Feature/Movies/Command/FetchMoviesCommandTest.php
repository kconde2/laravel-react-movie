<?php

use Domain\Movies\Enums\MovieTimeWindow;
use Domain\Movies\Interfaces\MovieApiDataProviderInterface;
use Domain\Movies\Models\Movie;
use Illuminate\Support\Facades\Artisan;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\mock;

it('fetches and stores trending movies for the day time window', function (string $timeWindow) {
    mock(MovieApiDataProviderInterface::class)
        ->shouldReceive('getTrendingMovies')
        ->with($timeWindow)
        ->andReturn([
            [
                'backdrop_path' => '/wNAhuOZ3Zf84jCIlrcI6JhgmY5q.jpg',
                'id' => 786892,
                'title' => 'Furiosa: A Mad Max Saga',
                'original_title' => 'Furiosa: A Mad Max Saga',
                'overview' => 'As the world fell, young Furiosa is snatched from the Green Place of Many Mothers and falls into the hands of a great Biker Horde led by the Warlord Dementus. Sweeping through the Wasteland they come across the Citadel presided over by The Immortan Joe. While the two Tyrants war for dominance, Furiosa must survive many trials as she puts together the means to find her way home.',
                'poster_path' => '/iADOJ8Zymht2JPMoy3R7xceZprc.jpg',
                'media_type' => 'movie',
                'adult' => false,
                'original_language' => 'en',
                'popularity' => 719.832,
                'release_date' => '2024-05-22',
                'video' => false,
                'vote_average' => 7.591,
                'vote_count' => 2843,
            ],
        ])
        ->getMock();

    // Run the command
    Artisan::call('movies:fetch', ['timeWindow' => $timeWindow]);

    // Assert the movie was added to the database
    assertDatabaseHas('movies', [
        'tmdb_id' => 786892,
        'title' => 'Furiosa: A Mad Max Saga',
        'original_title' => 'Furiosa: A Mad Max Saga',
        'time_window' => $timeWindow,
    ]);
})->with([
    'day time window' => MovieTimeWindow::DAY->value,
    'week time window' => MovieTimeWindow::WEEK->value,
]);

it('updates existing movies', function (string $timeWindow) {
    // Arrange
    Movie::factory()->create([
        'tmdb_id' => 1,
        'title' => 'Old Title',
        'original_title' => 'Old Original Title',
    ]);

    mock(MovieApiDataProviderInterface::class)
        ->shouldReceive('getTrendingMovies')
        ->with($timeWindow)
        ->andReturn([
            [
                'id' => 1,
                'title' => 'New Title',
                'original_title' => 'New Original Title',
                'backdrop_path' => '/path1.jpg',
                'overview' => 'New Overview',
                'release_date' => '2024-08-21',
                'vote_average' => 8.0,
                'vote_count' => 150,
                'genre_ids' => [1, 2],
                'popularity' => 600,
                'media_type' => 'movie',
                'poster_path' => '/poster1.jpg',
                'adult' => false,
                'original_language' => 'en',
                'video' => false,
            ],
        ])
        ->getMock();

    // Act
    Artisan::call('movies:fetch', ['timeWindow' => $timeWindow]);

    // Assert
    assertDatabaseHas('movies', [
        'tmdb_id' => 1,
        'title' => 'New Title',
        'original_title' => 'New Original Title',
    ]);

    assertDatabaseMissing('movies', [
        'title' => 'Old Title',
    ]);
})->with([
    'day time window' => MovieTimeWindow::DAY->value,
    'week time window' => MovieTimeWindow::WEEK->value,
]);

it('handles errors gracefully', function (string $timeWindow) {
    // Arrange
    mock(MovieApiDataProviderInterface::class)
        ->shouldReceive('getTrendingMovies')
        ->with($timeWindow)
        ->andReturn([
            [
                'id' => null,
                'title' => 'Movie Title 1',
            ],
        ])
        ->getMock();

    // Act
    Artisan::call('movies:fetch', ['timeWindow' => $timeWindow]);

    // Assert
    assertDatabaseMissing('movies', [
        'title' => 'Movie Title 1',
    ]);
})->with([
    'day time window' => MovieTimeWindow::DAY->value,
    'week time window' => MovieTimeWindow::WEEK->value,
]);
