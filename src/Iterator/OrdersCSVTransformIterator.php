<?php

declare(strict_types=1);

namespace Webshippy\Iterator;

use Webshippy\DataObject\Order;
use Webshippy\Enum\PriorityEnum;

class OrdersCSVTransformIterator extends CSVTransformableIterator
{
    /**
     * @inheritDoc
     */
    protected function getObjectClass(): string
    {
        return Order::class;
    }
    
    /**
     * @inheritDoc
     */
    protected function transform($from, $to): void
    {
        /** @var array $from */
        /** @var Order $to */
        $to->setProductId((int)$from['0']);
        $to->setQuantity((int)$from['1']);
        $to->setPriority(PriorityEnum::getEnumById((int)$from['2']));
        $to->setCreatedAt(\DateTime::createFromFormat('Y-m-d H:i:s', $from['3']));
    }
}
