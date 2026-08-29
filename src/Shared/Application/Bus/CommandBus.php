<?php

declare(strict_types=1);

namespace Core\Shared\Application\Bus;

use Core\Shared\Domain\Exceptions\DomainException;
use Illuminate\Contracts\Container\Container;

final class CommandBus implements CommandBusInterface
{
    public function __construct(
        private readonly Container $container
    ) {}

    public function dispatch(CommandInterface $command): mixed
    {
        $commandClass = get_class($command);
        $handlerClass = $commandClass . 'Handler';

        if (!class_exists($handlerClass)) {
            // Try resolving by replacing Command namespace to Handler
            $handlerClass = str_replace('\\Commands\\', '\\Handlers\\', $commandClass) . 'Handler';
        }

        if (!class_exists($handlerClass)) {
            throw new DomainException("Command handler [{$handlerClass}] not found for command [{$commandClass}].");
        }

        $handler = $this->container->make($handlerClass);

        return $handler->handle($command);
    }
}
