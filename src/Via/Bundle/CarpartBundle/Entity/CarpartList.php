<?php

namespace Via\Bundle\CarpartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CarpartList
 *
 * @ORM\Table(name="via_carpart_list")
 * @ORM\Entity
 */
class CarpartList
{
    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=55, nullable=false)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=55, nullable=false)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=55, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="platform", type="string", length=55, nullable=false)
     */
    private $platform;

    /**
     * @var string
     *
     * @ORM\Column(name="production_period", type="string", length=55, nullable=false)
     */
    private $productionPeriod;

    /**
     * @var string
     *
     * @ORM\Column(name="engine", type="string", length=55, nullable=false)
     */
    private $engine;

    /**
     * @var string
     *
     * @ORM\Column(name="hsn_tsn", type="string", length=55, nullable=false)
     */
    private $hsnTsn;

    /**
     * @var integer
     *
     * @ORM\Column(name="ktype", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ktype;



    /**
     * Set brand
     *
     * @param string $brand
     * @return ViaCarpartList
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return ViaCarpartList
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return ViaCarpartList
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set platform
     *
     * @param string $platform
     * @return ViaCarpartList
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Get platform
     *
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set productionPeriod
     *
     * @param string $productionPeriod
     * @return ViaCarpartList
     */
    public function setProductionPeriod($productionPeriod)
    {
        $this->productionPeriod = $productionPeriod;

        return $this;
    }

    /**
     * Get productionPeriod
     *
     * @return string
     */
    public function getProductionPeriod()
    {
        return $this->productionPeriod;
    }

    /**
     * Set engine
     *
     * @param string $engine
     * @return ViaCarpartList
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Get engine
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set hsnTsn
     *
     * @param string $hsnTsn
     * @return ViaCarpartList
     */
    public function setHsnTsn($hsnTsn)
    {
        $this->hsnTsn = $hsnTsn;

        return $this;
    }

    /**
     * Get hsnTsn
     *
     * @return string
     */
    public function getHsnTsn()
    {
        return $this->hsnTsn;
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
}
