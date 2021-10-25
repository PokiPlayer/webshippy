<?php

declare(strict_types=1);

namespace Webshippy\Service\Render;

use Webshippy\DataObject\Order;

class OrderAwareDataTableRenderer extends ObjectAwareDataTableRenderer
{
    /**
     * @inheritDoc
     */
    protected function getSupportedDataObjectClass(): string
    {
        return Order::class;
    }
}