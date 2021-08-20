<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
