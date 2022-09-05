<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experiment\ExperimentOutcomeMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\MasterUnit;
use App\Imports\ExpUnitOutcome;

class ExperimentOutcomeController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['experiment_outcomes'] = ExperimentOutcomeMaster::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $MasterUnit = MasterUnit::all();
        $data['MasterUnit'] = $MasterUnit->toArray();
        $experiment_outcomes = [];
        foreach ($data['experiment_outcomes'] as $experiment_outcome) {
            $experiment_outcomes[] = [
                "id" => $experiment_outcome['id'],
                "name" => $experiment_outcome['name'],
                "unit_type" => [
                    "unit_id" => (!empty($experiment_outcome->unit_types->id)) ? $experiment_outcome->unit_types->id : 0,
                    "unit_name" => (!empty($experiment_outcome->unit_types->unit_name)) ? $experiment_outcome->unit_types->unit_name : "",
                    "unit_constants" => (!empty($experiment_outcome->unit_types->unit_constant)) ? $experiment_outcome->unit_types->unit_constant : "",
                ],
            ];
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $experiment_outcomes
            ]);
        }
        return view('pages.admin.master.experiment.experiment_outcome.index', compact('data', 'tenant_id'));
    }

    public function get_outcome(Request $request)
    {
        try {
            $outcome = ExperimentOutcomeMaster::find($request->outcome_id);
            $outcome_info = [
                "id" => $outcome['id'],
                "name" => $outcome['name'],
                "unit_type" => [
                    "unit_id" => $outcome->unit_types->id,
                    "unit_name" => $outcome->unit_types->unit_name,
                    "default_unit" => json_decode($outcome->unit_types->default_unit),
                    "unit_constants" => $outcome->unit_types->unit_constant
                ],
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $outcome_info
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

    public function create()
    {
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
            $outcome =  new ExperimentOutcomeMaster();
            $outcome['name'] = $request->name;
            $outcome['tenant_id'] = ___decrypt($tenant_id);
            $outcome['description'] = $request->description;
            $outcome['unittype'] =  ___decrypt($request->unit_type);
            $outcome['status'] = 'active';
            $outcome['created_by'] = Auth::user()->id;
            $outcome['updated_by'] = Auth::user()->id;
            $outcome->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($tenant_id, $id)
    {
    }

    public function edit($tenant_id, $id)
    {
        $experiment_outcome = ExperimentOutcomeMaster::where('id', ___decrypt($id))->first();
        $MasterUnit = MasterUnit::all();
        $data['MasterUnit'] = $MasterUnit->toArray();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.experiment.experiment_outcome.edit', ['outcome' => $experiment_outcome, 'data' => $data, 'tenant_id' => $tenant_id])->render()
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
            $outcome =  ExperimentOutcomeMaster::find(___decrypt($id));
            $outcome['name'] = $request->name;
            $outcome['description'] = $request->description;
            $outcome['unittype'] = ___decrypt($request->unit_type);
            $outcome['status'] = 'active';
            $outcome['updated_by'] = Auth::user()->id;
            $outcome['updated_at'] = now();
            $outcome->save();
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
            $update = ExperimentOutcomeMaster::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ExperimentOutcomeMaster::where('id', ___decrypt($id))->update($update)) {
                ExperimentOutcomeMaster::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = true;
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
                \Excel::import(new ExpUnitOutcome(___decrypt($tenant_id)), request()->file('import_file'));
                $this->message = "CSV uploaded Successfully!";
            }
            if (!empty($request->import_json)) {
                $jsonString = file_get_contents(request()->file('import_json'));
                $data = json_decode($jsonString, true);
                for ($i = 0; $i < count($data); $i++) {
                    $master_unit = MasterUnit::where('unit_name', $data[$i]['unit'])->first();
                    $outcome =  new ExperimentOutcomeMaster();
                    $outcome['name'] = $data[$i]['Experiment outcome'];
                    $outcome['tenant_id'] = ___decrypt($tenant_id);
                    $outcome['description'] = "";
                    $outcome['unittype'] =  isset($master_unit->id) ? $master_unit->id : 0;
                    $outcome['status'] = $data[$i]['status'];
                    $outcome['created_by'] = Auth::user()->id;
                    $outcome['updated_by'] = Auth::user()->id;
                    $outcome->save();
                }
                $this->message = "JSON uploaded Successfully!";
            }
            $this->status = true;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/outcome');
            $this->status = true;
            $this->redirect = true;
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
        ExperimentOutcomeMaster::destroy($processIDS);
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
