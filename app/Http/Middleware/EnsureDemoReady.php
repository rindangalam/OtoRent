<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class EnsureDemoReady
{
    /**
     * On first request: auto-create the demo SQLite database (migrate + seed)
     * and make sure public/storage resolves to the uploads folder.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! \App\Providers\DemoServiceProvider::isDemoMode()) {
            return $next($request);
        }

        $db = storage_path('demo/demo.sqlite');
        $lock = storage_path('demo/demo.lock');

        if (! File::exists($db)) {
            File::ensureDirectoryExists(storage_path('demo'));

            if ($this->acquireLock($lock)) {
                try {
                    Artisan::call('migrate', ['--force' => true]);
                    Artisan::call('db:seed', ['--force' => true]);
                } finally {
                    File::delete($lock);
                }
            } else {
                // Another request is seeding; wait for it to finish.
                $waited = 0;
                while (! File::exists($db) && $waited < 30) {
                    usleep(250000);
                    $waited += 0.25;
                }
            }
        }

        $this->ensurePublicStorageLink();

        return $next($request);
    }

    private function acquireLock(string $lock): bool
    {
        if (File::exists($lock) && File::lastModified($lock) < now()->subSeconds(120)->getTimestamp()) {
            File::delete($lock);
        }

        return @fopen($lock, 'x') !== false;
    }

    private function ensurePublicStorageLink(): void
    {
        if (is_dir(public_path('storage')) || is_link(public_path('storage'))) {
            return;
        }

        try {
            Artisan::call('storage:link');
        } catch (\Throwable) {
            // Ignore: fall back to copying below.
        }

        if (! is_dir(public_path('storage'))) {
            File::copyDirectory(storage_path('app/public'), public_path('storage'));
            File::put(public_path('storage/.static-copy'), 'copied at '.now()->toDateTimeString());
        }
    }
}
