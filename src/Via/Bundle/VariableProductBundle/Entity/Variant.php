<?php
namespace Via\Bundle\VariableProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="variant")
 * @ORM\Entity(repositoryClass="Via\Bundle\VariableProductBundle\Repository\VariantRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
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
     * @var Boolean
     *
     * @ORM\Column(name="is_master", type="boolean")
     */
    protected $master;
    
    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Via\Bundle\CoreBundle\Entity\Product", inversedBy="variants")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;
    
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
     * Constructor.
     */
    public function __construct()
    {
        $this->master = false;
        #$this->options = new ArrayCollection();
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
    public function getProduct()
    {
        return $this->product;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProduct(VariableProductInterface $product = null)
    {
        $this->product = $product;
    
        return $this;
    }
}