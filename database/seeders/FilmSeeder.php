<?php

namespace Database\Seeders;

use App\Models\CleanVote;
use App\Models\Film;
use App\Models\Report;
use App\Models\Scene;
use App\Models\SceneVote;
use App\Models\User;
use App\Models\WatchedFilm;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    public function run(): void
    {
        $editor = User::where('email', 'editor@nsfwhen.com')->first();
        $kerem = User::where('email', 'kerem_a@example.com')->first();
        $mira = User::where('email', 'mira_k@example.com')->first();
        $deniz = User::where('email', 'deniz_y@example.com')->first();
        $onur = User::where('email', 'onur_t@example.com')->first();

        // 1. Poor Things (2023)
        $poorThings = Film::updateOrCreate(
            ['tmdb_id' => 792307],
            [
                'title' => 'Poor Things',
                'original_title' => 'Poor Things',
                'release_date' => '2023-12-08',
                'runtime_minutes' => 141,
                'genres' => ['Drama', 'Comedy', 'Romance'],
                'director' => 'Yorgos Lanthimos',
                'cast' => ['Emma Stone', 'Mark Ruffalo', 'Willem Dafoe', 'Ramy Youssef'],
                'overview' => 'The incredible tale about the fantastical evolution of Bella Baxter, a young woman brought back to life by the brilliant and unorthodox scientist Dr. Godwin Baxter.',
                'delist_status' => 'active',
                'clean_votes_count' => 0,
            ]
        );

        $ptScenes = [
            [1120, 1165, 'suggestive', 'verified', $deniz->id, $editor->id, 41],
            [1870, 1985, 'nudity', 'verified', $mira->id, $editor->id, 63],
            [2842, 2998, 'sex_scene', 'verified', $kerem->id, $editor->id, 88],
            [3485, 3552, 'nudity', 'unverified', $onur->id, null, 2],
            [3734, 3888, 'sex_scene', 'verified', $kerem->id, $editor->id, 71],
            [4530, 4604, 'suggestive', 'unverified', $mira->id, null, 5],
            [6068, 6200, 'sex_scene', 'verified', $deniz->id, $editor->id, 57],
            [7435, 7480, 'nudity', 'unverified', $onur->id, null, 9],
        ];

        foreach ($ptScenes as $ps) {
            $sc = Scene::create([
                'film_id' => $poorThings->id,
                'start_time_seconds' => $ps[0],
                'end_time_seconds' => $ps[1],
                'category' => $ps[2],
                'verification_status' => $ps[3],
                'submitted_by' => $ps[4],
                'reviewed_by' => $ps[5],
                'reviewed_at' => $ps[5] ? now()->subDays(5) : null,
            ]);

            // Add confirm votes
            SceneVote::create(['scene_id' => $sc->id, 'user_id' => $kerem->id, 'vote_type' => 'confirm']);
            if ($ps[6] > 1) {
                SceneVote::create(['scene_id' => $sc->id, 'user_id' => $mira->id, 'vote_type' => 'confirm']);
            }
        }

        // 2. Babylon (2022)
        $babylon = Film::updateOrCreate(
            ['tmdb_id' => 615777],
            [
                'title' => 'Babylon',
                'original_title' => 'Babylon',
                'release_date' => '2022-12-23',
                'runtime_minutes' => 189,
                'genres' => ['Drama', 'Comedy', 'History'],
                'director' => 'Damien Chazelle',
                'cast' => ['Brad Pitt', 'Margot Robbie', 'Diego Calva', 'Jean Smart'],
                'delist_status' => 'active',
                'clean_votes_count' => 0,
            ]
        );

        $babylonScene = Scene::create([
            'film_id' => $babylon->id,
            'start_time_seconds' => 5050,
            'end_time_seconds' => 5162,
            'category' => 'sex_scene',
            'verification_status' => 'unverified',
            'submitted_by' => $mira->id,
        ]);
        SceneVote::create(['scene_id' => $babylonScene->id, 'user_id' => $kerem->id, 'vote_type' => 'confirm']);
        SceneVote::create(['scene_id' => $babylonScene->id, 'user_id' => $deniz->id, 'vote_type' => 'confirm']);
        SceneVote::create(['scene_id' => $babylonScene->id, 'user_id' => $onur->id, 'vote_type' => 'confirm']);

        // 3. Past Lives (2023) — Clean verified!
        $pastLives = Film::updateOrCreate(
            ['tmdb_id' => 666277],
            [
                'title' => 'Past Lives',
                'original_title' => 'Past Lives',
                'release_date' => '2023-06-02',
                'runtime_minutes' => 105,
                'genres' => ['Drama', 'Romance'],
                'director' => 'Celine Song',
                'cast' => ['Greta Lee', 'Teo Yoo', 'John Magaro'],
                'delist_status' => 'active',
                'clean_votes_count' => 9,
                'clean_confirmed_by' => $editor->id,
                'clean_confirmed_at' => now()->subDays(10),
            ]
        );
        CleanVote::create(['film_id' => $pastLives->id, 'user_id' => $kerem->id]);
        CleanVote::create(['film_id' => $pastLives->id, 'user_id' => $deniz->id]);
        CleanVote::create(['film_id' => $pastLives->id, 'user_id' => $mira->id]);

        // 4. Dune: Part Two (2024) — Clean verified!
        $dune2 = Film::updateOrCreate(
            ['tmdb_id' => 693134],
            [
                'title' => 'Dune: Part Two',
                'original_title' => 'Dune: Part Two',
                'release_date' => '2024-03-01',
                'runtime_minutes' => 166,
                'genres' => ['Sci-Fi', 'Action', 'Drama'],
                'director' => 'Denis Villeneuve',
                'cast' => ['Timothée Chalamet', 'Zendaya', 'Rebecca Ferguson', 'Javier Bardem'],
                'delist_status' => 'active',
                'clean_votes_count' => 14,
                'clean_confirmed_by' => $editor->id,
                'clean_confirmed_at' => now()->subDays(12),
            ]
        );

        // 5. The Favourite (2018)
        $theFavourite = Film::updateOrCreate(
            ['tmdb_id' => 375262],
            [
                'title' => 'The Favourite',
                'original_title' => 'The Favourite',
                'release_date' => '2018-11-23',
                'runtime_minutes' => 119,
                'genres' => ['Drama', 'Comedy', 'History'],
                'director' => 'Yorgos Lanthimos',
                'cast' => ['Olivia Colman', 'Emma Stone', 'Rachel Weisz', 'Nicholas Hoult'],
                'delist_status' => 'active',
                'clean_votes_count' => 0,
            ]
        );
        Scene::create([
            'film_id' => $theFavourite->id,
            'start_time_seconds' => 3160,
            'end_time_seconds' => 3210,
            'category' => 'suggestive',
            'verification_status' => 'unverified',
            'submitted_by' => $onur->id,
        ]);

        // 6. Oppenheimer (2023)
        $oppenheimer = Film::updateOrCreate(
            ['tmdb_id' => 872585],
            [
                'title' => 'Oppenheimer',
                'original_title' => 'Oppenheimer',
                'release_date' => '2023-07-21',
                'runtime_minutes' => 180,
                'genres' => ['Drama', 'History'],
                'director' => 'Christopher Nolan',
                'cast' => ['Cillian Murphy', 'Emily Blunt', 'Matt Damon', 'Robert Downey Jr.', 'Florence Pugh'],
                'delist_status' => 'active',
                'clean_votes_count' => 1,
            ]
        );
        $oppScene = Scene::create([
            'film_id' => $oppenheimer->id,
            'start_time_seconds' => 2472,
            'end_time_seconds' => 2520,
            'category' => 'nudity',
            'verification_status' => 'verified',
            'submitted_by' => $mira->id,
            'reviewed_by' => $editor->id,
            'reviewed_at' => now()->subDays(2),
        ]);

        // Report on oppenheimer scene
        Report::create([
            'reportable_type' => Scene::class,
            'reportable_id' => $oppScene->id,
            'reporter_id' => $deniz->id,
            'reason' => 'Category should be sex_scene instead of nudity due to dialogue context.',
            'status' => 'pending',
        ]);

        // 7. The Handmaiden (2016)
        $handmaiden = Film::updateOrCreate(
            ['tmdb_id' => 290098],
            [
                'title' => 'The Handmaiden',
                'original_title' => 'Agassi',
                'release_date' => '2016-06-01',
                'runtime_minutes' => 145,
                'genres' => ['Thriller', 'Drama', 'Romance'],
                'director' => 'Park Chan-wook',
                'cast' => ['Kim Min-hee', 'Kim Tae-ri', 'Ha Jung-woo', 'Cho Jin-woong'],
                'delist_status' => 'active',
                'clean_votes_count' => 0,
            ]
        );
        $hmScene = Scene::create([
            'film_id' => $handmaiden->id,
            'start_time_seconds' => 5885,
            'end_time_seconds' => 6110,
            'category' => 'sex_scene',
            'verification_status' => 'unverified',
            'submitted_by' => $kerem->id,
        ]);
        SceneVote::create(['scene_id' => $hmScene->id, 'user_id' => $mira->id, 'vote_type' => 'confirm']);
        SceneVote::create(['scene_id' => $hmScene->id, 'user_id' => $deniz->id, 'vote_type' => 'confirm']);
        SceneVote::create(['scene_id' => $hmScene->id, 'user_id' => $onur->id, 'vote_type' => 'confirm']);

        // 8. Delist Candidate Film: Arrival (2016) with 6 clean votes
        $arrival = Film::updateOrCreate(
            ['tmdb_id' => 329865],
            [
                'title' => 'Arrival',
                'original_title' => 'Arrival',
                'release_date' => '2016-11-11',
                'runtime_minutes' => 116,
                'genres' => ['Drama', 'Sci-Fi', 'Mystery'],
                'director' => 'Denis Villeneuve',
                'cast' => ['Amy Adams', 'Jeremy Renner', 'Forest Whitaker'],
                'delist_status' => 'delist_candidate',
                'clean_votes_count' => 6,
            ]
        );
        CleanVote::create(['film_id' => $arrival->id, 'user_id' => $kerem->id]);
        CleanVote::create(['film_id' => $arrival->id, 'user_id' => $mira->id]);
        CleanVote::create(['film_id' => $arrival->id, 'user_id' => $deniz->id]);
        CleanVote::create(['film_id' => $arrival->id, 'user_id' => $onur->id]);
        CleanVote::create(['film_id' => $arrival->id, 'user_id' => $editor->id]);

        // Watched films for kerem_a
        WatchedFilm::create(['user_id' => $kerem->id, 'film_id' => $poorThings->id]);
        WatchedFilm::create(['user_id' => $kerem->id, 'film_id' => $babylon->id]);
        WatchedFilm::create(['user_id' => $kerem->id, 'film_id' => $pastLives->id]);
        WatchedFilm::create(['user_id' => $kerem->id, 'film_id' => $dune2->id]);
        WatchedFilm::create(['user_id' => $kerem->id, 'film_id' => $oppenheimer->id]);
        WatchedFilm::create(['user_id' => $kerem->id, 'film_id' => $handmaiden->id]);
    }
}
