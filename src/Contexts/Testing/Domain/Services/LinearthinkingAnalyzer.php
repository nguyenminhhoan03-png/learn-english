<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Domain\Services;

final class LinearthinkingAnalyzer
{
    /**
     * Parse structured Linearthinking breakdown and highlight keywords
     */
    public function formatExplanation(
        int $questionNumber,
        string $correctAnswer,
        ?string $evidenceLocation,
        ?string $structureAnalysis,
        ?string $logicAnalysis,
        array|string|null $paraphraseTable
    ): array {
        $paraphrases = is_string($paraphraseTable)
            ? json_decode($paraphraseTable, true) ?? []
            : ($paraphraseTable ?? []);

        return [
            'question_number' => $questionNumber,
            'correct_answer' => $correctAnswer,
            'evidence_location' => $evidenceLocation ?? 'Chưa xác định đoạn trích',
            'linearthinking' => [
                'sentence_simplification' => $structureAnalysis ?? 'Phân tích cấu trúc nòng cốt S-V-O...',
                'connection_logic' => $logicAnalysis ?? 'Phân tích đường dây liên kết ý nghĩa logic...',
            ],
            'paraphrase_table' => $paraphrases,
        ];
    }

    /**
     * So sánh câu trả lời của user với đáp án chuẩn (hỗ trợ nhiều đáp án chấp nhận dạng array/chuỗi)
     */
    public function checkAnswer(string $userAnswer, string $correctAnswer): bool
    {
        $normalizedUser = mb_strtolower(trim($userAnswer));
        $normalizedCorrect = mb_strtolower(trim($correctAnswer));

        if ($normalizedUser === $normalizedCorrect) {
            return true;
        }

        // Hỗ trợ trường hợp đáp án có nhiều lựa chọn (ví dụ JSON: ["FALSE", "F"])
        $decoded = json_decode($correctAnswer, true);
        if (is_array($decoded)) {
            foreach ($decoded as $opt) {
                if ($normalizedUser === mb_strtolower(trim((string) $opt))) {
                    return true;
                }
            }
        }

        // Hỗ trợ dạng A/B hoặc A | B
        if (str_contains($correctAnswer, '/')) {
            $options = explode('/', $correctAnswer);
            foreach ($options as $opt) {
                if ($normalizedUser === mb_strtolower(trim($opt))) {
                    return true;
                }
            }
        }

        return false;
    }
}
