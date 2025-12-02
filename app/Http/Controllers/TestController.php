<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function create(Request $request)
    {
        $course = Course::findOrFail($request->query('course'));
        $this->authorize('update', $course);
        $course->load('sections', 'lessons');
        return view('tests.create', compact('course'));
    }

    public function store(Request $request)
    {
        $course = Course::findOrFail($request->input('course_id'));
        $this->authorize('update', $course);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
            'order' => 'required|integer',
            'lesson_id' => 'nullable|exists:lessons,id',
            'course_section_id' => 'nullable|exists:course_sections,id',
            'type' => 'nullable|string|in:quiz,final_exam',
        ]);

        // Ensure type is set if not provided
        if (!isset($validated['type'])) {
            $validated['type'] = 'quiz';
        }

        $course->tests()->create($validated);

        return redirect()->route('courses.edit', $course)->with('status', 'Test created! 🎉');
    }

    public function show(Test $test)
    {
        $this->authorize('view', $test->course);
        return view('tests.show', compact('test'));
    }

    public function edit(Test $test)
    {
        $this->authorize('update', $test->course);
        $test->course->load('sections', 'lessons');
        return view('tests.edit', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $this->authorize('update', $test->course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
            'order' => 'required|integer',
            'lesson_id' => 'nullable|exists:lessons,id',
            'course_section_id' => 'nullable|exists:course_sections,id',
            'type' => 'nullable|string|in:quiz,final_exam',
        ]);

        $test->update($validated);

        return redirect()->route('courses.edit', $test->course)->with('status', 'Test updated! ✅');
    }

    public function destroy(Test $test)
    {
        $this->authorize('update', $test->course);
        $course = $test->course;
        $test->delete();

        return redirect()->route('courses.edit', $course)->with('status', 'Test deleted!');
    }

    public function duplicate(Test $test)
    {
        $this->authorize('update', $test->course);
        
        // Create a copy of the test
        $newTest = $test->replicate();
        $newTest->title = $test->title . ' (Copy)';
        $newTest->order = $test->course->tests()->max('order') + 1;
        $newTest->save();
        
        // Copy all questions
        foreach ($test->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->test_id = $newTest->id;
            $newQuestion->save();
        }
        
        return redirect()->route('courses.edit', $test->course)->with('status', 'Test duplicated successfully! 📋');
    }

    public function reorder(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|exists:tests,id'
        ]);

        foreach ($validated['order'] as $index => $testId) {
            $course->tests()->where('id', $testId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Tests reordered successfully!']);
    }

    public function results(Test $test)
    {
        $this->authorize('update', $test->course);
        
        $results = $test->results()->with('user')->latest()->get();
        
        return view('tests.results', compact('test', 'results'));
    }
}
