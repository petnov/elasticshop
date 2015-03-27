<?php

namespace App\Presenters;

/**
 * Category presenter.
 */
class HomepagePresenter extends CategoryPresenter
{
	/**
	 * Render default view
	 *
	 * @param string $categoryId
	 */
	public function renderDefault($page = 1, $categoryId = null)
	{
		// get all categories
		$categories = $this->categoryRepo->findAll();
		$this->template->categories = $categories;

		// find random category
		$category = $categories[array_rand($categories)];

		// get products
		$products = $this->productsRepo->findByCategory($category['id'], [
			'limit' => 21
		]);

		$this->template->products = $products;
	}

}
