<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LimitUsernameParameters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $jsonBody = $request->json()->all();
        if (
            isset($jsonBody['names'])
            && count($jsonBody['names']) > config('constants.gitUsers.usernameParametersLimit')
        ) {
            return response()->json([
                'message' => 'The request have too much username parameters. Maximum is 10',
            ], 400);
        } else {
            return $next($request);
        }
    }
}
