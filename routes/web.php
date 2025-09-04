<?php

use App\Http\Controllers\ThankController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ThankController::class, 'index']);
Route::post('/thanks/increment', [ThankController::class, 'increment'])->name('thanks.increment');
