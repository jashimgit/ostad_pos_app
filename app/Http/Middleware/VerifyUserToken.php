<?php

namespace App\Http\Middleware;

use App\Helpers\JwtTokenHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userToken = $request->header('token');
        $result = JwtTokenHelper::VerifyToken($userToken);

        if ($result == 'unauthorized') {
            
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized',
            ], 401);

        } else {
            
            $request->headers->set('email', $result);

            return $next($request);
        }
    }
}
