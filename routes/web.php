<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\User\ProductController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('user.products.index');
})->name('home');

Route::get('/test', [TestController::class, 'index'])->name('test');

// User routes
Route::prefix('user')->name('user.')->group(function () {
    // 商品関連
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/featured', [ProductController::class, 'featured'])->name('products.featured');
    Route::get('/products/category/{category}', [ProductController::class, 'category'])->name('products.category');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
