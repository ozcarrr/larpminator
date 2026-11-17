<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class GroqAnalyzerService
{
    public function analyze(string $role, string $techStack, string $question, string $answer): array
    {
        $apiKey = config('services.groq.api_key') ?? config('services.groq.key');
        if (empty($apiKey)) {
            return $this->fallback();
        }

        try {
            $systemPrompt = "Act as a Principal Engineer evaluating a candidate for {$role} ({$techStack}). "
                . "Analyze the Q&A pair to detect 'LARPing' (using theoretical buzzwords without real production trade-offs, operational depth, or failure handling). "
                . "Return ONLY a valid JSON object matching this exact schema: "
                . '{"depth_score": int (0-100), "verdict": "Authentic Depth" (if >=75) | "Moderate Risk" (if 45-74) | "High LARP Risk" (if <45), '
                . '"analysis_data": {"sub_scores": {"operational_depth": int, "friction_handling": int, "ownership": int, "logical_consistency": int}, '
                . '"flags": [{"severity": "red"|"amber", "quote": "exact substring from answer", "reason": "string"}], '
                . '"drill_downs": [{"topic": "string", "question": "tactical follow-up question", "expected_signal": "what a real engineer says vs a LARPer"}]}} '
                . 'Provide 2-3 flags and 3 drill_downs.';

            $response = Http::withToken($apiKey)
                ->timeout(15)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => "Question: {$question}\nAnswer: {$answer}"],
                    ],
                ]);

            if ($response->failed()) {
                return $this->fallback();
            }

            $data = json_decode($response->json('choices.0.message.content'), true);
            if (!is_array($data)) {
                return $this->fallback();
            }

            $analysisData = $data['analysis_data'] ?? [
                'sub_scores' => $data['sub_scores'] ?? [],
                'flags' => $data['flags'] ?? [],
                'drill_downs' => $data['drill_downs'] ?? [],
            ];

            return [
                'depth_score' => (int) ($data['depth_score'] ?? 50),
                'verdict' => (string) ($data['verdict'] ?? 'Moderate Risk'),
                'analysis_data' => $analysisData,
            ];
        } catch (Throwable) {
            return $this->fallback();
        }
    }

    private function fallback(): array
    {
        return [
            'depth_score' => 50,
            'verdict' => 'Moderate Risk',
            'analysis_data' => [
                'sub_scores' => [
                    'operational_depth' => 50,
                    'friction_handling' => 50,
                    'ownership' => 50,
                    'logical_consistency' => 50,
                ],
                'flags' => [
                    [
                        'severity' => 'amber',
                        'quote' => 'System fallback',
                        'reason' => 'Groq API request failed or API key is not configured.',
                    ],
                ],
                'drill_downs' => [
                    [
                        'topic' => 'Operational Trade-offs',
                        'question' => 'What specific production trade-offs and metrics defined this approach?',
                        'expected_signal' => 'Clear operational metrics and mitigation strategies.',
                    ],
                ],
            ],
        ];
    }
}
