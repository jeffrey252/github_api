<?php

namespace App\Repositories\Interfaces;

interface CacheRepository
{
    public function find($id);
    public function save($id, $data);
}