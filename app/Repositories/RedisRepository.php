<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MemberRepository;
use App\Repositories\Interfaces\CacheRepository;
use Illuminate\Support\Facades\Redis;

class RedisRepository implements CacheRepository
{
    public function find($id)
    {
        return Redis::get($id);
    }

    public function save($id, $data)
    {
        Redis::set($id, $data, 'EX', 10);
    }
}