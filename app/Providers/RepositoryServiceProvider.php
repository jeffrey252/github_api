<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\GitUsers\Interfaces\GitUserRepository;
use App\Repositories\GitUsers\Interfaces\ApiRepository;
use App\Repositories\GitUsers\CachedGitUserRepository;
use App\Repositories\GitUsers\Interfaces\CacheRepository;
use App\Repositories\GitUsers\RedisGitUserRepository;
use App\Repositories\GitUsers\GuzzleGitUserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(GitUserRepository::class, CachedGitUserRepository::class);
        
        $this->app->bind(CacheRepository::class, RedisGitUserRepository::class);
        $this->app->bind(ApiRepository::class, GuzzleGitUserRepository::class);
    }
}
