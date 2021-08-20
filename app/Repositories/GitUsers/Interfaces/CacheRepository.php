<?php

namespace App\Repositories\GitUsers\Interfaces;

interface CacheRepository
{
    public function find($data);
    public function save($dataKey, $data);
}
