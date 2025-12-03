<?php

use App\Models\Course;
use App\Models\User;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$course = Course::find(1);
$tutor = User::where('email', 'tutor@test.com')->first();

echo "--- DEBUG INFO ---\n";
if ($course) {
    echo "Course ID: " . $course->id . "\n";
    echo "Course Title: " . $course->title . "\n";
    echo "Course Tutor ID: " . $course->tutor_id . "\n";
    echo "Is Published: " . ($course->is_published ? 'Yes' : 'No') . "\n";
} else {
    echo "Course 1 not found.\n";
}

if ($tutor) {
    echo "Tutor User ID: " . $tutor->id . "\n";
    echo "Tutor Email: " . $tutor->email . "\n";
} else {
    echo "Tutor user not found.\n";
}

if ($course && $tutor) {
    echo "Tutor ID Type: " . gettype($course->tutor_id) . "\n";
    echo "User ID Type: " . gettype($tutor->id) . "\n";

    if ($course->tutor_id == $tutor->id) {
        echo "MATCH (Loose): The course belongs to this tutor.\n";
        
        // Force publish the course
        $course->is_published = true;
        $course->save();
        echo "SUCCESS: Course 1 has been FORCE PUBLISHED via script.\n";
    } else {
        echo "MISMATCH: The course tutor_id (" . $course->tutor_id . ") does not match the tutor user id (" . $tutor->id . ").\n";
    }
}
