<?php

namespace App\Repositories\GitUsers;

use App\Repositories\GitUsers\Interfaces\ApiRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Log;
use App\Models\GitUser;
use App\Http\Resources\GitUserResource;

class GuzzleGitUserRepository implements ApiRepository
{
    
    public function find($gitUsers)
    {
        $apiCalls = [];
        $gitUserData = [];
        foreach ($gitUsers AS $gitUser) {
            Log::channel('api')->info('Github API called for user: '.$gitUser);
            $apiCalls[$gitUser] = config('constants.gitUsers.gitApiUrl').$gitUser;
        }

        $apiCalls = collect($apiCalls);
        $responses = Http::pool(fn (Pool $pool) => [
            $apiCalls->map(function ($url, $gitUsername) use ($pool) {
                $pool->as($gitUsername)->get($url);
            })
        ]);
                        
        foreach($responses AS $gitUsername => $response) {
            if ($response->ok()) {
                $gitUserData[$gitUsername] = new GitUserResource(new GitUser($response->json()));
            }
        }
        
        return $gitUserData;
    }
}