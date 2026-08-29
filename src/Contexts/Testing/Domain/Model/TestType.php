<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Domain\Model;

enum TestType: string
{
    case READING = 'reading';
    case LISTENING = 'listening';
    case FULL_TEST = 'full_test';

    public function label(): string
    {
        return match ($this) {
            self::READING => 'Luyện Đọc (Reading)',
            self::LISTENING => 'Luyện Nghe (Listening)',
            self::FULL_TEST => 'Full Mock Test (Reading + Listening)',
        };
    }
}
