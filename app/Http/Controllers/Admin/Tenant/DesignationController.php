<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Users\Designation;
use App\Models\Tenant\TenantConfig;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    public function index($tenant_id)
    {
        $data = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        return view('pages.admin.tenant.designation.index', compact('data', 'tenant_id'));
    }

    public function create($tenant_id)
    {
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.tenant.designation.create', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->designation)) {
                foreach ($tenant->designation as $desig) {
                    $id = $desig['id'];
                }
                $designation[] = [
                    'id' => $id + 1,
                    'name' => $request->name,
                    'description' => $request->description,
                    'tags' => $request->tags,
                    'status' => 'active',
                ];
                $listData->designation = array_merge($tenant->designation, $designation);
            } else {
                $designation[] = [
                    'id' => 1,
                    'name' => $request->name,
                    'description' => $request->description,
                    'tags' => $request->tags,
                    'status' => 'active',
                ];
                $listData->designation = $designation;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/admin/tenant/' . $tenant_id . '/designation');
            $this->message = "Designation Added Successfully!";
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
                if ($desig['id'] == ___decrypt($id)) {
                    $designation['id'] = $desig['id'];
                    $designation['name'] = $desig['name'];
                    $designation['description'] = $desig['description'];
                    $designation['tags'] = isset($desig['tags']) ? $desig['tags'] : '';
                    $designation['status'] = !empty($desig['status']) ? $desig['status'] : 'active';
                }
            }
        }
        return view('pages.admin.tenant.designation.edit', compact('designation', 'tenant_id'));
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->designation)) {
                foreach ($tenant->designation as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['tags'] = isset($desig['tags']) ? $desig['tags'] : '';
                        $designation[$key]['status'] = $desig['status'];
                    } else {
                        $designation[$key]['id'] = ___decrypt($id);
                        $designation[$key]['name'] = $request->name;
                        $designation[$key]['description'] = $request->description;
                        $designation[$key]['tags'] = $request->tags;
                        $designation[$key]['status'] = $desig['status'];
                    }
                }
                $listData->designation = $designation;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
            $success = true;
            $message = "Designation Successfully Updated";
            $response = [
                'success' => $success,
                'message' => $message
            ];
            return response()->json($response, 200);
        }
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
            if (!empty($tenant->designation)) {
                $designation=[];
                foreach ($tenant->designation as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['tags'] = $desig['tags'];
                        $designation[$key]['status'] = $desig['status'];
                    } else {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['tags'] = $desig['tags'];
                        $designation[$key]['status'] = $status;
                    }
                }
                $listData->designation = $designation;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->designation)) {
                $designation = [];
                foreach ($tenant->designation as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['tags'] = $desig['tags'];
                        $designation[$key]['status'] = $desig['status'];
                    }
                }
                $listData->designation = $designation;
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
        if (!empty($listData->designation)) {
            foreach ($listData->designation as $key => $desig) {
                if (!in_array(___encrypt($desig['id']), $desig_ids)) {
                    $designation[$key]['id'] = $desig['id'];
                    $designation[$key]['name'] = $desig['name'];
                    $designation[$key]['description'] = $desig['description'];
                    $designation[$key]['tags'] = $desig['tags'];
                    $designation[$key]['status'] = $desig['status'];
                }
            }
            $listData->designation = $designation;
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
