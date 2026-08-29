<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Application\Commands;

use App\Models\UserFlashcard;
use App\Models\Vocabulary;
use Carbon\Carbon;
use Core\Shared\Application\Bus\CommandHandlerInterface;
use Core\Shared\Infrastructure\Concurrency\RedisLockService;

final class SaveWordCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RedisLockService $lockService
    ) {}

    public function handle(SaveWordCommand $command): UserFlashcard
    {
        $normalized = mb_strtolower(trim($command->word));
        $lockKey = "save_word:user_{$command->userId}:word_{$normalized}";

        return $this->lockService->executeTransactionalWithLock($lockKey, 5, function () use ($command, $normalized) {
            // Find or create vocabulary entry
            $vocab = Vocabulary::firstOrCreate(
                ['word' => $normalized],
                [
                    'definition_vi' => $command->definitionVi,
                    'phonetic_us' => $command->phoneticUs,
                    'audio_us' => $command->audioUs,
                    'part_of_speech' => $command->partOfSpeech,
                    'example_sentence' => $command->contextSentence,
                ]
            );

            // Find or create user flashcard
            return UserFlashcard::firstOrCreate(
                [
                    'user_id' => $command->userId,
                    'vocab_id' => $vocab->id,
                ],
                [
                    'custom_note' => $command->customNote,
                    'context_sentence' => $command->contextSentence,
                    'repetitions' => 0,
                    'ease_factor' => 2.50,
                    'interval_days' => 1,
                    'next_review_at' => Carbon::today(),
                ]
            );
        });
    }
}
