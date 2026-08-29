<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Application\Queries;

use Core\Shared\Application\Bus\QueryInterface;

final class GetSubmissionResultQuery implements QueryInterface
{
    public function __construct(
        public readonly int $submissionId,
        public readonly ?int $userId = null
    ) {}
}
