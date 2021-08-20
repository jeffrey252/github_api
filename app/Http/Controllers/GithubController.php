<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\Interfaces\MemberRepository;

class GithubController extends Controller
{
    protected $repo;

    public function __construct(MemberRepository $memberRepo)
    {
        $this->repo = $memberRepo;
    }

    public function view(Request $request)
    {
        echo $this->repo->find('key');
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