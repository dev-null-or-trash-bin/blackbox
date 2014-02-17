<?php
namespace Via\Bundle\CarpartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\Common\Util\Debug;
use Sonata\AdminBundle\Route\RouteCollection;

class CarpartListAdmin extends Admin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        // to remove a single route
        $collection->remove('delete');
        // OR remove all route except named ones
        $collection->clearExcept(array('list', 'show'));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('ktype', null, array(
            'label' => 'via.form.carpart_list.ktype'
        ))
        ->add('brand', null, array(
            'label' => 'via.form.carpart_list.brand'
        ))
    
        ->add('model', null, array(
            'label' => 'via.form.carpart_list.model'
        ))
    
        ->add('type', null, array(
            'label' => 'via.form.carpart_list.type'
        ))
            
        ->add('platform', null, array(
            'label' => 'via.form.carpart_list.platform'
        ))
        
        ->add('production_period', null, array(
            'label' => 'via.form.carpart_list.production_period'
        ))
        
        ->add('engine', null, array(
            'label' => 'via.form.carpart_list.engine'
        ))
        
        ->add('hsn_tsn', null, array(
            'label' => 'via.form.carpart_list.hsn_tsn'
        ))
        ;
    }
}