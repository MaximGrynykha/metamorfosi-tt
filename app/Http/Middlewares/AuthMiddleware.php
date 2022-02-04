<?php

namespace App\Http\Middlewares;

use App\Exceptions\Http\ForbiddenException;
use App\Internal\Middleware;
use App\Internal\Request;

class AuthMiddleware extends Middleware
{
    /** 
     * @param Request $request
     * 
     * @return void
    */
    public function execute(Request $request): void
    {
        if (app()->isGuest()) {
            throw new ForbiddenException(
                message: 'Use don\'t have permission to access this page',
                code: 403
            );
        }
    }
}