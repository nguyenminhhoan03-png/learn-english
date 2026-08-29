<?php

declare(strict_types=1);

namespace Core\Contexts\Dictation\Domain\Services;

final class LevenshteinVerificationEngine
{
    /**
     * So khớp từng từ và tính độ chính xác kèm phân tích Levenshtein
     */
    public function verify(string $userInput, string $originalText): array
    {
        $cleanUser = $this->cleanPunctuation($userInput);
        $cleanOriginal = $this->cleanPunctuation($originalText);

        $userWords = array_values(array_filter(explode(' ', $cleanUser)));
        $originalWords = array_values(array_filter(explode(' ', $cleanOriginal)));

        $totalWords = count($originalWords);
        $correctCount = 0;
        $diffList = [];

        foreach ($originalWords as $idx => $targetWord) {
            $userWord = $userWords[$idx] ?? '';
            $isExactMatch = (mb_strtolower($userWord) === mb_strtolower($targetWord));

            $similarity = 0.0;
            if (!$isExactMatch && !empty($userWord)) {
                $lev = levenshtein(mb_strtolower($userWord), mb_strtolower($targetWord));
                $maxLen = max(mb_strlen($userWord), mb_strlen($targetWord));
                $similarity = $maxLen > 0 ? (1 - ($lev / $maxLen)) : 0;
            }

            if ($isExactMatch) {
                $correctCount++;
            }

            $diffList[] = [
                'index' => $idx,
                'target_word' => $targetWord,
                'user_word' => $userWord,
                'is_correct' => $isExactMatch,
                'is_close' => ($similarity >= 0.70),
            ];
        }

        $accuracy = $totalWords > 0 ? round(($correctCount / $totalWords) * 100, 1) : 0.0;

        return [
            'accuracy' => $accuracy,
            'is_passed' => ($accuracy >= 85.0),
            'total_words' => $totalWords,
            'correct_words' => $correctCount,
            'diff' => $diffList,
        ];
    }

    private function cleanPunctuation(string $text): string
    {
        $cleaned = preg_replace('/[.,\/#!$%\^&\*;:{}=\-_`~()?"\']/u', '', $text);
        return trim(preg_replace('/\s+/', ' ', $cleaned ?? ''));
    }
}
