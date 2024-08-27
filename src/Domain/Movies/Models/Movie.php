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
        'adult',
        'original_language',
        // 'genre_ids',
        'popularity',
        'release_date',
        'video',
        'vote_average',
        'vote_count',
    ];

    protected $casts = [
        'adult' => 'boolean',
        'video' => 'boolean',
        // 'genre_ids' => 'array',
        'popularity' => 'float',
        'vote_average' => 'float',
        'release_date' => 'date',
    ];
}
