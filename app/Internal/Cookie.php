<?php

namespace App\Internal;

class Cookie
{

    protected string $path = '/';
    protected string $domain;
    protected ?bool $secure;
    protected $sameSite = 'lax';


    /**
     * @param string $key 
     * @param mixed $value 
     * 
     * @return void 
     */
    public function set(string $key, mixed $value, int $forever = 2^31-1): void
    {
        $_COOKIE[$key] = $value;
    }

    /**
     * @param string $key 
     * 
     * @return mixed 
     */
    public function get(string $key): mixed
    {
        return $_COOKIE[$key] ?? null;
    }

    /**
     * @param string $key 
     * 
     * @return void 
     */
    public function remove(string $key): void
    {
        setcookie($key, '', time() - 1);
        unset($_COOKIE[$key]);
    }
}