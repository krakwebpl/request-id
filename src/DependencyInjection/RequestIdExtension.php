<?php
/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 26.04.17
 * Time: 14:50
 */

namespace Krakweb\RequestId\DependencyInjection;


use Krakweb\RequestId\Generator\UuidRequestIdGenerator;
use Krakweb\RequestId\Listener\KernelRequest;
use Krakweb\RequestId\Listener\KernelResponse;
use Krakweb\RequestId\Monolog\Processor\RequestIdProcessor;
use Krakweb\RequestId\RequestId;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
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
        $definition = new Definition(RequestId::class, [
            new Reference('request_stack')
        ]);
        $this->container->setDefinition('krakweb.request_id.getter', $definition);

        if (! $this->config['enable']) {
            return;
        }

        $definition = new Definition(UuidRequestIdGenerator::class);
        $this->container->setDefinition('krakweb.request_id.generator', $definition);

        $definition = new Definition(KernelRequest::class, [
            new Reference('krakweb.request_id.generator')
        ]);
        $definition->addTag('kernel.event_listener', [
            'event' => 'kernel.request',
            'priority' => 255,
            'method' => 'onKernelRequest'
        ]);
        $this->container->setDefinition('krakweb.request_id.listener.request', $definition);

        $definition = new Definition(RequestIdProcessor::class);
        $definition->addTag('monolog.processor');
        $definition->addTag('kernel.event_listener', [
            'event' => 'kernel.request',
            'priority' => 254,
            'method' => 'onKernelRequest'
        ]);
        $this->container->setDefinition('krakweb.request_id.monolog_processor', $definition);

        if (!$this->config['enable_response']) {
            return;
        }

        $definition = new Definition(KernelResponse::class);
        $definition->addTag('kernel.event_listener', [
            'event' => 'kernel.response',
            'method' => 'onKernelResponse'
        ]);
        $this->container->setDefinition('krakweb.request_id.listener.response', $definition);
    }

}