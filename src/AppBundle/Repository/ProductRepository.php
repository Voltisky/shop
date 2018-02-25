<?php

namespace AppBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get product Query object
     * @return \Doctrine\ORM\Query
     * @author Karol Włodek
     */
    public function findProductsQuery(){
        return $this->createQueryBuilder('p')->getQuery();
    }
}
