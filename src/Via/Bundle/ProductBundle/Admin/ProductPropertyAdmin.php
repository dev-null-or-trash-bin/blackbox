<?php
namespace Via\Bundle\ProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ProductPropertyAdmin extends Admin
{
    protected $baseRoutePattern = 'via-product-property';
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('property', 'sonata_type_model', array(    
            'btn_add' => false,
            'btn_delete' => false,
        ), array(            
            
        ))
        ->add('translations', 'a2lix_translations_gedmo', array(
            'translatable_class' => 'Via\Bundle\ProductBundle\Entity\ProductProperty',
            'by_reference' => false,
            'locales' => array(
                'de',
                'en'
            ),            
        ))
        ;
    }
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('property', null, array('label' => 'via.form.label.product_property.property'))
        ->add('value', null, array('label' => 'via.form.label.product_property.value'))
        ;
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->add('presentation', null, array('label' => 'via.form.label.product_property.presentation'))
        ->add('value', null, array('label' => 'via.form.label.product_property.value'))
        ->add('product', null, array('label' => 'via.form.label.product_property.product'))
        ->add('_action', 'actions', array(
            'actions' => array(
                'view' => array(),
                'edit' => array(),
                #'new' => array(),
            ),
            'label' => 'via.form.label.custom_action'
        ))
        ;
    }
}