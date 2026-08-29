<?php

declare(strict_types=1);

namespace Core\Contexts\Dictation\Application\Commands;

use Core\Shared\Application\Bus\CommandInterface;

final class VerifySentenceCommand implements CommandInterface
{
    public function __construct(
        public readonly int $userId,
        public readonly int $sentenceId,
        public readonly string $userInput
    ) {}
}
