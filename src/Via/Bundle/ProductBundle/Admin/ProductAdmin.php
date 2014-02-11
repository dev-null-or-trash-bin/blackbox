<?php
namespace Via\Bundle\ProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\Common\Util\Debug;
use Sonata\AdminBundle\Route\RouteCollection;

use Knp\Menu\ItemInterface as MenuItemInterface;

class ProductAdmin extends Admin
{
    protected $baseRoutePattern = 'via-product';
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('generateAction');
        $collection->add('generate', $this->getRouterIdParameter().'/generate');
    }
    
    // protected $translationDomain = 'messages'; // default is 'messages'
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $product = $formMapper->getAdmin()->getSubject();
                
        // General
        $formMapper->with('via.tab.general', array(
            'description' => 'This section contains general settings for the web page',
        
        ))->add('sku', 'text', array(
            'label' => 'via.form.product.sku',
            
        ))->add('price', 'money', array(
            'label' => 'via.form.product.price',
            'attr' => array(
        	   'class' => 'span5',
            ),
            'help'  =>  'Set the title of a web page',
            
        ))
//         ->add('translations', 'a2lix_translations_gedmo', array(
//             'translatable_class' => 'Via\Bundle\ProductBundle\Entity\Product',
//             'by_reference' => false,
//             'locales' => array(
//                 'de',
//                 'en'
//             ),
//         ))->end()
        ;
        // Properties
//         $formMapper->with('via.tab.properties', array(
            
//         ))->add('properties', 'sonata_type_collection', array(
//             'required' => false,
//             'by_reference' => false,
//             'label' => 'via.form.product.properties',
//         ), array(
//             'edit' => 'inline',
//             'inline' => 'table',
            
//         ))->end()
//         ;
        
//         $optionTab = $formMapper->with('via.tab.options', array('description' => 'foo_bar'));
        
//         // Options
//         if ($product->getVariants()->isEmpty()) {
        
//             $optionTab->setHelps(array('via.tab.options' => 'bar_foo'));
            
//             $optionTab->add('options', 'via_option_choice', array(
//                 'label' => false,
//                 'by_reference' => false,
//                 'expanded' => true,
//                 'multiple' => true,
//             ))->end()
//             ;
//         }
    }
    
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }
        
        $admin = $this->isChild() ? $this->getParent() : $this;
                $product = $admin->getSubject();
        
        $id = $admin->getRequest()->get('id');
        
        if ($product->getVariants()->isEmpty()) {
        
            $menu->addChild(
                'Generate Variant',
                array(
                    'uri' => $admin->generateUrl('generate', array('id' => $id))
                )
            );
        }
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id', null, array(
            'label' => 'via.form.product.id'
            
        ))->addIdentifier('name', null, array(
            'label' => 'via.form.product.name'
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