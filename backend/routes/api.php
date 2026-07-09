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


Route::get('/languages', [LanguageController::class, 'all'])->name('languages');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
Route::post('/user', [AuthController::class, 'user'])->name('user');
Route::group(['middleware' => AuthMiddleware::class], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile-update');
    Route::get('/training', [TrainingController::class, 'newWord'])->name('new-word');
    Route::patch('/training/{id}', [TrainingController::class, 'repeatWord'])->name('repeat-word');

    Route::get('/dictionary/{baseTrainingId}/language/{targetLanguageId}', [DictionaryController::class, 'translate'])->name('translate');
    Route::get('/progress/{status}', [ProgressController::class, 'progress'])->name('progress');

    Route::post('/progress', [ProgressController::class, 'initProgress'])->name('progress-init');
    Route::delete('/progress', [ProgressController::class, 'clearProgress'])->name('progress-clear');

    Route::get('/teachable', [TrainingController::class, 'teachable'])->name('teachable');
});

