<?php

namespace Via\Bundle\ApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Doctrine\Common\Util\Debug;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ViaApiExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        if($config['headers'])
        {
            $this->setUpHeaders($config['headers'], $container);
        }
        
        $this->setUpAuth($container);
        $this->setServiceDescription($config, $container);
        $this->setBaseUrl($config, $container);
    }
    
    protected function setUpHeaders(array $headers, ContainerBuilder $container)
    {
        $container->setParameter('via.blackbox.plugin.header.headers', $headers);
        $container->getDefinition('via.blackbox.client')
        ->addMethodCall('getEventDispatcher')
        ->addMethodCall('addSubscriber', array($container->getDefinition('via.blackbox.plugin.header')));
    }

    protected function setUpAuth(ContainerBuilder $container)
    {
        $container->getDefinition('via.blackbox.client')
        ->addMethodCall('getEventDispatcher')
        ->addMethodCall('addSubscriber', array($container->getDefinition('via.blackbox.plugin.auth')));
    }
    
    protected function setServiceDescription(array $config, ContainerBuilder $container)
    {
        if (isset($config['sandbox']['service_description']))
        {
            $container->setParameter('via.blackbox.client.service_description.file', $config['sandbox']['service_description']);
        }
    }
    
    protected function setBaseUrl(array $config, ContainerBuilder $container)
    {
        if (isset($config['sandbox']['base_url']))
        {
            $container->setParameter('via.blackbox.client.base_url', $config['sandbox']['base_url']);
        }
    }
}
