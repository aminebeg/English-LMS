<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'editor',
            'is_approved' => true,
        ]);
    }
}
