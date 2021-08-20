<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MemberRepository;
use App\Repositories\Interfaces\CacheRepository;
use App\Repositories\Interfaces\Repository;

class CachedMemberRepository implements MemberRepository
{
    protected $cache;
    protected $repo;

    public function __construct(CacheRepository $cacheRepository, Repository $memberRepository)
    {
        $this->cache = $cacheRepository;
        $this->repo = $memberRepository;
    }
    
    public function find($username)
    {
        $data = $this->cache->find($username);

        if(empty($data)) {
            echo 'fetched from api | ';
            $data = $this->repo->find($username);
            $this->cache->save($username, $data);
            //save data on cache
        }
        else echo 'fetched from redis | ';
        return $data;
    }
}