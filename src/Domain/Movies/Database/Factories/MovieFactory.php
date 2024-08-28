<?php

namespace Domain\Movies\Database\Factories;

use Domain\Movies\Enums\MovieTimeWindow;
use Domain\Movies\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {
        return [
            'tmdb_id' => $this->faker->unique()->numberBetween(1, 100000),
            'title' => $this->faker->sentence(3),
            'original_title' => $this->faker->sentence(3),
            'overview' => $this->faker->paragraph,
            'poster_path' => $this->faker->imageUrl(),
            'backdrop_path' => $this->faker->imageUrl(),
            'media_type' => 'movie',
            'is_adult' => $this->faker->boolean,
            'original_language' => $this->faker->languageCode,
            'popularity' => $this->faker->randomFloat(2, 0, 100),
            'release_date' => $this->faker->date(),
            'is_video' => $this->faker->boolean,
            'vote_average' => $this->faker->randomFloat(1, 0, 10),
            'vote_count' => $this->faker->numberBetween(0, 10000),
            'time_window' => MovieTimeWindow::DAY->value,
        ];
    }
}
