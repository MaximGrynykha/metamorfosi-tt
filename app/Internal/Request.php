<?php

namespace App\Internal;

use App\Exceptions\Http\InvalidRequestMethodException;

class Request
{
    protected array $params = [];

    /** 
     * @return string
    */
    public function getPath(): string
    {
        return (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: null;
    }

    /**
     * @param string $name 
     * 
     * @return mixed 
     */
    public function getParam(string $name): mixed
    {
        return $this->params[$name];
    }

    /**
     * @param string $name 
     * @param mixed $value 
     * 
     * @return void 
     */
    public function setParam(string $name, mixed $value): void
    {
        $this->params[$name] = $value;
    }

    /**
     * Return method of HTTP-request
     * 
     * @return HTTPMethod
    */
    public function method(): HTTPMethod
    {
        $method = (isset($_POST['_method']))
            ? HTTPMethod::tryFrom(mb_strtolower($_POST['_method']))
            : HTTPMethod::tryFrom(mb_strtolower($_SERVER['REQUEST_METHOD']));

        if (! $method) {
            throw new InvalidRequestMethodException(code: 400);
        }

        return $method;
    }

    /**
     * @return mixed
    */
    public function getBody(): mixed
    {
        $body = [];

        if ($this->method() === HTTPMethod::GET) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } elseif ($this->method() === HTTPMethod::POST || $this->method() === HTTPMethod::PUT) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        unset($body['_method']);

        return $body;
    }
}