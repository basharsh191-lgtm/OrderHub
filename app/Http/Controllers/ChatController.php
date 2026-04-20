<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
//
public function ask(Request $request)
{
    $apiKey = env('GEMINI_API_KEY');

    $systemPrompt = "أنت مساعد طبي في عيادة. التخصصات: أسنان، أطفال،جلدية، نسائية، عيون. أجب باختصار مع فائدة مع جملة احجز موعد عندنا.";
    $userMessage = $request->input('message');

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post(
        "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key={$apiKey}",
        [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => $systemPrompt . "\nالمريض: " . $userMessage
                        ]
                    ]
                ]
            ]
        ]
    );

    // 🔥 مهم جدًا للتشخيص
    if ($response->failed()) {
        return response()->json([
            'error' => $response->json()
        ]);
    }

    return response()->json([
        'reply' => $response['candidates'][0]['content']['parts'][0]['text'] ?? 'No response'
    ]);









    
}
}
