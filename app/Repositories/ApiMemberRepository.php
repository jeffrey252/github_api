<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MemberRepository;
use Illuminate\Support\Facades\Http;
use App\Repositories\Interfaces\Repository;

class ApiMemberRepository implements Repository
{
    public function find($username)
    {
        return 'data';
    }
}