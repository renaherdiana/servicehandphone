<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;

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
        // Ambil user yang statusnya aktif pertama
        $activeUser = User::where('status', 'active')->orderBy('created_at', 'asc')->first();

        // Bagikan ke semua view
        View::share('activeUser', $activeUser);
    }

}
