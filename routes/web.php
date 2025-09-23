<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ThankController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ThankController::class, 'index']);
Route::post('/thanks/increment', [ThankController::class, 'increment'])->name('thanks.increment');

Route::get('/debug-test', function () {
    $n = 123; // ← ここにブレークポイント
    return $n;
});
