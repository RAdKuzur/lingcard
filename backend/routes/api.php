<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\TelemetryController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\StatMiddleware;
use App\Http\Middleware\VisitMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:api'])->group(function () {
    Route::get('/metrics', [TelemetryController::class, 'metrics'])->name('metrics');
    Route::post('/auth/broadcasting', [AuthController::class, 'broadcast'])->name('auth.broadcasting');
    Route::group(['middleware' => VisitMiddleware::class], function () {
        Route::get('/languages', [LanguageController::class, 'all'])->name('languages');
        Route::get('/active-languages', [LanguageController::class, 'allActive'])->name('active-languages');
        Route::get('/except-languages/{id}', [LanguageController::class, 'exceptLanguage'])->name('except-language');
        Route::get('/map-languages', [LanguageController::class, 'map'])->name('map-languages');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('/user', [AuthController::class, 'user'])->name('user');
        Route::get('/posts/{code?}', [PostController::class, 'all'])->name('posts');
        Route::group(['middleware' => AuthMiddleware::class], function () {
            Route::group(['middleware' => StatMiddleware::class], function () {
                Route::get('/articles/{id}', [PostController::class, 'one'])->name('article');
                Route::post('/posts/{postId}/comments', [PostController::class, 'createComment'])->name('create-comment');
                Route::post('/posts', [PostController::class, 'create'])->name('create');
                Route::delete('/comments/{commentId}', [PostController::class, 'deleteComment'])->name('delete-comment');
                Route::post('/likes/{postId}', [ReactionController::class , 'like'])->name('like');
                Route::post('/dislikes/{postId}', [ReactionController::class , 'dislike'])->name('dislike');
                Route::post('/unset-reactions/{postId}', [ReactionController::class , 'unset'])->name('unset-reaction');
                Route::get('/teachable', [TrainingController::class, 'teachable'])->name('teachable');
                Route::get('/training', [TrainingController::class, 'newWord'])->name('new-word');
                Route::patch('/training/{id}', [TrainingController::class, 'repeatWord'])->name('repeat-word');
                Route::post('/voices/{voteOptionId}', [VoteController::class, 'vote'])->name('vote');
                Route::post('/cancel-voices/{voteOptionId}', [VoteController::class, 'cancelVote'])->name('cancel-vote');
                Route::post('/suggestions', [SuggestionController::class, 'create'])->name('create-suggestions');
            });
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile-update');
            Route::get('/dictionary/{baseTrainingId}/language/{targetLanguageId}', [DictionaryController::class, 'translate'])->name('translate');
            Route::get('/progress/{status}', [ProgressController::class, 'progress'])->name('progress');
            Route::post('/progress', [ProgressController::class, 'initProgress'])->name('progress-init');
            Route::delete('/progress', [ProgressController::class, 'clearProgress'])->name('progress-clear');
            Route::delete('/words/{id}/progress', [ProgressController::class, 'clearWordProgress'])->name('progress-clear-word');
            Route::get('/votes', [VoteController::class, 'all'])->name('votes');
            Route::get('/votes/{id}', [VoteController::class, 'one'])->name('votes');
        });
    });
});
