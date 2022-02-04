<?php

use App\Http\Controllers as Controllers;
use App\Http\Middlewares as Middlewares;

return [
    '"GET~/login"' => [ # COMPLETE
        'handler' => [Controllers\AuthController::class, 'index'], 
    ],

    '"POST~/login"' => [
        'handler' => [Controllers\AuthController::class, 'store'],
    ],

    '"POST~/logout"' => [ # TODO
        'handler' => [Controllers\AuthController::class, 'destroy'],
    ]
];