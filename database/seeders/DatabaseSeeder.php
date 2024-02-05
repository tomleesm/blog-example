<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 用在 HTTP Basic 認證的使用者
        \App\Models\User::factory()->create([
            'name' => 'dhh',
            'email' => 'dhh@example.com',
            'password' => Hash::make('secret')
        ]);
    }
}
