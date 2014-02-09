<?php
namespace Via\Bundle\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Via\Bundle\ProductBundle\Repository\ProductRepository as BaseProductRepository;
use Doctrine\Common\Util\Debug;
/**
 * Class ProductRepository
 *
 * This is the Product entity repository class
 */
class ProductRepository extends BaseProductRepository
{
    public function find($id)
    {
        echo __METHOD__;
        Debug::dump($this->getQueryBuilder()->andWhere($this->getAlias().'.id = '.intval($id))->getQuery());
        die();
        return $this
        ->getQueryBuilder()
        ->andWhere($this->getAlias().'.id = '.intval($id))
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }
}