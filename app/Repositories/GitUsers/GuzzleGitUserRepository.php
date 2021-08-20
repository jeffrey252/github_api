<?php

namespace App\Repositories\GitUsers;

use App\Repositories\GitUsers\Interfaces\ApiRepository;
use Illuminate\Support\Facades\Http;

class GuzzleGitUserRepository implements ApiRepository
{
    
    public function find($gitUsername)
    {
        $data = [
            'name' => 'Name',
            'login' => 'Login',
            'company' => 'Company',
            'followersCount' => 7,
            'publicRepositoryCount' => 9,
        ];

        return $data;
        $response = Http::get(config('constants.gitUsers.gitApiUrl').$gitUsername);
        return $response->json();
    }
}