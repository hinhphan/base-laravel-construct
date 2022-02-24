<?php

namespace Core\Providers;

// use Core\Repositories\BaseRepository;
// use Core\Repositories\Interfaces\BaseRepositoryContract;

// use Core\Services\BaseService;
// use Core\Services\Interfaces\BaseServiceContract;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      // Repositories
      // $this->app->bind(BaseRepositoryContract::class, BaseRepository::class);

      // Services
      // $this->app->bind(BaseServiceContract::class, BaseService::class);

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
