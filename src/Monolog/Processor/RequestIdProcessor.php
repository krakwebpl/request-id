<?php
/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 26.04.17
 * Time: 14:06
 */

namespace Krakweb\RequestId\Monolog\Processor;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestIdProcessor
{
    const HEADER_NAME = 'X-Request-Id';
    private $requestId = '';


    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $this->requestId = $request->get(self::HEADER_NAME, null);
    }

    public function __invoke(array $record)
    {
        if ($this->requestId) {
            $record['extra']['request_id'] = $this->requestId;
        }

        return $record;
    }
}