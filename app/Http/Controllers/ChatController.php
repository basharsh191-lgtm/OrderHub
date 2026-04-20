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
    // هون عم اجبر الجمناي انو يجاوب الشخص بس ع الاسألة يلي انا محددلو ياها

    $systemPrompt = "أنت مساعد طبي في عيادة.
    التخصصات: أسنان، أطفال،جلدية، نسائية، عيون
    . أجب باختصار مع فائدة مع جملة احجز موعد عندنا.";

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
public function compareTests(Request $request)
{
    $apiKey = env('GEMINI_API_KEY');

    // التحقق من الصور
    $request->validate([
        'old_image' => 'required|image|max:5120',
        'new_image' => 'required|image|max:5120',
    ]);

    // تحويل الصور إلى base64
    $oldImageBase64 = base64_encode(file_get_contents($request->file('old_image')->path()));
    $newImageBase64 = base64_encode(file_get_contents($request->file('new_image')->path()));

    // Prompt مضبوط لإرجاع JSON فقط
    $prompt = "أنت مساعد طبي متخصص في قراءة التحاليل.
⚠️ مهم جداً:
- يجب أن تكون كل القيم النصية باللغة العربية فقط.
- لا تستخدم أي كلمة إنجليزية إطلاقاً.
- أسماء التحاليل ترجمها للعربية (مثال: Hemoglobin → الهيموغلوبين).

المطلوب:
- استخرج البيانات من الصورتين
- قارن بينهما

⚠️ أرجع النتيجة بصيغة JSON فقط بدون أي شرح.
المطلوب:
- استخرج البيانات من الصورتين
- قارن بينهما

⚠️ مهم:
أرجع النتيجة بصيغة JSON فقط بدون أي شرح إضافي.

الصيغة المطلوبة:

{
  \"old_tests\": [
    {
      \"name\": \"\",
      \"value\": \"\",
      \"unit\": \"\",
      \"normal_range\": \"\"
    }
  ],
  \"new_tests\": [
    {
      \"name\": \"\",
      \"value\": \"\",
      \"unit\": \"\",
      \"normal_range\": \"\"
    }
  ],
  \"differences\": [
    {
      \"test\": \"\",
      \"status\": \"increase | decrease | stable\",
      \"note\": \"\"
    }
  ],
  \"advice\": \"\"
}

إذا لم تستطع قراءة الصور بوضوح، أرجع:
{ \"error\": \"image_not_clear\" }";

    // إرسال الطلب إلى Gemini
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post(
        "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key={$apiKey}",
        [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt],
                        [
                            "inline_data" => [
                                "mime_type" => "image/jpeg",
                                "data" => $oldImageBase64
                            ]
                        ],
                        [
                            "inline_data" => [
                                "mime_type" => "image/jpeg",
                                "data" => $newImageBase64
                            ]
                        ]
                    ]
                ]
            ]
        ]
    );

    // التحقق من فشل الطلب
    if ($response->failed()) {
        return response()->json([
            'error' => 'API request failed',
            'details' => $response->json()
        ], 500);
    }

    // استخراج النص من الرد
    $resultText = $response['candidates'][0]['content']['parts'][0]['text'] ?? null;

    if (!$resultText) {
        return response()->json([
            'error' => 'Empty response from AI'
        ], 500);
    }

    // تنظيف JSON (إزالة ```json)
    $cleanText = trim($resultText);
    $cleanText = str_replace(['```json', '```'], '', $cleanText);

    // تحويل إلى array
    $decoded = json_decode($cleanText, true);

    if (!$decoded) {
        return response()->json([
            'error' => 'Invalid JSON from AI',
            'raw' => $resultText
        ], 500);
    }

    // إرجاع النتيجة نظيفة للفرونت
    return response()->json($decoded);
}
}
