<?php

declare(strict_types=1);

namespace Webshippy\Tests\Service\Render;

use PHPUnit\Framework\TestCase;
use Webshippy\Service\Order\StocksAwareFulfillableOrders;
use Webshippy\Service\Render\OrderAwareDataTableRenderer;

class OrdersAwareDataTableRenderTest extends TestCase
{
    public function testRendering()
    {
        $expectedStr = file_get_contents(__DIR__.'/Fixtures/fullfiledOrdersTableOutput.txt');
        $this->expectOutputString($expectedStr);
        $file            = __DIR__.'/Resource/orders.csv';
        $fulfilledOrders = StocksAwareFulfillableOrders::getByJson('{"1":8,"2":4,"3":5}', $file);
        
        $tableRenderer = new OrderAwareDataTableRenderer();
        $tableRenderer->renderDataHeader();
        
        foreach ($fulfilledOrders as $order) {
            $tableRenderer->renderDataRow($order);
        }
    }
}