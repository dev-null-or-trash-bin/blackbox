<?php

namespace Via\Bundle\CarpartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ViaProductCarpart
 *
 * @ORM\Table(name="via_product_carpart")
 * @ORM\Entity
 */
class ProductCarpart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ViaCarpartList
     *
     * @ORM\ManyToOne(targetEntity="ViaCarpartList")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="carpart_list_id", referencedColumnName="ktype")
     * })
     */
    private $carpartList;

    /**
     * @var \ViaProduct
     *
     * @ORM\ManyToOne(targetEntity="ViaProduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set carpartList
     *
     * @param \Via\Bundle\CarpartBundle\Entity\ViaCarpartList $carpartList
     * @return ViaProductCarpart
     */
    public function setCarpartList(\Via\Bundle\CarpartBundle\Entity\CarpartList $carpartList = null)
    {
        $this->carpartList = $carpartList;

        return $this;
    }

    /**
     * Get carpartList
     *
     * @return \Via\Bundle\CarpartBundle\Entity\ViaCarpartList
     */
    public function getCarpartList()
    {
        return $this->carpartList;
    }

    /**
     * Set product
     *
     * @param \Via\Bundle\ProductBundle\Entity\ViaProduct $product
     * @return ViaProductCarpart
     */
    public function setProduct(\Via\Bundle\ProductBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Via\Bundle\CarpartBundle\Entity\ViaProduct
     */
    public function getProduct()
    {
        return $this->product;
    }
}
