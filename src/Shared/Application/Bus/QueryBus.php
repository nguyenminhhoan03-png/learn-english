<?php

declare(strict_types=1);

namespace Core\Shared\Application\Bus;

use Core\Shared\Domain\Exceptions\DomainException;
use Illuminate\Contracts\Container\Container;

final class QueryBus implements QueryBusInterface
{
    public function __construct(
        private readonly Container $container
    ) {}

    public function ask(QueryInterface $query): mixed
    {
        $queryClass = get_class($query);
        $handlerClass = $queryClass . 'Handler';

        if (!class_exists($handlerClass)) {
            $handlerClass = str_replace('\\Queries\\', '\\Handlers\\', $queryClass) . 'Handler';
        }

        if (!class_exists($handlerClass)) {
            throw new DomainException("Query handler [{$handlerClass}] not found for query [{$queryClass}].");
        }

        $handler = $this->container->make($handlerClass);

        return $handler->handle($query);
    }
}
