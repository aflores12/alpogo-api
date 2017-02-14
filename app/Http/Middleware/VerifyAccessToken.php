<?php

namespace AlpogoApi\Http\Middleware;

use AlpogoApi\Alpogo\Repositories\AccessTokenRepository;
use AlpogoApi\Model\User\AccessToken;
use Closure;

class VerifyAccessToken
{

    use AccessTokenRepository;

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
        //dd($access_token);
        //dd(AccessToken::where('key', $access_token)->first());
        if(!AccessToken::where('key', $access_token)->first()) {
            abort(404);
        }

        return $next($request);
    }
}
