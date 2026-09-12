<?php

use App\Jobs\SyncFilmFromTmdbJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Shared hosting queue runner triggered by scheduler
Schedule::command('queue:work --stop-when-empty --max-time=50')
    ->everyMinute()
    ->withoutOverlapping();

Artisan::command('film:sync-tmdb {tmdb_id}', function ($tmdbId) {
    $this->info("Dispatching TMDb sync job for ID {$tmdbId}...");
    SyncFilmFromTmdbJob::dispatchSync((int) $tmdbId);
    $this->info('Done.');
})->purpose('Sync movie metadata from TMDb');
