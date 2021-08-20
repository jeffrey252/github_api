<?php

namespace App\Repositories\GitUsers;

use App\Repositories\GitUsers\Interfaces\GitUserRepository;
use App\Repositories\GitUsers\Interfaces\CacheRepository;
use App\Repositories\GitUsers\Interfaces\ApiRepository;
use App\Models\GitUser;
use Illuminate\Support\Facades\Log;

class CachedGitUserRepository implements GitUserRepository
{
    protected $cache;
    protected $repo;

    public function __construct(CacheRepository $cacheRepository, ApiRepository $apiRepository)
    {
        $this->cache = $cacheRepository;
        $this->repo = $apiRepository;
    }

    public function find($githubUsers)
    {
        $data = [];
        foreach($githubUsers AS $githubUser) {
            $userData = $this->cache->find($githubUser);
            if(empty($userData))
            {
                Log::channel('api')->info('Github API called for user: '.$githubUser);
                $userData = $this->repo->find($githubUser);
                $gitUserModel = new GitUser($userData);
                $userData = json_encode($gitUserModel);
                $this->cache->save($githubUser, $userData);
            } else {
                Log::channel('api')->info('Redis Cache used for user: '.$githubUser);
            }
            
            $data[] = json_decode($userData);
        }
        
        return $data;
    }
}