<?php

namespace Zento\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
        if(!Auth::user()->is_admin) {
            redirect(action('UserController@index'))
                ->withErrors(['Du hast keine Berechtigung diese Seite zu betrachten!']);
        }
        return $next($request);
    }
}
