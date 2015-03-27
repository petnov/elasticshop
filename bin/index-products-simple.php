<?php


$container = require __DIR__ . '/../app/bootstrap.php';

/* @var $indexer App\Model\ProductIndexer */
$indexer = $container->getByType('\App\Model\ProductIndexer');
$indexer->setIndexName('eshop');

$count = $indexer->indexAll();

echo "$count products indexed to ElasticSearch!\n";
