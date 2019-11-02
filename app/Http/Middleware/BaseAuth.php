<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userAuth = $request->getUser();
        $passwordAuth = $request->getPassword();
        //https://username:password@www.mailjet.loc/api/mailjet/callback
        if (!$userAuth || !$passwordAuth) {
            return response('Unauthorized', 401);
        } else {
            $username = config('services.mailjet.callback.username');
            $password = config('services.mailjet.callback.password');
            if($userAuth != $username || $passwordAuth != $password)
            {
                return response('Unauthorized', 401);
            }
        }
        return $next($request);
    }
}
