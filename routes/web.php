<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

// ホームページ
Route::get('/', function () {
    return redirect()->route('user.products.index');
})->name('home');

// テストページ
Route::get('/test', [TestController::class, 'index'])->name('test');

// ルートファイルの読み込み
require __DIR__.'/auth.php';
require __DIR__.'/user.php';
require __DIR__.'/owner.php';
