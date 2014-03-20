<?php
namespace Via\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Util\Debug;
use Via\Bundle\ApiBundle\Common\Exception\AuthentificationException;
use Sonata\AdminBundle\Controller\CRUDController;

class BlackboxController extends Controller
{
    public function indexAction()
    {
        $errorMessage = null;
        
        $rep = $this->getRepository('product');
        $products = $rep->findAll();
        
        if (true === $this->getAuthentification())
        {
            $user= $this->get('security.context')->getToken()->getUser();
            $subscriptionToken = $user->getViaebaySubscriptionToken();
            
            $client = $this->getClient();
            
            $client->setDefaultOption('headers', array('SubscriptionToken' => $subscriptionToken));
            $command = $client->getCommand('GetProducts', array());
            $responseModel = $client->execute($command);
        } else {
            $errorMessage = 'Authenfication not successfully!';
        }
        Debug::dump($responseModel, 6);
        
        return $this->render('ViaApiBundle:Blackbox:index.html.twig', array('errorMessage' => $errorMessage));
    }
    
    private function getRepository($entity)
    {
        $service = sprintf('via.repository.%s', $entity);
        return $this->get($service);
    }
    
    protected function getClient()
    {
        return $this->get('via.blackbox.client');
    }
    
    protected function getAuthentification()
    {
        $user= $this->get('security.context')->getToken()->getUser();
        $username = $user->getViaebayUsername();
        $password = $user->getViaebayPassword();
        
        $client = $this->getClient();
        
        $command = $client->getCommand('PostAuthentication', array('userName' => 'blabla', 'password' => $password));
        $responseModel = $client->execute($command);
        
        if (false === $responseModel->get('d'))
        {
            return false;
        }
        
        return true;
    }
}
