<?php

namespace App\Repositories\GitUsers\Interfaces;

interface CacheRepository
{
    public function find($key);
    public function save($key, $data);
}
