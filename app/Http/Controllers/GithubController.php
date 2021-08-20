<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\GitUsers\Interfaces\GitUserRepository;

class GithubController extends Controller
{
    protected $repo;

    public function __construct(GitUserRepository $memberRepo)
    {
        $this->repo = $memberRepo;
    }

    public function view(Request $request)
    {
        $data = $request->all();
        return $this->repo->find($data['names']);
        /*$url = 'https://api.github.com/users/';
        $data = $request->all();

        foreach($data['name'] AS $githubUser) {
            $response = Http::get($url.$githubUser);
            print_r($response->body());
        }*/


        /*$cachedData = Redis::get('github_' . $id);

        if(isset($cachedData)) {
            echo 'yayy';
        } else {
            Redis::set('github_' . $id, $data['name'][0]);
            echo 'nuuu';
        }*/
    }
}