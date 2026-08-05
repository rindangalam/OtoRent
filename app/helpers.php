<?php

use App\Providers\DemoServiceProvider;

if (! function_exists('demo_mode')) {
    function demo_mode(): bool
    {
        return DemoServiceProvider::isDemoMode();
    }
}
