<?php

declare(strict_types=1);

namespace Core\Shared\Domain\Events;

use DateTimeImmutable;

interface DomainEventInterface
{
    public function occurredOn(): DateTimeImmutable;
    public function eventName(): string;
}
