<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Create Kernel (full-stack)
$kernel = $app->make(\App\Http\Kernel::class);

// Handle request
$response = $kernel->handle($request = Request::capture());
$response->send();

// Terminate
$kernel->terminate($request, $response);
