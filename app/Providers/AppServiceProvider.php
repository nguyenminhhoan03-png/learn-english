<?php

declare(strict_types=1);

namespace App\Providers;

use Core\Shared\Application\Bus\CommandBus;
use Core\Shared\Application\Bus\CommandBusInterface;
use Core\Shared\Application\Bus\QueryBus;
use Core\Shared\Application\Bus\QueryBusInterface;
use Core\Shared\Infrastructure\Concurrency\RedisLockService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CommandBusInterface::class, CommandBus::class);
        $this->app->singleton(QueryBusInterface::class, QueryBus::class);
        $this->app->singleton(RedisLockService::class, RedisLockService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiters();
        $this->registerDomainEventListeners();
        $this->registerGlobalViewComposers();
    }

    private function registerGlobalViewComposers(): void
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with('currentUser', auth()->user());
        });
    }

    private function registerDomainEventListeners(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \Core\Contexts\Testing\Domain\Events\TestSubmittedEvent::class,
            \Core\Contexts\Gamification\Application\Listeners\UpdateStreakOnActivityListener::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \Core\Contexts\Dictation\Domain\Events\SentenceCompletedEvent::class,
            \Core\Contexts\Gamification\Application\Listeners\UpdateStreakOnActivityListener::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \Core\Contexts\Vocabulary\Domain\Events\FlashcardReviewedEvent::class,
            \Core\Contexts\Gamification\Application\Listeners\UpdateStreakOnActivityListener::class
        );
    }

    /**
     * Senior+ Multi-Tier Rate Limiting Configuration
     */
    private function configureRateLimiters(): void
    {
        // 1. Rate limiter cho AI chấm bài Writing (bảo vệ chi phí API tokens)
        RateLimiter::for('ai-grade', function (Request $request) {
            $userKey = $request->user()?->id ?: $request->ip();
            return Limit::perMinute(5)->by($userKey)->response(function () {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã gửi yêu cầu chấm bài AI quá nhanh. Vui lòng đợi 1 phút trước khi thử lại.'
                ], 429);
            });
        });

        // 2. Rate limiter cho Nộp bài thi IELTS (chống spam/double submit)
        RateLimiter::for('exam-submit', function (Request $request) {
            $userKey = $request->user()?->id ?: $request->ip();
            return Limit::perMinute(10)->by($userKey)->response(function () {
                return response()->json([
                    'success' => false,
                    'message' => 'Hệ thống đang xử lý bài nộp của bạn, vui lòng không nộp liên tiếp.'
                ], 429);
            });
        });

        // 3. Rate limiter cho So khớp câu chép chính tả (Realtime typing check)
        RateLimiter::for('dictation-verify', function (Request $request) {
            $userKey = $request->user()?->id ?: $request->ip();
            return Limit::perMinute(120)->by($userKey);
        });

        // 4. Rate limiter cho Tra từ điển nhanh qua popup
        RateLimiter::for('dictionary-lookup', function (Request $request) {
            return Limit::perMinute(100)->by($request->ip());
        });
    }
}
