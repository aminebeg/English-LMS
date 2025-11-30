<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create test result
$testResult = \App\Models\TestResult::create([
    'user_id' => 4,
    'test_id' => 1,
    'score' => 100,
    'passed' => true,
    'answers' => ['1' => '4'],
    'completed_at' => now(),
]);

echo "Test result created: ID {$testResult->id}\n";

// Update enrollment progress
$enrollment = \App\Models\Enrollment::where('user_id', 4)->where('course_id', 3)->first();
$progress = $enrollment->progress ?? ['completed_lessons' => [], 'completed_tests' => []];

if (!in_array(1, $progress['completed_tests'])) {
    $progress['completed_tests'][] = 1;
    $enrollment->update(['progress' => $progress]);
    echo "Enrollment progress updated\n";
}

$enrollment->refresh();
echo "Progress: " . json_encode($enrollment->progress) . "\n";
echo "Course progress: " . \App\Models\Course::find(3)->getProgressFor(\App\Models\User::find(4)) . "%\n";
