<?php

declare(strict_types=1);

namespace Core\Contexts\Gamification\Domain\Services;

use App\Models\UserAnswer;
use Core\Shared\Infrastructure\Caching\CacheKeyManager;
use Illuminate\Support\Facades\Cache;

final class WeaknessRadarEngine
{
    /**
     * Compute accuracy percentage for each core question type for the user
     *
     * @return array{labels: string[], series: int[], weakest_skill: string, strongest_skill: string}
     */
    public function calculateRadar(int $userId): array
    {
        $cacheKey = CacheKeyManager::userWeaknessRadar($userId);

        return Cache::remember($cacheKey, CacheKeyManager::TTL_HOUR, function () use ($userId) {
            $answers = UserAnswer::query()
                ->join('test_submissions', 'user_answers.submission_id', '=', 'test_submissions.id')
                ->join('questions', 'user_answers.question_id', '=', 'questions.id')
                ->join('question_groups', 'questions.group_id', '=', 'question_groups.id')
                ->where('test_submissions.user_id', $userId)
                ->select([
                    'question_groups.question_type',
                    'user_answers.is_correct',
                ])
                ->get();

            $categories = [
                'true_false_not_given' => 'True/False/NG',
                'matching_headings' => 'Matching Headings',
                'multiple_choice_single' => 'Multiple Choice',
                'fill_in_the_blank' => 'Fill in Blanks',
                'matching_information' => 'Matching Info',
                'drag_and_drop' => 'Drag & Drop',
            ];

            $stats = [];
            foreach ($categories as $typeKey => $typeName) {
                $typeAnswers = $answers->where('question_type', $typeKey);
                $total = $typeAnswers->count();
                $correct = $typeAnswers->where('is_correct', true)->count();

                $stats[$typeName] = $total > 0
                    ? (int) round(($correct / $total) * 100)
                    : 70; // Baseline default if not yet taken
            }

            $labels = array_keys($stats);
            $series = array_values($stats);

            // Determine weakest and strongest
            asort($stats);
            $weakest = array_key_first($stats);
            arsort($stats);
            $strongest = array_key_first($stats);

            return [
                'labels' => $labels,
                'series' => $series,
                'weakest_skill' => (string) $weakest,
                'strongest_skill' => (string) $strongest,
            ];
        });
    }
}
