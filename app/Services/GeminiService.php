<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $endpoint;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->endpoint = config('services.gemini.endpoint');
    }

    public function generateResponse($prompt)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->endpoint}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 500,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, tôi không thể tạo câu trả lời.';
            }

            Log::error('Lỗi Gemini API: ' . $response->body());
            return 'Xin lỗi, có lỗi xảy ra khi liên hệ với dịch vụ AI.';
        } catch (\Exception $e) {
            Log::error('Ngoại lệ Gemini API: ' . $e->getMessage());
            return 'Xin lỗi, có lỗi xảy ra khi xử lý yêu cầu của bạn.';
        }
    }
}
