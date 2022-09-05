<?php

namespace App\Http\Controllers\Console\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\TenantUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Organization\Users\UserPermission;
use App\Models\Tenant\TenantConfig;
use App\Models\UserMenu;
use App\User;

class UserPermissionController extends Controller
{
    public function index($tenant_id)
    {
        $user_permissions = UserPermission::where('tenant_id', ___decrypt($tenant_id))->where('user_group_id', '!=', '0')->get();
        $perm = [];
        if (!empty($user_permissions)) {
            foreach ($user_permissions as $key => $permission) {
                $perm[$key]['id'] = $permission->id;
                $perm[$key]['created_at'] = $permission->created_at;
                $perm[$key]['updated_at'] = $permission->updated_at;
                $perm[$key]['status'] = $permission->status;
                $perm[$key]['user_name'] = get_user_name($permission->user_id);
                $perm[$key]['designation'] = get_designation_user_group_location(___decrypt($tenant_id), $permission->designation_id, 'designation');
                $perm[$key]['user_group'] = get_designation_user_group_location(___decrypt($tenant_id), $permission->user_group_id, 'user_group');
            }
        }
        return view('pages.console.tenant.user_permission.index', compact('perm', 'tenant_id'));
    }

    public function create($tenant_id)
    {
        $where = 1;
        $where .= ' AND tenant_id =' . ___decrypt($tenant_id);
        $tenent_users = TenantUser::list('array', $where);
        // $user_data = [];
        // if (!empty($tenent_users)) {
        //     foreach ($tenent_users as $key => $users) {
        //         if (!empty($users['user_details'])) {
        //             $check_user = UserPermission::where(['user_id' => $users['user_details']['id'], 'tenant_id' => ___decrypt($tenant_id)])->first();
        //             if (empty($check_user)) {
        //                 $user_data[$key]['id'] = $users['user_details']['id'];
        //                 $user_data[$key]['first_name'] = $users['user_details']['first_name'];
        //                 $user_data[$key]['last_name'] = $users['user_details']['last_name'];
        //                 $user_data[$key]['email'] = $users['user_details']['email'];
        //             }
        //         }
        //     }
        // }
        $admin_users = User::where(['role' => 'admin', 'status' => 'active'])->get();
        if (!empty($admin_users)) {
            foreach ($admin_users as $key => $users) {
                $check_user = UserPermission::where(['user_id' => $users['id'], 'tenant_id' => ___decrypt($tenant_id)])->first();
                if (empty($check_user)) {
                    $admin_user[$key]['id'] = $users['id'];
                    $admin_user[$key]['first_name'] = $users['first_name'];
                    $admin_user[$key]['last_name'] = $users['last_name'];
                    $admin_user[$key]['email'] = $users['email'];
                }
            }
        }
        $data['admin_user'] = $admin_user;
        $config = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $user_group = [];
        if (!empty($config->user_group)) {
            foreach ($config->user_group as $key => $group_desig) {
                //  $check = UserPermission::where(['tenant_id'=>___decrypt($tenant_id),'user_group_id'=>$group_desig['id']])->first();
                //  if ($group_desig['status'] == 'active' && empty($check)) {
                $user_group[$key]['id'] = $group_desig['id'];
                $user_group[$key]['name'] = $group_desig['name'];
                // }
            }
        }
        $data['department'] = $user_group;
        $desg = [];
        if (!empty($config->designation)) {
            foreach ($config->designation as $k => $v) {
                if ($v['status'] == "active") {
                    $desg[$k]['id'] = $v['id'];
                    $desg[$k]['name'] = $v['name'];
                }
            }
        }
        $data['designation'] = $desg;
        $menu = UserMenu::where('parent_id', '=', 0)->get();
        $tenantMenuGroup =  $config->menu_group;
        $arr = [];
        $val = [];
        if (!empty($tenantMenuGroup)) {
            $arr = $tenantMenuGroup['menu_list'];
        }
        if (!empty($arr)) {
            $userMenu = UserMenu::whereIn('id', $arr)->get();
            $col = array_unique(array_column($userMenu->toArray(), 'parent_id'));
            $mrg = array_merge($arr, $col);
            $userMenu = UserMenu::where('parent_id', 0)->get();
            $submenu = [];
            foreach ($userMenu as $k => $v) {
                $ss = [];
                $usersubMenus = UserMenu::where('parent_id', $v['id'])->get();
                if (!empty($usersubMenus)) {
                    foreach ($usersubMenus as $sk => $sv) {
                        $ss[] = [
                            "id" => $sv->id,
                            "name" => $sv->name,
                            "sub_child_menus" => $sv->sub_menu,
                        ];
                    }
                }
                $submenu[] = [
                    "menu_id" => $v['id'],
                    "menu" => $v['name'],
                    "menu_icon" => $v['menu_icon'],
                    "submenu" => $ss,
                    "child_menus" => $v['sub_menu'],
                ];
            }
            $data['submenu'] = $submenu;
            $new[] = $data['submenu'][5];
            unset($data['submenu'][5]);
            $position = 3;
            array_splice($data['submenu'], $position, 0, $new);
            $new_e[] = $data['submenu'][4];
            unset($data['submenu'][4]);
            $position = 6;
            array_splice($data['submenu'], $position, 0, $new_e);
            if (!empty($data['submenu'])) {
                foreach ($data['submenu'] as $ak => $ap) {
                    if (in_array($ap['menu_id'], $mrg)) {
                        $val[] = $ap;
                    }
                }
            }
        }
        $data['value'] = $val;
        $data['menu_list'] = !empty($arr) ? $arr : [];
        return view('pages.console.tenant.user_permission.create', compact('data', 'tenant_id'));
    }

