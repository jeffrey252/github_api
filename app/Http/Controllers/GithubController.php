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
        $data = $request->json()->all();
        $githubUsers = $this->repo->find($data['names']);
        return $githubUsers;
    }
}
