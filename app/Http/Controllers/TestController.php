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
        ]);

        $course->tests()->create($validated);

        return redirect()->route('courses.show', $course)->with('status', 'Test created!');
    }

    public function show(Test $test)
    {
        $this->authorize('view', $test->course);
        return view('tests.show', compact('test'));
    }

    public function edit(Test $test)
    {
        $this->authorize('update', $test->course);
        return view('tests.edit', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $this->authorize('update', $test->course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
            'order' => 'required|integer',
        ]);

        $test->update($validated);

        return redirect()->route('courses.show', $test->course)->with('status', 'Test updated!');
    }

    public function destroy(Test $test)
    {
        $this->authorize('update', $test->course);
        $test->delete();

        return redirect()->route('courses.show', $test->course)->with('status', 'Test deleted!');
    }

    public function results(Test $test)
    {
        $this->authorize('update', $test->course);
        
        $results = $test->results()->with('user')->latest()->get();
        
        return view('tests.results', compact('test', 'results'));
    }
}
