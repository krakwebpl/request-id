<?php

/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 27.04.17
 * Time: 09:07
 */

namespace Krakweb\RequestId;

use Symfony\Component\HttpFoundation\RequestStack;

class RequestId
{
    const HEADER_NAME = 'X-Request-Id';
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function get()
    {
        return $this->request->headers->get(self::HEADER_NAME, false);
    }
}