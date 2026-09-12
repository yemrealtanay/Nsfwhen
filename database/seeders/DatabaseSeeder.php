<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BadgeSeeder::class,
            UserSeeder::class,
            FilmSeeder::class,
        ]);

        // Attach demo badges to kerem_a matching design screen 1f
        $kerem = User::where('email', 'kerem_a@example.com')->first();
        if ($kerem) {
            $badges = Badge::whereIn('key', ['first_mark', 'timekeeper', 'clean_sweep', 'second_pair_of_eyes', 'archivist', 'steady_hand'])->get();
            foreach ($badges as $b) {
                $kerem->badges()->syncWithoutDetaching([$b->id => ['earned_at' => now()->subDays(rand(5, 60))]]);
            }
        }
    }
}
