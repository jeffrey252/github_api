<?php

namespace App\Repositories\GitUsers;

use App\Repositories\GitUsers\Interfaces\CacheRepository;
use Illuminate\Support\Facades\Redis;

class RedisGitUserRepository implements CacheRepository
{
    public function find($key)
    {
        return Redis::get(config('constants.gitUsers.redisUserKeyPrefix').$key);
    }

    public function save($key, $data)
    {
        Redis::set(
            config('constants.gitUsers.redisUserKeyPrefix').$key,
            $data,
            'EX',
            config('constants.gitUsers.redisUserDataExpiry')
        );
    }
}