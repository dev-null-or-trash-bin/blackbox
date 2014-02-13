<?php

namespace Via\Bundle\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ViaCarpart
 *
 * @ORM\Table(name="via_carpart", indexes={@ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class ViaCarpart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ktype", type="integer", nullable=false)
     */
    private $ktype;

    /**
     * @var string
     *
     * @ORM\Column(name="hsn", type="string", length=5, nullable=false)
     */
    private $hsn;

    /**
     * @var integer
     *
     * @ORM\Column(name="tsn", type="integer", nullable=false)
     */
    private $tsn;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=false)
     */
    private $comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Via\Bundle\ProductBundle\Entity\ViaProduct
     *
     * @ORM\ManyToOne(targetEntity="Via\Bundle\ProductBundle\Entity\ViaProduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;



    /**
     * Set ktype
     *
     * @param integer $ktype
     * @return ViaCarpart
     */
    public function setKtype($ktype)
    {
        $this->ktype = $ktype;

        return $this;
    }

    /**
     * Get ktype
     *
     * @return integer
     */
    public function getKtype()
    {
        return $this->ktype;
    }

    /**
     * Set hsn
     *
     * @param string $hsn
     * @return ViaCarpart
     */
    public function setHsn($hsn)
    {
        $this->hsn = $hsn;

        return $this;
    }

    /**
     * Get hsn
     *
     * @return string
     */
    public function getHsn()
    {
        return $this->hsn;
    }

    /**
     * Set tsn
     *
     * @param integer $tsn
     * @return ViaCarpart
     */
    public function setTsn($tsn)
    {
        $this->tsn = $tsn;

        return $this;
    }

    /**
     * Get tsn
     *
     * @return integer
     */
    public function getTsn()
    {
        return $this->tsn;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return ViaCarpart
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

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
     * Set product
     *
     * @param \Via\Bundle\ProductBundle\Entity\ViaProduct $product
     * @return ViaCarpart
     */
    public function setProduct(\Via\Bundle\ProductBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Via\Bundle\ProductBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
