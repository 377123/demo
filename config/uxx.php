<?php

return [

    'bootstrap' => app_path('Uxx/bootstrap.php'),
 
    'route' => [

        'prefix' => env('ADMIN_ROUTE_PREFIX', 'uxx'),

        'namespace' => 'App\\Uxx\\Controllers',

        'middleware' => ['web', 'admin'],
    ],
 
    'directory' => app_path('Uxx'),
    'title' => 'Uxx',
    'https' => env('ADMIN_HTTPS', false),
 
    'extensions' => [

    ],
];
