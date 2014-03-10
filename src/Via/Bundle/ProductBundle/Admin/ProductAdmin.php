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
use Sonata\AdminBundle\Validator\ErrorElement;

class ProductAdmin extends Admin
{
    protected $formOptions = array(
        'cascade_validation' => true
    );
    
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->baseRouteName = 'admin_sonata_product_product';
        $this->baseRoutePattern = '/sonata/product/product';
    }
    
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
        
        ))
        ->add('name', 'text', array(
            'label' => 'via.form.product.name',
            'required' => true,
        ))
        
        ->add('description', 'sonata_formatter_type', array(
            'label'                => false,
            'source_field'         => 'rawDescription',
            'source_field_options' => array('attr' => array('class' => 'span10', 'rows' => 20)),
            'format_field'         => 'descriptionFormatter',
            'target_field'         => 'description',
            'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher()
        ))
        
        ->add('shortDescription', null, array(
            'label' => 'via.form.product.short_description',
        ))
        
        ->add('sku', 'text', array(
            'label' => 'via.form.product.sku',
            
        ))->add('price', 'money', array(
            'label' => 'via.form.product.price',
            'currency' => 'EUR',
            'attr' => array(
        	   'class' => 'span5',
            ),
            'help'  =>  'via.help.',
            
        ))->end();

        // Properties
        $formMapper->with('via.tab.properties', array(
            
        ))->add('properties', 'sonata_type_collection', array(
            'required' => true,
            'by_reference' => false,
            'label' => 'via.form.product.properties',
            'cascade_validation' => true,

        ), array(
            'edit' => 'inline',
            'inline' => 'table',
            
        ))->end()
        ;
        
        // Options
        if ($product->getVariants()->isEmpty()) {
            
            $formMapper->with('via.tab.options', array(
                'description' => 'via.form.product.help.options'
                
            ))->add('options', 'sonata_type_model', array(
                'label' => false,
                'by_reference' => false,
                'expanded' => true,
                'multiple' => true,
            ))->end()
            ;
        }
        
        // carparts
//         $formMapper->with('via.tab.carparts', array(
        
//         ))->add('carparts', 'sonata_type_collection', array(
//             'required' => false,
//             'by_reference' => false,
//             'label' => 'via.form.product.properties',
        
//         ), array(
//             'edit' => 'inline',
//             'inline' => 'table',
        
//         ))->end()
//         ;
    }

    
    /**
     * Kinda Hackish methods to fix potential bug with SonataAdminBundle.
     * I have not
     * confirmed this is necessary but I've seen this implemented more than once.
     */
    public function prePersist($product)
    {
        $product->setProperties($product->getProperties());
    }
    
    public function preUpdate($product)
    {
        $product->setProperties($product->getProperties());
    }
    
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && in_array($action, array('list'))) {
            return;
        }
        
        $admin = $this->isChild() ? $this->getParent() : $this;
        $product = $admin->getSubject();
        $id = $admin->getRequest()->get('id');
        
        $root = $menu->getRoot();
        
        $menu->addChild('Menu', array(
            'attributes' => array('class' => 'nav-header'),
        	'extras' => array(
                'safe_label' => true
            )
        ));
        
        if (!in_array($action, array('create'))) {
        
            $menu->addChild(
                'Product',
                array(
                    'uri' => $admin->generateUrl('edit', array('id' => $id))
                )
            );
            //
            if ($product->getVariants()->isEmpty() && $product->hasOptions()) {
            
                $menu->addChild(
                    'Generate Variants',
                    array(
                        'uri' => $admin->generateUrl('generate', array('id' => $id)),
                    )
                );
            }
           
            $menu->addChild(
                'Variants',
                array(
                    'uri' => $admin->generateUrl('via.sonata.admin.variant.list', array('id' => $id))
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
        
        ->add('hasVariants', 'boolean', array(
            'label' => 'via.form.product.hasVariations'
        ))
        
        ->add('hasCarparts', 'boolean', array(
            'label' => 'via.form.product.hasCarparts'
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