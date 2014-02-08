<?php
namespace Via\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Via\Bundle\VariableProductBundle\Entity\VariableProduct as BaseProduct;
use Via\Bundle\VariableProductBundle\Entity\Variant;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Via\Bundle\CoreBundle\Repository\ProductRepository")
 *
 */
class Product extends BaseProduct implements ProductInterface
{
}
