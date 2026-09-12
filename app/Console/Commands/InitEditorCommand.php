<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class InitEditorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-editor
                            {--email= : The email address of the editor}
                            {--name= : The name/handle of the editor}
                            {--password= : The password for the editor account}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize or update the master editor account using .env credentials or CLI input';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->option('email') ?: config('nsfwhen.initial_editor.email');
        $name = $this->option('name') ?: (config('nsfwhen.initial_editor.name') ?: 'master');
        $password = $this->option('password') ?: config('nsfwhen.initial_editor.password');

        if (empty($email)) {
            $email = $this->ask('Editor email');
        }

        if (empty($email)) {
            $this->error('Email is required to create or promote an editor.');

            return self::FAILURE;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->is_editor = true;
            if (! $user->hasVerifiedEmail()) {
                $user->email_verified_at = now();
            }
            if (! empty($password)) {
                $user->password = Hash::make($password);
            }
            if ($this->option('name')) {
                $user->name = $name;
            }
            $user->save();

            $this->info("User [{$user->email}] successfully promoted to Editor!");

            return self::SUCCESS;
        }

        if (empty($password)) {
            $password = $this->secret('Password for new editor account');
        }

        if (empty($password)) {
            $this->error('Password is required when creating a new editor account.');

            return self::FAILURE;
        }

        $newUser = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_editor' => true,
            'email_verified_at' => now(),
            'reputation_score' => 5000,
            'locale' => 'en',
        ]);

        $this->info("Master editor [{$newUser->email}] successfully created with role: Editor.");

        return self::SUCCESS;
    }
}
