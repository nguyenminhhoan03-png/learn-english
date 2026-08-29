<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Application\Commands;

use Core\Shared\Application\Bus\CommandInterface;

final class SaveWordCommand implements CommandInterface
{
    public function __construct(
        public readonly int $userId,
        public readonly string $word,
        public readonly string $definitionVi,
        public readonly ?string $contextSentence = null,
        public readonly ?string $phoneticUs = null,
        public readonly ?string $audioUs = null,
        public readonly ?string $partOfSpeech = null,
        public readonly ?string $customNote = null
    ) {}
}
