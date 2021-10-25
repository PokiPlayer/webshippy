<?php

declare(strict_types=1);

namespace Webshippy\Service\Order;

use Webshippy\DataObject\Order;
use Webshippy\Iterator\CSVReadlineIterator;
use Webshippy\Iterator\OrdersCSVTransformIterator;
use Webshippy\Iterator\OrdersStockAwareFilterIterator;

class StocksAwareFulfillableOrders
{
    /**
     * @param string $stocks
     * @param string $ordersCSV
     *
     * @return array
     * @throws \Exception
     */
    public static function getByJson(string $stocks, string $ordersCSV): array
    {
        try {
            $stocks = json_decode($stocks, true, 512, JSON_THROW_ON_ERROR);
            
            return self::get($stocks, $ordersCSV);
        } catch (\JsonException $e) {
            throw new \Exception('Invalid json!');
        }
    }
    
    /**
     * @param array $stocks
     *
     * @return array
     * @throws \Exception
     */
    public static function get(array $stocks, string $ordersCSV): array
    {
        $ordersIterator = new OrdersStockAwareFilterIterator(
            new OrdersCSVTransformIterator(
                new CSVReadlineIterator($ordersCSV)
            ),
            $stocks
        );
        
        $orders = iterator_to_array($ordersIterator);
        
        self::sort($orders);
        
        return $orders;
    }
    
    /**
     * @param array $orders
     *
     * @return void
     */
    protected static function sort(array &$orders): void
    {
        usort($orders, function ($a, $b) {
            /** @var Order $a */
            /** @var Order $b */
            $pc = -1 * ($a->getPriority()->getPriorityId() <=> $b->getPriority()->getPriorityId());
            
            return $pc === 0 ? $a->getCreatedAt() <=> $b->getCreatedAt() : $pc;
        });
    }
}