<?php
namespace Via\Bundle\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Via\Bundle\VariableProductBundle\Entity\Variant;
use Via\Bundle\VariableProductBundle\Entity\Option;
use Via\Bundle\CarpartBundle\Entity\CarpartList;

/**
 * @ORM\Entity
 * @ORM\Table(name="via_product")
 *
 */
class Product implements ProductInterface
{
    /*
     * Variant selection methods.
    *
    * 1) Choice - A list of all variants is displayed to user.
    *
    * 2) Match  - Each product option is displayed as select field.
    *             User selects the values and we match them to variant.
    */
    const VARIANT_SELECTION_CHOICE = 'choice';
    const VARIANT_SELECTION_MATCH  = 'match';
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(name="name", type="string", length=80)
     */
    protected $name;
    
    /**
     * @ORM\Column(name="description", type="text")
     */
    protected $description;
    
    /**
     * short description
     *
     * @ORM\Column(name="short_description", type="string", length=255, nullable=true)
     */
    protected $shortDescription;
    
    /**
     * Creation time.
     *
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;
    
    /**
     * Last update time.
     *
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;
    
    /**
     * Deletion time.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Via\Bundle\ProductBundle\Entity\ProductProperty", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
     */
    protected $properties;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Via\Bundle\VariableProductBundle\Entity\Option", cascade={"all"})
     * @ORM\JoinTable(name="via_product_option",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="option_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    protected $options;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Via\Bundle\VariableProductBundle\Entity\Variant", mappedBy="product", cascade={"all"}, orphanRemoval=true)
     */
    protected $variants;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Via\Bundle\ProductBundle\Entity\ProductProperty", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
     */
    protected $carparts;
    
    
    public function __construct()
    {

        $this->properties = new ArrayCollection();
        $this->variants = new ArrayCollection();
        $this->options = new ArrayCollection();
        
        $this->setMasterVariant(new Variant());
                
        $this->variantSelectionMethod = self::VARIANT_SELECTION_CHOICE;
    }
    
    public function __toString()
    {
        return ($this->getName()) ? : '';
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSku()
    {
        return $this->getMasterVariant()->getSku();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSku($sku)
    {
        $this->getMasterVariant()->setSku($sku);
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->getMasterVariant()->getPrice();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPrice($price)
    {
        $this->getMasterVariant()->setPrice($price);
    
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
    
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
    
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getProperties()
    {
        return $this->properties;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProperties(Collection $properties)
    {
        foreach ($properties as $property) {
            $this->addProperty($property);
        }
    
        return $this;
    }
    
    public function addPropertie (ProductProperty $property)
    {
        $this->addProperty($property);
    }
    
    /**
     * {@inheritdoc}
     */
    public function addProperty(ProductProperty $property)
    {
        if (!$this->hasProperty($property)) {
            $property->setProduct($this);
            $this->properties->add($property);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeProperty(ProductProperty $property)
    {
        if ($this->hasProperty($property)) {
            $property->setProduct(null);
            $this->properties->removeElement($property);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasProperty(ProductProperty $property)
    {
        return $this->properties->contains($property);
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasPropertyByName($propertyName)
    {
        foreach ($this->properties as $property) {
            if ($property->getName() === $propertyName) {
                return true;
            }
        }
    
        return false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPropertyByName($propertyName)
    {
        foreach ($this->properties as $property) {
            if ($property->getName() === $propertyName) {
                return $property;
            }
        }
    
        return null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        return $this
        ->getMasterVariant()
        ->isAvailable()
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAvailableOn()
    {
        return $this
        ->getMasterVariant()
        ->getAvailableOn()
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setAvailableOn(\DateTime $availableOn)
    {
        $this
        ->getMasterVariant()
        ->setAvailableOn($availableOn)
        ;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMasterVariant()
    {
        foreach ($this->variants as $variant) {
            if ($variant->isMaster()) {
                return $variant;
            }
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMasterVariant(Variant $masterVariant)
    {
        if ($this->variants->contains($masterVariant)) {
            return $this;
        }
    
        $masterVariant->setProduct($this);
        $masterVariant->setMaster(true);
    
        $this->variants->add($masterVariant);
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasVariants()
    {
        return !$this->getVariants()->isEmpty();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getVariants()
    {
        return $this->variants->filter(function (Variant $variant) {
            return !$variant->isMaster();
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAvailableVariants()
    {
        return $this->variants->filter(function (Variant $variant) {
            return !$variant->isMaster() && $variant->isAvailable();
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function setVariants(Collection $variants)
    {
        $this->variants->clear();
    
        foreach ($variants as $variant) {
            $this->addVariant($variant);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addVariant(Variant $variant)
    {
        if (!$this->hasVariant($variant)) {
            $variant->setProduct($this);
            $this->variants->add($variant);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeVariant(Variant $variant)
    {
        if ($this->hasVariant($variant)) {
            $variant->setProduct(null);
            $this->variants->removeElement($variant);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasVariant(Variant $variant)
    {
        return $this->variants->contains($variant);
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasOptions()
    {
        return !$this->options->isEmpty();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOptions(Collection $options)
    {
        $this->options = $options;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addOption(Option $option)
    {
        if (!$this->hasOption($option)) {
            $this->options->add($option);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeOption(Option $option)
    {
        if ($this->hasOption($option)) {
            $this->options->removeElement($option);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasOption(Option $option)
    {
        return $this->options->contains($option);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getVariantSelectionMethod()
    {
        return $this->variantSelectionMethod;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setVariantSelectionMethod($variantSelectionMethod)
    {
        if (!in_array($variantSelectionMethod, array(self::VARIANT_SELECTION_CHOICE, self::VARIANT_SELECTION_MATCH))) {
            throw new \InvalidArgumentException(sprintf('Wrong variant selection method "%s" given.', $variantSelectionMethod));
        }
    
        $this->variantSelectionMethod = $variantSelectionMethod;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isVariantSelectionMethodChoice()
    {
        return self::VARIANT_SELECTION_CHOICE === $this->variantSelectionMethod;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getVariantSelectionMethodLabel()
    {
        $labels = self::getVariantSelectionMethodLabels();
    
        return $labels[$this->variantSelectionMethod];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCarparts()
    {
        return $this->carparts;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCarparts(Collection $carparts)
    {
        foreach ($carparts as $carpart) {
            $this->addCarpart($carpart);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addCarpart(CarpartList $carpart)
    {
        if (!$this->hasCarpart($carpart)) {
            $carpart->setProduct($this);
            $this->carparts->add($carpart);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeCarpart(CarpartList $carpart)
    {
        if ($this->hasCarpart($carpart)) {
            $carpart->setProduct(null);
            $this->carparts->removeElement($carpart);
        }
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasCarpart(CarpartList $carpart)
    {
        return $this->carpart->contains($carpart);
    }
}
