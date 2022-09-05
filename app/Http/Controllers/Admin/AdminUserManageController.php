<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Users\UserPermission;
use App\Models\Tenant\Tenant;
use App\Models\Tenant\TenantConfig;
use Illuminate\Support\Facades\Validator;
use App\Models\UserMenu;
use App\User;
use App\Models\Tenant\TenantMenuGroup;
use Illuminate\Support\Facades\Auth;

class AdminUserManageController extends Controller
{
    public function index($user_id)
    {
        $data['roles'] = UserPermission::list('array');
        $data['user_id'] = ___decrypt($user_id);

        return view('pages.admin.admin_user.manage.index', $data);
    }

    public function edit($user_id, $id)
    {
        $where = "id  = " . ___decrypt($id);
        $data['roles'] = UserPermission::list('single', $where);
        $data['user_id'] = ___decrypt($user_id);
        $data['tenant_id'] = $data['roles']['tenant_id'];
        $data['tenants'] = Tenant::get();
        $data['user'] = User::where('status', 'active')->get();
        $tenantMenuGroup =  TenantMenuGroup::where('tenant_id', $data['roles']['tenant_id'])->first();
        $permission = [];
        if (!empty($data['roles']->permission)) {
            foreach ($data['roles']->permission as $pk => $pv) {
                $permission[$pv['menu_id']] = $pv['method'];
            }
        }
        $data['permission'] = $permission;
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
                            "name" => $sv->name
                        ];
                    }
                }
                $submenu[] = [
                    "menu_id" => $v['id'],
                    "menu" => $v['name'],
                    "menu_icon" => $v['menu_icon'],
                    "submenu" => $ss
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
        return view('pages.admin.admin_user.manage.edit', compact('data'));
    }

    public function create($tenant_id)
    {
        $data['tenant_id'] = ___decrypt($tenant_id);
        $data['user'] = User::where(['status' => 'active', 'role' => 'admin'])->get();
        $data['tenants'] = Tenant::get();
        $config =  TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $tenantMenuGroup = $config->menu_group;
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
                            "name" => $sv->name
                        ];
                    }
                }
                $submenu[] = [
                    "menu_id" => $v['id'],
                    "menu" => $v['name'],
                    "menu_icon" => $v['menu_icon'],
                    "submenu" => $ss
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
        return view('pages.admin.admin_user.manage.create', compact('data'));
    }

    public function store(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'tenant_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $adminRole = new UserPermission();
            $adminRole->user_id = ___decrypt($request->user_id);
            $adminRole->tenant_id = ___decrypt($request->tenant_id);
            $adminRole->department_id = 0;
            $adminRole->designation_id = 0;
            $adminRole->created_by = Auth::user()->id;
            $adminRole->updated_by = Auth::user()->id;
            $i = 0;
            foreach ($request->permission as $key => $permission) {
                $val_keys = array_keys($permission, 'on');
                if (in_array('create', $val_keys)) {
                    $method_arr = array('store', 'update', 'index');
                } else {
                    $method_arr = array('update', 'index');
                }
                $men = array_unique(array_merge($val_keys, $method_arr));
                $menus[$i]['menu_id'] = $key;
                $menus[$i]['method'] = $men;
                $i++;
            }
            $adminRole->permission = $menus;
            $adminRole->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/admin_users/' . $user_id . '/manage');
            $this->message = "Employee Added Successfully!";
        }
        return $this->populateresponse();
    }

    function getmenu(Request $request)
    {
        $tenantMenuGroup =  TenantMenuGroup::where('tenant_id', ___decrypt($request->id))->first();
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
                            "name" => $sv->name
                        ];
                    }
                }
                $submenu[] = [
                    "menu_id" => $v['id'],
                    "menu" => $v['name'],
                    "menu_icon" => $v['menu_icon'],
                    "submenu" => $ss
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
        return view('pages.admin.admin_user.manage.menulist')->with(compact('data'))->render();
    }

    public function update(Request $request, $user_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'tenant_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $AdminRole =  UserPermission::find(___decrypt($id));
            $AdminRole->user_id = ___decrypt($request->user_id);
            $AdminRole->tenant_id = ___decrypt($request->tenant_id);
            $AdminRole->updated_by = Auth::user()->id;
            $i = 0;
            foreach ($request->permission as $key => $permission) {
                $val_keys = array_keys($permission, 'on');
                if (in_array('create', $val_keys)) {
                    $method_arr = array('store', 'update', 'index');
                } else {
                    $method_arr = array('update', 'index');
                }
                $men = array_unique(array_merge($val_keys, $method_arr));
                $menus[$i]['menu_id'] = $key;
                $menus[$i]['method'] = $men;
                $i++;
            }
            $AdminRole->permission = $menus;
            $AdminRole->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/admin_users/' . $user_id . '/manage');
            $this->message = "Admin Role Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $id)
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
}
