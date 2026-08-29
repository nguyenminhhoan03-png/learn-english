<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Domain\Events;

use Core\Shared\Domain\Events\DomainEventInterface;
use Core\Shared\Domain\ValueObjects\BandScore;
use DateTimeImmutable;

final class TestSubmittedEvent implements DomainEventInterface
{
    private DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly int $submissionId,
        public readonly int $userId,
        public readonly int $testId,
        public readonly int $rawScore,
        public readonly BandScore $bandScore,
        public readonly int $timeSpentSeconds
    ) {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function eventName(): string
    {
        return 'testing.test_submitted';
    }
}
