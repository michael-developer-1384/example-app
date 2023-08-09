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
        
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.com',
        ]);

        \App\Models\User::factory(10)->create();

        \App\Models\Company::factory(5)->create()->each(function ($company) {
            $users = \App\Models\User::inRandomOrder()->take(rand(1, 3))->get();
            $company->users()->attach($users);
        });
    
        \App\Models\Role::factory(3)->create()->each(function ($role) {
            $users = \App\Models\User::inRandomOrder()->take(rand(1, 4))->get();
            $role->users()->attach($users);
        });
    }
}
