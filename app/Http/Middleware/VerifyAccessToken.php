<?php

namespace AlpogoApi\Http\Middleware;

use AlpogoApi\Model\User\AccessToken;
use Closure;
use Illuminate\Http\JsonResponse;

class VerifyAccessToken
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $access_token = $request->header('authorization');
        //dd(AccessToken::where('key', $access_token)->first());
        if(!AccessToken::where('key', $access_token)->first()) {
            return new JsonResponse([
                'message' => 'No access.',
                'code' => 404
            ], 404);
        }

        return $next($request);
    }
}
