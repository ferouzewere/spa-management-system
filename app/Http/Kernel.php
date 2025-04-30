<?php

namespace App\Http;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // ...existing middleware...
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
