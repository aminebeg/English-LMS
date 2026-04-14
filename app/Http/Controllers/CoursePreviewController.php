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
        $course->load([
            'tutor',
            'sections' => function ($query) {
                $query->orderBy('order');
            },
            'sections.lessons' => function ($query) {
                $query->orderBy('order');
            },
            'sections.tests' => function ($query) {
                $query->orderBy('order');
            },
            'lessons' => function ($query) {
                $query->whereNull('course_section_id')->orderBy('order');
            },
            'tests' => function ($query) {
                $query->whereNull('course_section_id')->whereNull('lesson_id')->orderBy('order');
            }
        ]);

        // Calculate preview vs paid lessons from all sources
        $allLessons = $course->sections->flatMap->lessons->concat($course->lessons);
        $previewLessonsCount = $allLessons->where('is_preview', true)->count();
        $totalLessonsCount = $allLessons->count();

        return view('courses.preview', compact('course', 'previewLessonsCount', 'totalLessonsCount'));
    }
}
