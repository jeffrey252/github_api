<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\MemberRepository;
use App\Repositories\CachedMemberRepository;
use App\Repositories\Interfaces\CacheRepository;
use App\Repositories\RedisRepository;
use App\Repositories\Interfaces\Repository;
use App\Repositories\ApiMemberRepository;

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
        //
    }
}
