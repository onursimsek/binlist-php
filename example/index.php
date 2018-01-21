<?php

require __DIR__ . '/../vendor/autoload.php';

$binlist = new \Binlist\Binlist('11111111');

print_r($binlist->getRawResponse());

if ($binlist->isSuccess()) {
    echo $binlist . PHP_EOL;
    echo $binlist->getScheme() . PHP_EOL;
    echo $binlist->getType() . PHP_EOL;
    echo $binlist->getBrand() . PHP_EOL;
    echo $binlist->getPrepaid() . PHP_EOL;
    echo $binlist->getCountry()->name . PHP_EOL;
}
