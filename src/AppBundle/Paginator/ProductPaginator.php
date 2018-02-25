<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/25/18
 * Time: 9:37 PM
 */

namespace AppBundle\Paginator;


use AppBundle\Repository\ProductRepository;
use Knp\Component\Pager\Paginator;

class ProductPaginator
{
    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(Paginator $paginator, ProductRepository $productRepository)
    {
        $this->paginator = $paginator;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $page
     * @param int $limit
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     * @author Karol Włodek
     */
    public function getPaginator(int $page = 1, int $limit = 10)
    {
        return $this->paginator->paginate($this->productRepository->findProductsQuery(), $page, $limit);
    }
}