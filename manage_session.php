<?php

use App\Models\Classroom;
use App\Models\ClassroomSession;
use App\Models\User;
use App\Models\Course;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Find the classroom
$classroom = Classroom::where('title', 'Live Business English Session')->first();

if (!$classroom) {
    echo "Classroom not found. Creating one...\n";
    // Create if missing (fallback)
    $tutor = User::where('email', 'tutor@test.com')->first();
    $course = Course::where('title', 'Business English Masterclass')->first();
    
    $classroom = Classroom::create([
        'teacher_id' => $tutor->id,
        'course_id' => $course->id,
        'title' => 'Live Business English Session',
        'description' => 'Auto-created session',
        'max_participants' => 20,
        'is_public' => true,
        'join_code' => 'TESTCODE'
    ]);
}

echo "Classroom ID: " . $classroom->id . "\n";
echo "Join Code: " . $classroom->join_code . "\n";

// 2. Check/Start Session
$session = $classroom->sessions()->whereNull('ended_at')->first();
if (!$session) {
    echo "No active session. Starting one...\n";
    $session = $classroom->startSession();
    echo "Session started.\n";
} else {
    echo "Active session found.\n";
}

// 3. Verify Student Enrollment
$student = User::where('email', 'student@test.com')->first();
$course = $classroom->course;

if ($course && $course->isEnrolledBy($student)) {
    echo "Student IS enrolled in the linked course.\n";
} else {
    echo "Student is NOT enrolled. Enrolling now...\n";
    $course->enroll($student);
    echo "Student enrolled.\n";
}
