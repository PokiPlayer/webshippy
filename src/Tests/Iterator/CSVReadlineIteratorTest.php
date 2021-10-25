<?php

declare(strict_types=1);

namespace Webshippy\Tests\Iterator;

use PHPUnit\Framework\TestCase;
use Webshippy\Iterator\CSVReadlineIterator;

class CSVReadlineIteratorTest extends TestCase
{
    
    public function testCSVReadLineIterator(): void
    {
        $file         = __DIR__.'/Resource/orders.csv';
        $csvIterator  = new CSVReadlineIterator($file, ',', true);
        $expectedData = $this->getExpectedData();
        
        $this->assertCount(count($expectedData), $csvIterator);
        
        $i = 0;
        foreach ($csvIterator as $order) {
            $expected = $expectedData[$i];
            $this->assertSame(array_diff($expected, $order), array_diff($order, $expected));
            $i++;
        }
    }
    
    public function testNotExistsCSVIterator(): void
    {
        $file = __DIR__.'/Resource/notexist.csv';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('\"%s\" is not exists or not readeable!', $file));
        
        $csvIterator = new CSVReadlineIterator($file, ',', true);
    }
    
    /**
     * @return array[]
     */
    protected function getExpectedData(): array
    {
        return require __DIR__.'/Fixtures/orders.php';
    }
}