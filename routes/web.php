<?php

// 使用するため
namespace App\Http\Controllers;

use App\Http\Controllers\ThankController;
use Illuminate\Support\Facades\Route;



// /を叩かれたらThankControllerのindexメソッドを実行
Route::get('/', [ThankController::class, 'index']);
// /thanks/incrementを叩かれたらThankControllerのincrementメソッドを実行
Route::post('/thanks/increment', [ThankController::class, 'increment'])->name('thanks.increment');

Route::get('/debug-test', function () {
    $n = 123; // ← ここにブレークポイント
    return $n;
});
