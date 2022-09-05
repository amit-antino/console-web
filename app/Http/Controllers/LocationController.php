<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Session;

class LocationController extends Controller
{
    public function setSession()
    {
        $get_cookie_value = sessionGet();
        if (!empty($get_cookie_value) && $get_cookie_value == 'not-active') {
            Session::put('sidebar_menu_toggle', 'active');
        } else {
            Session::put('sidebar_menu_toggle', 'not-active');
        }
    }

    public function error_auth_user()
    {
        $data['previous_url'] = 'dashboard';
        return view('pages.console.unauthorized', $data);
    }
}
