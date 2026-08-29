<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Domain\Services;

use Core\Shared\Domain\ValueObjects\BandScore;

final class IeltsScoringEngine
{
    /**
     * Quy đổi số câu đúng sang IELTS Reading Band Score (Academic)
     */
    public static function calculateReadingBand(int $rawScore): BandScore
    {
        $raw = max(0, min(40, $rawScore));

        $band = match (true) {
            $raw >= 39 => 9.0,
            $raw >= 37 => 8.5,
            $raw >= 35 => 8.0,
            $raw >= 33 => 7.5,
            $raw >= 30 => 7.0,
            $raw >= 27 => 6.5,
            $raw >= 23 => 6.0,
            $raw >= 19 => 5.5,
            $raw >= 15 => 5.0,
            $raw >= 13 => 4.5,
            $raw >= 10 => 4.0,
            $raw >= 8  => 3.5,
            $raw >= 6  => 3.0,
            $raw >= 4  => 2.5,
            default    => 2.0,
        };

        return BandScore::fromFloat($band);
    }

    /**
     * Quy đổi số câu đúng sang IELTS Listening Band Score
     */
    public static function calculateListeningBand(int $rawScore): BandScore
    {
        $raw = max(0, min(40, $rawScore));

        $band = match (true) {
            $raw >= 39 => 9.0,
            $raw >= 37 => 8.5,
            $raw >= 35 => 8.0,
            $raw >= 32 => 7.5,
            $raw >= 30 => 7.0,
            $raw >= 26 => 6.5,
            $raw >= 23 => 6.0,
            $raw >= 18 => 5.5,
            $raw >= 16 => 5.0,
            $raw >= 13 => 4.5,
            $raw >= 10 => 4.0,
            $raw >= 8  => 3.5,
            $raw >= 6  => 3.0,
            $raw >= 4  => 2.5,
            default    => 2.0,
        };

        return BandScore::fromFloat($band);
    }

    /**
     * Tính toán tổng thể cho bài Full Test
     */
    public static function calculateOverallBand(BandScore $reading, BandScore $listening): BandScore
    {
        $average = ($reading->getValue() + $listening->getValue()) / 2;
        // IELTS rounding rule: .25 rounds up to .5, .75 rounds up to next whole band
        $remainder = $average - floor($average);

        $roundedBand = match (true) {
            $remainder < 0.25 => floor($average),
            $remainder < 0.75 => floor($average) + 0.5,
            default => ceil($average),
        };

        return BandScore::fromFloat($roundedBand);
    }
}
