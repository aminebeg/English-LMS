<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Request $request)
    {
        $test = Test::findOrFail($request->query('test'));
        $this->authorize('update', $test->course);
        return view('questions.create', compact('test'));
    }

    public function store(Request $request)
    {
        $test = Test::findOrFail($request->input('test_id'));
        $this->authorize('update', $test->course);

        $validated = $request->validate([
            'test_id' => 'required|exists:tests,id',
            'content' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false,short_answer',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
            'correct_answer' => 'required|string',
            'order' => 'required|integer',
        ]);

        // Clean up options if not multiple choice
        if ($validated['type'] !== 'multiple_choice') {
            $validated['options'] = null;
        }

        $test->questions()->create($validated);

        return redirect()->route('tests.show', $test)->with('status', 'Question added!');
    }

    public function edit(Question $question)
    {
        $this->authorize('update', $question->test->course);
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question->test->course);

        $validated = $request->validate([
            'content' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false,short_answer',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
            'correct_answer' => 'required|string',
            'order' => 'required|integer',
        ]);

        // Clean up options if not multiple choice
        if ($validated['type'] !== 'multiple_choice') {
            $validated['options'] = null;
        }

        $question->update($validated);

        return redirect()->route('tests.show', $question->test)->with('status', 'Question updated!');
    }

    public function destroy(Question $question)
    {
        $test = $question->test;
        $this->authorize('update', $test->course);
        $question->delete();

        return redirect()->route('tests.show', $test)->with('status', 'Question deleted!');
    }
}
