<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Application\DTOs;

final class SubmissionResultDTO
{
    /**
     * @param int $submissionId
     * @param int $testId
     * @param string $testTitle
     * @param int $scoreRaw
     * @param int $totalQuestions
     * @param float $bandScore
     * @param int $timeSpentSeconds
     * @param array $answerDetails
     */
    public function __construct(
        public readonly int $submissionId,
        public readonly int $testId,
        public readonly string $testTitle,
        public readonly int $scoreRaw,
        public readonly int $totalQuestions,
        public readonly float $bandScore,
        public readonly int $timeSpentSeconds,
        public readonly array $answerDetails
    ) {}
}
