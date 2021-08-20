<?php

namespace App\Repositories\GitUsers\Interfaces;

use App\Http\Resources\GitUserCollection;

interface GitUserRepository
{
    public function findGitUsers(array $data): GitUserCollection;
}
