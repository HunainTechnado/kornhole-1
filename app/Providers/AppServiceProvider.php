<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    final public function boot(): void
    {
        Schema::defaultStringLength(191);
    }

    final public function register(): void
    {
        //
    }
}
