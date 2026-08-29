<?php

declare(strict_types=1);

namespace Core\Shared\Domain\ValueObjects;

use Core\Shared\Domain\Exceptions\DomainException;

final class BandScore
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value < 0.0 || $value > 9.0) {
            throw new DomainException("Band score must be between 0.0 and 9.0, got: {$value}");
        }

        // IELTS Band score must be rounded to nearest 0.5
        $this->value = round($value * 2) / 2;
    }

    public static function fromFloat(float $value): self
    {
        return new self($value);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getFormatted(): string
    {
        return number_format($this->value, 1);
    }

    public function isPassing(float $targetBand): bool
    {
        return $this->value >= $targetBand;
    }

    public function __toString(): string
    {
        return $this->getFormatted();
    }
}
