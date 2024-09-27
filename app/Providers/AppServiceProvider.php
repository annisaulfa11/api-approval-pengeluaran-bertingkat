<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ApproverRepository;
use App\Repositories\EloquentApproverRepository;
use App\Repositories\Interfaces\ApprovalStageRepository;
use App\Repositories\EloquentApprovalStageRepository;
use App\Repositories\EloquentExpenseRepository;
use App\Repositories\Interfaces\ExpenseRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {
        $this->app->bind(ApproverRepository::class, EloquentApproverRepository::class);
        $this->app->bind(ApprovalStageRepository::class, EloquentApprovalStageRepository::class);
        $this->app->bind(ExpenseRepository::class, EloquentExpenseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
