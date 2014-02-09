<?php
namespace Via\Bundle\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Via\Bundle\CoreBundle\Entity\Product as CoreProduct;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * 
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\TranslationEntity(class="Via\Bundle\ProductBundle\Entity\ProductTranslation")
 */
class Product extends CoreProduct implements ProductInterface
{   
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=80)
     */
    protected $name;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text")
     */
    protected $description;
    
    /**
     * short description
     *
     * @Gedmo\Translatable
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
     * @ORM\OneToMany(targetEntity="Via\Bundle\ProductBundle\Entity\ProductTranslation", mappedBy="object", cascade={"persist", "remove"})
     * 
     */
    protected $translations;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Via\Bundle\ProductBundle\Entity\ProductProperty", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
     */
    protected $properties;
    
    
    public function __construct()
    {   
        $this->translations = new ArrayCollection();
    }
    
    public function getTranslations()
    {
        return $this->translations;
    }
    
    public function addTranslation(ProductTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }
    
    public function removeTranslation(ProductTranslation $translation)
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
        }
        return $this;
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
    
    public function addPropertie (ProductPropertyInterface $property)
    {
        $this->addProperty($property);
    }
    
    /**
     * {@inheritdoc}
     */
    public function addProperty(ProductPropertyInterface $property)
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
    public function removeProperty(ProductPropertyInterface $property)
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
    public function hasProperty(ProductPropertyInterface $property)
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
}
