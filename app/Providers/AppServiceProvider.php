<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
     public function boot(): void
    {
        // ... (Kode default boot, biarkan saja) ...
        
        // TAMBAHKAN KODE INI UNTUK MENDAFTARKAN MIDDLEWARE SPATIE
        $router = $this->app->make(\Illuminate\Routing\Router::class);
        
        // Daftarkan alias 'role' dan 'permission'
        $router->aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class);
        $router->aliasMiddleware('permission', \Spatie\Permission\Middleware\PermissionMiddleware::class);
        
        // Jika Anda ingin juga mendaftarkan role_or_permission (opsional)
        // $router->aliasMiddleware('role_or_permission', \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class);
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }
}
