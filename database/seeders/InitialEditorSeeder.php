<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialEditorSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('nsfwhen.initial_editor.email');
        $password = config('nsfwhen.initial_editor.password');
        $name = config('nsfwhen.initial_editor.name') ?: 'master';

        if (! empty($email) && ! empty($password)) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make($password),
                    'is_editor' => true,
                    'email_verified_at' => now(),
                    'reputation_score' => 5000,
                    'locale' => 'en',
                ]
            );
        }
    }
}
