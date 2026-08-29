<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Application\Queries;

use Core\Shared\Application\Bus\QueryInterface;

final class GetTestDetailQuery implements QueryInterface
{
    public function __construct(
        public readonly string|int $slugOrId
    ) {}
}
