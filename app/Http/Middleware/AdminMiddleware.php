<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
    public function handle(Request $request, Closure $next)
    {
        // if(auth()->check() && auth()->user()->role === "admin"){
        //     return $next($request);
        // }
        // return  redirect()->route('login');

        if(Auth::check()){
        return $next($request);
      }
        return redirect('login')->with('error','You have not admin access');
    }
}
