<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GitUsers\Interfaces\GitUserRepository;

class GithubController extends Controller
{
    protected $repo;

    public function __construct(GitUserRepository $memberRepo)
    {
        $this->repo = $memberRepo;
    }

    public function findUsers(Request $request)
    {
        $data = $request->all();
        $usernames = explode(',', $data['names']);
        $githubUsers = $this->repo->findGitUsers($usernames);
        return $githubUsers;
    }

    public function findGitUsers(Request $request)
    {
        $githubUsers = $this->repo->findGitUsers($request->all());
        return $githubUsers;
    }
}
