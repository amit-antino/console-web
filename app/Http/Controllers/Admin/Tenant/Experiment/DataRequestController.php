<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use App\Models\ProcessExperiment\DataRequestModel;
use Illuminate\Http\Request;

class DataRequestController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['datsets'] = DataRequestModel::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = ___decrypt($tenant_id);
        return view('pages.admin.tenant.datarequest', $data);
    }

    public function destroy(Request $request, $tenant_id, $id)
    {
        if (!empty($request->status)) {
            DataRequestModel::where('id', ___decrypt($id))->update(['status' => $request->status]);
        } elseif (!empty($request->operation_status)) {
            if ($request->operation_status == 'active') {
                $operation_status = 'inactive';
            } else {
                $operation_status = 'active';
            }
            DataRequestModel::where('id', ___decrypt($id))->update(['operation_status' => $operation_status]);
        } else {
            DataRequestModel::find(___decrypt($id))->delete();
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/models');
        return $this->populateresponse();
    }
}
