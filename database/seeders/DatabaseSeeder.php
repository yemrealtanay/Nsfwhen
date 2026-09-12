<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's production database with static metadata and initial master editor.
     */
    public function run(): void
    {
        $this->call([
            BadgeSeeder::class,
            InitialEditorSeeder::class,
        ]);
    }
}
