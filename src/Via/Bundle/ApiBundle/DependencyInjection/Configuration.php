<?php

namespace Via\Bundle\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Via\Bundle\ApiBundle\ViaApiBundle;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('via_api');
        
        $rootNode
        ->children()

            ->arrayNode('headers')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('Accept')->defaultValue('application/json')->end()
                ->end()
            ->end()
            
            ->arrayNode('sandbox')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('base_url')->defaultValue('http://sandbox.api.via.de')->end()
                    ->scalarNode('login_path')->defaultValue('/Authentication_JSON_AppService.axd/Login')->end()
                    ->scalarNode('call_path')->defaultValue('/publicapi/v1/api.svc/')->end()
                    ->scalarNode('service_description')->defaultValue(__DIR__ . '/../Resources/config/Blackbox/V1/webservice.json')->end()
                ->end()
            ->end()
            
            ->arrayNode('plugin')
                ->addDefaultsIfNotSet()
            ->end()
            
        ->end();
        

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
