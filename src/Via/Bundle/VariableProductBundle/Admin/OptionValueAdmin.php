<?php
namespace Via\Bundle\VariableProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OptionValueAdmin extends Admin
{
    protected $baseRoutePattern = 'via-option-value';
    
    // protected $translationDomain = 'messages'; // default is 'messages'
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

    /**
     * Kinda Hackish methods to fix potential bug with SonataAdminBundle.
     * I have not
     * confirmed this is necessary but I've seen this implemented more than once.
     */
    public function prePersist($product)
    {
        #$product->setProperties($product->getProperties());
    }

    public function preUpdate($product)
    {
        #$product->setProperties($product->getProperties());
    }
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        /* $datagridMapper->add('getSku', null, array(
            'label' => 'via.form.label.product.articleNumber'
        ))
        ; */
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