<?php
namespace Via\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlackboxController extends Controller
{
    public function indexAction()
    {
        $rep = $this->getRepository('product');
        $products = $rep->findAll();
    
        return $this->render('ViaApiBundle:Blackbox:index.html.twig');
    }
    
    private function getRepository($entity)
    {
        //$this->get('via.repository.');
        $service = sprintf('via.repository.%s', $entity);
        return $this->get($service);
    }
}