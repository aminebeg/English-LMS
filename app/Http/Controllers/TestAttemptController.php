<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestAttemptController extends Controller
{
    // Show test-taking interface
    public function start(Test $test)
    {
        $user = Auth::user();
        $course = $test->course;

        // Check if user is enrolled
        if (!$course->isEnrolledBy($user)) {
            return redirect()->route('courses.browse')->with('error', 'You must be enrolled in this course to take the test.');
        }

        // Check if test has questions
        if ($test->questions->isEmpty()) {
            return redirect()->back()->with('error', 'This test has no questions yet.');
        }

        // Load questions with their order
        $questions = $test->questions()->orderBy('order')->get();

        return view('tests.take', compact('test', 'questions', 'course'));
    }

    // Submit test and calculate results
    public function submit(Request $request, Test $test)
    {
        $user = Auth::user();
        $course = $test->course;

        // Verify enrollment
        if (!$course->isEnrolledBy($user)) {
            return redirect()->route('courses.browse')->with('error', 'Unauthorized access.');
        }

        // Validate that all questions are answered
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        $answers = $validated['answers'];
        
        // Calculate score
        $result = $this->gradeTest($test, $answers);
        
        // Store test result
        $testResult = TestResult::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'score' => $result['score'],
            'passed' => $result['passed'],
            'answers' => $answers,
            'completed_at' => now(),
        ]);

        // Update enrollment progress
        $enrollment = $course->getEnrollmentFor($user);
        $progress = $enrollment->progress ?? ['completed_lessons' => [], 'completed_tests' => []];
        
        if (!in_array($test->id, $progress['completed_tests'])) {
            $progress['completed_tests'][] = $test->id;
            $enrollment->update(['progress' => $progress]);
        }

        return redirect()->route('tests.result', $testResult)->with('status', 'Test submitted successfully!');
    }

    // Show test results
    public function result(TestResult $testResult)
    {
        $user = Auth::user();

        // Check if this result belongs to the user
        if ($testResult->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $test = $testResult->test;
        $questions = $test->questions()->orderBy('order')->get();

        return view('tests.result', compact('testResult', 'test', 'questions'));
    }

    // Grade the test
    private function gradeTest(Test $test, array $answers): array
    {
        $questions = $test->questions;
        $totalQuestions = $questions->count();
        $correctAnswers = 0;

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? '';
            
            if ($this->isCorrectAnswer($question, $userAnswer)) {
                $correctAnswers++;
            }
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
        $passed = $score >= $test->passing_score;

        return [
            'score' => $score,
            'passed' => $passed,
            'correct_count' => $correctAnswers,
            'total_count' => $totalQuestions,
        ];
    }

    // Check if answer is correct
    private function isCorrectAnswer(Question $question, string $userAnswer): bool
    {
        $correctAnswer = trim($question->correct_answer);
        $userAnswer = trim($userAnswer);

        // For short answer, use case-insensitive comparison
        if ($question->type === 'short_answer') {
            return strtolower($userAnswer) === strtolower($correctAnswer);
        }

        // Exact match for multiple choice and true/false
        return $userAnswer === $correctAnswer;
    }
}
