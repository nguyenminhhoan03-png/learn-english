<?php

declare(strict_types=1);

namespace Tests\Unit;

use Core\Contexts\Dictation\Domain\Services\LevenshteinVerificationEngine;
use PHPUnit\Framework\TestCase;

class LevenshteinVerificationEngineTest extends TestCase
{
    private LevenshteinVerificationEngine $engine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->engine = new LevenshteinVerificationEngine();
    }

    public function test_it_verifies_exact_matching_sentence(): void
    {
        $original = "Good communication is the most powerful tool for spreading impactful ideas.";
        $input = "Good communication is the most powerful tool for spreading impactful ideas.";

        $result = $this->engine->verify($input, $original);

        $this->assertTrue($result['is_passed']);
        $this->assertEquals(100.0, $result['accuracy']);
        $this->assertEquals(11, $result['total_words']);
        $this->assertEquals(11, $result['correct_words']);
    }

    public function test_it_handles_punctuation_insensitivity(): void
    {
        $original = "When you share a compelling story, your audience naturally connects!";
        $input = "when you share a compelling story your audience naturally connects";

        $result = $this->engine->verify($input, $original);

        $this->assertTrue($result['is_passed']);
        $this->assertEquals(100.0, $result['accuracy']);
    }

    public function test_it_identifies_typos_and_missing_words(): void
    {
        $original = "Technology changes everything quickly.";
        $input = "Technology chnges everything";

        $result = $this->engine->verify($input, $original);

        $this->assertFalse($result['is_passed']);
        $this->assertLessThan(100.0, $result['accuracy']);
        $this->assertEquals(2, $result['correct_words']); // "Technology" and "everything"
    }
}
