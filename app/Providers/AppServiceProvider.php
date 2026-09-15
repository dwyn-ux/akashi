<?php

namespace App\Providers;

use App\Models\Competition;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            try {
                $settings = Setting::all()->pluck('value', 'key')->toArray();
                $globalClosed = ($settings['registration_status'] ?? 'OPEN') === 'CLOSED';
                $finished = $globalClosed || !Competition::where('status', 'OPEN')->exists();
                $view->with(compact('settings', 'finished'));
            } catch (\Throwable $e) {
                $view->with('settings', []);
                $view->with('finished', false);
            }
        });
    }
}
