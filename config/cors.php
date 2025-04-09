<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

   /* 'paths' => ['api/*','storage/*','*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
    'same_site' => 'None',
    'secure' => env('SESSION_SECURE_COOKIE', true),*/

//    'paths' => ['api/*', 'sanctum/csrf-cookie', 'section-logo', 'partner-logo', 'storage/*'],
//    'allowed_methods' => ['*'],
//    'allowed_origins' => ['http://localhost:3000'],
//    'allowed_origins_patterns' => [],
//    'allowed_headers' => ['*'],
//    'exposed_headers' => [],
//    'max_age' => 0,
//    'supports_credentials' => true,

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'partner-logo','section-logo','team-members','google-review','our-service' ,'blog-post','storage/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Change to allow all origins temporarily
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => ['Content-Disposition'],
    'max_age' => 0,
    'supports_credentials' => false, // Try setting this to false if not using cookies

];
