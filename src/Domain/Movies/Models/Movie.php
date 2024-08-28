<?php

namespace Domain\Movies\Models;

use Domain\Movies\Enums\MovieTimeWindow;
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
        'time_windows',
    ];

    protected $casts = [
        'time_windows' => 'array',
        'is_adult' => 'boolean',
        'is_video' => 'boolean',
        'popularity' => 'float',
        'vote_average' => 'float',
        'release_date' => 'date',
    ];

    public function syncTimeWindows(array $newWindows)
    {
        $validValues = array_map(fn ($case) => $case->value, MovieTimeWindow::cases());

        $currentWindows = $this->time_windows ?? [];

        $mergedWindows = array_merge($currentWindows, array_map(
            fn ($window) => $window instanceof MovieTimeWindow ? $window->value : $window,
            $newWindows
        ));

        $this->time_windows = array_values(array_unique(array_intersect($mergedWindows, $validValues)));

        $this->save();
    }
}
