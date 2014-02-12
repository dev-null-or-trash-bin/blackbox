<?php
namespace Via\Bundle\ProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Via\Bundle\ProductBundle\Entity\PropertyTypes;

class PropertyAdmin extends Admin
{

    protected $baseRoutePattern = 'via-property';
    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', 'text', array(
            'label' => 'via.form.property.name'
        ))
            ->add('type', 'choice', array(
            'label' => 'via.form.property.type',
            'choices' => PropertyTypes::getChoices()
        ))
            ->add('presentation', 'text', array(
            'label' => 'via.form.option.presentation'
        ));
        
        // $formMapper->with('Images');
    }
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, array(
            'label' => 'via.form.property.name'
        ))
        #->add('type', 'text', array(
        #    'label' => 'via.form.property.type'
        #))
        ;;

        ;
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->addIdentifier('name', null, array(
            'label' => 'via.form.property.name'
        ))
            ->add('type', 'text', array(
            'label' => 'via.form.property.type'
        ));
    }
}