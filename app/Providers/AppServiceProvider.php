<?php

namespace App\Providers;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Route;
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
        Route::resourceVerbs(['create' => 'ekle', 'edit' => 'duzenle']);

        View::composer('admin.layouts.app', function ($view) {
            $view->with('unreadCount', ContactMessage::query()->unread()->count());
        });
    }
}
