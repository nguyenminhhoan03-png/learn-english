<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Application\Commands;

use Core\Shared\Application\Bus\CommandInterface;

final class SubmitTestCommand implements CommandInterface
{
    /**
     * @param int $userId
     * @param int $testId
     * @param string $mode 'practice' | 'full_test'
     * @param int $timeSpentSeconds
     * @param array<int, string> $answers [question_id => user_answer_text]
     */
    public function __construct(
        public readonly int $userId,
        public readonly int $testId,
        public readonly string $mode,
        public readonly int $timeSpentSeconds,
        public readonly array $answers
    ) {}
}
