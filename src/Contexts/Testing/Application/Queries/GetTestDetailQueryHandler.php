<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Application\Queries;

use App\Models\Test;
use Core\Shared\Application\Bus\QueryHandlerInterface;
use Core\Shared\Domain\Exceptions\DomainException;
use Core\Shared\Infrastructure\Caching\CacheKeyManager;
use Illuminate\Support\Facades\Cache;

final class GetTestDetailQueryHandler implements QueryHandlerInterface
{
    public function handle(GetTestDetailQuery $query): Test
    {
        $cacheKey = CacheKeyManager::testDetail($query->slugOrId);

        return Cache::remember($cacheKey, CacheKeyManager::TTL_HOUR, function () use ($query) {
            $column = is_numeric($query->slugOrId) ? 'id' : 'slug';

            $test = Test::with([
                'testSet.category',
                'sections' => function ($q) {
                    $q->orderBy('section_number', 'asc');
                },
                'sections.questionGroups' => function ($q) {
                    $q->orderBy('id', 'asc');
                },
                'sections.questionGroups.questions' => function ($q) {
                    $q->orderBy('question_number', 'asc');
                },
            ])->where($column, $query->slugOrId)->first();

            if (!$test) {
                throw new DomainException("Đề thi [{$query->slugOrId}] không tồn tại.");
            }

            return $test;
        });
    }
}
