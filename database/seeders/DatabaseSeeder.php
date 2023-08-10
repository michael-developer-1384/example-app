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
        $roles = ['Admin', 'Manager', 'Participant', 'Trainer'];
        foreach ($roles as $roleName) {
            \App\Models\Role::create(['name' => $roleName]);
        }
        
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.com',
        ]);

        \App\Models\User::factory(10)->create();

        \App\Models\Company::factory(5)->create()->each(function ($company) {
            $users = \App\Models\User::inRandomOrder()->take(rand(1, 3))->get();
            $company->users()->attach($users);
        });

    }
}
