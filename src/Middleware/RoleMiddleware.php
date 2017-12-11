<?php

namespace Tropicalista\Admin\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission='')
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        if (! $request->user()->hasRole($role)) {
            return redirect('/login');
            abort(403);
        }
        
        if($permission != null) {
            if (! $request->user()->can($permission)) {
                return redirect('/login');
                abort(403);
            }
        }

        return $next($request);
    }
}