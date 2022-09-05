<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Console
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role) {
            if (Auth::user()->role == 'admin' && !empty($request->tenant_id) || !empty(Session::get('tenant_id'))) {
                if (!empty($request->tenant_id)) {
                    Session::put('tenant_id', ___decrypt($request->tenant_id));
                }
                return $next($request);
            }
            if (Auth::user()->role == 'console' || Auth::user()->role == 'console_admin') {
                $tenant = getTenent();
                if (empty(Session::get('tenant_id'))) {
                    Session::put('tenant_id', $tenant['id']);
                }
                return $next($request);
            } elseif (Auth::user()->role == 'admin' && empty($request->tenant_id)) {
                return redirect('admin/dashboard');
            }
        } else {
            return redirect('/logout');
        }
    }
}
