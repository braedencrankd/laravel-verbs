<?php

namespace Database\Seeders;

use App\Models\Plan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Test User 3',
            'email' => 'test3@example.com',
            'password' => bcrypt('password'),
        ]);

        Plan::factory(3)->create();

        auth()->login($user);
    }
}
