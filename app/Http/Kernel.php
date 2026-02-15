<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware stack.
     * These run on every request to your application.
     */
    protected $middleware = [
        // Handle proxy headers (like for load balancers)
        \App\Http\Middleware\TrustProxies::class,

        // Prevent requests during maintenance
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Validate POST size
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Trim all strings in request input
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,

        // Convert empty strings to null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        // Handle CORS
        \Fruitcake\Cors\HandleCors::class,
    ];

    /**
     * Route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            // Encrypt cookies
            \App\Http\Middleware\EncryptCookies::class,
            // Add queued cookies to response
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // Start session
            \Illuminate\Session\Middleware\StartSession::class,
            // Share errors with views
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // Verify CSRF token
            \App\Http\Middleware\VerifyCsrfToken::class,
            // Substitute route bindings
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Sanctum middleware to authenticate API tokens
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            // Throttle API requests
            'throttle:api',
            // Substitute route bindings
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Individual route middleware.
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class, // Custom middleware
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
