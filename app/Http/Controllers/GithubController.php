<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class GithubController extends Controller
{
    public function view(Request $request)
    {
        $data = $request->all();
        print_r($data['name']);
    }
}