<?php

namespace App\Presenters;

use Nette,
	App\Model\IProductRepository,
	App\Model\CategoryRepository;

/**
 * Category presenter.
 */
class SearchPresenter extends BasePresenter
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
	 * @param string $q
	 */
	public function renderDefault($keyword, $page = 1)
	{
		// get all categories
		$categories = $this->categoryRepo->findAll();
		$this->template->categories = $categories;


		$paginator = new Nette\Utils\Paginator;
		$paginator->setItemsPerPage(self::PER_PAGE); // the number of records on page
		$paginator->setPage($page);

		// get products
		$products = $this->productsRepo->search($keyword, [
			'limit' => $paginator->getLength(),
			'offset' => $paginator->getOffset()
		] + $this->getHttpRequest()->getQuery());


		$paginator->setItemCount($products['total']); // the total number of records (e.g., a number of products)

		$this->template->paginator = $paginator;
		$this->template->keyword = $keyword;
		$this->template->products = $products;
	}

}
