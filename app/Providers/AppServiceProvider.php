<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\View::composer(['layouts.frontend', 'frontend.*'], function ($view) {
            // Check if table exists to avoid errors on migration
            if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
                $view->with('sharedCategories', \App\Models\Category::where('status', 'active')->get());
            } else {
                $view->with('sharedCategories', collect());
            }

            if (\Illuminate\Support\Facades\Schema::hasTable('pages')) {
                $view->with('sharedPages', \App\Models\Page::where('status', 'Published')->get());
            } else {
                $view->with('sharedPages', collect());
            }

            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $view->with('siteSettings', \App\Models\Setting::pluck('value', 'key')->all());
            } else {
                $view->with('siteSettings', []);
            }
        });
    }
}
