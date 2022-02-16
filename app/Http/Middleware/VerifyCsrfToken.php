<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/wsmeguedelectronico/wsstore',
        '/user/wsclientestatus',
        '/user/wsclienteplazo',
        '/user/procesousuarioempresa',
        '/user/procesousuarionormal',
        '/documentos/procesoXML',
        '/usuarioweb/loginAuthWeb',
    ];
}
