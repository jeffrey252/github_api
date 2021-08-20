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

    public function view(Request $request)
    {
        $data = $request->json()->all();
        $githubUsers = $this->repo->findGitUsers($data['names']);
        return $githubUsers;
    }
}
