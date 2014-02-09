<?php
namespace Via\Bundle\ProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
{
    protected $baseRoutePattern = 'via-product';
    
    // protected $translationDomain = 'messages'; // default is 'messages'
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {   
        $formMapper->with('via.tab.label.product',array(
            
        ))
        ->add('translations', 'a2lix_translations_gedmo', array(
            'translatable_class' => 'Via\Bundle\ProductBundle\Entity\Product',
            'by_reference' => false,
            'locales' => array(
                'de',
                'en'
            ),
//             'label' => 'via.form.label.product.translations',
//             'fields' => array(
//                 'name' => array(
//                     'field_type' => 'text',
//                     'label' => 'via.form.label.product.name',
//                     'required' => true
//                 ),
//                 'shortDescription' => array(
//                     'field_type' => 'text',
//                     'label' => 'via.form.label.product.short_description'
//                 ),
//                 'description' => array(
//                     'field_type' => 'textarea',
//                     'label' => 'via.form.label.product.description'
//                 )
//             )
        ))
        ;
        
        $formMapper->with('via.tab.label.properties', array(
        ))
        ->add('properties', 'sonata_type_collection', array(
            'required' => false,
            'by_reference' => false,
            'label' => 'via.tab.label.properties',
            'type_options' => array(
                #'btn_add' => true
            )
        ), array(
            'edit' => 'inline',
            'inline' => 'table',
            #'allow_add' => false,
            #'allow_delete' => true,
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