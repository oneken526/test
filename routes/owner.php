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

        // 商品管理
        Route::get('/products', [\App\Http\Controllers\Owner\ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [\App\Http\Controllers\Owner\ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [\App\Http\Controllers\Owner\ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}', [\App\Http\Controllers\Owner\ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{id}/edit', [\App\Http\Controllers\Owner\ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [\App\Http\Controllers\Owner\ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [\App\Http\Controllers\Owner\ProductController::class, 'destroy'])->name('products.destroy');
        Route::patch('/products/{id}/toggle-status', [\App\Http\Controllers\Owner\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::patch('/products/{id}/update-stock', [\App\Http\Controllers\Owner\ProductController::class, 'updateStock'])->name('products.update-stock');
        Route::get('/products/low-stock', [\App\Http\Controllers\Owner\ProductController::class, 'lowStock'])->name('products.low-stock');

        // 注文管理（将来的に追加予定）
        // Route::get('/orders', \App\Livewire\Owner\Orders\Index::class)->name('orders.index');
        // Route::get('/orders/{order}', \App\Livewire\Owner\Orders\Show::class)->name('orders.show');

        // ログアウト
        Route::post('/logout', \App\Livewire\Owner\Actions\Logout::class)->name('logout');
    });
});
