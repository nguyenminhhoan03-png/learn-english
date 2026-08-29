<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Application\Queries;

use Core\Shared\Application\Bus\QueryInterface;

final class GetDueFlashcardsQuery implements QueryInterface
{
    public function __construct(
        public readonly int $userId,
        public readonly int $limit = 30
    ) {}
}
