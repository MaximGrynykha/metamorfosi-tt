<?php

return [
    'name' => getenv('APP_NAME') ?: 'Test Blog',
    'timezone' => getenv('APP_TIMEZONE') ?: 'UTC',
    'locale' => getenv('APP_LOCALE') ?: 'ru_RU.utf8',
    'url' => getenv('APP_URL') ?: 'http://localhost'
];