<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = ['Administrator', 'Manager', 'Participant', 'Trainer'];
        foreach ($roles as $roleName) {
            \App\Models\Role::create(['name' => $roleName]);
        }
        
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'is_admin' => true,
        ]);

    }
}
