<?php

namespace App\Internal;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    /** 
     * @return void
    */
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[static::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }

        $_SESSION[static::FLASH_KEY] = $flashMessages;
    }

    /**
     * @param string $key 
     * @return bool 
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key 
     * @return bool 
     */
    public function hasFlash(string $key): bool
    {
        return isset($_SESSION[static::FLASH_KEY][$key]);
    }

    /**
     * @param string $key 
     * @param mixed $value 
     * @return void 
     */
    public function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key 
     * @param mixed $message 
     * 
     * @return void 
     */
    public function setFlash(string $key, mixed $message): void
    {
        $_SESSION[static::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message,
        ];
    }

    /**
     * @param string $key 
     * @return mixed 
     */
    public function get(string $key)
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * @param string $key 
     * 
     * @return mixed 
     */
    public function getFlash(string $key): mixed
    {
        return $_SESSION[static::FLASH_KEY][$key]['value'] ?? false;
    }

    /**
     * @param string $key 
     * 
     * @return void 
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * @return void
    */
    public function __destruct()
    {
        $flashMessages = $_SESSION[static::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[static::FLASH_KEY] = $flashMessages;
        // session_destroy();
    }
}