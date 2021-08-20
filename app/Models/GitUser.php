<?php

namespace App\Models;

class GitUser
{
    protected $fillable = [
        'name',
        'login',
        'company',
        'followers',
        'publicRepositoryCount',
    ];

    public function __construct($data)
    {
        foreach($data AS $key => $value) {
            if(in_array($key, $this->fillable)) {
                $this->$key = $value;
            }
        }
    }
}
