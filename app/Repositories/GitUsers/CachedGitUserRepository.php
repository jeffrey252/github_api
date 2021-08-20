<?php

namespace App\Repositories\GitUsers;

use App\Repositories\GitUsers\Interfaces\GitUserRepository;
use App\Repositories\GitUsers\Interfaces\CacheRepository;
use App\Repositories\GitUsers\Interfaces\ApiRepository;


class CachedGitUserRepository implements GitUserRepository
{
    protected $cache;
    protected $apiRepo;

    private $usersForApiRepo = [];
    private $gitUserData = [];

    public function __construct(CacheRepository $cacheRepository, ApiRepository $apiRepository)
    {
        $this->cache = $cacheRepository;
        $this->apiRepo = $apiRepository;
    }

    public function find($githubUsers)
    {
        foreach ($githubUsers as $githubUser) {
            $githubUserData = $this->cache->find($githubUser);
            if (empty($githubUserData)) {
                $this->usersForApiRepo[] = $githubUser;
            } else {
                $this->gitUserData[] = json_decode($githubUserData);
            }
        }

        $this->fetchFromApiRepository($this->usersForApiRepo);
        return $this->gitUserData;
    }

    public function fetchFromApiRepository($usersForApiRepo)
    {
        $userDataFromApi = $this->apiRepo->find($usersForApiRepo);
        foreach ($userDataFromApi as $user => $userData) {
            $this->cache->save($user, $userData->toJson());
            $this->gitUserData[] = $userData;
        }
    }
}
