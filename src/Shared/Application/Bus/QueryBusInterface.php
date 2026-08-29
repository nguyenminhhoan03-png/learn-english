<?php

declare(strict_types=1);

namespace Core\Shared\Application\Bus;

interface QueryBusInterface
{
    /**
     * Ask a query to its corresponding handler
     */
    public function ask(QueryInterface $query): mixed;
}
