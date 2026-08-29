<?php

declare(strict_types=1);

namespace Core\Shared\Domain\Exceptions;

class ConcurrencyException extends DomainException
{
    public function __construct(string $message = "Hành động đang được xử lý đồng thời, vui lòng thử lại sau giây lát!")
    {
        parent::__construct($message);
    }
}
