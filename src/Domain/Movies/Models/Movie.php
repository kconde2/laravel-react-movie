<?php

namespace Domain\Movies\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'backdrop_path',
        'tmdb_id',
        'title',
        'original_title',
        'overview',
        'poster_path',
        'media_type',
        'is_adult',
        'original_language',
        'popularity',
        'release_date',
        'is_video',
        'vote_average',
        'vote_count',
        'time_window',
    ];

    protected $casts = [
        'is_adult' => 'boolean',
        'is_video' => 'boolean',
        'popularity' => 'float',
        'vote_average' => 'float',
        'release_date' => 'date',
    ];

    public function getPosterUrlAttribute(): string
    {
        $baseUrl = config('movie.tmdb.image_base_url');
        $imageSize = config('movie.tmdb.image_size');

        return "{$baseUrl}{$imageSize}{$this->poster_path}";
    }

    public function getBackdropUrlAttribute(): string
    {
        $baseUrl = config('movie.tmdb.image_base_url');
        $imageSize = config('movie.tmdb.image_size');

        return "{$baseUrl}{$imageSize}{$this->backdrop_path}";
    }
}
