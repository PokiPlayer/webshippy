<?php

declare(strict_types=1);

namespace Webshippy\Tests;

use PHPUnit\Framework\TestCase;
use Webshippy\DataObject\Order;
use Webshippy\Enum\PriorityEnum;

abstract class AbstractOrderAwareTest extends TestCase
{
    /**
     * @return Order[]
     */
    protected function getExpectedData(string $file): array
    {
        $rawData = require $file;
        
        return $this->getOrdersByRawArray($rawData);
    }
    
    /**
     * @param array $rawData
     *
     * @return Order[]
     * @throws \Exception
     */
    protected function getOrdersByRawArray(array $rawData): array
    {
        $expectedData = [];
        foreach ($rawData as $data) {
            $expectedData[] = $this->createOrderByData($data);
        }
        
        return $expectedData;
    }
    
    /**
     * @param array $data
     *
     * @return Order
     * @throws \Exception
     */
    protected function createOrderByData(array $data): Order
    {
        $order = new Order();
        $order->setProductId($data[0]);
        $order->setQuantity($data[1]);
        $order->setPriority(PriorityEnum::getEnumById($data[2]));
        $order->setCreatedAt(\DateTime::createFromFormat('Y-m-d H:i:s', $data[3]));
        
        return $order;
    }
    
    /**
     * @param Order $expected
     * @param Order $actual
     */
    protected function assertOrders($expected, $actual)
    {
        $this->assertInstanceOf(Order::class, $actual);
        $this->assertEquals($expected->getProductId(), $actual->getProductId());
        $this->assertEquals($expected->getQuantity(), $actual->getQuantity());
        $this->assertInstanceOf(get_class($expected->getPriority()), $actual->getPriority());
        $this->assertEquals($expected->getPriority()->getValue(), $actual->getPriority()->getValue());
        $this->assertEquals($expected->getCreatedAt()->getTimestamp(), $actual->getCreatedAt()->getTimestamp());
    }
}