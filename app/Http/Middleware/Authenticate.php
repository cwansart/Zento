<?php

namespace Zento\Http\Middleware;

use Closure;
use DB;
use Illuminate\Contracts\Auth\Guard;
use Redirect;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        } elseif ($this->auth->user()->first_login) {
            DB::update('update users set first_login = false where id = ?', array($this->auth->user()->getAuthIdentifier()));
            return redirect($request->url())->with('first_login', true);
        }

        return $next($request);
    }
}
