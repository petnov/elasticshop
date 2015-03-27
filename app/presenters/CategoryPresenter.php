<?php

namespace App\Presenters;

use Nette,
	App\Model\IProductRepository,
	App\Model\CategoryRepository;

/**
 * Category presenter.
 */
class CategoryPresenter extends BasePresenter
{
	// how many products per page
	const PER_PAGE = 30;

	/**
	 * Products repository
	 *
	 * @var IProductRepository
	 */
	protected $productsRepo;

	/**
	 * Category repository
	 *
	 * @var CategoryRepository
	 */
	protected $categoryRepo;

	/**
	 * Construct routines
	 *
	 * @param IProductRepository $productRepo
	 */
	public function __construct(IProductRepository $productRepo, CategoryRepository $categoryRepo)
	{
		$this->productsRepo = $productRepo;
		$this->categoryRepo = $categoryRepo;
	}

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
		$this->template->category = $categories[$categoryId];

		$paginator = new Nette\Utils\Paginator;
		$paginator->setItemsPerPage(self::PER_PAGE); // the number of records on page
		$paginator->setPage($page);

		// get products
		$products = $this->productsRepo->findByCategory($categoryId, [
			'limit' => $paginator->getLength(),
			'offset' => $paginator->getOffset()
		] + $this->getHttpRequest()->getQuery());



		$paginator->setItemCount($products['total']); // the total number of records (e.g., a number of products)
		$this->template->products = $products;
		$userFilters = $this->getHttpRequest()->getQuery();
		unset($userFilters['page']);
		$this->template->userFilters = $userFilters;

		$this->template->paginator = $paginator;

	}

}
