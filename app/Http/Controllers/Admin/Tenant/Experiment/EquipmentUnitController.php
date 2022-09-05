<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experiment\ExperimentUnitImage;
use App\Models\Organization\Experiment\EquipmentUnit;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\MasterUnit;
use Illuminate\Support\Facades\Auth;
use App\Models\Experiment\ExperimentConditionMaster;
use App\Models\Experiment\ExperimentOutcomeMaster;
use App\Models\Models\ModelDetail;

class EquipmentUnitController extends Controller
{
    public function index($tenant_id)
    {
        $data['equipment_units'] = EquipmentUnit::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.master.experiment.equipment_unit.index', $data);
    }

    public function create($tenant_id)
    {
        $data['unit_types'] = MasterUnit::get();
        $data['unit_images'] = ExperimentUnitImage::where(['status' => 'active', 'tenant_id' => ___decrypt($tenant_id)])->get();
        $data['conditions'] = ExperimentConditionMaster::where(['status' => 'active', 'tenant_id' => ___decrypt($tenant_id)])->get();
        $data['outcomes'] = ExperimentOutcomeMaster::where(['status' => 'active', 'tenant_id' => ___decrypt($tenant_id)])->get();
        $data['models'] = ModelDetail::where(['status' => 'active', 'tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.master.experiment.equipment_unit.create', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'equipment_unit_name' => 'required'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $equipment = new EquipmentUnit();
            $equipment['equipment_name'] = $request->equipment_unit_name;
            $equipment['tenant_id'] = ___decrypt($tenant_id);
            $equipment['unit_image'] = !empty($request->unit_image) ? ___decrypt($request->unit_image) : 0;
            $equipment['description'] = $request->description;
            if (!empty($request->condition)) {
                foreach ($request->condition as $cond) {
                    $condition[] = ___decrypt($cond);
                }
                $equipment['condition'] = $condition;
            }
            if (!empty($request->outcome)) {
                foreach ($request->outcome as $outc) {
                    $outcome[] = ___decrypt($outc);
                }
                $equipment['outcome'] = $outcome;
            }
            $equipment['model_id'] = !empty($request->models) ? ___decrypt($request->models) : 0;
            $streams_input = [];
            $streams_output = [];
            $equip_name = str_replace(' ', '_', $request->equipment_unit_name);
            if (!empty($request->stream_flow_input)) {
                for ($i = 1; $i < $request->stream_flow_input + 1; $i++) {
                    $streams_input[] = [
                        "id" => json_encode($i),
                        "stream_name" => $equip_name . '_input_' . $i,
                        "flow_type" => 'input'
                    ];
                }
            }
            if (!empty($request->stream_flow_output)) {
                for ($i = 1; $i < $request->stream_flow_output + 1; $i++) {
                    $streams_output[] = [
                        "id" => json_encode($i),
                        "stream_name" => $equip_name . '_output_' . $i,
                        "flow_type" => 'output'
                    ];
                }
            }
            $streams = array_merge($streams_input, $streams_output);
            $equipment['stream_flow'] = $streams;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $equipment['tags'] = $tags;
            $equipment['created_by'] = Auth::user()->id;
            $equipment['updated_by'] = Auth::user()->id;
            $equipment->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/equipment_unit');
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
            $update = EquipmentUnit::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (EquipmentUnit::where('id', ___decrypt($id))->update($update)) {
                EquipmentUnit::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/equipment_unit');
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
        if (EquipmentUnit::whereIn('id', $processIDS)->update($update)) {
            EquipmentUnit::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/equipment_unit');
        return $this->populateresponse();
    }

    public function edit($tenant_id, $id)
    {
        $data['equipment_unit'] = EquipmentUnit::find(___decrypt($id));
        $data['unit_types'] = MasterUnit::get();
        $data['unit_images'] = ExperimentUnitImage::where(['status' => 'active', 'tenant_id' => ___decrypt($tenant_id)])->get();
        $data['conditions'] = ExperimentConditionMaster::where(['status' => 'active', 'tenant_id' => ___decrypt($tenant_id)])->get();
        $data['outcomes'] = ExperimentOutcomeMaster::where(['status' => 'active', 'tenant_id' => ___decrypt($tenant_id)])->get();
        $data['models'] = ModelDetail::where(['status' => 'active', 'tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.master.experiment.equipment_unit.edit', $data);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'equipment_unit_name' => 'required'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $equipment = EquipmentUnit::find(___decrypt($id));
            $equipment['equipment_name'] = $request->equipment_unit_name;
            $equipment['unit_image'] = !empty($request->unit_image) ? ___decrypt($request->unit_image) : 0;
            $equipment['description'] = $request->description;
            if (!empty($request->condition)) {
                foreach ($request->condition as $cond) {
                    $condition[] = ___decrypt($cond);
                }
                $equipment['condition'] = $condition;
            }
            if (!empty($request->outcome)) {
                foreach ($request->outcome as $outc) {
                    $outcome[] = ___decrypt($outc);
                }
                $equipment['outcome'] = $outcome;
            }
            $equipment['model_id'] = !empty($request->models) ? ___decrypt($request->models) : 0;
            $streams_input = [];
            $streams_output = [];
            $equip_name = str_replace(' ', '_', $request->equipment_unit_name);
            if (!empty($request->stream_flow_input)) {
                for ($i = 1; $i < $request->stream_flow_input + 1; $i++) {
                    $streams_input[] = [
                        "id" => json_encode($i),
                        "stream_name" => $equip_name . '_input_' . $i,
                        "flow_type" => 'input'
                    ];
                }
            }
            if (!empty($request->stream_flow_output)) {
                for ($i = 1; $i < $request->stream_flow_output + 1; $i++) {
                    $streams_output[] = [
                        "id" => json_encode($i),
                        "stream_name" => $equip_name . '_output_' . $i,
                        "flow_type" => 'output'
                    ];
                }
            }
            $streams = array_merge($streams_input, $streams_output);
            $equipment['stream_flow'] = $streams;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $equipment['tags'] = $tags;
            $equipment['updated_by'] = Auth::user()->id;
            $equipment['updated_at'] = now();
            $equipment->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/equipment_unit');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function parameterFields(Request $request)
    {
        $unit_types = MasterUnit::get();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.experiment.equipment_unit.parameter', ['count' => $request->count, 'unit_types' => $unit_types])->render()
        ]);
    }

    public function show($tenant_id, $id)
    {
        $conditions = [];
        $outcomes = [];
        $equipment = EquipmentUnit::find(___decrypt($id));
        if (!empty($equipment->condition)) {
            foreach ($equipment->condition as $condition) {
                $master_condition = ExperimentConditionMaster::find($condition);
                $conditions[] = [
                    'name' => $master_condition->name,
                    'unit_type' => $master_condition->unit_types->unit_name
                ];
            }
        }
        if (!empty($equipment->outcome)) {
            foreach ($equipment->outcome as $outcome) {
                $master_outcome = ExperimentOutcomeMaster::find($outcome);
                $outcomes[] = [
                    'name' => $master_outcome->name,
                    'unit_type' => $master_outcome->unit_types->unit_name
                ];
            }
        }
        $exp_equip_unit_details = [
            'equip_unit_img_name' => !empty($equipment->exp_unit_image->name) ? $equipment->exp_unit_image->name : '',
            'equip_unit_img_url' => !empty($equipment->exp_unit_image->image) ? $equipment->exp_unit_image->image : '',
        ];
        $user = check_user_type($equipment->created_by);
        $response_data = [
            "id" => $equipment->id,
            "name" => $equipment->equipment_name,
            "exp_equip_unit" => $exp_equip_unit_details,
            "streams" => $equipment->stream_flow,
            "conditions" => $conditions,
            "outcomes" => $outcomes,
            "description" => $equipment->description,
            "tags" => $equipment->tags,
            "status" => $equipment->status,
        ];
        return view('pages.admin.master.experiment.equipment_unit.view', compact('response_data', 'user', 'tenant_id'));
    }
}
