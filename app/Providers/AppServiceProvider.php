<?php

namespace App\Providers;

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
        $this->app->bind(\App\Contracts\SearchServiceInterface::class, \App\Services\AlgoliaService::class);
        $this->app->bind(\App\Contracts\FileUploadServiceInterface::class, \App\Services\LocalFileUploadService::class);
        $this->app->bind(\App\Contracts\Repositories\MasterRepositoryInterface::class, \App\Repositories\MasterRepository::class);
        $this->app->bind(\App\Contracts\Repositories\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
        $this->app->bind(\App\Contracts\Repositories\DocumentViewRepositoryInterface::class, \App\Repositories\DocumentViewRepository::class);
        $this->app->bind(\App\Contracts\Services\DocumentViewServiceInterface::class, \App\Services\DocumentViewService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
