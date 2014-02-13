<?php
namespace Via\Bundle\VariableProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class VariantAdmin extends Admin
{
    #protected $baseRoutePattern = 'via-variant';
    
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        #$this->baseRouteName = 'sonata_admin_product_variations';
        #$this->baseRoutePattern = 'variant';
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {

    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        // to remove a single route
        $collection->remove('delete');
        // OR remove all route except named ones
        $collection->clearExcept(array('list', 'show'));
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
            'label' => 'via.form.variant.id'
        ))
        ->add('presentation', null, array(
            'label' => 'via.form.variant.presentation'
        ))
        
        ->add('sku', null, array(
            'label' => 'via.form.variant.sku'
        ))
        
        ->add('price', 'currency', array(
            'label' => 'via.form.variant.price',
            'currency' => 'EUR',
            'locale' => 'de',
        ))
        
        ->add('options', 'sonata_type_collection', array(
            'label' => 'via.form.variant.options'
        ))
        ;
    }
}