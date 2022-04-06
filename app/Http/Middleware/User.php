<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
     public function handle($request, Closure $next)
   {
     if (Auth::check() && Auth::user()->level == 2) {
         return $next($request);
     }
     elseif (Auth::check() && Auth::user()->level == 1) {
         return redirect('/dashboard');
     }
     else {
           return redirect('/');
     }
   }
   
}
