<?php

namespace App\Providers;

use App\Repositories\AvailableLanguageRepository;
use App\Repositories\CourseRepository;
use App\Repositories\Interfaces\AvailableLanguageRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\Interfaces\SuggestionRepositoryInterface;
use App\Repositories\Interfaces\TokenRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\VisitRepositoryInterface;
use App\Repositories\Interfaces\WordTranslationRepositoryInterface;
use App\Repositories\LanguageRepository;
use App\Repositories\NewsRepository;
use App\Repositories\SuggestionRepository;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitRepository;
use App\Repositories\WordTranslationRepository;
use App\Services\Interfaces\PrometheusServiceInterface;
use App\Services\PrometheusService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->app->bind(NewsRepositoryInterface::class, NewsRepository::class);
        $this->app->bind(AvailableLanguageRepositoryInterface::class, AvailableLanguageRepository::class);
        $this->app->bind(PrometheusServiceInterface::class, PrometheusService::class);
        $this->app->bind(VisitRepositoryInterface::class, VisitRepository::class);
        $this->app->bind(SuggestionRepositoryInterface::class, SuggestionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function () {
            return Limit::perMinute(500)->by(request()->header('X-Real-IP'));
        });
    }
}
