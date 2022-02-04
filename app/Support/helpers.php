<?php

use App\Internal\Application;
use Path2\Path;

if (! function_exists('path')) {
    function path(string $cwd = ''): Path
    {
        static $path;
        return $path ??= new Path($cwd ?: Application::$ROOT_DIR);
    }
}

if (! function_exists('app')) {
    function app(): Application
    {
        return Application::$app;
    }
}