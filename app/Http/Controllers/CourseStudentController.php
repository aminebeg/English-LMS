<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseStudentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $this->authorize('update', $course);

        $students = $course->students()
            ->with(['enrollments' => function($query) use ($course) {
                $query->where('course_id', $course->id);
            }])
            ->paginate(10);

        // Calculate progress for each student
        foreach ($students as $student) {
            $student->progress = $course->getProgressFor($student);
            $student->enrollment = $student->enrollments->first();
        }

        return view('courses.students', compact('course', 'students'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, User $student)
    {
        $this->authorize('update', $course);

        // Find the enrollment
        $enrollment = Enrollment::where('course_id', $course->id)
            ->where('user_id', $student->id)
            ->firstOrFail();

        $enrollment->delete();

        return redirect()->back()->with('status', 'Student removed from course successfully.');
    }
}
