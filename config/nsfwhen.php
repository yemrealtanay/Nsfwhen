<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Initial Master Editor Setup
    |--------------------------------------------------------------------------
    |
    | Credentials populated on fresh database seeding or via artisan command.
    | Kept securely in .env and not committed to source control.
    |
    */
    'initial_editor' => [
        'name' => env('INITIAL_EDITOR_NAME', 'master'),
        'email' => env('INITIAL_EDITOR_EMAIL'),
        'password' => env('INITIAL_EDITOR_PASSWORD'),
    ],
];
