<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Super admin',
            'email' => 'admin@politanisamarinda.ac.id',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'remember_token' => \Illuminate\Support\Str::random(10),
            'login_as' => 'admin',
            'group_id' => 1,
        ]);
    }
}
