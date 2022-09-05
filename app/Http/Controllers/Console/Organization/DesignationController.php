<?php

namespace App\Http\Controllers\Console\Organization;

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
        return view('pages.console.tenant.designation.index', compact('data', 'tenant_id'));
    }

    public function create($tenant_id)
    {
        $data['tenant_id'] = $tenant_id;
        return view('pages.console.tenant.designation.create', $data);
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
                    'status' => 'active',
                ];
                $listData->designation = array_merge($tenant->designation, $designation);
            } else {
                $designation[] = [
                    'id' => 1,
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => 'active',
                ];
                $listData->designation = $designation;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/' . $tenant_id . '/designation');
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
                    $designation['status'] = $desig['status'];
                }
            }
        }
        return view('pages.console.tenant.designation.edit', compact('designation', 'tenant_id'));
    }

    public function update(Request $request, $tenant_id, $id)
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
                foreach ($tenant->designation as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['status'] = $desig['status'];
                    } else {
                        $designation[$key]['id'] = ___decrypt($id);
                        $designation[$key]['name'] = $request->name;
                        $designation[$key]['description'] = $request->description;
                        $designation[$key]['status'] = $request->status;
                    }
                }

                $listData->designation = $designation;
            }

            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/' . $tenant_id . '/designation');
            $this->message = "Designation Updated Successfully.";
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
            if (!empty($tenant->designation)) {
                foreach ($tenant->designation as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['description'] = $desig['description'];
                        $designation[$key]['status'] = $desig['status'];
                    } else {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['description'] = $desig['description'];
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
                foreach ($tenant->designation as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $designation[$key]['id'] = $desig['id'];
                        $designation[$key]['name'] = $desig['name'];
                        $designation[$key]['description'] = $desig['description'];
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
        $processID = explode(',', ($id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_at'] = now();
        $update['updated_by'] = Auth::user()->id;
        if (Designation::whereIn('id', $processIDS)->update($update)) {
            Designation::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
