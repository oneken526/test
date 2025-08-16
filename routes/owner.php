<?php

use Illuminate\Support\Facades\Route;

// Owner routes
Route::prefix('owner')->name('owner.')->group(function () {
    // 認証関連（未認証）
    Route::middleware('guest.owner')->group(function () {
        Route::get('/login', \App\Livewire\Owner\Auth\Login::class)->name('login');
        Route::get('/register', \App\Livewire\Owner\Auth\Register::class)->name('register');
    });

    // 認証済みオーナー向けルート
    Route::middleware(['auth:owner'])->group(function () {
        // ダッシュボード
        Route::get('/dashboard', \App\Livewire\Owner\Dashboard::class)->name('dashboard');

        // プロフィール管理
        Route::get('/profile', \App\Livewire\Owner\Profile::class)->name('profile.edit');

        // 商品管理（将来的に追加予定）
        // Route::get('/products', \App\Livewire\Owner\Products\Index::class)->name('products.index');
        // Route::get('/products/create', \App\Livewire\Owner\Products\Create::class)->name('products.create');
        // Route::get('/products/{product}/edit', \App\Livewire\Owner\Products\Edit::class)->name('products.edit');

        // 注文管理（将来的に追加予定）
        // Route::get('/orders', \App\Livewire\Owner\Orders\Index::class)->name('orders.index');
        // Route::get('/orders/{order}', \App\Livewire\Owner\Orders\Show::class)->name('orders.show');

        // ログアウト
        Route::post('/logout', \App\Livewire\Owner\Actions\Logout::class)->name('logout');
    });
});
