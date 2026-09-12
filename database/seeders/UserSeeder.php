<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Primary Editor Account
        User::updateOrCreate(
            ['email' => 'editor@nsfwhen.com'],
            [
                'name' => 'Editor Admin',
                'password' => Hash::make('password'),
                'is_editor' => true,
                'reputation_score' => 3500,
                'preferred_genres' => ['Drama', 'Thriller', 'Sci-Fi'],
                'locale' => 'tr',
            ]
        );

        // 2. Demo Community Contributors
        $users = [
            [
                'email' => 'kerem_a@example.com',
                'name' => 'kerem_a',
                'password' => Hash::make('password'),
                'is_editor' => false,
                'reputation_score' => 2410,
                'preferred_genres' => ['Drama', 'Sci-Fi', 'Thriller', 'Documentary'],
                'locale' => 'en',
            ],
            [
                'email' => 'mira_k@example.com',
                'name' => 'mira_k',
                'password' => Hash::make('password'),
                'is_editor' => false,
                'reputation_score' => 1250,
                'preferred_genres' => ['Drama', 'Romance', 'Comedy'],
                'locale' => 'tr',
            ],
            [
                'email' => 'deniz_y@example.com',
                'name' => 'deniz_y',
                'password' => Hash::make('password'),
                'is_editor' => false,
                'reputation_score' => 820,
                'preferred_genres' => ['Sci-Fi', 'Horror', 'Mystery'],
                'locale' => 'tr',
            ],
            [
                'email' => 'onur_t@example.com',
                'name' => 'onur_t',
                'password' => Hash::make('password'),
                'is_editor' => false,
                'reputation_score' => 450,
                'preferred_genres' => ['Action', 'Thriller'],
                'locale' => 'tr',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], $u);
        }
    }
}
