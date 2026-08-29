<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Application\Queries;

use App\Models\Vocabulary;
use Core\Shared\Application\Bus\QueryHandlerInterface;
use Core\Shared\Infrastructure\Caching\CacheKeyManager;
use Illuminate\Support\Facades\Cache;

final class LookupWordQueryHandler implements QueryHandlerInterface
{
    public function handle(LookupWordQuery $query): ?Vocabulary
    {
        $normalized = mb_strtolower(trim($query->word));
        $cacheKey = CacheKeyManager::vocabularyLookup($normalized);

        return Cache::remember($cacheKey, CacheKeyManager::TTL_WEEK, function () use ($normalized) {
            return Vocabulary::where('word', $normalized)->first();
        });
    }
}
