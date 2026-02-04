<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@agripulse.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create worker user
        User::create([
            'name' => 'Worker User',
            'email' => 'worker@agripulse.com',
            'password' => Hash::make('password'),
            'role' => 'worker',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin and Worker users created successfully!');
        $this->command->info('Admin: admin@agripulse.com / password');
        $this->command->info('Worker: worker@agripulse.com / password');
    }
}
