<?php

declare(strict_types=1);

namespace Tests\Unit;

use Core\Contexts\Vocabulary\Domain\Services\SuperMemoSm2Engine;
use PHPUnit\Framework\TestCase;

class SuperMemoSm2EngineTest extends TestCase
{
    private SuperMemoSm2Engine $engine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->engine = new SuperMemoSm2Engine();
    }

    public function test_it_schedules_day_one_for_first_successful_repetition(): void
    {
        $result = $this->engine->computeNextReview(
            repetitions: 0,
            currentEaseFactor: 2.50,
            currentIntervalDays: 1,
            grade: 2 // Good
        );

        $this->assertEquals(1, $result['repetitions']);
        $this->assertEquals(1, $result['interval_days']);
        $this->assertGreaterThanOrEqual(2.50, $result['ease_factor']);
    }

    public function test_it_schedules_six_days_for_second_successful_repetition(): void
    {
        $result = $this->engine->computeNextReview(
            repetitions: 1,
            currentEaseFactor: 2.50,
            currentIntervalDays: 1,
            grade: 3 // Easy
        );

        $this->assertEquals(2, $result['repetitions']);
        $this->assertEquals(6, $result['interval_days']);
    }

    public function test_it_resets_interval_on_memory_blackout(): void
    {
        $result = $this->engine->computeNextReview(
            repetitions: 4,
            currentEaseFactor: 2.30,
            currentIntervalDays: 18,
            grade: 0 // Completely forgotten
        );

        $this->assertEquals(0, $result['repetitions']);
        $this->assertEquals(1, $result['interval_days']);
    }
}
