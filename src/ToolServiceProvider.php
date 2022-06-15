<?php

namespace Eminiarts\NovaPermissions;

use Eminiarts\NovaPermissions\Http\Middleware\Authorize;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Filesystem $filesystem)
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/create_permission_tables.php.stub' => $this->getMigrationFileName($filesystem),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/permission.php' => config_path('permission.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/seeds/RolesAndPermissionsSeeder.php.stub' => $this->app->databasePath() . "/seeders/RolesAndPermissionsSeeder.php",
        ], 'seeds');

        $this->app->booted(function () {
            $this->routes();
        });
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $filesystem
     * @return string
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path . '*_create_permission_tables.php');
            })->push($this->app->databasePath() . "/migrations/{$timestamp}_create_permission_tables.php")
            ->first();
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-permissions')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/permission.php',
            'permission'
        );
    }
}
