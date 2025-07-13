<?php

namespace App\Providers;

use App\Services\TaskInterface;
use App\Services\AuthInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\KanbanInterface;
use App\Services\Impl\TaskImpl;
use App\Services\Impl\KanbanImpl;
use App\Services\Impl\AuthImpl;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class, function ($app) {
            return new AuthImpl();
        });

        $this->app->bind(TaskInterface::class, function ($app) {
            return new TaskImpl();
        });

        $this->app->bind(KanbanInterface::class, function ($app) {
            return new KanbanImpl();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
