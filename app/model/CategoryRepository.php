<?php

namespace App\Model;

use Nette,
	Nette\Security\Passwords;


/**
 * Categories repository.
 */
class CategoryRepository extends Nette\Object
{
	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}


	/**
	 * Find category by its id
	 *
	 * @param string $categoryId
	 * @return array
	 */
	public function findById($categoryId)
	{
		$category = $this->database
					->table('category')
					->where('id', $categoryId)
					->fetch();

		return $category->toArray();
	}

	/**
	 * Find all categories
	 *
	 * @return array
	 */
	public function findAll()
	{
		$categoryRes = $this->database
			->table('category')
			->order('title')
			->fetchAll();

		$categories = [];
		foreach ($categoryRes as $cat) {
			$categories[$cat['id']] = $cat->toArray();
		}

		return $categories;
	}

}
