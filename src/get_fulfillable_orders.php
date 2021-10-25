<?php

declare(strict_types=1);

use Webshippy\Service\Order\StocksAwareFulfillableOrders;
use Webshippy\Service\Render\OrderAwareDataTableRenderer;

require dirname(__DIR__).'/vendor/autoload.php';

$orders        = StocksAwareFulfillableOrders::getByJson($argv[1], __DIR__.'/orders.csv');
$tableRenderer = new OrderAwareDataTableRenderer();
$tableRenderer->renderDataHeader();

foreach ($orders as $order) {
    $tableRenderer->renderDataRow($order);
}