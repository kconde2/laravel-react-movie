<?php

use App\Models\User;
use Domain\Movies\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('deletes a movie successfully', function () {
    // Arrange
    /** @var Illuminate\Contracts\Auth\Authenticatable */
    $user = User::factory()->create();
    actingAs($user);
    $movie = Movie::factory()->create();

    // Act
    $response = actingAs($user)->delete("/dashboard/movies/trending/delete/$movie->id");

    // Assert
    $response->assertStatus(302);
    $this->assertDatabaseMissing('movies', ['id' => $movie->id, 'deleted_at' => null]);
    $response->assertSessionHas('success', 'Movie deleted successfully.');
});

it('returns a 404 for an incorrect URL', function () {
    // Arrange
    /** @var Illuminate\Contracts\Auth\Authenticatable */
    $user = User::factory()->create();
    actingAs($user);

    // Act
    $response = actingAs($user)->delete('/dashboard/movies/trending/incorrect-url');

    // Assert
    $response->assertStatus(404);
});

it('returns a 404 when trying to delete a non-existent movie', function () {
    // Arrange
    /** @var Illuminate\Contracts\Auth\Authenticatable */
    $user = User::factory()->create();
    actingAs($user);

    // Utilisez un ID de film qui n'existe pas (par exemple, 9999)
    $nonExistentMovieId = 9999;

    // Act
    $response = actingAs($user)->delete("/dashboard/movies/trending/delete/$nonExistentMovieId");

    // Assert
    $response->assertStatus(404);
});
