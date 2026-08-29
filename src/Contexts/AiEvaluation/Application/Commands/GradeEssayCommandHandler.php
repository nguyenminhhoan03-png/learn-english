<?php

declare(strict_types=1);

namespace Core\Contexts\AiEvaluation\Application\Commands;

use App\Models\AiWritingEvaluation;
use Core\Contexts\AiEvaluation\Domain\Services\AiWritingGraderService;
use Core\Contexts\Gamification\Domain\Services\StreakService;
use Core\Shared\Application\Bus\CommandHandlerInterface;
use Core\Shared\Infrastructure\Concurrency\RedisLockService;

final class GradeEssayCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RedisLockService $lockService,
        private readonly AiWritingGraderService $graderService,
        private readonly StreakService $streakService
    ) {}

    public function handle(GradeEssayCommand $command): AiWritingEvaluation
    {
        $lockKey = "ai_grade_user:{$command->userId}";

        return $this->lockService->executeTransactionalWithLock($lockKey, 30, function () use ($command) {
            $result = $this->graderService->grade(
                $command->taskType,
                $command->prompt,
                $command->userEssay
            );

            $evaluation = AiWritingEvaluation::create([
                'user_id' => $command->userId,
                'task_type' => $command->taskType,
                'prompt' => $command->prompt,
                'user_essay' => $command->userEssay,
                'overall_band' => $result['overall_band'],
                'band_task_response' => $result['tr_band'],
                'band_coherence' => $result['cc_band'],
                'band_lexical' => $result['lr_band'],
                'band_grammar' => $result['gra_band'],
                'detailed_feedback' => $result['feedback'],
                'revised_essay' => $result['revised_essay'],
            ]);

            // Update user streak & XP
            $this->streakService->recordActivity($command->userId, 'writing_ai', $evaluation->id, 15);

            return $evaluation;
        });
    }
}
