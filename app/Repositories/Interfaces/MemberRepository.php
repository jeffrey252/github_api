<?php

namespace App\Repositories\Interfaces;

interface MemberRepository
{
    public function find($username);
}