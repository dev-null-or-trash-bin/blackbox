<?php
namespace Via\Bundle\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="property")
 * @ORM\Entity(repositoryClass="Via\Bundle\ProductBundle\Repository\PropertyRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\TranslationEntity(class="Via\Bundle\ProductBundle\Entity\PropertyTranslation")
 */
class Property implements PropertyInterface, Translatable
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;
    
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="presentation", type="string", length=255, nullable=false)
     */
    protected $presentation;
    
    /**
     * Type.
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    protected $type;
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;
    
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
     */
    protected $deletedAt;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Via\Bundle\ProductBundle\Entity\ProductProperty", mappedBy="property")
     */
    protected $products;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
	
}