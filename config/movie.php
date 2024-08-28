<?php

return [
    'tmdb' => [
        'key' => env('APP_TMDB_API_KEY', 'to-be-defined'),
        'url' => env('APP_TMDB_API_URL', 'to-be-defined'),
        'image_base_url' => 'http://image.tmdb.org/t/p/',
        'image_size' => 'w500',
    ],
];
