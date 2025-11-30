<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CoursePreviewController extends Controller
{
    public function show(Course $course)
    {
        // Only show published courses
        if (!$course->is_published) {
            abort(404);
        }

        // Load relationships
        $course->load(['tutor', 'lessons' => function($query) {
            $query->orderBy('order');
        }, 'tests' => function($query) {
            $query->orderBy('order');
        }]);

        // Count preview vs paid lessons
        $previewLessonsCount = $course->lessons->where('is_preview', true)->count();
        $totalLessonsCount = $course->lessons->count();

        return view('courses.preview', compact('course', 'previewLessonsCount', 'totalLessonsCount'));
    }
}
