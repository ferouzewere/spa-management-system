<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'manager',
            'employee',
            'client'
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => "$role"
            ]);
        }
    }
}
