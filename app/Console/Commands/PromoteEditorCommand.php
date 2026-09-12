<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteEditorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:promote-editor {email : The email address of the registered user to promote}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote an existing registered user to Editor role';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("User with email [{$email}] not found.");

            return self::FAILURE;
        }

        $user->is_editor = true;
        if (! $user->hasVerifiedEmail()) {
            $user->email_verified_at = now();
        }
        $user->save();

        $this->info("User [{$user->name}] ({$user->email}) is now an Editor!");

        return self::SUCCESS;
    }
}
