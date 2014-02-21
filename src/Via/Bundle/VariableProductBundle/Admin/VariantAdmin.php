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
    
    protected function configureFormFields(FormMapper $formMapper)
    {

    }
    
    public function createQuery($context = 'list')
    {
        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');
        
        $query = parent::createQuery($context);
                
        if ($this->isChild())
        {
            $query->andWhere(
                $query->expr()->eq($query->getRootAlias().'.product',':product')
            );
            
            $query->setParameter('product', $id);
        }
        
        $query->andWhere(
            $query->expr()->eq($query->getRootAlias().'.master',':isMaster')
        );
        
        $query->setParameter('isMaster', false);
        
        return $query;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        // to remove a single route
        $collection->remove('delete');
        // OR remove all route except named ones
        $collection->clearExcept(array('list', 'show', 'edit'));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id', null, array(
            'label' => 'via.form.variant.id'
        ))

        ->addIdentifier('product.name', null, array(
            'label' => 'via.form.variant.product_name'
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