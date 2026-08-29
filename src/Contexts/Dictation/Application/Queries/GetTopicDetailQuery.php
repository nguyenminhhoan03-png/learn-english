<?php

declare(strict_types=1);

namespace Core\Contexts\Dictation\Application\Queries;

use Core\Shared\Application\Bus\QueryInterface;

final class GetTopicDetailQuery implements QueryInterface
{
    public function __construct(
        public readonly string|int $slugOrId,
        public readonly ?int $userId = null
    ) {}
}
