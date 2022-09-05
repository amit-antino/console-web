<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tenant\Tenant;
use App\Models\Tenant\TenantConfig;
use App\Models\Tenant\TenantMenuGroup;
use App\Models\UserMenu;

class RoleController extends Controller
{
    public function index($id)
    {
        $data['tenant'] =  Tenant::with([
            'tenant_config' => function ($q) {
                $q->select('id', 'tenant_id', 'menu_group');
            }
        ])->where('id', ___decrypt($id))->first();
        return view('pages.admin.tenant.role.index', $data);
    }

    public function create($id)
    {
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
        $data['tenant'] =  Tenant::where('id', ___decrypt($id))->first();
        $data['submenu'] = $submenu;
        return view('pages.admin.tenant.role.create', $data);
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'menu_list' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $menu_group['id'] = 1;
            $menu_group['name'] = $request->name;
            $menu_group['menu_list'] = $request->menu_list;
            $menu_group['description'] = $request->description;
            $menu_group['status'] = 'active';
            $data['menu_group'] = $menu_group;
            TenantConfig::where('tenant_id', ___decrypt($id))->update($data);
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $id . '/role');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
    }

    public function edit($id, $role_id)
    {
        $data['tenant'] =  Tenant::where('id', ___decrypt($id))->first();
        $config = TenantConfig::where('tenant_id', ___decrypt($id))->first();
        $data['role'] =  $config->menu_group;
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
        return view('pages.admin.tenant.role.edit', $data);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'menu_list' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $model =  TenantMenuGroup::find(___decrypt($id));
            $model['name'] = $request->name;
            $model['menu_list'] = $request->menu_list;
            $model['description'] = $request->description;
            $model->save();
            $this->status = true;
            $this->modal    = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/role');
            $this->message  = " Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $tenant_id, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            TenantMenuGroup::where('id', ___decrypt($id))->update(['status' => $status]);
        } else {
            TenantMenuGroup::find(___decrypt($id))->delete();
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/role');
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request, $id)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        TenantMenuGroup::destroy($processIDS);
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $id . '/role');
        return $this->populateresponse();
    }
}
