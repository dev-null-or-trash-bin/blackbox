<?php
namespace Via\Bundle\VariableProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class OptionValueAdmin extends Admin
{
    protected $baseRoutePattern = 'via-option-value';
    
    // disable edit in variation list
    protected function configureRoutes(RouteCollection $collection)
    {
        // to remove a single route
        $collection->remove('delete');
        // OR remove all route except named ones
        #$collection->clearExcept(array('list', 'show'));
    }
    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('via.tab.label.product',array(
            
        ))
        ->add('value', 'text', array(
            'label' => 'via.option_value.form.value',
        ))
        ;
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id', null, array(
            'label' => 'via.form.label.product.id'
        ))
        
        
        // add custom action links
        ->add('_action', 'actions', array(
            'actions' => array(
                'show' => array(),
                'edit' => array(),
            ),
        ))
        ;
    }
}