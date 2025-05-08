<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::aliasMiddleware('role', RoleMiddleware::class);
    }
}
