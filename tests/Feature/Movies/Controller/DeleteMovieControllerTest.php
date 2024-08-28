<?php

use App\Models\User;
use Domain\Movies\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var Illuminate\Contracts\Auth\Authenticatable */
    $user = User::factory()->create();
    actingAs($user);
});

it('deletes a movie successfully', function () {
    // Arrange
    $movie = Movie::factory()->create();

    // Act
    $response = delete("/dashboard/movies/trending/delete/{$movie->id}");

    // Assert
    $response->assertStatus(302);
    $this->assertDatabaseMissing('movies', ['id' => $movie->id, 'deleted_at' => null]);
    $response->assertSessionHas('success', 'Movie deleted successfully.');
});

it('returns a 404 for an incorrect URL', function () {
    // Act
    $response = delete('/dashboard/movies/trending/incorrect-url');

    // Assert
    $response->assertStatus(404);
});

it('returns a 404 when trying to delete a non-existent movie', function () {
    // Arrange
    $nonExistentMovieId = 9999;

    // Act
    $response = delete("/dashboard/movies/trending/delete/{$nonExistentMovieId}");

    // Assert
    $response->assertStatus(404);
});

it('redirects back unauthenticateds users when trying to delete a movie', function () {
    $movie = Movie::factory()->create();

    $response = delete("/dashboard/movies/trending/delete/{$movie->id}");

    $response->assertRedirect('/');
    $response->assertStatus(302);
}, ['skip_before' => true]);
