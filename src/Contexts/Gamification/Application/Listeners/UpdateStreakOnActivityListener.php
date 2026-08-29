<?php

declare(strict_types=1);

namespace Core\Contexts\Gamification\Application\Listeners;

use Core\Contexts\Dictation\Domain\Events\SentenceCompletedEvent;
use Core\Contexts\Gamification\Domain\Services\StreakService;
use Core\Contexts\Testing\Domain\Events\TestSubmittedEvent;
use Core\Contexts\Vocabulary\Domain\Events\FlashcardReviewedEvent;
use Core\Shared\Domain\Events\DomainEventInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

final class UpdateStreakOnActivityListener implements ShouldQueue
{
    public function __construct(
        private readonly StreakService $streakService
    ) {}

    public function handle(DomainEventInterface $event): void
    {
        if ($event instanceof TestSubmittedEvent) {
            $duration = (int) ceil($event->timeSpentSeconds / 60);
            $this->streakService->recordActivity($event->userId, 'test', $event->testId, max(5, $duration));
        } elseif ($event instanceof SentenceCompletedEvent) {
            $this->streakService->recordActivity($event->userId, 'dictation', $event->topicId, 3);
        } elseif ($event instanceof FlashcardReviewedEvent) {
            $this->streakService->recordActivity($event->userId, 'flashcard', $event->cardId, 1);
        }
    }
}
