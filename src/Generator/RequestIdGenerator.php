<?php
/**
 * Created by PhpStorm.
 * User: gmajta
 * Date: 28.04.17
 * Time: 08:56
 */

namespace Krakweb\RequestId\Generator;


interface RequestIdGenerator
{
    /**
     * @return string
     */
    public function generate();
}