    public function store(Request $request, $tenant_id)
    {
        // if ($request->permission_type == 'group') {
        //     $validator = Validator::make($request->all(), [
        //         'permission_type' => 'required',
        //         'user_group_id' => 'required',
        //         'permission' => 'required',
        //     ]);
        // } else {
        $validator = Validator::make($request->all(), [
            //'permission_type' => 'required',
            'user_id' => 'required',
            'permission' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            // if ($request->permission_type == 'group') {
            //     $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            //     $user_group = [];
            //     if (!empty($tenant->user_group)) {
            //         foreach ($tenant->user_group as $key => $desig) {
            //             if ($desig['id'] == ___decrypt($request->user_group_id)) {
            //                 $user_group['users'] = !empty($desig['users']) ? $desig['users'] : [];
            //             }
            //         }
            //     }
            // } else {
            foreach ($request->user_id as $user_id) {
                $new_user[] = ___decrypt($user_id);
            }
            $user_group['users'] = $new_user;
            //}
            if (!empty($user_group['users'])) {
                foreach ($user_group['users'] as $user_id) {
                    $employeeData = new UserPermission();
                    $employeeData->tenant_id = ___decrypt($tenant_id);
                    $employeeData->user_id = $user_id;
                    // if ($request->permission_type == 'group') {
                    $employeeData->user_group_id = !empty($request->user_group_id) ? ___decrypt($request->user_group_id) : 0;
                    // } else {
                    //     $employeeData->user_group_id = 0;
                    // }
                    $employeeData->designation_id = 1;
                    $employeeData->description = isset($request->description) ? $request->description : "";
                    $employeeData->created_by = Auth::user()->id;
                    $employeeData->updated_by = Auth::user()->id;
                    $i = 0;
                    foreach ($request->permission as $key => $permission) {
                        foreach ($permission as $sub_key => $perm) {
                            $val_keys = array_keys($perm, 'on');
                            if (in_array('create', $val_keys)) {
                                $method_arr = array('store', 'update', 'index');
                            } else {
                                $method_arr = array('update', 'index');
                            }
                            $men = array_unique(array_merge($val_keys, $method_arr));
                            $menus[$key][$sub_key]['menu_id'] = $key;
                            $menus[$key][$sub_key]['method'] = $men;
                        }
                        $i++;
                    }
                    $employeeData->permission = $menus;
                    $employeeData->status = 'active';
                    $employeeData->save();
                }
            }
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/' . $tenant_id . '/user_permission');
            $this->message = "User Permission Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($tenant_id, $id)
    {
    }

    public function edit($tenant_id, $id)
    {
        $permissions = UserPermission::find(___decrypt($id));
        $where = 1;
        $where .= ' AND tenant_id =' . ___decrypt($tenant_id);
        $tenent_users = TenantUser::list('array', $where);
        $user_data = [];
        if (!empty($tenent_users)) {
            foreach ($tenent_users as $key => $users) {

                $user_data[$key]['id'] = $users['user_details']['id'];
                $user_data[$key]['first_name'] = $users['user_details']['first_name'];
                $user_data[$key]['last_name'] = $users['user_details']['last_name'];
                $user_data[$key]['email'] = $users['user_details']['email'];
            }
        }
        $admin_users = User::where('status', 'active')->get();
        if (!empty($tenent_users)) {
            foreach ($admin_users as $key => $users) {
                $admin_user[$key]['id'] = $users['id'];
                $admin_user[$key]['first_name'] = $users['first_name'];
                $admin_user[$key]['last_name'] = $users['last_name'];
                $admin_user[$key]['email'] = $users['email'];
            }
        }
        $data['user'] = $user_data;
        $data['admin_user'] = $admin_user;
        $config = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $data['department'] = $config->user_group;
        $desg = [];
        if (!empty($config->designation)) {
            foreach ($config->designation as $k => $v) {
                if ($v['status'] == "active") {
                    $desg[$k]['id'] = $v['id'];
                    $desg[$k]['name'] = $v['name'];
                }
            }
        }
        $data['designation'] = $desg;
        $menu = UserMenu::where('parent_id', '=', 0)->get();
        $tenantMenuGroup =  $config->menu_group;
        $arr = [];
        $val = [];
        if (!empty($tenantMenuGroup)) {
            $arr = $tenantMenuGroup['menu_list'];
        }
        if (!empty($arr)) {
            $userMenu = UserMenu::whereIn('id', $arr)->get();
            $col = array_unique(array_column($userMenu->toArray(), 'parent_id'));
            $mrg = array_merge($arr, $col);
            $userMenu = UserMenu::where('parent_id', 0)->get();
            $submenu = [];
            foreach ($userMenu as $k => $v) {
                $ss = [];
                $usersubMenus = UserMenu::where('parent_id', $v['id'])->get();
                if (!empty($usersubMenus)) {
                    foreach ($usersubMenus as $sk => $sv) {
                        $ss[] = [
                            "id" => $sv->id,
                            "name" => $sv->name,
                            "sub_child_menus" => $sv->sub_menu,
                        ];
                    }
                }
                $submenu[] = [
                    "menu_id" => $v['id'],
                    "menu" => $v['name'],
                    "menu_icon" => $v['menu_icon'],
                    "submenu" => $ss,
                    "child_menus" => $v['sub_menu'],
                ];
            }
            $data['submenu'] = $submenu;
            $new[] = $data['submenu'][5];
            unset($data['submenu'][5]);
            $position = 3;
            array_splice($data['submenu'], $position, 0, $new);
            $new_e[] = $data['submenu'][4];
            unset($data['submenu'][4]);
            $position = 6;
            array_splice($data['submenu'], $position, 0, $new_e);
            if (!empty($data['submenu'])) {
                foreach ($data['submenu'] as $ak => $ap) {
                    if (in_array($ap['menu_id'], $mrg)) {
                        $val[] = $ap;
                    }
                }
            }
        }
        $data['value'] = $val;
        $data['menu_list'] = !empty($arr) ? $arr : [];
        if (!empty($permissions->permission)) {
            foreach ($permissions->permission as $keys => $sub_perm) {
                foreach ($sub_perm as $sub_keys => $perm) {
                    $menus_id[] = $perm['menu_id'];
                    $user_perms[$keys]['menu_id'] = $perm['menu_id'];
                    $user_perms[$keys][$sub_keys]['method'] = $perm['method'];
                }
            }
        }
        return view('pages.console.tenant.user_permission.edit', compact('data', 'tenant_id', 'permissions', 'user_perms'));
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nulable',
            // 'department_id' => 'required',
            // 'designation_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $employeeData =  UserPermission::find(___decrypt($id));
            $employeeData->description = isset($request->description) ? $request->description : "";
            $employeeData->updated_by = now();
            $employeeData->updated_by = Auth::user()->id;
            $i = 0;
            foreach ($request->permission as $key => $permission) {
                //if ($key == 2 || $key == 9) {
                foreach ($permission as $sub_key => $perm) {
                    $val_keys = array_keys($perm, 'on');
                    if (in_array('create', $val_keys)) {
                        $method_arr = array('store', 'update', 'index');
                    } else {
                        $method_arr = array('update', 'index');
                    }
                    $men = array_unique(array_merge($val_keys, $method_arr));
                    $menus[$key][$sub_key]['menu_id'] = $key;
                    $menus[$key][$sub_key]['method'] = $men;
                }
                // } else {
                //     $val_keys = array_keys($permission, 'on');
                //     if (in_array('create', $val_keys)) {
                //         $method_arr = array('store', 'update', 'index');
                //     } else {
                //         $method_arr = array('update', 'index');
                //     }
                //     $men = array_unique(array_merge($val_keys, $method_arr));
                //     $menus[$key]['profile']['menu_id'] = $key;
                //     $menus[$key]['profile']['method'] = $men;
                // }
                $i++;
            }
            $employeeData->permission = $menus;
            $employeeData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/' . $tenant_id . '/user_permission');
            $this->message = "User Permission Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $tenant_id, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } elseif ($request->status == 'pending') {
                $status = 'active';
            } else {
                $status = 'active';
            }
            $update = UserPermission::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (UserPermission::where('id', ___decrypt($id))->update($update)) {
                UserPermission::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request, $tenant_id)
    {
        $id_string = implode(',', $request->bulk);
        $processID = explode(',', ($id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (UserPermission::whereIn('id', $processIDS)->update($update)) {
            UserPermission::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function group_user_list(Request $request, $tenant_id)
    {
        $group_id = !empty($request->parameters) ? ___decrypt($request->parameters) : '';
        $config = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $user_arr = [];
        if (!empty($config->user_group)) {
            foreach ($config->user_group as $key => $group_desig) {
                if ($group_id == $group_desig['id']) {
                    $users = User::whereIn('id', $group_desig['users'])->get();
                    foreach ($users as $key => $user) {
                        $check = UserPermission::where(['tenant_id' => ___decrypt($tenant_id), 'user_group_id' => $group_desig['id'], 'user_id' => $user['id']])->first();
                        if (empty($check)) {
                            $user_arr[$key]['id'] = $user['id'];
                            $user_arr[$key]['name'] = $user['first_name'] . ' ' . $user['last_name'];
                        }
                    }
                }
            }
        }
        return response()->json([
            'status' => true,
            'html' => view('pages.console.tenant.user_permission.user_list', ['user_arr' => $user_arr, 'tenant_id' => $tenant_id])->render()
        ]);
    }
}
