<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\TenantConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CalcServerController extends Controller
{
    public function index($tenant_id)
    {
        $data = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        return view('pages.admin.tenant.calc_server.index', compact('data', 'tenant_id'));
    }

    public function create($tenant_id)
    {
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.tenant.calc_server.create', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        //$regex = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
        $validator = Validator::make($request->all(), [
            'server_type' => 'required',
            'name' => 'required',
            'version' => 'required',
            //'calc_url' => 'required|regex:' . $regex,
            'calc_url' => 'required|url',



        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->calc_server)) {
                foreach ($tenant->calc_server as $desig) {
                    $id = $desig['id'];
                }
                $designation[] = [
                    'id' => $id + 1,
                    'name' => $request->name,
                    'server_type' => $request->server_type,
                    'calc_url' => $request->calc_url,
                    'version' => $request->version,
                    'description' => $request->description,
                    'tags' => $request->tags,
                    'status' => 'active',
                ];
                $listData->calc_server = array_merge($tenant->calc_server, $designation);
            } else {
                $designation[] = [
                    'id' => 1,
                    'name' => $request->name,
                    'server_type' => $request->server_type,
                    'calc_url' => $request->calc_url,
                    'version' => $request->version,
                    'description' => $request->description,
                    'tags' => $request->tags,
                    'status' => 'active',
                ];
                $listData->calc_server = $designation;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/admin/tenant/' . $tenant_id . '/calc_url');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($tenant_id, $id)
    {
    }

    public function edit($tenant_id, $id)
    {
        $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $calc = [];
        if (!empty($tenant->calc_server)) {
            foreach ($tenant->calc_server as $key => $desig) {
                if ($desig['id'] == ___decrypt($id)) {
                    $calc['id'] = $desig['id'];
                    $calc['name'] = $desig['name'];
                    $calc['server_type'] = $desig['server_type'];
                    $calc['calc_url'] = $desig['calc_url'];
                    $calc['version'] = $desig['version'];
                    $calc['description'] = $desig['description'];
                    $calc['tags'] = isset($desig['tags']) ? $desig['tags'] : '';
                    $calc['status'] = !empty($desig['status']) ? $desig['status'] : 'active';
                }
            }
        }
        return view('pages.admin.tenant.calc_server.edit', compact('calc', 'tenant_id'));
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'server_type' => 'required',
            'name' => 'required',
            'version' => 'required',
            'calc_url' => 'required|url',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->calc_server)) {
                foreach ($tenant->calc_server as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['server_type'] = $desig['server_type'];
                        $designation[$key]['calc_url'] = $desig['calc_url'];
                        $designation[$key]['version'] = $desig['version'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['tags'] = isset($desig['tags']) ? $desig['tags'] : '';
                        $designation[$key]['status'] = $desig['status'];
                    } else {
                        $designation[$key]['id'] = ___decrypt($id);
                        $designation[$key]['name'] = $request->name;
                        $designation[$key]['server_type'] = $request->server_type;
                        $designation[$key]['calc_url'] = $request->calc_url;
                        $designation[$key]['version'] = $request->version;
                        $designation[$key]['description'] = $request->description;
                        $designation[$key]['tags'] = $request->tags;
                        $designation[$key]['status'] = $desig['status'];
                    }
                }
                $listData->calc_server = $designation;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
            $success = true;
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/admin/tenant/' . $tenant_id . '/calc_url');
            $this->message = "Updated Successfully!";
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
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->calc_server)) {
                foreach ($tenant->calc_server as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['server_type'] = $desig['server_type'];
                        $designation[$key]['calc_url'] = $desig['calc_url'];
                        $designation[$key]['version'] = $desig['version'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['tags'] = $desig['tags'];
                        $designation[$key]['status'] = $desig['status'];
                    } else {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['server_type'] = $desig['server_type'];
                        $designation[$key]['calc_url'] = $desig['calc_url'];
                        $designation[$key]['version'] = $desig['version'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['tags'] = $desig['tags'];
                        $designation[$key]['status'] = $status;
                    }
                }
                $listData->calc_server = $designation;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->calc_server)) {
                foreach ($tenant->calc_server as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['server_type'] = $desig['server_type'];
                        $designation[$key]['calc_url'] = $desig['calc_url'];
                        $designation[$key]['version'] = $desig['version'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['tags'] = $desig['tags'];
                        $designation[$key]['status'] = $desig['status'];
                    }
                }
                $listData->calc_server = $designation;
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
        $desig_ids = explode(',', ($id_string));
        $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $listData =  TenantConfig::find($tenant->id);
        $designation = [];
        if (!empty($listData->calc_server)) {
            foreach ($listData->calc_server as $key => $desig) {
                if (!in_array(___encrypt($desig['id']), $desig_ids)) {
                    $designation[$key]['id'] = $desig['id'];
                    $designation[$key]['name'] = $desig['name'];
                    $designation[$key]['server_type'] = $desig['server_type'];
                    $designation[$key]['calc_url'] = $desig['calc_url'];
                    $designation[$key]['version'] = $desig['version'];
                    $designation[$key]['description'] = $desig['description'];
                    $designation[$key]['tags'] = $desig['tags'];
                    $designation[$key]['status'] = $desig['status'];
                }
            }
            $listData->calc_server = $designation;
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
