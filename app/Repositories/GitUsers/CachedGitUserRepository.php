<?php

namespace App\Repositories\GitUsers;

use App\Repositories\GitUsers\Interfaces\GitUserRepository;
use App\Repositories\GitUsers\Interfaces\CacheRepository;
use App\Repositories\GitUsers\Interfaces\ApiRepository;
use App\Http\Resources\GitUserCollection;
use App\Models\GitUser;

class CachedGitUserRepository implements GitUserRepository
{
    protected $cache;
    protected $apiRepo;

    private $usersForApiRepo = [];
    private $gitUserData = [];

    public function __construct(CacheRepository $cacheRepository, GitUserRepository $apiRepository)
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
                $this->gitUserData[] = new GitUser(json_decode($githubUserData));
            }
        }
        $this->fetchFromApiRepository($this->usersForApiRepo);
        $collection = new GitUserCollection($this->gitUserData);
        return $collection;
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
