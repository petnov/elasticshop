<?php

namespace App\Model;

use Nette;


/**
 * Products repository.
 */
interface IProductRepository
{
	/**
	 * Find all products in category.
	 *
	 * Additional filters can be given as an array ['filter' => 'value']
	 *
	 * @return array - ['data' => [product[]], 'total' => int]
	 */
	public function findByCategory($categoryId, array $filters = []);

}
