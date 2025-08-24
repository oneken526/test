<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
        Route::resource('products', \App\Http\Controllers\Owner\ProductController::class);

// 商品画像削除用のルート
Route::delete('product-images/{id}', function($id) {
    try {
        $image = \App\Models\ProductImage::findOrFail($id);

        // 認証されたオーナーの商品かチェック
        $ownerId = Auth::guard('owner')->id();
        if ($image->product->owner_id !== $ownerId) {
            return response()->json(['success' => false, 'message' => '権限がありません'], 403);
        }

        // 画像を削除
        $image->delete();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
})->name('owner.product-images.destroy');

        // 注文管理（将来的に追加予定）
        // Route::get('/orders', \App\Livewire\Owner\Orders\Index::class)->name('orders.index');
        // Route::get('/orders/{order}', \App\Livewire\Owner\Orders\Show::class)->name('orders.show');

        // ログアウト
        Route::post('/logout', \App\Livewire\Owner\Actions\Logout::class)->name('logout');
    });
});
