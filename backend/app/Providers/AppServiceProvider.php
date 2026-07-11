<?php

namespace App\Providers;

use App\Repositories\CourseRepository;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\TokenRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WordTranslationRepositoryInterface;
use App\Repositories\LanguageRepository;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use App\Repositories\WordTranslationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TokenRepositoryInterface::class, TokenRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(WordTranslationRepositoryInterface::class, WordTranslationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
