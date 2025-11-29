<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->teachingCourses()->with('lessons')->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'nullable|string|in:A1,A2,B1,B2,C1,C2',
            'type' => 'required|string|in:adult,kid,researcher',
            'price' => 'required|numeric|min:0',
        ]);

        $course = auth()->user()->teachingCourses()->create($validated);

        return redirect()->route('courses.show', $course)->with('status', 'Course created!');
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);
        $course->load('lessons.materials', 'tests');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'nullable|string|in:A1,A2,B1,B2,C1,C2',
            'type' => 'required|string|in:adult,kid,researcher',
            'price' => 'required|numeric|min:0',
            'is_published' => 'boolean',
        ]);

        $course->update($validated);

        return redirect()->route('courses.show', $course)->with('status', 'Course updated!');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();

        return redirect()->route('courses.index')->with('status', 'Course deleted!');
    }
}
