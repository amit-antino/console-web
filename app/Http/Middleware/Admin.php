<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        //$response = $next($request);
        // $response->headers->set('Access-Control-Allow-Origin', '*');
        // $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        // $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return $next($request);
            } elseif (Auth::user()->role == 'console' || Auth::user()->role == 'console_admin') {
                return redirect('/dashboard');
            }
        } else {
            return redirect('/logout');
        }
    }
}
