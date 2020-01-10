<?php

namespace App\Providers;

use App\Models\Article\Article;
use App\Models\Goal\Goal;
use App\Models\User\User;
use App\Observers\Article\ArticleObserver;
use App\Observers\Goal\GoalObserver;
use App\Observers\User\UserObserver;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();
        Article::observe(ArticleObserver::class);

        Goal::observe(GoalObserver::class);

    }
}
