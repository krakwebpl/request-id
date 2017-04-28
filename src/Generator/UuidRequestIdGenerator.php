<?php
/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 28.04.17
 * Time: 09:01
 */

namespace Krakweb\RequestId\Generator;


use Ramsey\Uuid\Uuid;

class UuidRequestIdGenerator implements RequestIdGenerator
{
    
    public function generate()
    {
        $uuid = Uuid::uuid1();
        return $uuid->toString();
    }

}