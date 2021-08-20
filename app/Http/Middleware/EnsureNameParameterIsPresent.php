<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureNameParameterIsPresent
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
        $jsonBody = $request->all();

        if (empty($jsonBody) || !isset($jsonBody['names'])) {
            return response()->json([
                'message' => 'The request does not have a valid JSON body. Please send a JSON body with a `names` key that is an array of all the usernames for your request.',
            ], 400);
        } else {
            return $next($request);
        }
    }
}
