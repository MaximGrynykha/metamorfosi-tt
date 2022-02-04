<?php

use Dotenv\Dotenv;
use App\Internal\Application;

require __DIR__.'/../vendor/autoload.php';

Dotenv::createUnsafeImmutable(dirname(__DIR__))->load();
(new Application(dirname(__DIR__)))->run();