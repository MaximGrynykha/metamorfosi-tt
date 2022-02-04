<?php

use App\Http\Controllers as Controllers;
use App\Http\Middlewares as Middlewares;

return [
    '"GET~/login"' => [
        'handler' => [Controllers\AuthController::class, 'index'], 
    ],

    '"POST~/login"' => [
        'handler' => [Controllers\AuthController::class, 'store'],
    ],

    '"POST~/logout"' => [
        'handler' => [Controllers\AuthController::class, 'destroy'],
    ]
];