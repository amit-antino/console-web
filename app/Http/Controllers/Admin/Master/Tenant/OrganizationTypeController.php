<?php

namespace App\Http\Controllers\Admin\Master\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\TenantMasterType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OrganizationTypeController extends Controller
{
    public function index()
    {
        $data['type'] = TenantMasterType::get();
        return view('pages.admin.master.tenant.type.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $type =  new TenantMasterType();
            $type['name'] = $request->name;
            $type['description'] = $request->description;
            $type['created_by'] = Auth::user()->id;
            $type['updated_by'] = Auth::user()->id;
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/tenant/organization_type');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = TenantMasterType::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (TenantMasterType::where('id', ___decrypt($id))->update($update)) {
                TenantMasterType::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/tenant/organization_type');
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (TenantMasterType::whereIn('id', $processIDS)->update($update)) {
            TenantMasterType::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/tenant/organization_type');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $cat = TenantMasterType::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.tenant.type.edit', ['cat' => $cat])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $type =  TenantMasterType::find(___decrypt($id));
            $type['name'] = $request->name;
            $type['description'] = $request->description;
            $type['updated_by'] = Auth::user()->id;
            $type['updated_at'] = now();
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
