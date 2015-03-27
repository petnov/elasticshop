<?php

namespace App\Model;

use Nette;
use Elasticsearch;


/**
 * Product indexer
 */
class ProductIndexer extends Nette\Object
{
	/** @var Nette\Database\Context */
	private $database;

	/**
	 * @var Elasticsearch\Client
	 */
	private $es;

	/**
	 * Name of index to index to
	 *
	 * @var string
	 */
	private $indexName;

	public function __construct(Nette\Database\Context $database, Elasticsearch\Client $es)
	{
		$this->database = $database;
		$this->es = $es;
	}

	/**
	 * Index name setter
	 *
	 * @param string $name
	 */
	public function setIndexName($name)
	{
		$this->indexName = $name;
	}

	/**
	 * Index all products
	 *
	 * @return number
	 */
	public function indexAll()
	{
		$products = $this->database->table('product')->fetchAll();
		foreach	($products as $product) {

			$this->es->index([
				'index' => $this->indexName,
				'type' => 'product',
				'id' => $product['id'],
				'body' => $product->toArray()
			]);
		}

		return count($products);
	}

}
