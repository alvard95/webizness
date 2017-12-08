<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/login',
        'api/register',
        'api/get-uploads',
        'api/get-inbox',
        'api/get-favourite',
        'api/get-menu',
        'api/remove_music',
        'api/get-group_music',
        'api/set-favorite',
        'sendmessage',
        '/upload_img',
        '/get_message',
        '/check_old_password',
        '/update_password',
        '/getMusicInfo',
        '/add_second_email'
    ];
}
