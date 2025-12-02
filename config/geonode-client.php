<?php

// config for EricAriyanto/LaravelGeoNodeClient
return [
    /* Base URL of GeoNode e.g. https://geonode.example.com */
    'base_url' => env('GEONODE_URL', 'http://localhost'),


    /* Authentication: either 'basic' or 'token' */
    'auth' => env('GEONODE_AUTH', 'basic'),


    'username' => env('GEONODE_USER', null),
    'password' => env('GEONODE_PASS', null),


    /* If using token (Bearer) */
    'token' => env('GEONODE_TOKEN', null),


    /* Optional: default timeout (seconds) */
    'timeout' => 30,


    /* Optional: default headers */
    'headers' => [
        'Accept' => 'application/json',
    ],
];
