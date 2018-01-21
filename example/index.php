<?php

require __DIR__ . '/../vendor/autoload.php';

$binlist = new \Binlist\Binlist('65465421');

print_r($binlist->getResponse());

echo $binlist . PHP_EOL;

echo $binlist->getScheme() . PHP_EOL;

echo $binlist->getType() . PHP_EOL;

echo $binlist->getBrand() . PHP_EOL;

echo $binlist->getPrepaid() . PHP_EOL;

echo $binlist->getCountry()->name . PHP_EOL;