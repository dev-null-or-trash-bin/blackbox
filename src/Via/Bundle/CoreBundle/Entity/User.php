<?php
namespace Via\Bundle\CoreBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as Orm;

/**
 * @ORM\Entity
 * @ORM\Table(name="via_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(name="viaebay_username", type="string", length=80, nullable=true)
     */
    protected $viaEbayUsername;
    
    /**
     * @ORM\Column(name="viaebay_password", type="string", length=80, nullable=true)
     */
    protected $viaEbayPassword;
    
    /**
     * @ORM\Column(name="viaebay_subscriptiontoken", type="string", length=80, nullable=true)
     */
    protected $viaEbaySubscriptionToken;
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     *
     * @return the unknown_type
     */
    public function getViaEbayUsername()
    {
        return $this->viaEbayUsername;
    }

    /**
     *
     * @param unknown_type $viaEbayUsername
     */
    public function setViaEbayUsername($viaEbayUsername)
    {
        $this->viaEbayUsername = $viaEbayUsername;
        return $this;
    }

    /**
     *
     * @return the unknown_type
     */
    public function getViaEbayPassword()
    {
        return $this->viaEbayPassword;
    }

    /**
     *
     * @param unknown_type $viaEbaypassword
     */
    public function setViaEbayPassword($viaEbaypassword)
    {
        $this->viaEbayPassword = $viaEbaypassword;
        return $this;
    }

    /**
     *
     * @return the unknown_type
     */
    public function getViaEbaySubscriptionToken()
    {
        return $this->viaEbaySubscriptionToken;
    }

    /**
     *
     * @param unknown_type $viaEbaySubscriptionToken
     */
    public function setViaEbaySubscriptionToken($viaEbaySubscriptionToken)
    {
        $this->viaEbaySubscriptionToken = $viaEbaySubscriptionToken;
        return $this;
    }
	
}