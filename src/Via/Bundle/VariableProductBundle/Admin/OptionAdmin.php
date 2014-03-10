<?php
namespace Via\Bundle\VariableProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OptionAdmin extends Admin
{
    protected $formOptions = array(
        'cascade_validation' => true
    );
    
    // protected $translationDomain = 'messages'; // default is 'messages'
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('via.tab.option',array(
            
        ))
        ->add('name', 'text', array(
            'label' => 'via.form.option.name',
            'required' => true
        ))
        
        ->add('presentation', 'text', array(
            'label' => 'via.form.option.presentation',
        ))
        
        ->add('values', 'sonata_type_collection', array(
            'by_reference' => false,
            'required' => true,
            'label' => 'via.form.option.values',
        ), array(
            'edit' => 'inline',
            'inline' => 'table',
            
        ))->end()
        ;
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id', null, array(
            'label' => 'via.form.option.id'
        ))
        ->addIdentifier('name', null, array(
            'label' => 'via.form.option.name'
        ))
        
        ->add('values', 'sonata_type_collection', array(
            'label' => 'via.form.option.name',
        ))
        
        ->add('createdAt', null, array(
            'label' => 'via.form.option.created_at'
        ))
        
        ->add('updatedAt', null, array(
            'label' => 'via.form.option.updated_at'
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