<?php

namespace App\Model;

use Nette,
	Nette\Security\Passwords;


/**
 * Products repository.
 */
class ProductRepository extends Nette\Object implements IProductRepository
{
	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}


	/**
	 * (non-PHPdoc)
	 * @see \App\Model\IProductRepository::findByCategory()
	 */
	public function findByCategory($categoryId, array $filters = [])
	{
		$productsQuery = $this->database
					->table('product')
					->where('category_id', $categoryId);

		$return = [
			'total' => count($productsQuery),
			'products' => [],
		];

		if (isset($filters['limit'])) {
			$offset = isset($filters['offset']) ? $filters['offset'] : null;
			$productsQuery->limit($filters['limit'], $offset);
		}

		$productsRes = $productsQuery->fetchAll();

		foreach ($productsRes as $product) {
			$return['products'][] = $product->toArray();
		}

		return $return;
	}

}
