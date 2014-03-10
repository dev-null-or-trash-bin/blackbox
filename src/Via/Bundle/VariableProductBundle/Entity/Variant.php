<?php
namespace Via\Bundle\VariableProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Via\Bundle\ProductBundle\Entity\Product as BaseProduct;
/**
 * @ORM\Entity
 * @ORM\Table(name="via_variant")
 *
 */
class Variant implements VariantInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=255, nullable=true)
     */
    private $sku;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    /**
     * Is master?
     *
     * @var Boolean
     *
     * @ORM\Column(name="is_master", type="boolean")
     */
    protected $master;

    /**
     * @var string
     *
     * @ORM\Column(name="presentation", type="string", length=255, nullable=true)
     */
    protected $presentation;

    /**
     * @ORM\ManyToOne(targetEntity="Via\Bundle\ProductBundle\Entity\Product", inversedBy="variants")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $product;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Via\Bundle\VariableProductBundle\Entity\OptionValue")
     * @ORM\JoinTable(name="via_variant_option_value",
     *   joinColumns={
     *     @ORM\JoinColumn(name="variant_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="option_value_id", referencedColumnName="id")
     *   }
     * )
     */
    protected $options;

    /**
     * Available on.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="available_on", type="datetime")
     */
    protected $availableOn;

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
     * Constructor.
     */
    public function __construct()
    {
        $this->master = false;
        $this->options = new ArrayCollection();
        $this->availableOn = new \DateTime();
        $this->createdAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function isMaster()
    {
        return $this->master;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaster($master)
    {
        $this->master = (Boolean) $master;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * {@inheritdoc}
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(BaseProduct $product = null)
    {
        $this->product = $product;

        return $this;
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
    public function addOption(OptionValueInterface $option)
    {
        if (!$this->hasOption($option)) {
            $this->options->add($option);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeOption(OptionValueInterface $option)
    {
        if ($this->hasOption($option)) {
            $this->options->removeElement($option);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption(OptionValueInterface $option)
    {
        return $this->options->contains($option);
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        return new \DateTime('now') >= $this->availableOn;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableOn()
    {
        return $this->availableOn;
    }

    /**
     * {@inheritdoc}
     */
    public function setAvailableOn(\DateTime $availableOn)
    {
        $this->availableOn = $availableOn;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaults(VariantInterface $masterVariant)
    {
        if (!$masterVariant->isMaster()) {
            throw new \InvalidArgumentException('Cannot inherit values from non master variant.');
        }

        if ($this->isMaster()) {
            throw new \LogicException('Master variant cannot inherit from another master variant.');
        }

        $this->setAvailableOn($masterVariant->getAvailableOn());

        return $this;
    }
    
    public function __toString()
    {
        $string = $this->getProduct()->getName();
    
        if (!$this->getOptions()->isEmpty()) {
            $string .= '(';
    
            foreach ($this->getOptions() as $option) {
                $string .= $option->getOption()->getName(). ': '.$option->getValue().', ';
            }
    
            $string = substr($string, 0, -2).')';
        }
    
        return $string;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSku()
    {
        return $this->sku;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isDeleted()
    {
        return null !== $this->deletedAt && new \DateTime() >= $this->deletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeletedAt(\DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
