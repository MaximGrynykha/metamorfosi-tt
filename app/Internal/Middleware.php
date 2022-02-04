<?php

namespace App\Internal;

abstract class Middleware
{
    /** 
     * @return void
    */
    abstract public function execute(Request $request): void;
}