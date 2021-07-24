<?php

namespace App\Http\Middleware;

use App\Frame\System\Session\UserSession;
use Closure;
use Illuminate\Http\Request;

class Authorize
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
        $user = new UserSession();
        if ($user->isSet() === false){
            return redirect(route('/login'));
        }
        return $next($request);
    }
}
