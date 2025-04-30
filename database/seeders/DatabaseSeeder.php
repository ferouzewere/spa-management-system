<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        // Create an admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => 1, // Admin role (assuming it's the first role created)
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Worker User',
            'email' => 'work@example.com',
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);
    }
}
