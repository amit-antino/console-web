<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experiment\PriorityMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PriorityController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['priority'] = PriorityMaster::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = $tenant_id;
        $priority_props = [];
        foreach ($data['priority'] as $priority) {
            $priority_props[] = [
                'id' => $priority['id'],
                'name' => $priority['name'],
            ];
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $priority_props
            ]);
        }
        return view('pages.admin.master.experiment.priority.index', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $priority =  new PriorityMaster();
            $priority['name'] = $request->name;
            $priority['tenant_id'] = ___decrypt($tenant_id);
            $priority['description'] = $request->description;
            $priority['created_by'] = Auth::user()->id;
            $priority['updated_by'] = Auth::user()->id;
            $priority->save();
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
            $update = PriorityMaster::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (PriorityMaster::where('id', ___decrypt($id))->update($update)) {
                PriorityMaster::destroy(___decrypt($id));
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
        if (PriorityMaster::whereIn('id', $processIDS)->update($update)) {
            PriorityMaster::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function edit($tenant_id, $id)
    {
        $priority = PriorityMaster::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.experiment.priority.edit', [
                'priority' => $priority,
                'tenant_id' => $tenant_id,
            ])->render()
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $priority = PriorityMaster::find(___decrypt($id));
            $priority['name'] = $request->name;
            $priority['description'] = $request->description;
            $priority['updated_by'] = Auth::user()->id;
            $priority['updated_at'] = now();
            $priority->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
