<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter;
use App\Filters\GuestFilter;
use App\Filters\AdminFilter;
use App\Filters\CorsFilter;
use App\Filters\RateLimitFilter;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'auth'          => AuthFilter::class,
        'guest'         => GuestFilter::class,
        'admin'         => AdminFilter::class,
        'cors'          => CorsFilter::class,
        'ratelimit'     => RateLimitFilter::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            'honeypot',
            'csrf' => ['except' => [
                'api/*'
            ]],
            'invalidchars',
            'cors',
        ],
        'after' => [
            'toolbar',
            'honeypot',
            'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [
        'auth' => [
            'before' => [
                'profil/*',
                'unggah',
                'karya/store',
                'karya/edit/*',
                'karya/update/*',
                'karya/delete/*',
                'karya-saya',
                'api/v1/user/*',
                'api/v1/works/post',
                'api/v1/works/put',
                'api/v1/works/delete'
            ]
        ],
        'guest' => [
            'before' => [
                'login',
                'register'
            ]
        ],
        'admin' => [
            'before' => [
                'admin/*'
            ]
        ],
        'ratelimit' => [
            'before' => [
                'api/*'
            ]
        ]
    ];
}