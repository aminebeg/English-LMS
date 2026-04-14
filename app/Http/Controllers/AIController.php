<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
            'provider' => 'nullable|string|in:gemini,cerebras',
        ]);

        try {
            $content = $this->aiService->generateContent(
                $request->input('prompt'),
                $request->input('provider', 'gemini')
            );
            return response()->json(['content' => $content]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function generateQuestions(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'topic' => 'required|string',
            'count' => 'nullable|integer|min:1|max:10',
            'provider' => 'nullable|string|in:gemini,cerebras',
        ]);

        $count = $request->input('count', 5);
        $topic = $request->input('topic');
        $testId = $request->input('test_id');
        $provider = $request->input('provider', 'cerebras'); // Default to cerebras

        $prompt = "Generate exactly {$count} multiple choice questions about '{$topic}' for an English learning test.

IMPORTANT: Return ONLY a valid JSON array with no additional text, no markdown, no code blocks.

Each question object must have these exact fields:
- \"content\": the question text (string)
- \"type\": \"multiple_choice\" (string)
- \"options\": array of exactly 4 answer choices (array of strings)
- \"correct_answer\": the correct answer which must be one of the options (string)

Example of the EXACT format needed:
[{\"content\":\"What is the past tense of go?\",\"type\":\"multiple_choice\",\"options\":[\"goed\",\"gone\",\"went\",\"going\"],\"correct_answer\":\"went\"}]

Generate {$count} questions now:";

        try {
            $content = $this->aiService->generateContent($prompt, $provider);

            // Log the raw response for debugging
            \Log::info('AI Response for questions:', ['response' => $content]);

            // Clean up the response - remove markdown code blocks
            $content = trim($content);
            $content = preg_replace('/^```(?:json)?\s*/i', '', $content);
            $content = preg_replace('/\s*```$/', '', $content);
            $content = trim($content);
            
            // Try to extract JSON array if there's extra text
            if (preg_match('/\[[\s\S]*\]/', $content, $matches)) {
                $content = $matches[0];
            }

            $questionsData = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('JSON parse error:', ['error' => json_last_error_msg(), 'content' => $content]);
                throw new \Exception('Failed to parse AI response. Please try again.');
            }

            if (!is_array($questionsData) || empty($questionsData)) {
                throw new \Exception('AI returned empty or invalid data. Please try again.');
            }

            $createdQuestions = [];
            $test = \App\Models\Test::find($testId);
            
            // Get the current highest order
            $currentOrder = $test->questions()->max('order') ?? 0;

            foreach ($questionsData as $qData) {
                // Validate required fields
                if (empty($qData['content']) || empty($qData['options']) || empty($qData['correct_answer'])) {
                    continue; // Skip invalid questions
                }
                
                $currentOrder++;
                $question = $test->questions()->create([
                    'content' => $qData['content'],
                    'type' => 'multiple_choice',
                    'options' => is_array($qData['options']) ? $qData['options'] : [],
                    'correct_answer' => $qData['correct_answer'],
                    'order' => $currentOrder,
                ]);
                $createdQuestions[] = $question;
            }

            if (empty($createdQuestions)) {
                throw new \Exception('No valid questions were generated. Please try again.');
            }

            return response()->json([
                'message' => "Successfully generated " . count($createdQuestions) . " questions!",
                'questions' => $createdQuestions
            ]);

        } catch (\Exception $e) {
            \Log::error('AI Question Generation Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
