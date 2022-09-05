<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Organization\Users\UserPermission;
use App\Models\Tenant\Tenant;
use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\UserMenu;
use App\Models\Tenant\TenantConfig;
use Illuminate\Http\Request;

class PermissionModule
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role == "admin") {
            $tenant_id = Session::get('tenant_id');
        } else {
            $tenant = getTenent();
            $tenant_id = $tenant['id'];
        }
        $url = "";
        $method = $request->route()->getActionMethod();
        if (!empty(request()->segment(1))) {
            if (request()->segment(1) == 'dashboard') {
                $method = 'index';
            }
            $url .=  request()->segment(1);
        }
        if (!empty(request()->segment(2))) {
            $arr = array('models', 'data_request');
            if (!in_array($url, $arr)) {
                $url .= "/" . request()->segment(2);
            }
        }
        if (!empty(request()->segment(1)) && request()->segment(1) == 'product') {
            if (request()->segment(2) == 'generic') {
                $method = 'index';
            }
            $url =  'product/chemical';
        }
        if (!empty(request()->segment(1)) && request()->segment(1) == 'models') {
            if (request()->segment(2) == 'generic') {
                $method = 'index';
            }
            $url =  'models';
        }
        if (
            !empty(request()->segment(3)) && request()->segment(3) == 'view_configuration' || request()->segment(3) == 'view_exp_configuration' || request()->segment(3) == 'view_varition'
            || request()->segment(3) == 'view_associate_model' || request()->segment(3) == 'associate_model' || request()->segment(3) == 'view_dataset' || request()->segment(3) == 'dataset_list'
            || request()->segment(3) == 'view_datarequest'
        ) {
            $method = 'index';
            $url =  'experiment/experiment';
        }
        if (!empty(request()->segment(2)) && request()->segment(2) == 'process_diagram') {
            $method = 'index';
            $url =  'experiment/experiment';
        }
        $segment_array = array('addprop', 'manage', 'copy_to_knowledge', 'sim_config', 'property', 'exp_profile_master', 'getConfiguration');
        if (!empty(request()->segment(3)) && in_array(request()->segment(3), $segment_array)) {
            $method = 'manage';
        }
        if (!empty(request()->segment(4)) && in_array(request()->segment(4), $segment_array)) {
            if (request()->segment(4) == 'copy_to_knowledge') {
                $method = 'index';
            } else {
                $method = 'manage';
            }
        }
        if (!empty(request()->segment(5)) && in_array(request()->segment(5), $segment_array)) {
            if (request()->segment(5) == 'copy_to_knowledge') {
                $method = 'index';
            }
        }
        $user_menu = [];
        //$user_menu_id = 1;
        if (\Request::is('organization/*')) {
            if (Auth::user()->role == 'console' && !\Request::is('organization/profile')) {
                if (\Request::is('organization/profile/*')) {
                    $user_menu_id = 1;
                } else {
                    return redirect('/unauthorized');
                }
            } elseif (\Request::is('organization/vendor')) {
                $user_menu = UserMenu::where('menu_url', $url)->first();
                $user_menu_id = $user_menu->id;
            } else {
                $user_menu_id = 1;
                // $user_menu = UserMenu::where('menu_url', $url)->first();
                // $user_menu_id = $user_menu->id;
            }
        } else {
            $user_menu = UserMenu::where('menu_url', $url)->first();
            $user_menu_id = $user_menu->id;
        }
        // if (Auth::user()->role == 'admin') {
        $permissionEmp = UserPermission::where(['tenant_id' => $tenant_id, 'user_id' => Auth::user()->id, 'status' => 'active'])->first();
        // if( $permissionEmp->status=='acti'){
        // }
        // } else {
        //     $config = TenantConfig::where('tenant_id', $tenant_id)->first();
        //     $new_group = [];
        //     if (!empty($config->user_group)) {
        //         foreach ($config->user_group as $user_group) {
        //             if (in_array(Auth::user()->id, $user_group['users'])) {
        //                 $new_group = $user_group;
        //             }
        //         }
        //     }
        //     $group_id = !empty($new_group['id']) ? $new_group['id'] : '';
        //     $permissionEmp = UserPermission::where(['tenant_id' => $tenant_id, 'user_group_id' => $group_id])->first();
        // }
        $permissionEmpRole = !empty($permissionEmp->permission) ? $permissionEmp->permission : [];
        $menus_id = [];
        if (!empty($permissionEmpRole)) {
            foreach ($permissionEmpRole as $keys => $sub_perm) {
                foreach ($sub_perm as $sub_keys => $perm) {
                    $menus_id[] = $perm['menu_id'];
                    $perms[$keys]['menu_id'] = $perm['menu_id'];
                    if ($perm['menu_id'] == 1) {
                        $perms[$keys]['method'] = array("index", "create", "show", "edit", "delete", "manage", "store", "update", "kb", "copy_to_knowledge");
                    } else {
                        $manage = array('manage');
                        $perms[$keys]['method'] = array_merge($perm['method'], $manage);
                        $perms[$keys][$sub_keys]['method'] = array_merge($perm['method'], $manage);
                    }
                }
            }
        } else {
            return redirect('/unauthorized');
        }
        if ($method == 'destroy') {
            $method = 'delete';
        }
        if ($method == 'bulkDelete') {
            $method = 'delete';
        }
        if ($method == 'default_preference') {
            $method = 'store';
        }
        if ($method == 'show') {
            $method = 'index';
        }
        $tenant_config = TenantConfig::Select('id', 'menu_group')->where('tenant_id', $tenant_id)->first();
        $menu_group = $tenant_config->menu_group;
        if (empty($menus_id)) {
            if (!empty($menu_group['menu_list'])) {
                foreach ($menu_group['menu_list'] as $menu_key => $menu_list) {
                    $menus_id[] = $menu_list;
                    $perms[$menu_key]['menu_id'] = $menu_list;
                    if ($menu_list == 1) {
                        $perms[$menu_key]['method'] = array("index", "create", "show", "edit", "delete", "manage", "store", "update", "kb", "copy_to_knowledge");
                    } else {
                        $perms[$menu_key]['method'] = array("index", "create", "show", "edit", "delete", "manage", "store", "update", "kb", "copy_to_knowledge");
                    }
                }
            } else {
                $menus_id[] = 1;
                $perms[0]['menu_id'] = 1;
                $perms[0]['method'] = array('index');
            }
        }
        if (in_array($user_menu_id, $menus_id)) {
            foreach ($perms as $sub_keys => $val) {
                if ($val['menu_id'] == $user_menu_id) {
                    if (in_array($method, $val['method'])) {
                        if (Auth::user()->role == "admin" && empty($permissionEmpRole)) {
                            $vals['menu_id'] = $val['menu_id'];
                            $vals['properties']['method'] = array('create', 'edit', 'delete', 'index');
                            $request->merge(array("sub_menu_permission" => $vals));
                        } else {
                            $request->merge(array("sub_menu_permission" => $val));
                        }
                        return $next($request);
                    } else {
                        if ($request->ajax()) {
                            return response()->json([
                                'status' => true,
                                'modal' => true,
                                'redirect' => true,
                                'message' => "Permission Denied!",
                            ]);
                        }
                        return redirect('/unauthorized');
                    }
                }
            }
        } else {
            return redirect('/unauthorized');
        }
    }
}
