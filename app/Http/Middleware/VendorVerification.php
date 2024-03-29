<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role != 2){
            //toastr()->warning('unauthorized');
            return redirect('/');
        }

        if(!$request->user()->vendor()->verified){
            return redirect('/vendor/get_started');
        }

        return $next($request);
    }
}
