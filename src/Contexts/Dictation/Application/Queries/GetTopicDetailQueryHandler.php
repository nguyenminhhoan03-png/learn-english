<?php

declare(strict_types=1);

namespace Core\Contexts\Dictation\Application\Queries;

use App\Models\DictationTopic;
use App\Models\UserDictationProgress;
use Core\Shared\Application\Bus\QueryHandlerInterface;
use Core\Shared\Domain\Exceptions\DomainException;
use Core\Shared\Infrastructure\Caching\CacheKeyManager;
use Illuminate\Support\Facades\Cache;

final class GetTopicDetailQueryHandler implements QueryHandlerInterface
{
    public function handle(GetTopicDetailQuery $query): array
    {
        $cacheKey = CacheKeyManager::dictationTopic($query->slugOrId);

        $topic = Cache::remember($cacheKey, CacheKeyManager::TTL_HOUR, function () use ($query) {
            $column = is_numeric($query->slugOrId) ? 'id' : 'slug';
            $t = DictationTopic::with(['sentences'])->where($column, $query->slugOrId)->first();

            if (!$t) {
                throw new DomainException("Chủ đề bài nghe [{$query->slugOrId}] không tồn tại.");
            }

            return $t;
        });

        $userProgress = null;
        if ($query->userId !== null) {
            $userProgress = UserDictationProgress::where('user_id', $query->userId)
                ->where('topic_id', $topic->id)
                ->first();
        }

        return [
            'topic' => $topic,
            'user_progress' => $userProgress,
        ];
    }
}
