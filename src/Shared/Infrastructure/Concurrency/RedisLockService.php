<?php

declare(strict_types=1);

namespace Core\Shared\Infrastructure\Concurrency;

use Closure;
use Core\Shared\Domain\Exceptions\ConcurrencyException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

final class RedisLockService
{
    /**
     * Executes a callback within a distributed atomic lock with automatic release.
     *
     * @template T
     * @param string $lockKey Unique resource key (e.g. "submission:user:1:test:2")
     * @param int $ttlSeconds Lock validity in seconds
     * @param int $waitTimeoutSeconds How long to wait to acquire lock
     * @param Closure(): T $callback
     * @return T
     * @throws ConcurrencyException|Throwable
     */
    public function executeWithLock(
        string $lockKey,
        int $ttlSeconds,
        int $waitTimeoutSeconds,
        Closure $callback
    ): mixed {
        $lock = Cache::lock("lock:{$lockKey}", $ttlSeconds);

        $acquired = $waitTimeoutSeconds > 0
            ? $lock->block($waitTimeoutSeconds)
            : $lock->get();

        if (!$acquired) {
            throw new ConcurrencyException("Yêu cầu đang được xử lý đồng thời. Vui lòng không thực hiện thao tác liên tiếp!");
        }

        try {
            return $callback();
        } finally {
            $lock->release();
        }
    }

    /**
     * Executes within both a distributed lock AND a database transaction.
     *
     * @template T
     * @param string $lockKey
     * @param int $ttlSeconds
     * @param Closure(): T $callback
     * @return T
     */
    public function executeTransactionalWithLock(
        string $lockKey,
        int $ttlSeconds,
        Closure $callback
    ): mixed {
        return $this->executeWithLock($lockKey, $ttlSeconds, 0, function () use ($callback) {
            return DB::transaction(function () use ($callback) {
                return $callback();
            });
        });
    }
}
