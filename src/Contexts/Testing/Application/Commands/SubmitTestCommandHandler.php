<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Application\Commands;

use App\Models\Question;
use App\Models\Test;
use App\Models\TestSubmission;
use App\Models\UserAnswer;
use Core\Contexts\Testing\Application\DTOs\SubmissionResultDTO;
use Core\Contexts\Testing\Domain\Events\TestSubmittedEvent;
use Core\Contexts\Testing\Domain\Model\TestType;
use Core\Contexts\Testing\Domain\Services\IeltsScoringEngine;
use Core\Contexts\Testing\Domain\Services\LinearthinkingAnalyzer;
use Core\Shared\Application\Bus\CommandHandlerInterface;
use Core\Shared\Domain\Exceptions\DomainException;
use Core\Shared\Infrastructure\Concurrency\RedisLockService;
use Illuminate\Support\Facades\Event;

final class SubmitTestCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RedisLockService $lockService,
        private readonly LinearthinkingAnalyzer $linearthinkingAnalyzer
    ) {}

    public function handle(SubmitTestCommand $command): SubmissionResultDTO
    {
        $lockKey = "submission:user:{$command->userId}:test:{$command->testId}";

        // Race condition prevention: lock user + test submission for 10 seconds
        return $this->lockService->executeTransactionalWithLock($lockKey, 10, function () use ($command) {
            $test = Test::with(['sections.questionGroups.questions'])->find($command->testId);

            if (!$test) {
                throw new DomainException("Bài test ID {$command->testId} không tồn tại.");
            }

            // Flatten all questions of the test
            $allQuestions = $test->sections
                ->flatMap(fn($section) => $section->questionGroups)
                ->flatMap(fn($group) => $group->questions)
                ->keyBy('id');

            $rawScore = 0;
            $totalQuestions = $allQuestions->count();
            $answersData = [];
            $dtoDetails = [];

            foreach ($allQuestions as $questionId => $question) {
                /** @var Question $question */
                $userAns = (string) ($command->answers[$questionId] ?? '');
                $isCorrect = $this->linearthinkingAnalyzer->checkAnswer($userAns, $question->correct_answer);

                if ($isCorrect) {
                    $rawScore++;
                }

                $answersData[] = [
                    'question_id' => $questionId,
                    'user_answer' => $userAns,
                    'is_correct' => $isCorrect,
                ];

                $dtoDetails[] = [
                    'question_id' => $questionId,
                    'question_number' => $question->question_number,
                    'user_answer' => $userAns,
                    'correct_answer' => $question->correct_answer,
                    'is_correct' => $isCorrect,
                    'explanation' => $this->linearthinkingAnalyzer->formatExplanation(
                        $question->question_number,
                        $question->correct_answer,
                        $question->evidence_paragraph,
                        $question->linearthinking_structure,
                        $question->linearthinking_logic,
                        $question->paraphrase_table
                    ),
                ];
            }

            // Convert to IELTS Band Score based on test type
            $bandScoreVo = ($test->type === TestType::LISTENING->value)
                ? IeltsScoringEngine::calculateListeningBand($rawScore)
                : IeltsScoringEngine::calculateReadingBand($rawScore);

            // Persist Submission
            $submission = TestSubmission::create([
                'user_id' => $command->userId,
                'test_id' => $command->testId,
                'mode' => $command->mode,
                'score_raw' => $rawScore,
                'band_score' => $bandScoreVo->getValue(),
                'time_spent_seconds' => $command->timeSpentSeconds,
                'status' => 'completed',
            ]);

            // Persist User Answers
            foreach ($answersData as $ans) {
                UserAnswer::create([
                    'submission_id' => $submission->id,
                    'question_id' => $ans['question_id'],
                    'user_answer' => $ans['user_answer'],
                    'is_correct' => $ans['is_correct'],
                ]);
            }

            // Dispatch Domain Event for Gamification & Weakness Radar
            Event::dispatch(new TestSubmittedEvent(
                submissionId: $submission->id,
                userId: $command->userId,
                testId: $command->testId,
                rawScore: $rawScore,
                bandScore: $bandScoreVo,
                timeSpentSeconds: $command->timeSpentSeconds
            ));

            return new SubmissionResultDTO(
                submissionId: $submission->id,
                testId: $test->id,
                testTitle: $test->title,
                scoreRaw: $rawScore,
                totalQuestions: $totalQuestions,
                bandScore: $bandScoreVo->getValue(),
                timeSpentSeconds: $command->timeSpentSeconds,
                answerDetails: $dtoDetails
            );
        });
    }
}
