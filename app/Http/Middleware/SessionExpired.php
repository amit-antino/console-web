<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use Auth;
use Session;

class SessionExpired
{
    protected $session;
    protected $timeout = 1200;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function handle($request, Closure $next)
    {
        if ($request->path() != 'logout') {
            $value = !empty($request->path()) ? $request->path() : 'dashboard';
            session()->put('intend', $value);
        }
        return $next($request);
    }
}
