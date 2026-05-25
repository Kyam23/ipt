<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-admin-user {email : The email of the user} {--create : Create user if not exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user an admin by email address. Use --create flag to create new user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $shouldCreate = $this->option('create');

        $user = User::where('email', $email)->first();

        if (!$user) {
            if (!$shouldCreate) {
                $this->error("User with email '{$email}' not found.");
                $this->info("Tip: Use --create flag to create a new user:");
                $this->info("  php artisan app:make-admin-user $email --create");
                return 1;
            }

            // Create new user
            $name = $this->ask('Enter full name for this user');
            $password = $this->secret('Enter password (will be hashed)');

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'role' => 'admin',
            ]);

            $this->info("✅ User created and made admin successfully!");
            $this->line("📧 Email: $email");
            $this->line("👤 Name: $name");
            return 0;
        }

        if ($user->isAdmin()) {
            $this->info("{$user->name} is already an admin.");
            return 0;
        }

        $user->update(['role' => 'admin']);

        $this->info("✅ Successfully made {$user->name} ({$email}) an admin!");
        return 0;
    }
}
