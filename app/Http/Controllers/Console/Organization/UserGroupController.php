<?php

namespace App\Http\Controllers\Console\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Users\Department;
use App\Models\Tenant\TenantConfig;
use App\Models\Tenant\TenantUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserGroupController extends Controller
{
    public function index($tenant_id)
    {
        $data = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        return view('pages.console.tenant.user_group.index', compact('data', 'tenant_id'));
    }

    public function create($tenant_id)
    {
        $data['tenant_id'] = $tenant_id;
        $where = 1;
        $where .= ' AND tenant_id =' . ___decrypt($tenant_id);
        $tenent_users = TenantUser::list('array', $where);
        $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $designation = [];
        if (!empty($tenant->designation)) {
            foreach ($tenant->designation as $key => $desig) {
                if ($desig['status'] == 'active') {
                    $designation[$key]['id'] = $desig['id'];
                    $designation[$key]['name'] = $desig['name'];
                }
            }
        }
        $data['designation'] = $designation;
        $user_group = [];
        $key = 0;
        if (!empty($tenant->user_group)) {
            foreach ($tenant->user_group as  $desig) {
                if (!empty($desig['users'])) {
                    foreach ($desig['users'] as $user) {
                        $user_group[] = $user;
                    }
                }
            }
        }
        $user_data = [];
        if (!empty($tenent_users)) {
            foreach ($tenent_users as $key => $users) {
                if (!empty($users['user_details'])) {
                    if (!in_array($users['user_details']['id'], $user_group)) {
                        $user_data[$key]['id'] = $users['user_details']['id'];
                        $user_data[$key]['first_name'] = $users['user_details']['first_name'];
                        $user_data[$key]['last_name'] = $users['user_details']['last_name'];
                        $user_data[$key]['email'] = $users['user_details']['email'];
                    }
                }
            }
        }
        $data['users'] = $user_data;
        return view('pages.console.tenant.user_group.create', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'users' => 'required',
            // 'designation' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            $users = [];
            if (!empty($request->users)) {
                foreach ($request->users as $user) {
                    $users[] = ___decrypt($user);
                }
            }
            if (!empty($tenant->user_group)) {
                foreach ($tenant->user_group as $desig) {
                    $id = $desig['id'];
                }
                $user_group[] = [
                    'id' => $id + 1,
                    'designation' => !empty($request->designation) ? ___decrypt($request->designation) : 0,
                    'name' => $request->name,
                    'users' => $users,
                    'description' => $request->description,
                    'status' => 'active',
                ];
                $listData->user_group = array_merge($tenant->user_group, $user_group);
            } else {
                $user_group[] = [
                    'id' => 1,
                    'designation' => !empty($request->designation) ? ___decrypt($request->designation) : 0,
                    'name' => $request->name,
                    'users' => $users,
                    'description' => $request->description,
                    'status' => 'active',
                ];
                $listData->user_group = $user_group;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/' . $tenant_id . '/user_group');
            $this->message = "User Group Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($tenant_id, $id)
    {
    }

    public function edit($tenant_id, $id)
    {
        $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $designation = [];
        if (!empty($tenant->designation)) {
            foreach ($tenant->designation as $key => $desig) {
                if ($desig['status'] == 'active') {
                    $designation[$key]['id'] = $desig['id'];
                    $designation[$key]['name'] = $desig['name'];
                }
            }
        }
        $user_group = [];
        if (!empty($tenant->user_group)) {
            foreach ($tenant->user_group as $key => $desig) {
                if ($desig['id'] == ___decrypt($id)) {
                    $user_group['id'] = $desig['id'];
                    $user_group['designation'] = !empty($desig['designation']) ? $desig['designation'] : '';
                    $user_group['name'] = $desig['name'];
                    $user_group['users'] = !empty($desig['users']) ? $desig['users'] : [];
                    $user_group['description'] = $desig['description'];
                    $user_group['status'] = $desig['status'];
                }
            }
        }
        $where = 1;
        $where .= ' AND tenant_id =' . ___decrypt($tenant_id);
        $tenent_users = TenantUser::list('array', $where);
        $user_data = [];
        if (!empty($tenent_users)) {
            foreach ($tenent_users as $key => $users) {
                if (!empty($users['user_details'])) {
                    $user_data[$key]['id'] = $users['user_details']['id'];
                    $user_data[$key]['first_name'] = $users['user_details']['first_name'];
                    $user_data[$key]['last_name'] = $users['user_details']['last_name'];
                    $user_data[$key]['email'] = $users['user_details']['email'];
                }
            }
        }
        $user_group_new = [];
        $key = 0;
        if (!empty($tenant->user_group)) {
            foreach ($tenant->user_group as  $desig) {
                if ($desig['id'] != ___decrypt($id)) {
                    if (!empty($desig['users'])) {
                        foreach ($desig['users'] as $user) {
                            $user_group_new[] = $user;
                        }
                    }
                }
            }
        }
        $user_data = [];
        if (!empty($tenent_users)) {
            foreach ($tenent_users as $key => $users) {
                if (!empty($users['user_details'])) {
                    if (!in_array($users['user_details']['id'], $user_group_new)) {
                        $user_data[$key]['id'] = $users['user_details']['id'];
                        $user_data[$key]['first_name'] = $users['user_details']['first_name'];
                        $user_data[$key]['last_name'] = $users['user_details']['last_name'];
                        $user_data[$key]['email'] = $users['user_details']['email'];
                    }
                }
            }
        }
        $users = $user_data;
        return view('pages.console.tenant.user_group.edit', compact('user_group', 'tenant_id', 'users', 'designation'));
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'users' => 'required',
            // 'designation' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->user_group)) {
                foreach ($tenant->user_group as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $user_group[$key]['id'] = $desig['id'];
                        $user_group[$key]['designation'] = !empty($desig['designation']) ? $desig['designation'] : '';
                        $user_group[$key]['name'] = $desig['name'];
                        $user_group[$key]['users'] = !empty($desig['users']) ? $desig['users'] : [];
                        $user_group[$key]['description'] = $desig['description'];
                        $user_group[$key]['status'] = $desig['status'];
                    } else {
                        $users = [];
                        if (!empty($request->users)) {
                            foreach ($request->users as $user) {
                                $users[] = ___decrypt($user);
                            }
                        }
                        $user_group[$key]['id'] = ___decrypt($id);
                        $user_group[$key]['designation'] = !empty($request->designation) ? ___decrypt($request->designation) : 0;
                        $user_group[$key]['name'] = $request->name;
                        $user_group[$key]['users'] = $users;
                        $user_group[$key]['description'] = $request->description;
                        $user_group[$key]['status'] = $request->status;
                    }
                }
                $listData->user_group = $user_group;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/' . $tenant_id . '/user_group');
            $this->message = "User Group Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $tenant_id, $id)
    {
        $user_group = [];
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->user_group)) {
                foreach ($tenant->user_group as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $user_group[$key]['id'] = $desig['id'];
                        $user_group[$key]['designation'] = !empty($desig['designation']) ? $desig['designation'] : '';
                        $user_group[$key]['name'] = $desig['name'];
                        $user_group[$key]['users'] = !empty($desig['users']) ? $desig['users'] : [];
                        $user_group[$key]['description'] = $desig['description'];
                        $user_group[$key]['status'] = $desig['status'];
                    } else {
                        $user_group[$key]['id'] = $desig['id'];
                        $user_group[$key]['designation'] = !empty($desig['designation']) ? $desig['designation'] : '';
                        $user_group[$key]['name'] = $desig['name'];
                        $user_group[$key]['users'] = !empty($desig['users']) ? $desig['users'] : [];
                        $user_group[$key]['description'] = $desig['description'];
                        $user_group[$key]['status'] = $status;
                    }
                }

                $listData->user_group = $user_group;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
        } else {

            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->user_group)) {
                foreach ($tenant->user_group as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $user_group[$key]['id'] = $desig['id'];
                        $user_group[$key]['designation'] = !empty($desig['designation']) ? $desig['designation'] : '';
                        $user_group[$key]['name'] = $desig['name'];
                        $user_group[$key]['users'] = !empty($desig['users']) ? $desig['users'] : [];
                        $user_group[$key]['description'] = $desig['description'];
                        $user_group[$key]['status'] = $desig['status'];
                    }
                }
                $listData->user_group = $user_group;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
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
        if (Department::whereIn('id', $processIDS)->update($update)) {
            Department::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
