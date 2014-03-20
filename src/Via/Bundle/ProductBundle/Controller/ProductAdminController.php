<?php
namespace Via\Bundle\ProductBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductAdminController extends CRUDController
{
    public function batchActionSendToBlackbox ()
    {
        if ($data = json_decode($this->get('request')->get('data'), true)) {
            $action       = $data['action'];
            $idx          = $data['idx'];
            $all_elements = $data['all_elements'];
            $this->get('request')->request->replace($data);
        } else {
            $this->get('request')->request->set('idx', $this->get('request')->get('idx', array()));
            $this->get('request')->request->set('all_elements', $this->get('request')->get('all_elements', false));
        
            $action       = $this->get('request')->get('action');
            $idx          = $this->get('request')->get('idx');
            $all_elements = $this->get('request')->get('all_elements');
            $data         = $this->get('request')->request->all();
        
            unset($data['_sonata_csrf_token']);
        }
        Debug::dump($data, 6);
	}
	
	public function sendToBlackboxAction ($id)
	{
	    // the key used to lookup the template
	    $templateKey = 'list';
	    
	    $rep = $this->getRepository('product');
	    $product = $rep->findById($id);
	    
	    if (true === $this->getAuthentification())
	    {
	        $client = $this->get('via.blackbox.client');
	        
	        $user= $this->get('security.context')->getToken()->getUser();
	        $subscriptionToken = $user->getViaebaySubscriptionToken();
	        
	        $client->setDefaultOption('headers', array('SubscriptionToken' => $subscriptionToken));
	        $command = $client->getCommand('GetProducts', array());
	        $responseModel = $client->execute($command);
	    }
	    #return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())), '');
	    
	    return $this->render($this->admin->getTemplate($templateKey), array(
	        'action' => 'list',
	        'object' => $responseModel,
	        'csrf_token' => $this->getCsrfToken('sonata.batch'),
	    ));
	}
	
	private function getRepository($entity)
	{
	    $service = sprintf('via.repository.%s', $entity);
	    return $this->get($service);
	}
	
	private function getAuthentification()
	{
	    $user= $this->get('security.context')->getToken()->getUser();
	    $username = $user->getViaebayUsername();
	    $password = $user->getViaebayPassword();
	
	    $client = $this->get('via.blackbox.client');
	
	    $command = $client->getCommand('PostAuthentication', array('userName' => $username, 'password' => $password));
	    $responseModel = $client->execute($command);
	
	    if (false === $responseModel->get('d'))
	    {
	        return false;
	    }
	
	    return true;
	}
}