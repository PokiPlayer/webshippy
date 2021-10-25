<?php

declare(strict_types=1);

namespace Webshippy\Tests\Iterator;

use Webshippy\DataObject\Order;
use Webshippy\Iterator\CSVReadlineIterator;
use Webshippy\Iterator\OrdersCSVTransformIterator;
use Webshippy\Tests\AbstractOrderAwareTest;

class CSVTransformableIteratorTest extends AbstractOrderAwareTest
{
    public function testTransformer()
    {
        $file = __DIR__.'/Resource/orders.csv';
        
        $transformIterator = new OrdersCSVTransformIterator(
            new CSVReadlineIterator($file, ',', true)
        );
        $expectedData      = $this->getExpectedData(__DIR__.'/Fixtures/orders.php');
        
        $this->assertCount(count($expectedData), $transformIterator);
        
        $i = 0;
        foreach ($transformIterator as $actual) {
            /** @var Order $expected */
            /** @var Order $actual */
            $expected = $expectedData[$i];
            $this->assertOrders($expected, $actual);
            $i++;
        }
    }
}