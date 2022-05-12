<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
      public function handle($request, Closure $next){
        if (Auth::check() && Auth::user()->level == 1) {
            return $next($request);
        }
// need login as user to purchase
        // elseif(Auth::check() && Auth::user()->level == 2) {
        //     return redirect('/kenalkopi/produk');
        // }
// doesnt need user instead order session from redeirect after qr login
        // elseif(session()->level == 2) {
        //     return redirect('/kenalkopi');
        // }
        // else {
        //     return redirect('/');
        // }
// for now
        else{
            return redirect('/kenalkopi');
        }
      }
}
