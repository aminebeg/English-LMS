<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create Editor
        $editor = User::updateOrCreate(
            ['email' => 'editor@test.com'],
            [
                'name' => 'Editor Test',
                'password' => Hash::make('password123'),
                'is_approved' => true,
            ]
        );
        $editor->assignRole('editor');

        // Create Tutor
        $tutor = User::updateOrCreate(
            ['email' => 'tutor@test.com'],
            [
                'name' => 'Tutor Test',
                'password' => Hash::make('password123'),
                'is_approved' => true,
            ]
        );
        $tutor->assignRole('tutor');

        // Create Student
        $student = User::updateOrCreate(
            ['email' => 'student@test.com'],
            [
                'name' => 'Student Test',
                'password' => Hash::make('password123'),
                'is_approved' => true,
            ]
        );
        $student->assignRole('student');
    }
}
