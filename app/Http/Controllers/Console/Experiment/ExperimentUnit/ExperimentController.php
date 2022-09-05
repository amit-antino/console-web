<?php

namespace App\Http\Controllers\Console\Experiment\ExperimentUnit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessExperiment\ExperimentUnit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization\Experiment\EquipmentUnit;
use App\Models\Experiment\ExperimentConditionMaster;
use App\Models\Experiment\ExperimentOutcomeMaster;
use App\Models\Models\ModelDetail;
use App\Models\Experiment\ExperimentUnitImage;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Imports\ExpUnit;

class ExperimentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'console') {
            $data = ExperimentUnit::where('created_by', Auth::user()->id)->where(['tenant_id' => session()->get('tenant_id')])->with('exp_equip_unit')->orderBy('id', 'desc')->get();
        } else {
            $data = ExperimentUnit::where(['tenant_id' => session()->get('tenant_id')])->with('exp_equip_unit')->orderBy('id', 'desc')->get();
        }
       // dd($data->equipment_name);
        return view('pages.console.experiment.experiment_unit.index', compact('data'));
    }

    public function create()
    {
        $data['equipment_units'] = EquipmentUnit::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $data['unit_images'] = ExperimentUnitImage::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $data['conditions'] = ExperimentConditionMaster::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $data['outcomes'] = ExperimentOutcomeMaster::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $data['models'] = ModelDetail::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        return view('pages.console.experiment.experiment_unit.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_name' => 'required',
            'equipment_unit' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $exp_unit = new ExperimentUnit();
            $exp_unit['tenant_id'] = session()->get('tenant_id');
            $exp_unit['experiment_unit_name'] = $request->unit_name;
            $exp_unit['description'] = $request->description;
            $exp_unit['equipment_unit_id'] = ___decrypt($request->equipment_unit);
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $exp_unit['tags'] = $tags;
            $exp_unit['created_by'] = Auth::user()->id;
            $exp_unit['updated_by'] = Auth::user()->id;
            $exp_unit->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/experiment/experiment_units');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $process_exp = ExperimentUnit::find(___decrypt($id));
        $exp_equip_unit_details = [
            'equip_unit_name' => !empty($process_exp->exp_equip_unit->equipment_name) ? $process_exp->exp_equip_unit->equipment_name : '',
            'equip_unit_img_name' => !empty($process_exp->exp_equip_unit->exp_unit_image->name) ? $process_exp->exp_equip_unit->exp_unit_image->name : '',
            'equip_unit_img_url' => !empty($process_exp->exp_equip_unit->exp_unit_image->image) ? $process_exp->exp_equip_unit->exp_unit_image->image : '',
            'equip_unit_parameters' => !empty($process_exp->exp_equip_unit->parameters_details) ? $process_exp->exp_equip_unit->parameters_details : ''
        ];
        $streams = [];
        $conditions = [];
        $outcomes = [];
        $equipment = EquipmentUnit::find($process_exp->equipment_unit_id);
        if (!empty($equipment->condition)) {
            foreach ($equipment->condition as $condition) {
                $master_condition = ExperimentConditionMaster::find($condition);
                $conditions[] = [
                    'name' => !empty($master_condition->name) ? $master_condition->name : "",
                    'unit_type' => !empty($master_condition->unit_types->unit_name) ? $master_condition->unit_types->unit_name : ''
                ];
            }
        }
        if (!empty($equipment->outcome)) {
            foreach ($equipment->outcome as $outcome) {
                $master_outcome = ExperimentOutcomeMaster::find($outcome);
                $outcomes[] = [
                    'name' => !empty($master_outcome->name) ? $master_outcome->name : '',
                    'unit_type' => !empty($master_outcome->unit_types->unit_name) ? $master_outcome->unit_types->unit_name : ''
                ];
            }
        }
        $response_data = [
            "id" => $process_exp->id,
            "name" => $process_exp->experiment_unit_name,
            "exp_equip_unit" => $exp_equip_unit_details,
            "streams" => !empty($equipment->stream_flow) ? $equipment->stream_flow : '',
            "conditions" => $conditions,
            "outcomes" => $outcomes,
            "description" => $process_exp->description,
            "tags" => $process_exp->tags,
            "status" => $process_exp->status
        ];
        return view('pages.console.experiment.experiment_unit.view', compact('response_data'));
    }

    public function edit($id)
    {
        $data['process_exp'] = ExperimentUnit::find(___decrypt($id));
        $data['equipment_units'] = EquipmentUnit::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $data['unit_images'] = ExperimentUnitImage::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $data['conditions'] = ExperimentConditionMaster::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $data['outcomes'] = ExperimentOutcomeMaster::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $data['models'] = ModelDetail::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $equipment = EquipmentUnit::find($data['process_exp']->equipment_unit_id);
        $data['condition_exp_unit'] = !empty($equipment->condition) ? $equipment->condition : [];
        $data['outcome_exp_unit'] =   !empty($equipment->outcome) ? $equipment->outcome : [];
        $data['stream_flow'] = !empty($equipment->stream_flow) ? $equipment->stream_flow : [];
        return view('pages.console.experiment.experiment_unit.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'unit_name' => 'required',
            'equipment_unit' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $exp_unit = ExperimentUnit::find(___decrypt($id));
            $exp_unit['tenant_id'] = session()->get('tenant_id');
            $exp_unit['experiment_unit_name'] = $request->unit_name;
            $exp_unit['equipment_unit_id'] = ___decrypt($request->equipment_unit);
            $exp_unit['description'] = $request->exp_description;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $exp_unit['tags'] = $tags;
            $exp_unit['updated_by'] = Auth::user()->id;
            $exp_unit['updated_at'] = now();
            $exp_unit->save();
            $this->message = "Experiment Unit Successfully Updated";
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/experiment/experiment_units');
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
            ExperimentUnit::where('id', ___decrypt($id))->update(['status' => $status]);
        } else {
            ExperimentUnit::find(___decrypt($id))->delete();
        }
        $this->status = true;
        $this->redirect = url('/experiment/experiment_units');
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $processID = explode(',', ($id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ExperimentUnit::whereIn('id', $processIDS)->update($update)) {
            ExperimentUnit::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('/experiment/experiment_units');
        return $this->populateresponse();
    }

    public function streamAddMore(Request $request)
    {
        return response()->json([
            'status'    => true,
            'html'      => view('pages.console.experiment.experiment_unit.stream', [
                'count' => $request->count,
            ])->render()
        ]);
    }

    public function equipment_condition_outcome(Request $request)
    {
        $equipment = EquipmentUnit::find(___decrypt($request->id));
        $condition_exp_unit = !empty($equipment->condition) ? $equipment->condition : [];
        $outcome_exp_unit =   !empty($equipment->outcome) ? $equipment->outcome : [];
        $conditions = ExperimentConditionMaster::where(['tenant_id' => session()->get('tenant_id')])->get();
        $outcomes = ExperimentOutcomeMaster::where(['tenant_id' => session()->get('tenant_id')])->get();
        $stream_flow = $equipment->stream_flow;
        return response()->json([
            'status'    => true,
            'html'      => view('pages.console.experiment.experiment_unit.condition_outcome', [
                'count' => $request->count,
                'condition_exp_unit' => $condition_exp_unit,
                'outcome_exp_unit' => $outcome_exp_unit,
                'conditions' => $conditions,
                'outcomes' => $outcomes,
                'stream_flow' => $stream_flow,
                'ajax_form' => 'ajax_form'
            ])->render()
        ]);
    }

    public function get_experiment_units()
    {
        try {
            $experiment_units = ExperimentUnit::select('id', 'experiment_unit_name', 'equipment_unit_id', 'description')->with('exp_equip_unit')->where('status', 'active')->get();
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $experiment_units
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_experiment_unit_info(Request $request)
    {
        try {
            $experiment_unit = ExperimentUnit::select('id', 'experiment_unit_name', 'equipment_unit_id', 'description')->with('exp_equip_unit')->where([['id', $request->experiment_unit_id], ['status', 'active']])->get()->first();
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $experiment_unit
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_experiment_units_for_experiment(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find(($request->experiment_id));
            $experiment_units = [];
            if (!empty($process_experiment->experiment_unit)) {
                foreach ($process_experiment->experiment_unit as $experiment_unit) {
                    $experiment_units[] = [
                        "id" => json_decode($experiment_unit['id']),
                        "experiment_unit_name" => $experiment_unit['unit'],
                        "experiment_equipment_unit" => get_experiment_unit($experiment_unit['exp_unit']),
                    ];
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $experiment_units
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_experiment_units_for_experiment_by_id(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find(($request->experiment_id));
            $experiment_units = "";
            if (!empty($process_experiment->experiment_unit)) {
                foreach ($process_experiment->experiment_unit as $experiment_unit) {
                    if ($request['experiment_unit_id'] == $experiment_unit['id']) {
                        $experiment_units = [
                            "id" => json_decode($experiment_unit['id']),
                            "experiment_unit_name" => $experiment_unit['unit'],
                            "experiment_equipment_unit" => get_experiment_unit($experiment_unit['exp_unit']),
                        ];
                    }
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $experiment_units
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function cloneExpUnit(Request $request)
    {
        try {
            $clone = ExperimentUnit::find(___decrypt($request->experiment_unit_id));
            $expUnitData = new ExperimentUnit();
            $expUnitData->tenant_id = !empty($clone->tenant_id) ? ($clone->tenant_id) : 0;
            $exp_unit_name = "";
            if (isset($request->name)) {
                if (!empty($request->name)) {
                    $exp_unit_name = $request->name;
                } else {
                    $exp_unit_name = $clone->experiment_unit_name;
                }
            } else {
                $exp_unit_name = $clone->experiment_unit_name;
            }

            $expUnitData->experiment_unit_name = $exp_unit_name;
            $expUnitData->equipment_unit_id = !empty($clone->equipment_unit_id) ? ($clone->equipment_unit_id) : 0;
            $expUnitData->description = !empty($clone->description) ? ($clone->description) : "";
            $expUnitData->status = 'active';
            $expUnitData->created_by = Auth::user()->id;
            $expUnitData->updated_by = Auth::user()->id;
            if ($expUnitData->save()) {
                $newpeId = $expUnitData->id;
            }
            $status = true;
            $message = "Clone Successfully!";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $response = [
            'success' => $status,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function importFile(Request $request)
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
                \Excel::import(new ExpUnit(session()->get('tenant_id')), request()->file('import_file'));
                $this->message = "CSV uploaded Successfully!";
            }
            if (!empty($request->import_json)) {
                $jsonString = file_get_contents(request()->file('import_json'));
                $data = json_decode($jsonString, true);
                for ($i = 0; $i < count($data); $i++) {
                    if ($data[$i]['Tags'] != "") {
                        $tags = explode(",", $data[$i]['Tags']);
                    } else {
                        $tags = [];
                    }
                    // $equip_unit = EquipmentUnit::where('unit_name', $data[$i]['unit'])->first();
                    $outcome =  new ExperimentUnit();
                    $outcome['experiment_unit_name'] = $data[$i]['Name'];
                    $outcome['tenant_id'] = session()->get('tenant_id');
                    $outcome['description'] = $data[$i]['Description'];
                    $outcome['equipment_unit_id'] = 0; //isset($equip_unit->id) ? $equip_unit->id : 0;
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
            $this->redirect = url('pages/console/experiment/experiment_unit/index');
            $this->status = true;
            $this->redirect = true;
        }
        return $this->populateresponse();
    }
}
