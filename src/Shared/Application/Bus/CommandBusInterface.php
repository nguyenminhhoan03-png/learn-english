<?php

declare(strict_types=1);

namespace Core\Shared\Application\Bus;

interface CommandBusInterface
{
    /**
     * Dispatch a command to its corresponding handler
     */
    public function dispatch(CommandInterface $command): mixed;
}
