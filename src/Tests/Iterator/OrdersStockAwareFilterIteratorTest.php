<?php

declare(strict_types=1);

namespace Webshippy\Tests\Iterator;

use Webshippy\DataObject\Order;
use Webshippy\Iterator\CSVReadlineIterator;
use Webshippy\Iterator\OrdersCSVTransformIterator;
use Webshippy\Iterator\OrdersStockAwareFilterIterator;
use Webshippy\Tests\AbstractOrderAwareTest;

class OrdersStockAwareFilterIteratorTest extends AbstractOrderAwareTest
{
    /**
     * @param array $stocks
     * @param array $expectedDatas
     *
     * @throws \Exception
     *
     * @dataProvider dataProvider
     */
    public function testFilteredOrders(array $stocks, array $expectedDatas): void
    {
        $file           = __DIR__.'/Resource/orders.csv';
        $expectedOrders = $this->getOrdersByRawArray($expectedDatas);
        $ordersIterator = new OrdersStockAwareFilterIterator(
            new OrdersCSVTransformIterator(
                new CSVReadlineIterator($file)
            ),
            $stocks
        );
        
        $this->assertCount(count($expectedOrders), $ordersIterator);
        
        $i = 0;
        foreach ($ordersIterator as $order) {
            $expected = $expectedOrders[$i];
            $actual   = $order;
            $this->assertOrders($expected, $actual);
            $i++;
        }
    }
    
    /**
     * @return array[]
     */
    public function dataProvider(): array
    {
        return [
            // testcase #1
            [
                [
                    '1' => 8,
                    '2' => 4,
                    '3' => 0,
                ],
                [
                    [
                        1,
                        2,
                        3,
                        '2021-03-25 14:51:47',
                    ],
                    [
                        2,
                        1,
                        2,
                        '2021-03-21 14:00:26',
                    ],
                    [
                        2,
                        4,
                        1,
                        '2021-03-22 17:41:32',
                    ],
                ],
            ],
            // testcase #2
            [
                [
                    '3' => 1,
                ],
                [
                    [
                        3,
                        1,
                        2,
                        '2021-03-22 12:31:54',
                    ],
                ],
            ],
            // testcase #3
            [
                [
                    '5' => 10,
                ],
                [
                ],
            ],
        ];
    }
}