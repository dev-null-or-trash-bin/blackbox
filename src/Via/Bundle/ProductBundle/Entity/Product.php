<?php
namespace Via\Bundle\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\MappedSuperclass
 * @ORM\MappedSuperclass(repositoryClass="Via\Bundle\ProductBundle\Repository\ProductRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\TranslationEntity(class="Via\Bundle\ProductBundle\Entity\ProductTranslation")
 */
class Product implements ProductInterface, Translatable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;
    
    /**
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $description;
    
    /**
     * short description
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text", length=250, nullable=true)
     */
    protected $shortDescription;
        
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
     * @var integer
     *
     * @ORM\Column(name="stock_amount", type="integer", nullable=false)
     */
    private $stockAmount;
    
    /**
     * @var string
     *
     * @ORM\Column(name="vat_percent", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $vatPercent = '19.00';
    
    /**
     * @var ProductPropertyInterface[] \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Via\Bundle\ProductBundle\Entity\ProductProperty", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
     */
    protected $properties;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }
    
    public function __toString()
    {
        return ($this->getName()) ? : '';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->getPrice();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPrice($price)
    {
        $this->setPrice($price);
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return $this->getImages();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return $this->getImages()->first();
    }
}
