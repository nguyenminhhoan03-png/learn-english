<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Application\Commands;

use Core\Shared\Application\Bus\CommandInterface;

final class ReviewFlashcardCommand implements CommandInterface
{
    /**
     * @param int $userId
     * @param int $cardId
     * @param int $grade 0 = Blackout, 1 = Hard, 2 = Good, 3 = Easy
     */
    public function __construct(
        public readonly int $userId,
        public readonly int $cardId,
        public readonly int $grade
    ) {}
}
