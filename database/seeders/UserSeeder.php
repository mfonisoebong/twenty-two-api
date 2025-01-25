<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory(5)->create();

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Adnin',
            'phone' => fake()->phoneNumber(),
            'email' => config('app.admin_email'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('TTAvenue$2020'),
            'remember_token' => Str::random(10),
        ]);
    }
}
