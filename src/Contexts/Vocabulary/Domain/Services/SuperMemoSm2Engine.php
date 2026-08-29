<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Domain\Services;

use Core\Shared\Domain\ValueObjects\EaseFactor;
use DateTimeImmutable;

final class SuperMemoSm2Engine
{
    /**
     * Calculates the next review parameters according to the SuperMemo SM-2 algorithm.
     *
     * @param int $repetitions Current repetition count
     * @param float $currentEaseFactor Current Ease Factor (>= 1.30)
     * @param int $currentIntervalDays Current interval in days
     * @param int $grade Review grade: 0 = Blackout/Forgotten, 1 = Hard, 2 = Good, 3 = Easy
     * @return array{repetitions: int, ease_factor: float, interval_days: int, next_review_date: DateTimeImmutable}
     */
    public function computeNextReview(
        int $repetitions,
        float $currentEaseFactor,
        int $currentIntervalDays,
        int $grade
    ): array {
        // Clamp grade to 0..3 range
        $clampedGrade = max(0, min(3, $grade));

        // 1. Calculate New Ease Factor
        // SM-2 Formula scaled for 0-3 grade range:
        $newEase = $currentEaseFactor + (0.1 - (3 - $clampedGrade) * (0.08 + (3 - $clampedGrade) * 0.02));
        $easeVo = EaseFactor::fromFloat($newEase);

        // 2. Calculate New Interval & Repetitions
        if ($clampedGrade < 2) {
            // Failed recall: reset repetition count and schedule for next day
            $newRepetitions = 0;
            $newIntervalDays = 1;
        } else {
            if ($repetitions === 0) {
                $newIntervalDays = 1;
            } elseif ($repetitions === 1) {
                $newIntervalDays = 6;
            } else {
                $newIntervalDays = (int) round($currentIntervalDays * $easeVo->getValue());
                $newIntervalDays = max(1, $newIntervalDays);
            }
            $newRepetitions = $repetitions + 1;
        }

        $nextDate = (new DateTimeImmutable())->modify("+{$newIntervalDays} days");

        return [
            'repetitions' => $newRepetitions,
            'ease_factor' => $easeVo->getValue(),
            'interval_days' => $newIntervalDays,
            'next_review_date' => $nextDate,
        ];
    }
}
