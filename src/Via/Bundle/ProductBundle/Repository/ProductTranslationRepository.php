<?php
namespace Via\Bundle\ProductBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Via\Bundle\CoreBundle\Repository\EntityRepository;
#use Via\Bundle\CoreBundle\Repository\TranslatableRepository;

class ProductTranslationRepository extends EntityRepository #TranslatableRepository
{   
    /**
     * {@inheritdoc}
     */
    protected function getCollectionQueryBuilder()
    {
        return parent::getCollectionQueryBuilder()
        ->select('product, translation')
        ->leftJoin('product.translations', 'translation')
        ;
    }
    
    protected function getAlias()
    {
        return 'product';
    }
}