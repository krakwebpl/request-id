<?php
/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 26.04.17
 * Time: 14:50
 */

namespace Krakweb\RequestId\DependencyInjection;


use Krakweb\RequestId\Monolog\Processor\RequestIdProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class RequestIdExtension extends Extension
{

    private $config = array();

    /**
     * @var ContainerBuilder
     */
    private $container;

    public function load(array $configs, ContainerBuilder $container)
    {
        $this->container = $container;

        $configuration = new Configuration();
        $this->config = $this->processConfiguration($configuration, $configs);
        $this->loadServices();
        
        $this->addClassesToCompile(array(
            RequestIdProcessor::class
        ));
    }

    private function loadServices()
    {
        if (! $this->config['enable']) {
            return;
        }

        $definition = new Definition(RequestIdProcessor::class);
        $definition->addTag('monolog.processor');
        $definition->addTag('kernel.event_listener', [
            'event' => 'kernel.request',
            'priority' => 255,
            'method' => 'onKernelRequest'
        ]);
        $this->container->setDefinition('krakweb.request_id.monolog_processor', $definition);
    }

}