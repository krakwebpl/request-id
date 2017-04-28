<?php
/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 26.04.17
 * Time: 15:56
 */

namespace Krakweb\RequestId\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder();
        $rootNode = $tree->root('request_id');
        $rootNode
            ->children()
                ->booleanNode('enable')
                ->defaultTrue()
                ->end()
                ->booleanNode('enable_response')
                ->defaultTrue()
                ->end()
            ->end();

        return $tree;
    }

}