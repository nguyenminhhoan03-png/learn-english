<?php

declare(strict_types=1);

namespace Core\Contexts\Gamification\Domain\Services;

use App\Models\User;
use App\Models\UserStudyLog;
use Carbon\Carbon;
use Core\Shared\Infrastructure\Concurrency\RedisLockService;

final class StreakService
{
    public function __construct(
        private readonly RedisLockService $lockService
    ) {}

    /**
     * Records a study activity and updates the user's daily streak atomically.
     * Prevents race conditions from multiple simultaneous submissions.
     */
    public function recordActivity(int $userId, string $activityType, ?int $referenceId = null, int $durationMinutes = 5): void
    {
        $lockKey = "user_streak_update:{$userId}";

        $this->lockService->executeTransactionalWithLock($lockKey, 5, function () use ($userId, $activityType, $referenceId, $durationMinutes) {
            /** @var User|null $user */
            $user = User::where('id', $userId)->lockForUpdate()->first();

            if (!$user) {
                return;
            }

            $today = Carbon::today();
            $lastStudyDate = $user->last_study_date ? Carbon::parse($user->last_study_date) : null;

            // Log activity
            UserStudyLog::create([
                'user_id' => $userId,
                'activity_type' => $activityType,
                'reference_id' => $referenceId,
                'duration_minutes' => $durationMinutes,
                'study_date' => $today->toDateString(),
            ]);

            // Add XP Points based on activity
            $xpGain = match ($activityType) {
                'test' => 50,
                'dictation' => 20,
                'flashcard' => 10,
                'writing_ai' => 40,
                default => 5,
            };
            $user->xp_points += $xpGain;

            // Check and update streak
            if ($lastStudyDate === null) {
                // First ever study
                $user->streak_count = 1;
                $user->last_study_date = $today->toDateString();
            } elseif ($lastStudyDate->isYesterday()) {
                // Studied yesterday: increment streak
                $user->streak_count += 1;
                $user->last_study_date = $today->toDateString();
            } elseif ($lastStudyDate->isToday()) {
                // Already studied today: do not increment streak count again
            } else {
                // Missed more than 1 day: reset streak to 1
                $user->streak_count = 1;
                $user->last_study_date = $today->toDateString();
            }

            $user->save();
        });
    }
}
