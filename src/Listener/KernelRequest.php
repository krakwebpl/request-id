<?php
/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 28.04.17
 * Time: 08:50
 */

namespace Krakweb\RequestId\Listener;


use Krakweb\RequestId\Generator\RequestIdGenerator;
use Krakweb\RequestId\RequestId;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class KernelRequest
{
    private $generator;

    public function __construct(RequestIdGenerator $generator)
    {
        $this->generator = $generator;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (! $request->headers->has(RequestId::HEADER_NAME)) {
            $request->headers->set(RequestId::HEADER_NAME, $this->generator->generate());
        }
    }
}