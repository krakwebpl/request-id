<?php
/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 28.04.17
 * Time: 08:51
 */

namespace Krakweb\RequestId\Listener;


use Krakweb\RequestId\RequestId;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class KernelResponse
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $requestId = $request->headers->get(RequestId::HEADER_NAME, false);

        if (!$requestId) {
            return;
        }

        $response = $event->getResponse();
        $response->headers->set(RequestId::HEADER_NAME, $requestId);
    }
}