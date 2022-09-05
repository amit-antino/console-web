<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experiment\ExperimentConditionMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\MasterUnit;
use App\Imports\ExpCondition;

class ExperimentConditionController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['experiment_conditions'] = ExperimentConditionMaster::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $MasterUnit = MasterUnit::all();
        $data['MasterUnit'] = $MasterUnit->toArray();
        $experiment_conditions = [];
        foreach ($data['experiment_conditions'] as $experiment_condition) {
            $experiment_conditions[] = [
                "id" => $experiment_condition['id'],
                "name" => $experiment_condition['name'],
                "unit_type" => [
                    "unit_id" => (!empty($experiment_condition->unit_types->id)) ? $experiment_condition->unit_types->id : 0,
                    "unit_name" => (!empty($experiment_condition->unit_types->unit_name)) ? $experiment_condition->unit_types->unit_name : "",
                    "unit_constants" => (!empty($experiment_condition->unit_types->unit_constant)) ? $experiment_condition->unit_types->unit_constant : "",
                ],
            ];
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $experiment_conditions
            ]);
        }
        return view('pages.admin.master.experiment.experiment_condition.index', compact('data', 'tenant_id'));
    }

    public function get_condition(Request $request)
    {
        try {
            $condition = ExperimentConditionMaster::find($request->condition_id);
            $condition_info = [
                "id" => $condition['id'],
                "name" => $condition['name'],
                "unit_type" => [
                    "unit_id" => $condition->unit_types->id,
                    "unit_name" => $condition->unit_types->unit_name,
                    "default_unit" => json_decode($condition->unit_types->default_unit),
                    "unit_constants" => $condition->unit_types->unit_constant
                ],
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $condition_info
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'unit_type' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $condition =  new ExperimentConditionMaster();
            $condition['name'] = $request->name;
            $condition['tenant_id'] = ___decrypt($tenant_id);
            $condition['description'] = $request->description;
            $condition['unittype'] =  ___decrypt($request->unit_type);
            $condition['status'] = 'active';
            $condition['created_by'] = Auth::user()->id;
            $condition['updated_by'] = Auth::user()->id;
            $condition->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/condition');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($tenant_id, $id)
    {
    }

    public function edit($tenant_id, $id)
    {
        $experiment_condition = ExperimentConditionMaster::where('id', ___decrypt($id))->first();
        $MasterUnit = MasterUnit::all();
        $data['MasterUnit'] = $MasterUnit->toArray();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.experiment.experiment_condition.edit', ['condition' => $experiment_condition, 'data' => $data, 'tenant_id' => $tenant_id])->render()
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'unit_type' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $condition =  ExperimentConditionMaster::find(___decrypt($id));
            $condition['name'] = $request->name;
            $condition['description'] = $request->description;
            $condition['unittype'] =  ___decrypt($request->unit_type);
            $condition['status'] = 'active';
            $condition['updated_by'] = Auth::user()->id;
            $condition['updated_at'] = now();
            $condition->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/condition');
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
            $update = ExperimentConditionMaster::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ExperimentConditionMaster::where('id', ___decrypt($id))->update($update)) {
                ExperimentConditionMaster::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/condition');
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request, $tenant_id)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        ExperimentConditionMaster::destroy($processIDS);
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/condition');
        return $this->populateresponse();
    }

    public function importFile(Request $request, $tenant_id)
    {
        $validations = [
            //'import_file' => ['required'],
            'import_file' => ['required_without_all:import_json'],
            'import_json' => ['required_without_all:import_file'],
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            if (!empty($request->import_file)) {
                \Excel::import(new ExpCondition(___decrypt($tenant_id)), request()->file('import_file'));
                $this->message = "CSV uploaded Successfully!";
            }
            if (!empty($request->import_json)) {
                $jsonString = file_get_contents(request()->file('import_json'));
                $data = json_decode($jsonString, true);
                for ($i = 0; $i < count($data); $i++) {
                    $master_unit = MasterUnit::where('unit_name', $data[$i]['unit'])->first();
                    $condition =  new ExperimentConditionMaster();
                    $condition['name'] = $data[$i]['Experiment Condition'];
                    $condition['tenant_id'] = ___decrypt($tenant_id);
                    $condition['description'] = "";
                    $condition['unittype'] =  isset($master_unit->id) ? $master_unit->id : 0;;
                    $condition['status'] = $data[$i]['status'];
                    $condition['created_by'] = Auth::user()->id;
                    $condition['updated_by'] = Auth::user()->id;
                    $condition->save();
                }
                $this->message = "JSON uploaded Successfully!";
            }
            $this->status = true;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/condition');
        }
        return $this->populateresponse();
    }
}
