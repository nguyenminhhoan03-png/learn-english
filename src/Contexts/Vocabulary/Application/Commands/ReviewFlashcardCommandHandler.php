<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Application\Commands;

use App\Models\UserFlashcard;
use Core\Contexts\Vocabulary\Domain\Events\FlashcardReviewedEvent;
use Core\Contexts\Vocabulary\Domain\Services\SuperMemoSm2Engine;
use Core\Shared\Application\Bus\CommandHandlerInterface;
use Core\Shared\Domain\Exceptions\DomainException;
use Core\Shared\Infrastructure\Concurrency\RedisLockService;
use Illuminate\Support\Facades\Event;

final class ReviewFlashcardCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RedisLockService $lockService,
        private readonly SuperMemoSm2Engine $sm2Engine
    ) {}

    public function handle(ReviewFlashcardCommand $command): array
    {
        $lockKey = "review_card:{$command->cardId}";

        return $this->lockService->executeTransactionalWithLock($lockKey, 5, function () use ($command) {
            /** @var UserFlashcard|null $card */
            $card = UserFlashcard::where('id', $command->cardId)
                ->where('user_id', $command->userId)
                ->lockForUpdate() // Database pessimistic lock
                ->first();

            if (!$card) {
                throw new DomainException("Thẻ từ vựng #{$command->cardId} không tồn tại.");
            }

            $calc = $this->sm2Engine->computeNextReview(
                repetitions: $card->repetitions,
                currentEaseFactor: (float) $card->ease_factor,
                currentIntervalDays: $card->interval_days,
                grade: $command->grade
            );

            $card->repetitions = $calc['repetitions'];
            $card->ease_factor = $calc['ease_factor'];
            $card->interval_days = $calc['interval_days'];
            $card->next_review_at = $calc['next_review_date']->format('Y-m-d');
            $card->save();

            Event::dispatch(new FlashcardReviewedEvent(
                userId: $command->userId,
                cardId: $card->id,
                vocabId: $card->vocab_id,
                grade: $command->grade,
                intervalDays: $calc['interval_days']
            ));

            return [
                'card_id' => $card->id,
                'repetitions' => $card->repetitions,
                'ease_factor' => $card->ease_factor,
                'interval_days' => $card->interval_days,
                'next_review_at' => $card->next_review_at->toDateString(),
            ];
        });
    }
}
