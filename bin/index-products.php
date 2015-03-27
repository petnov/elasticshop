<?php


use Tracy\Debugger;
$container = require __DIR__ . '/../app/bootstrap.php';
Debugger::enable(false);
// create new index
array_shift($_SERVER['argv']);

// delete old index?
$removeOldIndex = false;
if (isset($_SERVER['argv'][0]) && $_SERVER['argv'][0] == '-f') {
	$removeOldIndex = true;
	array_shift($_SERVER['argv']);
}

if (!$_SERVER['argv'][0]) {

	echo '
Index products to ElasticSearch.

Usage: index-products.php [-f] <index_name>

Parameters:
	-f = force to create an index if it already exists
';
	exit(1);
}

/* @var $indexer App\Model\ProductIndexer */
$indexer = $container->getByType('\App\Model\ProductIndexer');
$es = $container->getByType('Elasticsearch\Client');

$indexName = $_SERVER['argv'][0];
$indexer->setIndexName($indexName);

// remove old index
if ($removeOldIndex) {

	$exists = $es->indices()->exists(array(
		'index' => $indexName
	));

	if ($exists) {
		$es->indices()->delete(array(
			'index' => $indexName
		));
	}
}

// create index
$indexSettings = json_decode(file_get_contents(__DIR__ . '/index.json'), true);
$createParams = [
	'index' => $indexName,
	'body' => $indexSettings
];
$es->indices()->create($createParams);

$count = $indexer->indexAll();

echo "$count products indexed to ElasticSearch!\n";
