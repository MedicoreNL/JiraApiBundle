<?php

namespace JiraApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This validates and merges configurations from your app/config files.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jira_api');

        $rootNode
            ->children()
                ->scalarNode('url')
                    ->isRequired()
                ->end()
                ->scalarNode('credentials')
                    ->isRequired()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
