<?php

namespace App\Model;

use Nette,
	Elasticsearch\Client;


/**
 * Products repository.
 */
class ProductEsRepository extends Nette\Object implements IProductRepository
{
	/** @var Nette\Database\Context */
	private $es;

	public function __construct(Client $es)
	{
		$this->es = $es;
	}

	/**
	 * (non-PHPdoc)
	 * @see \App\Model\IProductRepository::findByCategory()
	 */
	public function findByCategory($categoryId, array $filters = [])
	{

		$query = [
			'index' => 'eshop',
			'type' => 'product',
			'body' => [
				'query' => [
					'filtered' => [
						'filter' => [
							'term' => [
								'category_id' => $categoryId
							]
						]
					]
				]
			]
		];

		// add limit
		if (isset($filters['limit'])) {
			$query['size'] = $filters['limit'];
			if (isset($filters['offset'])) {
				$query['from'] = $filters['offset'];
			}
		}

		$result = $this->es->search($query);
		$return = [
			'total' => $result['hits']['total'],
			'products' => [],
		];

		foreach ($result['hits']['hits'] as $product) {
			$return['products'][] = $product['_source'];
		}

		return $return;
	}

}
