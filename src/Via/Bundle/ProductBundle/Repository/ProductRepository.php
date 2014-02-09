<?php
namespace Via\Bundle\ProductBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Via\Bundle\ProductBundle\Repository\ProductTranslationRepository;

/**
 * Class ProductRepository
 *
 * This is the Product entity repository class
 */
class ProductRepository extends ProductTranslationRepository
{
    /* public function find($id)
    {
        return $this
        ->getCollectionQueryBuilder()
        ->andWhere($this->getAlias().'.id = '.intval($id))
        ->getQuery()
        ->getArrayResult()
        ;
    } */
    
}