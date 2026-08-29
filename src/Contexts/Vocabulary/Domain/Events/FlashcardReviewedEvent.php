<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Domain\Events;

use Core\Shared\Domain\Events\DomainEventInterface;
use DateTimeImmutable;

final class FlashcardReviewedEvent implements DomainEventInterface
{
    private DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly int $userId,
        public readonly int $cardId,
        public readonly int $vocabId,
        public readonly int $grade,
        public readonly int $intervalDays
    ) {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function eventName(): string
    {
        return 'vocabulary.flashcard_reviewed';
    }
}
