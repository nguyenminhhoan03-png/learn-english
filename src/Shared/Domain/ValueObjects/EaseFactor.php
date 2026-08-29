<?php

declare(strict_types=1);

namespace Core\Shared\Domain\ValueObjects;

use Core\Shared\Domain\Exceptions\DomainException;

final class EaseFactor
{
    public const DEFAULT_EASE = 2.50;
    public const MIN_EASE = 1.30;

    private float $value;

    public function __construct(float $value)
    {
        if ($value < self::MIN_EASE) {
            $this->value = self::MIN_EASE;
        } else {
            $this->value = round($value, 2);
        }
    }

    public static function default(): self
    {
        return new self(self::DEFAULT_EASE);
    }

    public static function fromFloat(float $value): self
    {
        return new self($value);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
