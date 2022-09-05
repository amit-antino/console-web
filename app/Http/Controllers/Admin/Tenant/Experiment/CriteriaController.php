<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experiment\CriteriaMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CriteriaController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['criteria'] = CriteriaMaster::where(['status' => 'active'])->get();
        $data['tenant_id'] = $tenant_id;
        $criteria_props = [];
        foreach ($data['criteria'] as $criteria) {
            $criteria_props[] = [
                'id' => $criteria['id'],
                'name' => $criteria['name'],
            ];
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $criteria_props
            ]);
        }
        return view('pages.admin.master.experiment.criteria.index', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'symbol' => 'required'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $criteria =  new CriteriaMaster();
            $criteria['name'] = $request->name;
            //$criteria['symbol'] = $request->symbol;
            //$criteria['is_range_type'] = !empty($request->is_range_type) ? $request->is_range_type : 'false';
            $criteria['tenant_id'] = ___decrypt($tenant_id);
            $criteria['description'] = $request->description;
            $criteria['created_by'] = Auth::user()->id;
            $criteria['updated_by'] = Auth::user()->id;
            $criteria->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Added Successfully!";
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
            $update = CriteriaMaster::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (CriteriaMaster::where('id', ___decrypt($id))->update($update)) {
                CriteriaMaster::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request, $tenant_id)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (CriteriaMaster::whereIn('id', $processIDS)->update($update)) {
            CriteriaMaster::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function edit($tenant_id, $id)
    {
        $criteria = CriteriaMaster::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.experiment.criteria.edit', [
                'criteria' => $criteria,
                'tenant_id' => $tenant_id,
            ])->render()
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'symbol' => 'required'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $criteria = CriteriaMaster::find(___decrypt($id));
            $criteria['name'] = $request->name;
            $criteria['symbol'] = $request->symbol;
            $criteria['is_range_type'] = !empty($request->is_range_type) ? $request->is_range_type : 'false';
            $criteria['description'] = $request->description;
            $criteria['updated_by'] = Auth::user()->id;
            $criteria['updated_at'] = now();
            $criteria->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
