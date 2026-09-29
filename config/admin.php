<?php

return [
    'bootstrap' => [
        'name' => env('INITIAL_ADMIN_NAME'),
        'email' => env('INITIAL_ADMIN_EMAIL'),
        'password' => env('INITIAL_ADMIN_PASSWORD'),
    ],

    'staff_bootstrap' => [
        'role' => env('INITIAL_STAFF_ROLE'),
        'name' => env('INITIAL_STAFF_NAME'),
        'email' => env('INITIAL_STAFF_EMAIL'),
        'password' => env('INITIAL_STAFF_PASSWORD'),
    ],
];