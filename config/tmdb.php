<?php

return [
    'api_key' => env('TMDB_API_KEY', ''),
    'read_token' => env('TMDB_READ_TOKEN', ''),
    'base_url' => env('TMDB_BASE_URL', 'https://api.themoviedb.org/3'),
    'image_base_url' => env('TMDB_IMAGE_BASE_URL', 'https://image.tmdb.org/t/p'),
    'cache_ttl' => 86400, // 24 hours
];
