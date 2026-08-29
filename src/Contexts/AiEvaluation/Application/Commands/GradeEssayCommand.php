<?php

declare(strict_types=1);

namespace Core\Contexts\AiEvaluation\Application\Commands;

use Core\Shared\Application\Bus\CommandInterface;

final class GradeEssayCommand implements CommandInterface
{
    public function __construct(
        public readonly int $userId,
        public readonly string $taskType,
        public readonly string $prompt,
        public readonly string $userEssay
    ) {}
}
