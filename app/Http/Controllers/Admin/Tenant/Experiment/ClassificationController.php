<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Experiment\ExperimentClassification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ClassificationController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['classifications'] = ExperimentClassification::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = $tenant_id;
        $classifications = [];
        foreach ($data['classifications'] as $classification) {
            if ($classification['status'] == 'active') {
                $classifications[] = [
                    'id' => $classification['id'],
                    'name' => $classification['name'],
                ];
            }
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $classifications
            ]);
        }
        return view('pages.admin.master.experiment.classification.index', $data);
    }

    public function create()
    {
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $classification =  new ExperimentClassification();
            $classification['name'] = $request->name;
            $classification['tenant_id'] = ___decrypt($tenant_id);
            $classification['description'] = $request->description;
            $classification['created_by'] = Auth::user()->id;
            $classification['updated_by'] = Auth::user()->id;
            $classification->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Added Successfully!";
        }
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
        if (ExperimentClassification::whereIn('id', $processIDS)->update($update)) {
            ExperimentClassification::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function edit($tenant_id, $id)
    {
        $class = ExperimentClassification::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.experiment.classification.edit', ['class' => $class, 'tenant_id' => $tenant_id])->render()
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'classification_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $classification = ExperimentClassification::find(___decrypt($id));
            $classification['name'] = $request->classification_name;
            $classification['description'] = $request->description;
            $classification['updated_by'] = Auth::user()->id;
            $classification['updated_at'] = now();
            $classification->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = " Updated Successfully!";
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
            $update = ExperimentClassification::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ExperimentClassification::where('id', ___decrypt($id))->update($update)) {
                ExperimentClassification::destroy(___decrypt($id));
            }
        }

        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
