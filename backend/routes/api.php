<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\TrainingController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
Route::group(['middleware' => AuthMiddleware::class], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/languages', [LanguageController::class, 'all'])->name('languages');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/training', [TrainingController::class, 'newWord'])->name('new-word');
    Route::patch('/training', [TrainingController::class, 'repeatWord'])->name('repeat-word');

    Route::get('/dictionary/{baseTrainingId}/language/{targetLanguageId}', [DictionaryController::class, 'translate'])->name('translate');
    Route::get('/progress/{status}', [ProgressController::class, 'progress'])->name('progress');
});

