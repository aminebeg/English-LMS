<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    // Show all published courses for browsing
    public function browse(Request $request)
    {
        $query = Course::published()
            ->with('tutor', 'lessons', 'tests');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('level') && $request->input('level') !== '') {
            $query->where('level', $request->input('level'));
        }

        if ($request->has('type') && $request->input('type') !== '') {
            $query->where('type', $request->input('type'));
        }

        $courses = $query->latest()->paginate(12)->withQueryString();

        return view('courses.browse', compact('courses'));
    }

    // Enroll a student in a course
    public function enroll(Course $course)
    {
        $user = Auth::user();

        // Check if course is published
        if (!$course->is_published) {
            return redirect()->back()->with('error', 'This course is not available for enrollment.');
        }

        // Check if already enrolled
        if ($course->isEnrolledBy($user)) {
            return redirect()->route('enrollments.show', $course)->with('info', 'You are already enrolled in this course.');
        }

        // Create enrollment
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress' => [
                'completed_lessons' => [],
                'completed_tests' => [],
            ],
        ]);

        return redirect()->route('enrollments.show', $course)->with('status', 'Successfully enrolled in ' . $course->title . '!');
    }

    // Show all enrolled courses for the student
    public function index()
    {
        $user = Auth::user();
        $enrollments = Enrollment::where('user_id', $user->id)
            ->with('course.tutor', 'course.lessons', 'course.tests')
            ->latest()
            ->get();

        return view('enrollments.index', compact('enrollments'));
    }

    // Show a specific enrolled course
    public function show(Course $course)
    {
        $user = Auth::user();

        // Check if user is enrolled
        if (!$course->isEnrolledBy($user)) {
            return redirect()->route('courses.browse')->with('error', 'You must enroll in this course first.');
        }

        $enrollment = $course->getEnrollmentFor($user);
        $progress = $course->getProgressFor($user);

        return view('enrollments.show', compact('course', 'enrollment', 'progress'));
    }
}
