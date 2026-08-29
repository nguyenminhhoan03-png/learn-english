<?php

declare(strict_types=1);

namespace Core\Contexts\Dictation\Application\Commands;

use App\Models\DictationSentence;
use App\Models\UserDictationProgress;
use Core\Contexts\Dictation\Domain\Events\SentenceCompletedEvent;
use Core\Contexts\Dictation\Domain\Services\LevenshteinVerificationEngine;
use Core\Shared\Application\Bus\CommandHandlerInterface;
use Core\Shared\Domain\Exceptions\DomainException;
use Illuminate\Support\Facades\Event;

final class VerifySentenceCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly LevenshteinVerificationEngine $verificationEngine
    ) {}

    public function handle(VerifySentenceCommand $command): array
    {
        $sentence = DictationSentence::find($command->sentenceId);

        if (!$sentence) {
            throw new DomainException("Câu nghe ID #{$command->sentenceId} không tồn tại.");
        }

        $result = $this->verificationEngine->verify($command->userInput, $sentence->original_text);

        // Update User progress in topic
        $progress = UserDictationProgress::firstOrCreate(
            [
                'user_id' => $command->userId,
                'topic_id' => $sentence->topic_id,
            ],
            [
                'completed_sentences' => 0,
                'accuracy_percentage' => 0.0,
                'is_finished' => false,
            ]
        );

        if ($result['is_passed']) {
            $progress->completed_sentences = max($progress->completed_sentences, $sentence->sentence_order);
            $progress->save();

            Event::dispatch(new SentenceCompletedEvent(
                userId: $command->userId,
                topicId: $sentence->topic_id,
                sentenceId: $sentence->id,
                accuracy: $result['accuracy_percentage']
            ));
        }

        return array_merge($result, [
            'original_text' => $sentence->original_text,
            'translation_vi' => $sentence->translation_vi,
            'phonetic_notes' => $sentence->phonetic_notes,
            'sentence_order' => $sentence->sentence_order,
        ]);
    }
}
