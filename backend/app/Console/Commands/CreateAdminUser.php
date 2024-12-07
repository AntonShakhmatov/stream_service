<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'create:admin {email} {password}';
    protected $description = 'Создать администратора';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
            // 'role' => 'admin',
        ]);

        $this->info("Администратор с email {$email} успешно создан.");
    }
}

// Command for making administrator: php artisan create:admin admin@example.com yourpassword
