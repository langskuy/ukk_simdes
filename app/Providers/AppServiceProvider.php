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
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\LogAuthActivity::class,
        );

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Logout::class,
            \App\Listeners\LogAuthActivity::class,
        );

        // Share pending counts with admin layout
        \Illuminate\Support\Facades\View::composer('layouts.admin', function ($view) {
            $view->with('pendingSuratCount', \App\Models\Surat::where('status', 'diajukan')->count());
            $view->with('pendingPengaduanCount', \App\Models\Pengaduan::where('status', 'baru')->count());
        });
    }
}
