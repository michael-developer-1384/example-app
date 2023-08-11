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
        //Create Admin Eser
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'is_admin' => true,
        ]);

        // Create Roles
        $roles = ['Administrator', 'Manager', 'Participant', 'Trainer'];
        foreach ($roles as $roleName) {
            \App\Models\Role::create(['name' => $roleName]);
        } 

        // Create 10 users
        \App\Models\User::factory(10)->create(['is_active' => true]);

        // Create 10 companies
        $companies = \App\Models\Company::factory(10)->create();

        // Create an additional 100 users and randomly assign them to companies
        $users = \App\Models\User::factory(100)->create(['is_active' => true, 'is_full_profile' => false]);
        foreach ($users as $user) {
            $company = $companies->random();
            $role = \App\Models\Role::where('name', 'Participant')->first();
            $user->companies()->attach($company->id, ['role_id' => $role->id]);
        }

        // For each company, create a user with the "Administrator" role
        foreach ($companies as $company) {
            $user = \App\Models\User::factory()->create(['is_active' => true]);
            $role = \App\Models\Role::where('name', 'Administrator')->first();
            $user->companies()->attach($company->id, ['role_id' => $role->id]);
        }
    }
}
