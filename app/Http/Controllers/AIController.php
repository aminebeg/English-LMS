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
            'count' => 'integer|min:1|max:10|default:5',
            'provider' => 'nullable|string|in:gemini,cerebras',
        ]);

        $count = $request->input('count', 5);
        $topic = $request->input('topic');
        $testId = $request->input('test_id');

        $prompt = "Generate {$count} multiple choice questions about '{$topic}' for an English learning test. 
        Return ONLY a raw JSON array (no markdown formatting, no code blocks). 
        Each object in the array must have:
        - 'content' (the question text)
        - 'type' (must be 'multiple_choice')
        - 'options' (array of 4 strings)
        - 'correct_answer' (one of the strings from options)
        - 'explanation' (brief explanation of why it's correct)
        
        Example format:
        [
            {
                \"content\": \"What is the past tense of 'go'?\",
                \"type\": \"multiple_choice\",
                \"options\": [\"goed\", \"gone\", \"went\", \"going\"],
                \"correct_answer\": \"went\",
                \"explanation\": \"'Go' is an irregular verb.\"
            }
        ]";

        try {
            $content = $this->aiService->generateContent(
                $prompt,
                $request->input('provider', 'gemini')
            );

            // Clean up the response if it contains markdown code blocks
            $content = preg_replace('/^```json\s*|\s*```$/', '', trim($content));
            
            $questionsData = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Failed to parse AI response: ' . json_last_error_msg());
            }

            if (!is_array($questionsData)) {
                throw new \Exception('AI response is not an array.');
            }

            $createdQuestions = [];
            $test = \App\Models\Test::find($testId);
            
            // Get the current highest order
            $currentOrder = $test->questions()->max('order') ?? 0;

            foreach ($questionsData as $qData) {
                $currentOrder++;
                $question = $test->questions()->create([
                    'content' => $qData['content'],
                    'type' => 'multiple_choice', // Enforcing multiple choice for now as per prompt
                    'options' => $qData['options'],
                    'correct_answer' => $qData['correct_answer'],
                    'order' => $currentOrder,
                ]);
                $createdQuestions[] = $question;
            }

            return response()->json([
                'message' => "Successfully generated " . count($createdQuestions) . " questions.",
                'questions' => $createdQuestions
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
