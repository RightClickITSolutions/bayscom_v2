<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/customer/delete/inst-delete',
        '/customer/edit/inst-edit/',
        '/station/delete/inst-delete/',
        '/lubebay/delete/inst-delete/',
        '/pro/reverse_pro/delete/inst-delete/',
    ];
}
