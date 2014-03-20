<?php
namespace Via\Bundle\ApiBundle\EventListener\Blackbox;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;

class AuthSubscriber implements EventSubscriberInterface
{
    /**
     *
     * @var string
     */
    private $username;
    
    /**
     *
     * @var string
     */
    private $password;
    
    /**
     *
     * @var string
     */
    private $subscriptionToken;
    
    /**
     *
     * @param Event $event
     */
    public function onRequestCreate(Event $event)
    {
        
        $request = $event['request'];
        $client = $event['client'];
        #Debug::dump($request->getClient(), 6);
//         $client->setBody(
            
//                 array(
//                     'userName' => '',
//                     'password' => '',
//                     'createPersistentCookie' => false
//                 )
            
//         );
    }
    
    /**
     *
     * @return multitype:string
     */
    public static function getSubscribedEvents()
    {
        return array(
            'client.create_request' => 'onRequestCreate'
        );
    }
}