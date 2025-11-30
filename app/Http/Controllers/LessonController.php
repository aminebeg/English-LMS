<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function create(Request $request)
    {
        $course = Course::findOrFail($request->course);
        $this->authorize('update', $course);
        return view('lessons.create', compact('course'));
    }

    public function store(Request $request)
    {
        $course = Course::findOrFail($request->course_id);
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_free' => 'boolean',
        ]);

        $course->lessons()->create($validated);

        return redirect()->route('courses.show', $course)->with('status', 'Lesson created!');
    }

    public function show(Lesson $lesson)
    {
        $this->authorize('view', $lesson->course);
        $lesson->load('materials');
        return view('lessons.show', compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
        $this->authorize('update', $lesson->course);
        return view('lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $this->authorize('update', $lesson->course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_free' => 'boolean',
        ]);

        $lesson->update($validated);

        return redirect()->route('lessons.show', $lesson)->with('status', 'Lesson updated!');
    }

    public function destroy(Lesson $lesson)
    {
        $course = $lesson->course;
        $this->authorize('update', $course);
        $lesson->delete();

        return redirect()->route('courses.show', $course)->with('status', 'Lesson deleted!');
    }
}
