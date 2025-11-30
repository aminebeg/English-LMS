<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create Tutor
        $tutor = User::updateOrCreate(
            ['email' => 'tutor@test.com'],
            [
                'name' => 'Tutor Test',
                'password' => 'password',
                'is_approved' => true,
            ]
        );
        $tutor->assignRole('tutor');

        // Create Student
        $student = User::updateOrCreate(
            ['email' => 'student@test.com'],
            [
                'name' => 'Student Test',
                'password' => 'password',
                'is_approved' => true,
            ]
        );
        $student->assignRole('student');
    }
}
