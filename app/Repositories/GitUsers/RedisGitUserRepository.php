<?php

namespace App\Repositories\GitUsers;

use App\Repositories\GitUsers\Interfaces\CacheRepository;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class RedisGitUserRepository implements CacheRepository
{
    public function find($gitUsername)
    {
        $gitUserData = Redis::get(config('constants.gitUsers.redisUserKeyPrefix').$gitUsername);
        if (!empty($gitUserData)) {
            Log::channel('api')->info('Redis Cache accessed for user: '.$gitUsername);
        }
        return $gitUserData;
    }

    public function save($gitUsername, $gitUserData)
    {
        Redis::set(
            config('constants.gitUsers.redisUserKeyPrefix').$gitUsername,
            $gitUserData,
            'EX',
            config('constants.gitUsers.redisUserDataExpiry')
        );
    }
}