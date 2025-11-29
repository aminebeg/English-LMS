<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLessonController extends Controller
{
    // Show lesson content to student
    public function show(Lesson $lesson)
    {
        $user = Auth::user();
        $course = $lesson->course;

        // Check if user is enrolled
        if (!$course->isEnrolledBy($user)) {
            return redirect()->route('courses.browse')->with('error', 'You must be enrolled in this course to view lessons.');
        }

        // Get enrollment to check progress
        $enrollment = $course->getEnrollmentFor($user);
        $progress = $enrollment->progress ?? ['completed_lessons' => [], 'completed_tests' => []];
        $isCompleted = in_array($lesson->id, $progress['completed_lessons']);

        // Load materials
        $materials = $lesson->materials;

        return view('learn.lesson', compact('lesson', 'course', 'isCompleted', 'materials'));
    }

    // Mark lesson as complete
    public function markComplete(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        $course = $lesson->course;

        // Verify enrollment
        if (!$course->isEnrolledBy($user)) {
            return redirect()->route('courses.browse')->with('error', 'Unauthorized access.');
        }

        $enrollment = $course->getEnrollmentFor($user);
        $progress = $enrollment->progress ?? ['completed_lessons' => [], 'completed_tests' => []];

        // Add lesson to completed if not already there
        if (!in_array($lesson->id, $progress['completed_lessons'])) {
            $progress['completed_lessons'][] = $lesson->id;
            $enrollment->update(['progress' => $progress]);
        }

        return redirect()->back()->with('status', 'Lesson marked as complete!');
    }

    // Mark lesson as incomplete (for review)
    public function markIncomplete(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        $course = $lesson->course;

        // Verify enrollment
        if (!$course->isEnrolledBy($user)) {
            return redirect()->route('courses.browse')->with('error', 'Unauthorized access.');
        }

        $enrollment = $course->getEnrollmentFor($user);
        $progress = $enrollment->progress ?? ['completed_lessons' => [], 'completed_tests' => []];

        // Remove lesson from completed
        $progress['completed_lessons'] = array_values(array_diff($progress['completed_lessons'], [$lesson->id]));
        $enrollment->update(['progress' => $progress]);

        return redirect()->back()->with('status', 'Lesson marked as incomplete.');
    }
}
