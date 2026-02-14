<?php

namespace App\Providers;

use App\AddOnDetails;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('AddOnDetails', function ($app) {
            return new AddOnDetails();
        });
        
    }


    public function boot()
    {
        $this->ensureFrameworkStorageDirectories();
        Schema::defaultStringLength(191);
    }

    protected function ensureFrameworkStorageDirectories(): void
    {
        $directories = [
            storage_path('framework'),
            storage_path('framework/cache'),
            storage_path('framework/cache/data'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
        ];

        foreach ($directories as $directory) {
            if (! File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
        }
    }
}
