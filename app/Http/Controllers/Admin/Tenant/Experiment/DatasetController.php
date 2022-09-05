<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use App\Models\ProcessExperiment\DatasetModel;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['datsets'] = DatasetModel::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = ___decrypt($tenant_id);
        return view('pages.admin.tenant.dataset', $data);
    }
    
    public function destroy(Request $request, $tenant_id, $id)
    {
        if (!empty($request->status)) {
            DatasetModel::where('id', ___decrypt($id))->update(['status' => $request->status]);
        } elseif (!empty($request->operation_status)) {
            if ($request->operation_status == 'active') {
                $operation_status = 'inactive';
            } else {
                $operation_status = 'active';
            }
            DatasetModel::where('id', ___decrypt($id))->update(['operation_status' => $operation_status]);
        } else {
            DatasetModel::find(___decrypt($id))->delete();
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/models');
        return $this->populateresponse();
    }
}
