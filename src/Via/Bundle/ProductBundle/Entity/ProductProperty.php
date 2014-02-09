<?php
namespace Via\Bundle\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Via\Bundle\ProductBundle\Entity\Property;
use Via\Bundle\ProductBundle\Entity\PropertyTypes;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="via_product_property")
 * @ORM\Entity(repositoryClass="Via\Bundle\ProductBundle\Repository\ProductPropertyRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\TranslationEntity(class="Via\Bundle\ProductBundle\Entity\ProductPropertyTranslation")
 *
 */
class ProductProperty implements ProductPropertyInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Via\Bundle\ProductBundle\Entity\Product", inversedBy="properties")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    protected $product;
    
    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Via\Bundle\ProductBundle\Entity\Property", inversedBy="products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    protected $property;
    
    /**
     * Property value.
     * 
     * @Gedmo\Translatable
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    protected $value;
    
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
     * @ORM\OneToMany(targetEntity="Via\Bundle\ProductBundle\Entity\ProductPropertyTranslation", mappedBy="object", cascade={"persist", "remove"})
     *
     */
    protected $translations;
    
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }
    
    public function __toString()
    {
        return ($this->getValue()) ? : '';
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
    public function getProduct()
    {
        return $this->product;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProduct(ProductInterface $product = null)
    {
        $this->product = $product;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getProperty()
    {
        return $this->property;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProperty(Property $property)
    {
        $this->property = $property;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        if ($this->property && PropertyTypes::CHECKBOX === $this->property->getType()) {
            return (boolean) $this->value;
        }
    
        return $this->value;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $this->assertPropertyIsSet();
    
        return $this->property->getName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        $this->assertPropertyIsSet();
    
        return $this->property->getPresentation();
    }
    
    public function getType()
    {
        $this->assertPropertyIsSet();
    
        return $this->property->getType();
    }
    
    public function getConfiguration()
    {
        $this->assertPropertyIsSet();
    
        return $this->property->getConfiguration();
    }
    
    /**
     * @throws \BadMethodCallException When property is not set
     */
    protected function assertPropertyIsSet()
    {
        if (null === $this->property) {
            throw new \BadMethodCallException('The property have not been created yet so you cannot access proxy methods.');
        }
    }
    
    public function getTranslations()
    {
        return $this->translations;
    }
    
    public function addTranslation(ProductPropertyTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }
    
    public function removeTranslation(ProductPropertyTranslation $translation)
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
        }
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
}