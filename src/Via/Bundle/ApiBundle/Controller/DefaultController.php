<?php

namespace Via\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ViaApiBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function apiAction()
    {
        $rep = $this->getRepository('product');
        $products = $rep->findAll();
    
        return $this->render('ViaBlackboxBundle:Default:api.html.twig');
    }
    
    private function getRepository($entity)
    {
        //$this->get('via.repository.');
        $service = sprintf('via.repository.%s', $entity);
        return $this->get($service);
    }
}
