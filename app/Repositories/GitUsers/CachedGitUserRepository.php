<?php

namespace App\Repositories\GitUsers;

use App\Repositories\GitUsers\Interfaces\GitUserRepository;
use App\Repositories\GitUsers\Interfaces\CacheRepository;
use App\Http\Resources\GitUserCollection;
use App\Models\GitUser;

class CachedGitUserRepository implements GitUserRepository
{
    protected $cache;
    protected $apiRepo;

    private $usersForRepoAccess = [];
    private $gitUserData = [];

    public function __construct(CacheRepository $cacheRepository, GitUserRepository $repository)
    {
        $this->cache = $cacheRepository;
        $this->repository = $repository;
    }

    public function findGitUsers(array $usernames): GitUserCollection
    {
        foreach ($usernames as $username) {
            $cachedUserData = $this->cache->find($username);
            if (empty($cachedUserData)) {
                $this->usersForRepoAccess[] = $username;
            } else {
                $this->gitUserData[] = $cachedUserData;
            }
        }
        $userDataFromApi = $this->repository->findGitUsers($this->usersForRepoAccess);
        foreach ($userDataFromApi as $user => $userData) {
            $this->cache->save($user, $userData);
            $this->gitUserData[] = $userData;
        }
        $collection = new GitUserCollection($this->gitUserData);
        return $collection;
    }
}
