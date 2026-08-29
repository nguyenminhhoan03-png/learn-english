<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Application\Queries;

use Core\Shared\Application\Bus\QueryInterface;

final class LookupWordQuery implements QueryInterface
{
    public function __construct(
        public readonly string $word
    ) {}
}
