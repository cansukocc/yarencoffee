<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::post('/iletisim', [ContactMessageController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::prefix('yonetim')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('giris', [LoginController::class, 'create'])->name('login');
        Route::post('giris', [LoginController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('cikis', [LoginController::class, 'destroy'])->name('logout');

        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('urunler', ProductController::class)
            ->except('show')
            ->parameters(['urunler' => 'product'])
            ->names('products');

        Route::get('ayarlar', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('ayarlar', [SettingController::class, 'update'])->name('settings.update');

        Route::get('mesajlar', [MessageController::class, 'index'])->name('messages.index');
        Route::get('mesajlar/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::patch('mesajlar/{message}/okunmadi', [MessageController::class, 'markAsUnread'])->name('messages.unread');
        Route::delete('mesajlar/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });
});
