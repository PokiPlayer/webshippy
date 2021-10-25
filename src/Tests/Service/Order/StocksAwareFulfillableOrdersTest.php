<?php

declare(strict_types=1);

namespace Webshippy\Tests\Service\Order;

use Webshippy\Service\Order\StocksAwareFulfillableOrders;
use Webshippy\Tests\AbstractOrderAwareTest;

class StocksAwareFulfillableOrdersTest extends AbstractOrderAwareTest
{
    /**
     * @param string $stocks
     * @param array  $expectedDatas
     *
     * @throws \Exception
     *
     * @dataProvider dataProvider
     */
    public function testFulfilledOrders(string $stocks, array $expectedDatas): void
    {
        $file            = __DIR__.'/Resource/orders.csv';
        $expectedOrders  = $this->getOrdersByRawArray($expectedDatas);
        $fulfilledOrders = StocksAwareFulfillableOrders::getByJson($stocks, $file);
        
        $this->assertCount(count($expectedOrders), $fulfilledOrders);
        
        $i = 0;
        foreach ($fulfilledOrders as $actual) {
            $expected = $expectedOrders[$i];
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
            [
                '{"1":8,"2":4,"3":0}',
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
                        '2021-03-20 14:00:26',
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
        ];
    }
    
    public function testInvalidJSON()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid json!');
        $file            = __DIR__.'/Resource/orders.csv';
        $fulfilledOrders = StocksAwareFulfillableOrders::getByJson("", $file);
    }
}