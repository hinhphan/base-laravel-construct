<?php

namespace Core\Providers;

// use Core\Repositories\BaseRepository;
// use Core\Repositories\Interfaces\BaseRepositoryContract;

// use Core\Services\BaseService;
// use Core\Services\Interfaces\BaseServiceContract;

use Core\Repositories\Interfaces\UserRepositoryContract;
use Core\Repositories\UserRepository;
use Core\Services\SanctumRefreshToken\PersonalAccessToken;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

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
      $this->app->bind(UserRepositoryContract::class, UserRepository::class);

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
        // Sanctum
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        
    }
}
