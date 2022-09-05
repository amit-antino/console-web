<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use App\Models\Models\ModelDetail;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['models'] = ModelDetail::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = ___decrypt($tenant_id);
        return view('pages.admin.tenant.model', $data);
    }
    
    public function destroy(Request $request, $tenant_id, $id)
    {
        if (!empty($request->status)) {
            ModelDetail::where('id', ___decrypt($id))->update(['status' => $request->status]);
        } elseif (!empty($request->operation_status)) {
            if ($request->operation_status == 'active') {
                $operation_status = 'inactive';
            } else {
                $operation_status = 'active';
            }
            ModelDetail::where('id', ___decrypt($id))->update(['operation_status' => $operation_status]);
        } else {
            ModelDetail::find(___decrypt($id))->delete();
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/models');
        return $this->populateresponse();
    }
}
