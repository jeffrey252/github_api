<?php

namespace App\Models;

use App\Models\Abstracts\Model;

class GitUser extends Model
{
    public $fillable = [
        'name',
        'login',
        'company',
        'followers',
        'publicRepos',
    ];

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->$key = $value;
            } elseif ($key === 'public_repos') {
                $this->publicRepos = $value;
            }
        }
    }
}
