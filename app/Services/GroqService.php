<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class GroqService
{
    private string $apiKey;
    private string $baseUrl;
    private int $timeout;

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
        $this->baseUrl = config('services.groq.base_url');
        $this->timeout = 120;
    }

    public function chat(array $messages, array $options = []): array
    {
        $payload = array_merge([
            'model' => 'llama-3.3-70b-versatile',
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 1024,
        ], $options);

        $payload['messages'] = $messages;

        try {
            $response = Http::withToken($this->apiKey)
                ->timeout($this->timeout)
                ->post("{$this->baseUrl}/chat/completions", $payload);

            if ($response->failed()) {
                return [
                    'success' => false,
                    'error' => $response->json('error.message') ?? 'Groq API request failed',
                    'status' => $response->status(),
                ];
            }

            return [
                'success' => true,
                'data' => $response->json(),
            ];
        } catch (ConnectionException $e) {
            return [
                'success' => false,
                'error' => 'Unable to connect to Groq API: ' . $e->getMessage(),
                'status' => 503,
            ];
        }
    }

    public function models(): array
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(30)
                ->get("{$this->baseUrl}/models");

            if ($response->failed()) {
                return [
                    'success' => false,
                    'error' => $response->json('error.message') ?? 'Failed to fetch models',
                    'status' => $response->status(),
                ];
            }

            return [
                'success' => true,
                'data' => $response->json('data', []),
            ];
        } catch (ConnectionException $e) {
            return [
                'success' => false,
                'error' => 'Unable to connect to Groq API: ' . $e->getMessage(),
                'status' => 503,
            ];
        }
    }
}
