<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class AIService
{
    public function generateContent(string $prompt, string $provider = 'gemini')
    {
        $user = auth()->user();

        if (!$user) {
            throw new Exception('User not authenticated.');
        }

        if ($provider === 'gemini') {
            $apiKey = $user->gemini_api_key;
            if (!$apiKey) {
                throw new Exception('Gemini API Key not configured.');
            }
            return $this->callGemini($prompt, $apiKey);
        } elseif ($provider === 'cerebras') {
            $apiKey = $user->cerebras_api_key;
            if (!$apiKey) {
                throw new Exception('Cerebras API Key not configured.');
            }
            return $this->callCerebras($prompt, $apiKey);
        }

        throw new Exception('Invalid AI provider.');
    }

    protected function callGemini(string $prompt, string $apiKey)
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}";

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            throw new Exception('Gemini API Error: ' . $response->body());
        }

        $data = $response->json();
        return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    protected function callCerebras(string $prompt, string $apiKey)
    {
        // Placeholder for Cerebras API call
        // Assuming OpenAI-compatible interface
        $url = "https://api.cerebras.ai/v1/chat/completions";

        $response = Http::withToken($apiKey)->post($url, [
            'model' => 'llama3-8b-8192',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        if ($response->failed()) {
            throw new Exception('Cerebras API Error: ' . $response->body());
        }

        $data = $response->json();
        return $data['choices'][0]['message']['content'] ?? '';
    }
}
