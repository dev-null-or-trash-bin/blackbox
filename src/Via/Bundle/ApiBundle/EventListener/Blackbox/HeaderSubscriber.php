<?php
namespace Via\Bundle\ApiBundle\EventListener\Blackbox;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Collections\ArrayCollection;

class HeaderSubscriber implements EventSubscriberInterface
{
    /**
     *
     * @var array $headers
     */
    private $headers;

    /**
     *
     * @param array $headers
     */
    public function __construct(array $headers)
    {
        $this->headers = new ArrayCollection();
        $this->setHeaders($headers);
    }

    /**
     *
     * @return multitype:array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     *
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        foreach($headers as $header => $value)
        {
            if (!$this->hasHeader($header)) {
                $this->setHeader($header, $value);
            }
        }
    }

    /**
     *
     * @param string $header
     * @param string $value
     */
    public function setHeader($header, $value)
    {
        $this->headers->set($header, $value);
    }
    
    /**
     *
     * @param string $header
     */
    public function hasHeader($header)
    {
        return $this->headers->contains($header);
    }
    
    /**
     *
     * @param Event $event
     */
    public function onRequestCreate(Event $event)
    {
        $request = $event['request'];
        
        // make sure to keep headers that have been already set
        foreach ($this->headers as $key => $value)
        {
            $request->addHeader($key, $value);
        }
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