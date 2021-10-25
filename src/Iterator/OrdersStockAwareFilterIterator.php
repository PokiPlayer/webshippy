<?php

declare(strict_types=1);

namespace Webshippy\Iterator;

use FilterIterator;
use Webshippy\DataObject\Order;

class OrdersStockAwareFilterIterator extends FilterIterator
{
    protected array $stocks;
    
    /**
     * @param \Iterator $iterator
     * @param array     $stocks
     */
    public function __construct(\Iterator $iterator, array $stocks)
    {
        parent::__construct($iterator);
        $this->stocks = $stocks;
    }
    
    /**
     * @inheritDoc
     */
    public function accept()
    {
        /** @var Order $order */
        $order = $this->current();
    
        return array_key_exists($order->getProductId(), $this->stocks) &&
            $this->stocks[$order->getProductId()] >= $order->getQuantity();
    }
}