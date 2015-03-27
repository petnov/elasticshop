<?php

namespace App\Presenters;

use Nette,
	App\Model\IProductRepository;

/**
 * Product presenter.
 */
class ProductPresenter extends BasePresenter
{
	/**
	 * Products repository
	 *
	 * @var IProductRepository
	 */
	private $productsRepo;

	/**
	 * Construct routines
	 *
	 * @param IProductRepository $productRepo
	 */
	public function __construct(IProductRepository $productRepo)
	{
		$this->productsRepo = $productRepo;
	}

	/**
	 * Render default view
	 *
	 * @param string $categoryId
	 */
	public function renderDefault($urlKey)
	{
		$this->template->product = $this->productsRepo->findByUrl($urlKey);
	}

}
