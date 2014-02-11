<?php
namespace Via\Bundle\VariableProductBundle\Generator;

use Via\Bundle\ProductBundle\Entity\ProductInterface;

interface VariantGeneratorInterface
{
    /**
     * Generate all possible variants if they don't exist currently.
     * Add them do product.
     *
     * @param VariableProductInterface $product
     */
    public function generate(ProductInterface $product);
}
