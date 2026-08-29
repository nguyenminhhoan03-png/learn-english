<?php

declare(strict_types=1);

namespace Core\Shared\Infrastructure\Caching;

final class CacheKeyManager
{
    public const TTL_HOUR = 3600;
    public const TTL_DAY = 86400;
    public const TTL_WEEK = 604800;

    public static function testDetail(string|int $testIdOrSlug): string
    {
        return "cache:test:detail:{$testIdOrSlug}";
    }

    public static function testCategories(): string
    {
        return "cache:test:categories";
    }

    public static function dictationTopic(string|int $topicIdOrSlug): string
    {
        return "cache:dictation:topic:{$topicIdOrSlug}";
    }

    public static function vocabularyLookup(string $word): string
    {
        $normalized = mb_strtolower(trim($word));
        return "cache:vocab:lookup:{$normalized}";
    }

    public static function userWeaknessRadar(int $userId): string
    {
        return "cache:user:weakness:{$userId}";
    }
}
