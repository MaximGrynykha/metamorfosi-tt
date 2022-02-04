<?php

namespace App\Internal;

use App\Exceptions\Http\InvalidStatusCodeException;

class Response
{
    /**
     * @param int $code 
     * 
     * @return void 
     */
    public function setStatusCode(int $code): void
    {
        http_response_code(
            $this->isValidStatusCode($code) 
                ? $code 
                : throw new InvalidStatusCodeException(code: $code)
        );
    }

    /**
     * @param string $uri 
     * 
     * @return never 
     */
    public function redirect(string $uri, int $code = 302): never
    {
        $this->setStatusCode($code);
        header('Location: '.$uri);
        exit();
    }

    /**
     * @param int $code 
     * 
     * @return bool 
     */
    protected function isValidStatusCode(int $code): bool
    {
        return (! ($code <= 100 || $code >= 600));
    }
}