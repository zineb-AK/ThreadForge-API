<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GroqService;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function chat(Request $request, GroqService $groq)
    {
        $request->validate([
            'messages' => 'required|array',
            'messages.*.role' => 'required|string|in:system,user,assistant',
            'messages.*.content' => 'required|string',
            'model' => 'nullable|string',
            'temperature' => 'nullable|numeric|between:0,2',
            'max_tokens' => 'nullable|integer|min:1|max:32768',
        ]);

        $result = $groq->chat(
            $request->messages,
            $request->only(['model', 'temperature', 'max_tokens'])
        );

        if (!$result['success']) {
            return response()->json([
                'message' => $result['error'],
            ], $result['status'] ?? 500);
        }

        return response()->json([
            'message' => $result['data']['choices'][0]['message']['content'] ?? '',
            'usage' => $result['data']['usage'] ?? null,
        ]);
    }
}
