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
            'content' => 'required|string',
            'order' => 'required|integer|min:0',
            'is_preview' => 'boolean',
            'video_url' => 'nullable|url',
            'summary' => 'nullable|string',
            'objectives' => 'nullable|json',
            'notes' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'key_points' => 'nullable|json',
            'vocabulary' => 'nullable|json',
            'exercises' => 'nullable|json',
            'resources' => 'nullable|json',
            'is_published' => 'boolean',
        ]);

        // Decode JSON fields
        $jsonFields = ['objectives', 'key_points', 'vocabulary', 'exercises', 'resources'];
        foreach ($jsonFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_decode($validated[$field], true) ?? [];
            }
        }

        // Handle booleans
        $validated['is_preview'] = $request->has('is_preview');
        $validated['is_published'] = $request->has('is_published');
        
        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        $course->lessons()->create($validated);

        return redirect()->route('courses.show', $course)->with('status', 'Lesson created successfully!');
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
            'content' => 'required|string',
            'order' => 'required|integer|min:0',
            'is_preview' => 'boolean',
            'video_url' => 'nullable|url',
            'summary' => 'nullable|string',
            'objectives' => 'nullable|json',
            'notes' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'key_points' => 'nullable|json',
            'vocabulary' => 'nullable|json',
            'exercises' => 'nullable|json',
            'resources' => 'nullable|json',
            'is_published' => 'boolean',
        ]);

        // Decode JSON fields
        $jsonFields = ['objectives', 'key_points', 'vocabulary', 'exercises', 'resources'];
        foreach ($jsonFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_decode($validated[$field], true) ?? [];
            }
        }

        // Handle booleans
        $validated['is_preview'] = $request->has('is_preview');
        $validated['is_published'] = $request->has('is_published');

        $lesson->update($validated);

        return redirect()->route('lessons.show', $lesson)->with('status', 'Lesson updated successfully!');
    }

    public function destroy(Lesson $lesson)
    {
        $course = $lesson->course;
        $this->authorize('update', $course);
        $lesson->delete();

        return redirect()->route('courses.show', $course)->with('status', 'Lesson deleted!');
    }
}
