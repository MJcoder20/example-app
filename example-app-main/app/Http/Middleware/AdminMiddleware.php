<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$guard=null)
    {
        // return $next($request);

        // if (Auth::guard($guard)->guest()) {

        //     if ($request->ajax()) {
 
        //       return response('Unauthorized.', 401);
 
        //     } else {
 
        //       return redirect()->guest('login');
 
        //     }
 
        //   } else if (!Auth::guard($guard)->user()->is_admin==1) {
 
        //     return redirect()->route('login');
 
        //   }
 
          return $next($request);
    }
}
