<?php

namespace App\Http\Controllers\Admin\Master\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\TenantMasterPlan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $data['plan'] = TenantMasterPlan::get();
        return view('pages.admin.master.tenant.plan.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $plan =  new TenantMasterPlan();
            $plan['name'] = $request->name;
            $plan['description'] = $request->description;
            $plan['created_by'] = Auth::user()->id;
            $plan['updated_by'] = Auth::user()->id;
            $plan->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/tenant/plan');
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
            $update = TenantMasterPlan::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (TenantMasterPlan::where('id', ___decrypt($id))->update($update)) {
                TenantMasterPlan::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/tenant/plan');
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
        if (TenantMasterPlan::whereIn('id', $processIDS)->update($update)) {
            TenantMasterPlan::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/tenant/plan');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $cat = TenantMasterPlan::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.tenant.plan.edit', ['cat' => $cat])->render()
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
            $type =  TenantMasterPlan::find(___decrypt($id));
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
