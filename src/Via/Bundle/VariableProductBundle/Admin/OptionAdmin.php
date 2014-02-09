<?php
namespace Via\Bundle\VariableProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OptionAdmin extends Admin
{
    protected $baseRoutePattern = 'via-option';
    
    // protected $translationDomain = 'messages'; // default is 'messages'
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {   
        $formMapper->with('via.tab.label.option',array(
            
        ))
        ->add('name', 'text', array(
            'label' => 'via.option.form.name',
        ))
        
        ->add('presentation', 'text', array(
            'label' => 'via.option.form.presentation',
        ))
        
        ->add('values', 'sonata_type_collection', array(
            #'type'         => 'via_option_value',
            #'required' => false,
            'by_reference' => false,
            #'label' => 'via.option.label.values',
            #'type_options' => array(
                #'btn_add' => true
            #)
        ), array(
            'edit' => 'inline',
            'inline' => 'table',
            #'allow_add' => false,
            #'allow_delete' => true,
        ))        
        ;
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
        ->addIdentifier('name', null, array(
            'label' => 'via.form.label.product.name'
        ))
        
        ->add('values', 'sonata_type_collection', array(
            'label' => 'via.form.label.product.name'
        ))
        
        ->add('createdAt', null, array(
            'label' => 'via.form.label.product.created_at'
        ))
        
        ->add('updatedAt', null, array(
            'label' => 'via.form.label.product.updated_at'
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