<?php

declare(strict_types=1);

namespace Core\Contexts\Dictation\Domain\Events;

use Core\Shared\Domain\Events\DomainEventInterface;
use DateTimeImmutable;

final class SentenceCompletedEvent implements DomainEventInterface
{
    private DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly int $userId,
        public readonly int $topicId,
        public readonly int $sentenceId,
        public readonly float $accuracy
    ) {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function eventName(): string
    {
        return 'dictation.sentence_completed';
    }
}
