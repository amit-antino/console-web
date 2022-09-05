<?php

use App\Models\Organization\Users\User;
use App\Models\Tenant\Tenant;
use App\Models\Tenant\TenantConfig;
use App\Models\Tenant\TenantUser;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

function getTenent($id = '')
{
    $tenentArr = [];
    if (Auth::user()->role == 'admin') {
        $tenant_id = \Session::get('tenant_id');
        if (!empty($id)) {
            $tenant_id = $id;
        }
        $tenentObj = Tenant::where('id', $tenant_id)->first();
        $tenentArr = $tenentObj->toArray();
        $tenant_user = _arefy(TenantUser::where('tenant_id', $tenant_id)->get());
        if (!empty($tenant_user)) {
            foreach ($tenant_user as $t_user) {
                $tenentArr['tenant_user'][] = $t_user['user_id'];
            }
        }
    } else {
        $user_id = Auth::user()->id;
        $data = TenantUser::where('user_id', $user_id)->first();

        $tenant_id = $data['tenant_id'];
        if (!empty($data)) {
            $tenentObj = Tenant::where('id', $tenant_id)->first();
            $tenentArr = $tenentObj->toArray();
        } else {
            $dataUser = User::where('id', $user_id)->first();
            $dataten = TenantUser::where('user_id', $dataUser['created_by'])->first();
            if (!empty($dataten)) {
                $tenentObj = Tenant::where('id', $dataten['tenant_id'])->first();
                $tenentArr = $tenentObj->toArray();
            } else {
                $tenentArr['id'] = 0;
                $tenentArr['organization_name'] = 'simreka';
                $tenentArr['no_users'] = 0;
            }
        }
        $tenant_user = _arefy(TenantUser::where('tenant_id', $data['tenant_id'])->get());
        if (!empty($tenant_user)) {
            foreach ($tenant_user as $t_user) {
                $tenentArr['tenant_user'][] = $t_user['user_id'];
            }
        }
    }
    return $tenentArr;
}

function getUser($user_id)
{
    if (empty($user_id)) {
        $user_id = 2;
    }
    $dataUser = User::where('id', $user_id)->first();
    $data=array();
    if (isset($dataUser['role']) == "admin") {
        $data['username'] =
            $dataUser['first_name'] . ' ' . $dataUser['last_name'];
        $data['organization_name'] = "Admin";
    } else {
        $dataten = TenantUser::where('user_id', $user_id)->first();
        if (!empty($dataten)) {
            $tenentObj = Tenant::where('id', $dataten['tenant_id'])->first();
            $tenentArr = $tenentObj->toArray();
            $data['username'] = $dataUser['first_name'] . ' ' . $dataUser['last_name'];
            $data['organization_name'] = $tenentArr['name'];
        }
    }
    return $data;
}

function getTenentCalURL($tenant_id = 0)
{
    $tenant = TenantConfig::where('tenant_id', $tenant_id)->first();
    $calc = [];
    if (!empty($tenant->calc_server)) {
        foreach ($tenant->calc_server as $key => $desig) {
            if (env('SERVER_TYPE') == $desig['server_type']) {
                $calc['id'] = $desig['id'];
                $calc['name'] = $desig['name'];
                $calc['server_type'] = $desig['server_type'];
                $calc['calc_url'] = $desig['calc_url'];
                $calc['version'] = $desig['version'];
                $calc['status'] = !empty($desig['status']) ? $desig['status'] : 'active';
            }
        }
    }
    return $calc;
}

function sessionGet()
{
    return \Session::get('sidebar_menu_toggle');
}

function two_factor_is_enable()
{
    if (Auth::user()->role != 'admin') {
        $tenant = getTenent();
        $config = TenantConfig::where('tenant_id', $tenant['id'])->first();
        if (!empty($config['two_factor_auth'])) {
            if ($config['two_factor_auth'] == 'true') {
                return 'checked';
            }
        }
    }
    if (Auth::user()->role == 'admin') {
        if (Auth::user()->two_factor_auth == 'true') {
            return 'checked';
        }
    }
}

function get_user_name($user_id)
{
    $user = User::find($user_id);
    $first_name = !empty($user->first_name) ? $user->first_name : '';
    $last_name = !empty($user->last_name) ? $user->last_name : '';
    return  $first_name . ' ' . $last_name;
}

function check_user_type($user_id)
{
    return App\User::Select('id', 'role', 'email')->where('id', $user_id)->first();
}


function tenant_details($user_id)
{
    try {
        $user_id = Auth::user();
        if ($user_id) {
            $tenent_info = TenantUser::where('user_id', $user_id->id)->get()->first();
            $tenant = Tenant::find($tenent_info['tenant_id']);
            return $tenant;
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'status_code' => 500,
            'status' => false,
            'data' => $e->getMessage()
        ]);
    }
}

function get_designation_user_group_location($tenant_id, $id, $type = '')
{
    $conigs = TenantConfig::where('tenant_id', $tenant_id)->first();
    $name = '';
    if ($type == 'designation') {
        if (!empty($conigs->designation)) {
            foreach ($conigs->designation as $desig) {
                if ($desig['id'] == $id) {
                    $name = $desig['name'];
                }
            }
        }
    } elseif ($type == 'location') {
        if (!empty($conigs->location)) {
            foreach ($conigs->location as $desig) {
                if ($desig['id'] == $id) {
                    $name = $desig['name'];
                }
            }
        }
    } elseif ($type == 'user_group') {
        if (!empty($conigs->user_group)) {
            foreach ($conigs->user_group as $desig) {
                if ($desig['id'] == $id) {
                    $name = $desig['name'];
                }
            }
        }
    }
    return  $name;
}
