<?php

namespace Via\Bundle\VariableProductBundle\Repository;

use Via\Bundle\CoreBundle\Repository\EntityRepository;

class VariantRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->select('product, option, variant')
            ->leftJoin('product.options', 'option')
            ->leftJoin('product.variants', 'variant')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'product';
    }
}
