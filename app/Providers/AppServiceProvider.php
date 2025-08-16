<?php

namespace App\Providers;

use App\Services\Impl\TransactionImpl;
use App\Services\TaskInterface;
use App\Services\AuthInterface;
use App\Services\TransactionsInterface;
use Elastic\Apm\TransactionInterface;
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
            $this->app->bind(AuthInterface::class, AuthImpl::class);
            $this->app->bind(TaskInterface::class, TaskImpl::class);
            $this->app->bind(KanbanInterface::class, KanbanImpl::class);
            $this->app->bind(TransactionsInterface::class, TransactionImpl::class);
      }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
