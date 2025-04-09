<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'section-logo',
        'partner-logo',
        'api/section-logo',
        'api/partner-logo',
    ];
}
