<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureJsonBodyIsPresent
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
        if (empty($jsonBody)|| !isset($jsonBody['names'])) {
            return response()->json([
                'message' => 'The request does not have a valid JSON body',
            ], 400);
        } else {
        }
        return $next($request);
    }
}
