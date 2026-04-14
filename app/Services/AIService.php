<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class AIService
{
    public function generateContent(string $prompt, string $provider = 'cerebras')
    {
        if ($provider === 'gemini') {
            // Try env key first, then fallback to user key
            $apiKey = config('services.gemini.api_key') ?: (auth()->user()?->gemini_api_key);
            if (!$apiKey) {
                throw new Exception('Gemini API Key not configured. Please set GEMINI_API_KEY in .env');
            }
            return $this->callGemini($prompt, $apiKey);
        } elseif ($provider === 'cerebras') {
            // Try env key first, then fallback to user key
            $apiKey = config('services.cerebras.api_key') ?: (auth()->user()?->cerebras_api_key);
            if (!$apiKey) {
                throw new Exception('Cerebras API Key not configured. Please set CEREBRAS_API_KEY in .env');
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
        $url = "https://api.cerebras.ai/v1/chat/completions";

        $response = Http::withToken($apiKey)->post($url, [
            'model' => 'llama-3.3-70b', 
            'stream' => false,
            'max_tokens' => 40960,
            'temperature' => 0.6,
            'top_p' => 0.95,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
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
