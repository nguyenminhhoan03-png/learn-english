<?php

declare(strict_types=1);

namespace Tests\Unit;

use Core\Contexts\Testing\Domain\Services\IeltsScoringEngine;
use PHPUnit\Framework\TestCase;

class IeltsScoringEngineTest extends TestCase
{
    public function test_it_calculates_reading_band_scores_accurately(): void
    {
        $this->assertEquals(9.0, IeltsScoringEngine::calculateReadingBand(40)->getValue());
        $this->assertEquals(9.0, IeltsScoringEngine::calculateReadingBand(39)->getValue());
        $this->assertEquals(8.5, IeltsScoringEngine::calculateReadingBand(37)->getValue());
        $this->assertEquals(8.0, IeltsScoringEngine::calculateReadingBand(35)->getValue());
        $this->assertEquals(7.5, IeltsScoringEngine::calculateReadingBand(33)->getValue());
        $this->assertEquals(7.0, IeltsScoringEngine::calculateReadingBand(30)->getValue());
        $this->assertEquals(6.5, IeltsScoringEngine::calculateReadingBand(27)->getValue());
        $this->assertEquals(6.0, IeltsScoringEngine::calculateReadingBand(23)->getValue());
        $this->assertEquals(5.5, IeltsScoringEngine::calculateReadingBand(19)->getValue());
        $this->assertEquals(5.0, IeltsScoringEngine::calculateReadingBand(15)->getValue());
    }

    public function test_it_calculates_listening_band_scores_accurately(): void
    {
        $this->assertEquals(9.0, IeltsScoringEngine::calculateListeningBand(40)->getValue());
        $this->assertEquals(8.5, IeltsScoringEngine::calculateListeningBand(37)->getValue());
        $this->assertEquals(8.0, IeltsScoringEngine::calculateListeningBand(35)->getValue());
        $this->assertEquals(7.5, IeltsScoringEngine::calculateListeningBand(32)->getValue());
        $this->assertEquals(7.0, IeltsScoringEngine::calculateListeningBand(30)->getValue());
        $this->assertEquals(6.5, IeltsScoringEngine::calculateListeningBand(26)->getValue());
        $this->assertEquals(6.0, IeltsScoringEngine::calculateListeningBand(23)->getValue());
    }

    public function test_it_calculates_overall_band_with_ielts_rounding_rules(): void
    {
        $reading = IeltsScoringEngine::calculateReadingBand(35); // 8.0
        $listening = IeltsScoringEngine::calculateListeningBand(30); // 7.0
        
        $overall = IeltsScoringEngine::calculateOverallBand($reading, $listening);
        $this->assertEquals(7.5, $overall->getValue());
    }
}
