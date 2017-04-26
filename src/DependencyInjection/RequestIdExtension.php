<?php
/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 26.04.17
 * Time: 14:50
 */

namespace Krakweb\RequestId\DependencyInjection;


use Krakweb\RequestId\Monolog\Processor\RequestIdProcessor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class RequestIdExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        
        $loader->load('services.yml');
        
        $this->addClassesToCompile(array(
            RequestIdProcessor::class
        ));
    }

}