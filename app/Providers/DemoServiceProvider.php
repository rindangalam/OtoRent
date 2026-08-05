<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DemoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (! $this->isDemoMode()) {
            return;
        }

        config([
            'app.demo' => true,
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => storage_path('demo/demo.sqlite'),
            'session.driver' => 'file',
            'cache.default' => 'file',
            'queue.default' => 'sync',
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (! $this->isDemoMode()) {
            return;
        }

        config(['app.demo' => true]);
    }

    public static function isDemoMode(): bool
    {
        return ! app()->environment('testing')
            && filter_var(env('APP_DEMO', true), FILTER_VALIDATE_BOOL);
    }
}
