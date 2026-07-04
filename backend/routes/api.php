<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
Route::group(['middleware' => AuthMiddleware::class], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/languages', [LanguageController::class, 'all'])->name('languages');
});

