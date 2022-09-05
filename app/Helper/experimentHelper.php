<?php

use App\Models\Experiment\CriteriaMaster;
use App\Models\Experiment\ExperimentConditionMaster;
use App\Models\Experiment\ExperimentOutcomeMaster;
use App\Models\Experiment\PriorityMaster;
use App\Models\Experiment\ProcessDiagram;
use App\Models\Master\MasterUnit;
use App\Models\Master\ProcessSimulation\SimulationFlowType;
use App\Models\MFG\ProcessProfile;
use App\Models\Organization\Experiment\EquipmentUnit;
use App\Models\ProcessExperiment\ExperimentUnit;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\ProcessExperiment\ProcessExpProfile;
use App\Models\ProcessExperiment\ProcessExpProfileMaster;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\ProcessExperiment\Variation;
use App\Models\Tenant\Tenant;
use Illuminate\Support\Facades\Auth;

function clonevVariation($request, $pid, $clnpid)
{
    $variation = new Variation();
    $variation->created_by = Auth::user()->id;
    $variation->name = $request->name;
    $variation->experiment_id = $pid;
    $unit_specification = [];
    $unit_specification["master_units"] = $request->unit_specification['master_units'];
    $unit_specification["experiment_units"] = $request->unit_specification['experiment_units'];;
    $variation->unit_specification = $unit_specification;
    //$variation->process_flow_table = $request->process_flow_table;
    $variation->models = $request->models;
    $variation->dataset = $request->dataset;
    $variation->datamodel = $request->datamodel;
    $variation->process_flow_chart = $request->process_flow_chart;
    $variation->status = $request->status;
    $variation->updated_by = Auth::user()->id;
    $simInput = [];
    if ($variation->save()) {
        $clnprodiagrams = ProcessDiagram::whereIn('id', $request->process_flow_table)->where('process_id', $clnpid)->get();
        $expdiagrams = [];
        if ($clnprodiagrams) {
            foreach ($clnprodiagrams as $clnprodiagram) {
                $expdiagrams[] = cloneprocessdiagram($clnprodiagram, $variation->experiment_id);
            }
        }
        $MasterUnit = [];
        if (!empty($request->unit_specification['master_units'])) {
            $varMasterUnits = explode(',', $request->unit_specification['master_units']);
            foreach ($varMasterUnits as $varMasterUnit) {
                $MasterUnit[] = $varMasterUnit;
            }
        }
        $clnmasterprofiles = ProcessExpProfileMaster::whereIn('id', $MasterUnit)->where('process_exp_id', $clnpid)->get();
        $masterprofiles = [];
        if ($clnmasterprofiles) {
            foreach ($clnmasterprofiles as $clnmasterprofile) {
                $masterprofiles[] = cloneExpprofilemaster($clnmasterprofile, $variation->experiment_id);
            }
        }
        $clnexpprofiles = ProcessExpProfile::where(['variation_id' => $request->id])->get();
        if (!empty($clnexpprofiles)) {
            foreach ($clnexpprofiles as $clnexpprofile) {
                $expprofile[] = cloneExpprofile($clnexpprofile, $variation->experiment_id, $variation->id);
            }
            $expprofiles = ProcessExpProfile::select('id')->where(['variation_id' => $variation->id])->get();
        }
        $arr = [];
        $var_data = Variation::where('id', $variation->id)->first();
        $varArr = $var_data->unit_specification;
        if (!empty($expprofiles)) {
            foreach ($expprofiles as $expprofile_id) {
                array_push($arr, $expprofile_id->id);
            }
        }
        $varArr['master_units'] = implode(",", $masterprofiles);
        $varArr['experiment_units'] = $arr;
        $var_data->process_flow_table = $expdiagrams;
        $var_data->unit_specification = $varArr;
        $var_data->updated_by = Auth::user()->id;
        $var_data->save();
        $simulationInput = SimulateInput::where(['experiment_id' => $request->experiment_id, 'variation_id' => $request->id])->get();
        if (!empty($simulationInput)) {
            foreach ($simulationInput as $sd) {
                $simInput[] = clonevsimulationInput($sd, $pid, $variation->id);
            }
        }
    }
}

function clonevsimulationInput($request, $pid, $varId)
{
    $simulate = new SimulateInput();
    $simulate['name'] = $request->name;
    $simulate['experiment_id'] = $pid;
    $simulate['variation_id'] = $varId;
    $simulate['simulate_input_type'] = $request->simulate_input_type;
    $raw_material = [];
    foreach ($request->raw_material as $rm) {
        if (!empty($rm['pfd_stream_id']) && $rm['pfd_stream_id'] > 0) {
            $pfd_data = ProcessDiagram::select('id')->where('clone_id', $rm['pfd_stream_id'])->first();
            $pfd_stream_id = $pfd_data['id'];
        } else {
            $pfd_stream_id = $rm['pfd_stream_id'];
        }
        $raw_material[] = [
            'id' => $rm['id'],
            'product' => $rm['product'],
            'unit_id' => $rm['unit_id'],
            'pfd_stream_id' => $pfd_stream_id,
            'value_flow_rate' => $rm['value_flow_rate'],
            'unit_constant_id' => $rm['unit_constant_id'],
        ];
    }
    $simulate['raw_material'] = $raw_material;
    $simulate['master_condition'] = $request->master_condition;
    $simulate['master_outcome'] = $request->master_outcome;
    $simulate['unit_condition'] = $request->unit_condition;
    $simulate['unit_outcome'] = $request->unit_outcome;
    $simulate['simulation_type'] = $request->simulation_type;
    $simulate['notes'] = $request->description;
    $simulate['note_urls'] = $request->note_urls;
    $simulate['status'] = $request->status;
    $simulate['updated_by'] = Auth::user()->id;
    $simulate['created_by'] = Auth::user()->id;
    $simulate->save();
    return $simulate->save();
}
function cloneprocessdiagram($request, $pid)
{
    $processDiagram = new ProcessDiagram();
    $processDiagram['process_id'] = $pid;
    $processDiagram['flowtype'] = !empty($request['flowtype']) ? ($request['flowtype']) : 0;
    $processDiagram['name'] = !empty($request['name']) ? $request['name'] : '';
    $to_unit = [];
    if (!empty($request->to_unit)) {
        $processDiagram['to_unit'] = $request->to_unit;
    }
    $from_unit = [];
    if (!empty($request->from_unit)) {
        $processDiagram['from_unit'] = $request->from_unit;
    }
    $processDiagram['products'] = !empty($request['products']) ? $request['products'] : [];
    $processDiagram['openstream'] = $request->openstream;
    $processDiagram['status'] = $request->status;
    $processDiagram['created_by'] = Auth::user()->id;
    $processDiagram['updated_by'] = Auth::user()->id;
    $processDiagram['clone_id'] = $request['id'];
    $processDiagram->save();
    return $processDiagram->id;
}

function cloneExpprofile($request, $id, $variation_id)
{
    $profile = new ProcessExpProfile();
    $profile->process_exp_id = $id;
    $profile->variation_id = $variation_id;
    $profile->experiment_unit = $request->experiment_unit;
    $profile->condition = $request->condition;
    $profile->outcome = $request->outcome;
    $profile->reaction = $request->reaction;
    $profile->updated_by = Auth::user()->id;
    $profile->created_by = Auth::user()->id;
    return $profile->save();
}

function cloneExpprofilemaster($request, $id)
{
    $profile = new ProcessExpProfileMaster();
    $profile->process_exp_id = $id;
    $profile->condition = $request->condition;
    $profile->outcome = $request->outcome;
    $profile->reaction = $request->reaction;
    $profile->updated_by = Auth::user()->id;
    $profile->created_by = Auth::user()->id;
    $profile->save();
    return $profile->id;
}

function raw_material($simulate_input_id, $simulate_type = 'foward')
{
    $simulate_input = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'raw_material', 'simulate_input_type')->where(['id' => $simulate_input_id])->first();
    $raw_material_data = [];
    if (!empty($simulate_input['raw_material'])) {
        foreach ($simulate_input['raw_material'] as $r_key => $raw_material) {
            $process_diagram_data = ProcessDiagram::find($raw_material['pfd_stream_id']);
            // dd($process_diagram_data,$simulate_input['experiment_id']);
            if (!empty($process_diagram_data['to_unit']) && $process_diagram_data['process_id'] == $simulate_input['experiment_id']) {
                $raw_material_data[$r_key]['process_diagram_name'] = $process_diagram_data->name;
                $raw_material_data[$r_key]['pfd_stream_id'] = $raw_material['pfd_stream_id'];
                $raw_material_data[$r_key]['unit_id'] = $raw_material['unit_id'];
                $raw_material_data[$r_key]['unit_constant_id'] = $raw_material['unit_constant_id'];
                $raw_material_data[$r_key]['unit_constant_name'] = get_unit_constant($raw_material['unit_id'], $raw_material['unit_constant_id']);
                $raw_material_data[$r_key]['value_flow_rate'] = $raw_material['value_flow_rate'];
                $product = [];
                if (!empty($raw_material['product'])) {
                    foreach ($raw_material['product'] as $pro_key => $pro) {
                        $product[$pro_key]['product_id'] = !empty($pro['product_id']) ? $pro['product_id'] : 0;
                        $associate_products = getAssociateValue(___encrypt($pro['product_id']));
                        $product[$pro_key]['product_name'] = $associate_products['prod']['chemical_name'];
                        $product[$pro_key]['value'] = !empty($pro['value']) ? $pro['value'] : 0;;
                        $product[$pro_key]['criteria'] = !empty($pro['criteria']) ? $pro['criteria'] : 0;
                        $product[$pro_key]['criteria_data'] = get_criteria_data(!empty($pro['criteria']) ? $pro['criteria'] : 0);
                        $product[$pro_key]['max_value'] = !empty($pro['max_value']) ? $pro['max_value'] : 0;
                    }
                }
                $raw_material_data[$r_key]['product'] = $product;
            }
        }
    }
    return $raw_material_data;
}


function master_condition_list($simulate_input_id, $criteria = 'foward')
{
    $simulate_input = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'master_condition', 'simulate_input_type')->where(['id' => $simulate_input_id])->first();
    $master_condition_output = [];
    if (!empty($simulate_input['master_condition'])) {
        foreach ($simulate_input['master_condition'] as $key => $master_condition) {
            $condition_data = getConditionInfo($master_condition['condition_id']);
            $master_condition_output[$key]['id'] = $master_condition['id'];
            if ($simulate_input['simulate_input_type'] == 'reverse') {
                if ($criteria == 'criteria' && empty($master_condition['criteria'])) {
                    return 'criteria_empty';
                }
                $master_condition_output[$key]['max_value'] = !empty($master_condition['max_value']) ? $master_condition['max_value'] : 0;
                $master_condition_output[$key]['criteria'] = !empty($master_condition['criteria']) ? $master_condition['criteria'] : 0;
                $master_condition_output[$key]['criteria_data'] = get_criteria_data(!empty($master_condition['criteria']) ? $master_condition['criteria'] : 0);
            }
            $master_condition_output[$key]['condition_id'] = $master_condition['condition_id'];
            $master_condition_output[$key]['unit_id'] = $master_condition['unit_id'];
            $master_condition_output[$key]['unit_constant_id'] = $master_condition['unit_constant_id'];
            $master_condition_output[$key]['value'] = !empty($master_condition['value']) ? $master_condition['value'] : 0;
            $master_condition_output[$key]['condition_name'] = $condition_data['condition_name'];
            $master_condition_output[$key]['default_unit'] = $condition_data['unit_type']['default_unit'];
            $master_condition_output[$key]['default_constant_unit'] = get_unit_constant($condition_data['unit_type']['unit_id'], $condition_data['unit_type']['default_unit']);
            $master_condition_output[$key]['unit_constant_name'] = get_unit_constant($master_condition['unit_id'], $master_condition['unit_constant_id']);
        }
    }

    return $master_condition_output;
}


function master_outcome_list($simulate_input_id, $criteria = 'forward')
{
    $simulate_input = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'master_outcome', 'simulate_input_type')->where(['id' => $simulate_input_id])->first();
    $master_outcome_output = [];
    if (!empty($simulate_input['master_outcome'])) {
        foreach ($simulate_input['master_outcome'] as $key => $master_outcome) {
            $outcome_data = getOutcomeInfo($master_outcome['outcome_id']);
            $master_outcome_output[$key]['id'] = $master_outcome['id'];
            $master_outcome_output[$key]['outcome_id'] = $master_outcome['outcome_id'];
            if ($simulate_input['simulate_input_type'] == 'reverse') {
                if ($criteria == 'criteria' && empty($master_outcome['criteria'])) {
                    return 'criteria_empty';
                }
                $master_outcome_output[$key]['criteria'] = $master_outcome['criteria'];
                $master_outcome_output[$key]['max_value'] = !empty($master_outcome['max_value']) ? $master_outcome['max_value'] : 0;
                $master_outcome_output[$key]['criteria_data'] = get_criteria_data($master_outcome['criteria']);
                $master_outcome_output[$key]['priority'] = $master_outcome['priority'];
                $master_outcome_output[$key]['priority_name'] = get_priority_name($master_outcome['priority']);
            }
            $master_outcome_output[$key]['unit_id'] = $master_outcome['unit_id'];
            $master_outcome_output[$key]['unit_constant_id'] = $master_outcome['unit_constant_id'];
            $master_outcome_output[$key]['value'] = !empty($master_outcome['value']) ? $master_outcome['value'] : 0;
            $master_outcome_output[$key]['outcome_name'] = !empty($outcome_data['outcome_name']) ? $outcome_data['outcome_name'] : '';
            $master_outcome_output[$key]['default_constant_unit'] = isset($outcome_data['unit_type']['unit_id']) ? get_unit_constant($outcome_data['unit_type']['unit_id'], $outcome_data['unit_type']['default_unit']) : '';
            $master_outcome_output[$key]['unit_constant_name'] = get_unit_constant($master_outcome['unit_id'], $master_outcome['unit_constant_id']);
        }
    }
    return $master_outcome_output;
}

function unit_condition_list($simulate_input_id, $criteria = 'foward')
{
    $simulate_input = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'unit_condition', 'simulate_input_type')->where(['id' => $simulate_input_id])->first();
    $unit_condition_output = [];
    if (!empty($simulate_input['unit_condition'])) {
        foreach ($simulate_input['unit_condition'] as $key => $master_condition) {
            $condition_data = getConditionInfo($master_condition['condition_id']);
            $exp_unit = get_experiment_unit_details($simulate_input['experiment_id'], !empty($master_condition['exp_unit_id']) ? $master_condition['exp_unit_id'] : 0);
            $unit_condition_output[$key]['id'] = $master_condition['id'];
            $unit_condition_output[$key]['exp_unit_id'] = $master_condition['exp_unit_id'];
            if ($simulate_input['simulate_input_type'] == 'reverse') {
                if ($criteria == 'criteria' && empty($master_condition['criteria'])) {
                    return 'criteria_empty';
                }
                $unit_condition_output[$key]['criteria'] = $master_condition['criteria'];
                $unit_condition_output[$key]['max_value'] = !empty($master_condition['max_value']) ? $master_condition['max_value'] : 0;
                $unit_condition_output[$key]['criteria_data'] = get_criteria_data($master_condition['criteria']);
            }
            $unit_condition_output[$key]['exp_unit_name'] = !empty($exp_unit['exp_unit_name']) ? $exp_unit['exp_unit_name'] : '';
            $unit_condition_output[$key]['condition_id'] = $master_condition['condition_id'];
            $unit_condition_output[$key]['unit_id'] = $master_condition['unit_id'];
            $unit_condition_output[$key]['unit_constant_id'] = $master_condition['unit_constant_id'];
            $unit_condition_output[$key]['value'] = !empty($master_condition['value']) ? $master_condition['value'] : 0;
            $unit_condition_output[$key]['condition_name'] = $condition_data['condition_name'];
            $unit_condition_output[$key]['unit_constant_name'] = get_unit_constant($condition_data['unit_type']['unit_id'], $master_condition['unit_constant_id']);
            $unit_condition_output[$key]['default_unit'] = $condition_data['unit_type']['default_unit'];
            $unit_condition_output[$key]['default_constant_unit'] = get_unit_constant($condition_data['unit_type']['unit_id'], $condition_data['unit_type']['default_unit']);
        }
    }
    return $unit_condition_output;
}
function unit_outcome_list($simulate_input_id, $criteria = 'forward')
{
    $simulate_input = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'unit_outcome', 'simulate_input_type')->where(['id' => $simulate_input_id])->first();
    $master_outcome_output = [];
    if (!empty($simulate_input['unit_outcome'])) {
        foreach ($simulate_input['unit_outcome'] as $key => $master_outcome) {
            $outcome_data = getOutcomeInfo($master_outcome['outcome_id']);

            $exp_unit = get_experiment_unit_details($simulate_input['experiment_id'], !empty($master_outcome['exp_unit_id']) ? $master_outcome['exp_unit_id'] : 0);
            $master_outcome_output[$key]['id'] = $master_outcome['id'];
            $master_outcome_output[$key]['exp_unit_id'] = $master_outcome['exp_unit_id'];
            if ($simulate_input['simulate_input_type'] == 'reverse') {
                if ($criteria == 'criteria' && empty($master_outcome['criteria'])) {
                    return 'criteria_empty';
                }
                $master_outcome_output[$key]['criteria'] = $master_outcome['criteria'];
                $master_outcome_output[$key]['max_value'] = !empty($master_outcome['max_value']) ? $master_outcome['max_value'] : 0;
                $master_outcome_output[$key]['criteria_data'] = get_criteria_data($master_outcome['criteria']);
                $master_outcome_output[$key]['priority'] = $master_outcome['priority'];
                $master_outcome_output[$key]['priority_name'] = get_priority_name($master_outcome['priority']);
            }
            $master_outcome_output[$key]['exp_unit_name'] = !empty($exp_unit['exp_unit_name']) ? $exp_unit['exp_unit_name'] : '';
            $master_outcome_output[$key]['outcome_id'] = $master_outcome['outcome_id'];
            $master_outcome_output[$key]['unit_id'] = !empty($outcome_data['unit_type']['unit_id']) ? $outcome_data['unit_type']['unit_id'] : 0;
            $master_outcome_output[$key]['unit_constant_id'] = $master_outcome['unit_constant_id'];
            $master_outcome_output[$key]['value'] = !empty($master_outcome['value']) ? $master_outcome['value'] : 0;
            $master_outcome_output[$key]['outcome_name'] = !empty($outcome_data['outcome_name']) ? $outcome_data['outcome_name'] : "";
            $master_outcome_output[$key]['unit_constant_name'] = get_unit_constant($master_outcome['unit_id'], $master_outcome['unit_constant_id']);
            $master_outcome_output[$key]['default_unit'] = $outcome_data['unit_type']['default_unit'];
            $master_outcome_output[$key]['default_constant_unit'] = get_unit_constant($outcome_data['unit_type']['unit_id'], $outcome_data['unit_type']['default_unit']);
        }
    }
    return $master_outcome_output;
}

function master_condition_single($simulate_input_id, $id, $simulate_type = 'foward')
{
    $simulate_input = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'master_condition', 'simulate_input_type')->where(['id' => $simulate_input_id])->first();
    $master_condition_output = [];
    if (!empty($simulate_input['master_condition'])) {
        foreach ($simulate_input['master_condition'] as $key => $master_condition) {
            if ($id == $master_condition['id']) {
                $condition_data = getConditionInfo($master_condition['condition_id']);
                $master_condition_output['id'] = $master_condition['id'];
                $master_condition_output['condition_id'] = $master_condition['condition_id'];
                if ($simulate_input['simulate_input_type'] == 'reverse') {
                    $master_condition_output['max_value'] = !empty($master_condition['max_value']) ? $master_condition['max_value'] : 0;
                    $master_condition_output['criteria'] = $master_condition['criteria'];
                    $master_condition_output['criteria_data'] = get_criteria_data($master_condition['criteria']);
                }
                $master_condition_output['unit_id'] = $condition_data['unit_type']['unit_id'];
                $master_condition_output['unit_constant_id'] = $master_condition['unit_constant_id'];
                $master_condition_output['value'] = !empty($master_condition['value']) ? $master_condition['value'] : 0;
                $master_condition_output['condition_name'] = $condition_data['condition_name'];
                $master_condition_output['unit_constants'] = $condition_data['unit_type']['unit_constants'];
                $master_condition_output['default_unit'] = $condition_data['unit_type']['default_unit'];
                $master_condition_output['unit_constant_name'] = get_unit_constant($master_condition['unit_id'], $master_condition['unit_constant_id']);
            }
        }
    }
    return $master_condition_output;
}


function master_outcome_single($simulate_input_id, $id, $simulate_type = 'foward')
{
    $simulate_input = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'master_outcome', 'simulate_input_type')->where(['id' => $simulate_input_id])->first();
    $master_outcome_output = [];
    if (!empty($simulate_input['master_outcome'])) {
        foreach ($simulate_input['master_outcome'] as $key => $master_outcome) {
            if ($id == $master_outcome['id']) {
                $outcome_data = getOutcomeInfo($master_outcome['outcome_id']);
                $master_outcome_output['id'] = $master_outcome['id'];
                $master_outcome_output['outcome_id'] = $master_outcome['outcome_id'];
                if ($simulate_input['simulate_input_type'] == 'reverse') {
                    $master_outcome_output['criteria'] = $master_outcome['criteria'];
                    $master_outcome_output['max_value'] = !empty($master_outcome['max_value']) ? $master_outcome['max_value'] : 0;
                    $master_outcome_output['criteria_data'] = get_criteria_data($master_outcome['criteria']);
                    $master_outcome_output['priority'] = $master_outcome['priority'];
                    $master_outcome_output['priority_name'] = get_priority_name($master_outcome['priority']);
                }
                $master_outcome_output['unit_id'] = $outcome_data['unit_type']['unit_id'];
                $master_outcome_output['unit_constant_id'] = $master_outcome['unit_constant_id'];
                $master_outcome_output['value'] = !empty($master_outcome['value']) ? $master_outcome['value'] : 0;
                $master_outcome_output['outcome_name'] = $outcome_data['outcome_name'];
                $master_outcome_output['unit_constants'] = $outcome_data['unit_type']['unit_constants'];
                $master_outcome_output['default_unit'] = $outcome_data['unit_type']['default_unit'];
                $master_outcome_output['unit_constant_name'] = get_unit_constant($master_outcome['unit_id'], $master_outcome['unit_constant_id']);
            }
        }
    }
    return $master_outcome_output;
}

function unit_condition_single($simulate_input_id, $id, $simulate_type = 'foward')
{
    $simulate_input = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'unit_condition', 'simulate_input_type')->where(['id' => $simulate_input_id])->first();
    $master_condition_output = [];
    if (!empty($simulate_input['unit_condition'])) {
        foreach ($simulate_input['unit_condition'] as $key => $master_condition) {
            if ($id == $master_condition['id']) {
                $condition_data = getConditionInfo($master_condition['condition_id']);
                $exp_unit = get_experiment_unit_details($simulate_input['experiment_id'], !empty($master_condition['exp_unit_id']) ? $master_condition['exp_unit_id'] : 0);
                $master_condition_output['id'] = $master_condition['id'];
                $master_condition_output['exp_unit_id'] = $master_condition['exp_unit_id'];
                $master_condition_output['exp_unit_name'] = !empty($exp_unit['exp_unit_name']) ? $exp_unit['exp_unit_name'] : '';
                $master_condition_output['condition_id'] = $master_condition['condition_id'];
                if ($simulate_input['simulate_input_type'] == 'reverse') {

                    $master_condition_output['criteria'] = $master_condition['criteria'];
                    $master_condition_output['max_value'] = !empty($master_condition['max_value']) ? $master_condition['max_value'] : 0;
                    $master_condition_output['criteria_data'] = get_criteria_data($master_condition['criteria']);;
                }
                $master_condition_output['unit_id'] = $condition_data['unit_type']['unit_id'];
                $master_condition_output['unit_constant_id'] = $master_condition['unit_constant_id'];
                $master_condition_output['value'] = !empty($master_condition['value']) ? $master_condition['value'] : 0;
                $master_condition_output['condition_name'] = $condition_data['condition_name'];
                $master_condition_output['unit_constants'] = $condition_data['unit_type']['unit_constants'];
                $master_condition_output['default_unit'] = $condition_data['unit_type']['default_unit'];
                $master_condition_output['unit_constant_name'] = get_unit_constant($master_condition['unit_id'], $master_condition['unit_constant_id']);
                $master_condition_output['experiment_id'] = $simulate_input['experiment_id'];
            }
        }
    }
    return $master_condition_output;
}

function unit_outcome_single($simulate_input_id, $id, $simulate_type = 'foward')
{
    $simulate_input = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'unit_outcome', 'simulate_input_type')->where(['id' => $simulate_input_id])->first();
    $master_outcome_output = [];
    if (!empty($simulate_input['unit_outcome'])) {
        foreach ($simulate_input['unit_outcome'] as $key => $master_outcome) {
            if ($id == $master_outcome['id']) {
                $outcome_data = getOutcomeInfo($master_outcome['outcome_id']);
                $exp_unit = get_experiment_unit_details($simulate_input['experiment_id'], !empty($master_outcome['exp_unit_id']) ? $master_outcome['exp_unit_id'] : 0);
                $master_outcome_output['id'] = $master_outcome['id'];
                $master_outcome_output['exp_unit_id'] = $master_outcome['exp_unit_id'];
                $master_outcome_output['exp_unit_name'] = !empty($exp_unit['exp_unit_name']) ? $exp_unit['exp_unit_name'] : '';
                $master_outcome_output['outcome_id'] = $master_outcome['outcome_id'];
                if ($simulate_input['simulate_input_type'] == 'reverse') {
                    $master_outcome_output['max_value'] = !empty($master_outcome['max_value']) ? $master_outcome['max_value'] : 0;
                    $master_outcome_output['criteria'] = $master_outcome['criteria'];
                    $master_outcome_output['criteria_data'] = get_criteria_data($master_outcome['criteria']);
                    $master_outcome_output['priority'] = $master_outcome['priority'];
                    $master_outcome_output['priority_name'] = get_priority_name($master_outcome['priority']);
                }
                $master_outcome_output['unit_id'] = $outcome_data['unit_type']['unit_id'];
                $master_outcome_output['default_unit'] = $outcome_data['unit_type']['default_unit'];
                $master_outcome_output['unit_constants'] = $outcome_data['unit_type']['unit_constants'];
                $master_outcome_output['unit_constant_id'] = $master_outcome['unit_constant_id'];
                $master_outcome_output['value'] = !empty($master_outcome['value']) ? $master_outcome['value'] : 0;
                $master_outcome_output['outcome_name'] = $outcome_data['outcome_name'];
                $master_outcome_output['experiment_id'] = $simulate_input['experiment_id'];
                $master_outcome_output['unit_constant_name'] = get_unit_constant($master_outcome['unit_id'], $master_outcome['unit_constant_id']);
            }
        }
    }
    return $master_outcome_output;
}

function get_tenant_name($tenant_id)
{
    $tenant = Tenant::find(___decrypt($tenant_id));
    return $tenant->name;
}

function get_variation($id)
{
    $varname = Variation::select('name')->where('id', $id)->first();
    return $varname;
}

function get_simulation($id)
{
    $simname = SimulateInput::select('name')->where('id', $id)->first();
    return $simname;
}

function simulate_input_status_change($variation_id, $status)
{
    $simulate_inputs = SimulateInput::where('variation_id', $variation_id)->get();
    if (!empty($simulate_inputs)) {
        foreach ($simulate_inputs as $simulate_input) {
            if ($status == 'inactive') {
                $sim_status = $status;
                $prev_status = $simulate_input->status;
            } else {
                $sim_status = $simulate_input->prev_status;
                $prev_status = $simulate_input->prev_status;
            }
            $simulate_input->status = $sim_status;
            $simulate_input->prev_status = $prev_status;
            $simulate_input->updated_by = Auth::user()->id;
            $simulate_input->updated_at = now();
            $simulate_input->save();
        }
    }
}

function getCriteriaValue($criteria_id, $max = '')
{
    if ($criteria_id == 1)
        $val = '#=';
    else if ($criteria_id == 2)
        $val = '#<';
    else if ($criteria_id == 3)
        $val = '#>';
    else if ($criteria_id == 4)
        $val = ',' . $max . '#Range';
    else
        $val = '#=';
    return $val;
}


function getsinglestreamname($product_id)
{
    try {
        $data = ProcessDiagram::select('name')->where('id', $product_id)->first();
        return $data['name'];
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function getConditionInfo($condition_id)
{
    $condition_info = ExperimentConditionMaster::where('id', $condition_id)->with('unit_types')->first();
    $conditions = [];
    $conditions = [
        "id" => !empty($condition_info->id) ? $condition_info->id : '',
        "condition_name" => !empty($condition_info->name) ? $condition_info->name : '',
        "unit_type" => [
            "unit_id" =>  !empty($condition_info->unit_types->id) ? $condition_info->unit_types->id : '',
            "unit_name" =>  !empty($condition_info->unit_types->unit_name) ? $condition_info->unit_types->unit_name : '',
            "default_unit" => !empty($condition_info->unit_types->default_unit) ? $condition_info->unit_types->default_unit : '',
            "unit_constants" =>  !empty($condition_info->unit_types->unit_constant) ? $condition_info->unit_types->unit_constant : [],
        ]
    ];
    return $conditions;
}

function getOutcomeInfo($outcome_id)
{
    $outcome_info = ExperimentOutcomeMaster::where('id', $outcome_id)->with('unit_types')->first();;
    $outcomes = [];
    if (!empty($outcome_info)) {
        $outcomes = [
            "id" => $outcome_info->id,
            "outcome_name" => $outcome_info->name,
            "unit_type" => [
                "unit_id" => !empty($outcome_info->unit_types->id) ? $outcome_info->unit_types->id : '',
                "unit_name" => !empty($outcome_info->unit_types->unit_name) ? $outcome_info->unit_types->unit_name : '',
                "default_unit" => !empty($outcome_info->unit_types->default_unit) ? $outcome_info->unit_types->default_unit : '',
                "unit_constants" => !empty($outcome_info->unit_types->unit_constant) ? $outcome_info->unit_types->unit_constant : [],
            ]
        ];
    }
    return $outcomes;
}

function get_experiment_unit_name($experiment_unit_id)
{
    try {
        $experiment_unit = ExperimentUnit::find($experiment_unit_id);
        $experiment_info = [
            "id" => $experiment_unit->id,
            "name" => $experiment_unit->unit_name
        ];
        return $experiment_info;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_all_pe_stream_info($experiment_unit_id)
{
    try {
        $experiment_unit = ExperimentUnit::find($experiment_unit_id);
        $stream_flow_info = [];
        foreach ($experiment_unit->stream_flow as $stream_flow) {
            $stream_flow_info = [
                "id" => $stream_flow['id'],
                "name" => $stream_flow['stream_name'],
                "flow_type" => $stream_flow['flow_type'],
            ];
        }
        return $stream_flow_info;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_pe_stream_info($experiment_unit_id, $stream_flow_id)
{
    try {
        $experiment_unit = ExperimentUnit::find($experiment_unit_id);
        $stream_flow_info = [];
        foreach ($experiment_unit->stream_flow as $stream_flow) {
            if ($stream_flow_id == $stream_flow['id']) {
                $stream_flow_info = [
                    "id" => $stream_flow['id'],
                    "name" => $stream_flow['stream_name'],
                    "flow_type" => $stream_flow['flow_type'],
                ];
            }
        }
        return $stream_flow_info;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_mass_flow_type($flow_type_id)
{
    try {
        $flow_type = SimulationFlowType::find($flow_type_id);
        $flow_type_info = [];
        if (!empty($flow_type)) {
            $flow_type_info = [
                "id" => $flow_type->id,
                "name" => $flow_type->flow_type_name
            ];
        }
        return $flow_type_info;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_criteria_name($criteria_id)
{
    $criteria = CriteriaMaster::find($criteria_id);
    return !empty($criteria->name) ? $criteria->name : '';
}

function get_criteria_data($criteria_id)
{
    $criteria = CriteriaMaster::find($criteria_id);
    $data['id'] = !empty($criteria['id']) ? $criteria['id'] : '';
    $data['name'] = !empty($criteria['name']) ? $criteria['name'] : '';
    $data['symbol'] = !empty($criteria['symbol']) ? $criteria['symbol'] : '';
    $data['is_range_type'] = !empty($criteria['is_range_type']) ? $criteria['is_range_type'] : '';
    return $data;
}

function get_priority_name($criteria_id)
{
    $priority = PriorityMaster::find($criteria_id);
    return !empty($priority->name) ? $priority->name : '';
}

function getOutcomeInfoReport($outcome_id)
{
    $outcome_info = ExperimentOutcomeMaster::find($outcome_id);
    $outcomes = [
        "id" => $outcome_info->id,
        "outcome_name" => $outcome_info->name,
        "MAE" => "NA",
        "RMSE" => "NA",
        "accuracy" => "NA",
        "max" => "NA",
        "mean" => "NA",
        "min" => "NA",
        "outcome_name" => $outcome_info->name,
        "std" => "NA"
    ];
    return $outcomes;
}

function getExpUnitname($id, $expunitId)
{
    $experiment_units = [];
    $process_experiment = ProcessExperiment::find(($id));
    if (!empty($process_experiment->experiment_unit)) {
        foreach ($process_experiment->experiment_unit as $experiment_unit) {
            if ($experiment_unit['id'] == $expunitId) {
                return $experiment_unit['unit'];
            }
        }
    }
}

function getOutcomeName($outcome_id)
{
    $outcome_info = ExperimentOutcomeMaster::find($outcome_id);
    return $outcome_info->name;
}

function getConditionName($condition_id)
{
    $con_info = ExperimentConditionMaster::find($condition_id);
    if (!empty($con_info->name)) {
        return $con_info->name;
    } else {
        return '';
    }
}

function getConditionInfoReport($condition_id, $unit_constant_id)
{
    $condition_info = ExperimentConditionMaster::find($condition_id);
    $unit_info = MasterUnit::find($condition_info->unittype);
    $unit_constant = [];
    foreach ($unit_info->unit_constant as $unit_constant_info) {
        if ($unit_constant_id == $unit_constant_info['id']) {
            $unit_constant = $unit_constant_info;
        }
    }
    $condition = [
        "condition_name" => (!empty($condition_info->name)) ? $condition_info->name : "",
        "value" => (!empty($condition_info->value)) ? $condition_info->value : "0",
        "unit_name" => (!empty($unit_info->unit_name)) ? $unit_info->unit_name : "",
        "unit_constant_name" => (!empty($unit_constant['unit_name'])) ? $unit_constant['unit_name'] : "",
        "unit_constant_symbol" => (!empty($unit_constant['unit_symbol'])) ? $unit_constant['unit_symbol'] : ""
    ];
    return $condition;
}

function templateUsed($template_id)
{
    $check_template_used = SimulateInput::where('template_id', $template_id)->first();
    return $check_template_used;
}

function getsingleFlowtyeName($flow_type_id)
{
    $data = SimulationFlowType::select('flow_type_name')->where('id', $flow_type_id)->first();
    return $data['flow_type_name'];
}

function insert_simulate_input($variation_id, $request)
{
    $variation = Variation::find($variation_id);
    $simulate_data = SimulateInput::where(['variation_id' => $variation_id, 'experiment_id' => $variation->experiment_id, 'simulate_input_type' => 'forward'])->first();
    //if (empty($simulate_data)) {
    $master_product_io = [];
    if (!empty($variation['process_flow_table'])) {
        $key = 0;
        foreach ($variation['process_flow_table'] as $key => $process_diagram_id) {
            $process_diagram_data = ProcessDiagram::find($process_diagram_id);
            if (!empty($process_diagram_data) && $process_diagram_data->openstream == 1) {
                $process_diagram[$key]['id'] = intval($key + 1);
                $process_diagram[$key]['pfd_stream_id'] = $process_diagram_data->id;
                $process_diagram[$key]['unit_id'] = 0;
                $process_diagram[$key]['value_flow_rate'] = 0;
                $process_diagram[$key]['unit_constant_id'] = 0;
                $process_diagram[$key]['product'] = [];
            }
        }
        $master_product_io = $process_diagram;
    }
    $master_conditions = [];
    if (!empty($variation['unit_specification']['master_units'])) {
        $key = 0;
        $master_unit_id = $variation['unit_specification']['master_units'];
        // foreach ($variation['unit_specification']['master_units'] as  $condition_value) {
        $condition_data = ProcessExpProfileMaster::Select('id', 'condition')->where('id', $master_unit_id)->first();
        if (!empty($condition_data['condition'])) {
            foreach ($condition_data['condition'] as  $value) {
                $master_conditions[$key]['id'] = $key + 1;
                $master_conditions[$key]['condition_id'] = $value;
                $master_conditions[$key]['unit_id'] = 0;
                $master_conditions[$key]['criteria'] = 0;
                $master_conditions[$key]['priority'] = 0;
                $master_conditions[$key]['max_value'] = 0;
                $master_conditions[$key]['value'] = 0;
                $master_conditions[$key]['unit_constant_id'] = 0;
                $key++;
            }
        }
        //  }
    }
    $master_outcomes = [];
    if (!empty($variation['unit_specification']['master_units'])) {
        $key = 0;
        $master_unit_id = $variation['unit_specification']['master_units'];
        // foreach ($variation['unit_specification']['master_units'] as  $outcome_value) {
        $outcome_data = ProcessExpProfileMaster::Select('id', 'outcome')->where('id', $master_unit_id)->first();
        foreach ($outcome_data['outcome'] as  $value) {
            $defaultUnit = getOutcomeInfo($value);
            $master_outcomes[$key]['id'] = $key + 1;
            $master_outcomes[$key]['outcome_id'] = $value;
            $master_outcomes[$key]['unit_id'] = $defaultUnit['unit_type']['unit_id'];
            $master_outcomes[$key]['criteria'] = 0;
            $master_outcomes[$key]['priority'] = 0;
            $master_outcomes[$key]['max_value'] = 0;
            $master_outcomes[$key]['value'] = 0;
            $master_outcomes[$key]['unit_constant_id'] = $defaultUnit['unit_type']['default_unit'];;
            $key++;
        }
        //}
    }
    $exp_unit_outcomes = [];
    $exp_unit_conditions = [];
    if (!empty($variation['unit_specification']['experiment_units'])) {
        $i = 0;
        foreach ($variation['unit_specification']['experiment_units'] as  $outcome_value) {
            $outcome_data = ProcessExpProfile::Select('id', 'experiment_unit', 'outcome')->where(['id' => $outcome_value, 'variation_id' => $variation['id']])->first();
            if (!empty($outcome_data['outcome'])) {
                foreach ($outcome_data['outcome'] as  $value) {
                    $defaultUnit = getOutcomeInfo($value);
                    $exp_unit_outcomes[$i]['id'] = $i + 1;
                    $exp_unit_outcomes[$i]['exp_unit_id'] = $outcome_data['experiment_unit'];
                    $exp_unit_outcomes[$i]['outcome_id'] = $value;
                    $exp_unit_outcomes[$i]['unit_id'] = $defaultUnit['unit_type']['unit_id'];
                    $exp_unit_outcomes[$i]['criteria'] = 0;
                    $exp_unit_outcomes[$i]['priority'] = 0;
                    $exp_unit_outcomes[$i]['max_value'] = 0;
                    $exp_unit_outcomes[$i]['value'] = 0;
                    $exp_unit_outcomes[$i]['unit_constant_id'] = $defaultUnit['unit_type']['default_unit'];;;
                    $i++;
                }
            }
        }
    }
    if (!empty($variation['unit_specification']['experiment_units'])) {
        $j = 0;
        foreach ($variation['unit_specification']['experiment_units'] as  $condition_value) {
            $condition_data = ProcessExpProfile::Select('id', 'condition', 'experiment_unit')->where(['id' => $condition_value, 'variation_id' => $variation['id']])->first();
            if (!empty($condition_data['condition'])) {
                foreach ($condition_data['condition'] as  $value) {
                    $exp_unit_conditions[$j]['id'] = $j + 1;
                    $exp_unit_conditions[$j]['exp_unit_id'] = $condition_data['experiment_unit'];
                    $exp_unit_conditions[$j]['condition_id'] = $value;
                    $exp_unit_conditions[$j]['unit_id'] = 0;
                    $exp_unit_conditions[$j]['criteria'] = 0;
                    $exp_unit_conditions[$j]['priority'] = 0;
                    $exp_unit_conditions[$j]['value'] = 0;
                    $exp_unit_conditions[$j]['max_value'] = 0;
                    $exp_unit_conditions[$j]['unit_constant_id'] = 0;
                    $j++;
                }
            }
        }
    }
    if (!empty($exp_unit_conditions)) {
        $exp_u_con_sort = array_column($exp_unit_conditions, 'exp_unit_id');
        array_multisort($exp_u_con_sort, SORT_ASC, $exp_unit_conditions);
    }
    if (!empty($exp_unit_outcomes)) {
        $exp_u_outcome_sort = array_column($exp_unit_outcomes, 'exp_unit_id');
        array_multisort($exp_u_outcome_sort, SORT_ASC, $exp_unit_outcomes);
    }
    $simulate_input = new SimulateInput;
    $simulate_input->experiment_id = $variation->experiment_id;
    $simulate_input->variation_id = $variation_id;
    $simulate_input->name = $request->name;
    $simulate_input->notes = $request->description;;
    $simulate_input->raw_material = $master_product_io;
    $simulate_input->master_condition = $master_conditions;
    $simulate_input->master_outcome = $master_outcomes;
    $simulate_input->unit_condition = $exp_unit_conditions;
    $simulate_input->unit_outcome = $exp_unit_outcomes;
    $simulate_input->simulate_input_type = 'forward';
    $simulate_input->simulation_type = [];
    $simulate_input->created_by = Auth::user()->id;
    $simulate_input->updated_by = Auth::user()->id;
    $simulate_input->save();
    //}
    return true;
}

function insert_simulate_input_reverse($variation_id, $request)
{
    $variation = Variation::find($variation_id);
    $simulate_data = SimulateInput::where(['variation_id' => $variation_id, 'experiment_id' => $variation->experiment_id, 'simulate_input_type' => 'reverse'])->first();
    // if (empty($simulate_data)) {
    $master_product_io = [];
    if (!empty($variation['process_flow_table'])) {
        $key = 0;
        foreach ($variation['process_flow_table'] as $key => $process_diagram_id) {
            $process_diagram_data = ProcessDiagram::find($process_diagram_id);
            if (!empty($process_diagram_data) && $process_diagram_data->openstream == 1) {
                $process_diagram[$key]['id'] = intval($key + 1);
                $process_diagram[$key]['pfd_stream_id'] = $process_diagram_data->id;
                $process_diagram[$key]['unit_id'] = 0;
                $process_diagram[$key]['value_flow_rate'] = 0;
                $process_diagram[$key]['unit_constant_id'] = 0;
                $process_diagram[$key]['product'] = [];
            }
        }
        $master_product_io = $process_diagram;
    }
    $master_conditions = [];
    if (!empty($variation['unit_specification']['master_units'])) {
        $key = 0;
        $master_unit_id = $variation['unit_specification']['master_units'];
        // foreach ($variation['unit_specification']['master_units'] as  $condition_value) {
        $condition_data = ProcessExpProfileMaster::Select('id', 'condition')->where('id', $master_unit_id)->first();
        if (!empty($condition_data['condition'])) {
            foreach ($condition_data['condition'] as  $value) {
                $master_conditions[$key]['id'] = $key + 1;
                $master_conditions[$key]['condition_id'] = $value;
                $master_conditions[$key]['unit_id'] = 0;
                $master_conditions[$key]['criteria'] = 0;
                $master_conditions[$key]['priority'] = 0;
                $master_conditions[$key]['max_value'] = 0;
                $master_conditions[$key]['value'] = 0;
                $master_conditions[$key]['unit_constant_id'] = 0;
                $key++;
            }
        }
        // }
    }
    $master_outcomes = [];
    if (!empty($variation['unit_specification']['master_units'])) {
        $key = 0;
        $master_unit_id = $variation['unit_specification']['master_units'];
        $outcome_data = ProcessExpProfileMaster::Select('id', 'outcome')->where('id', $master_unit_id)->first();
        foreach ($outcome_data['outcome'] as  $value) {
            $master_outcomes[$key]['id'] = $key + 1;
            $master_outcomes[$key]['outcome_id'] = $value;
            $master_outcomes[$key]['unit_id'] = 0;
            $master_outcomes[$key]['criteria'] = 0;
            $master_outcomes[$key]['priority'] = 0;
            $master_outcomes[$key]['max_value'] = 0;
            $master_outcomes[$key]['value'] = 0;
            $master_outcomes[$key]['unit_constant_id'] = 0;
            $key++;
        }
        //}
    }
    $exp_unit_outcomes = [];
    $exp_unit_conditions = [];
    if (!empty($variation['unit_specification']['experiment_units'])) {
        $i = 0;
        foreach ($variation['unit_specification']['experiment_units'] as  $outcome_value) {
            $outcome_data = ProcessExpProfile::Select('id', 'experiment_unit', 'outcome')->where(['id' => $outcome_value, 'variation_id' => $variation['id']])->first();
            if (!empty($outcome_data['outcome'])) {
                foreach ($outcome_data['outcome'] as  $value) {
                    $exp_unit_outcomes[$i]['id'] = $i + 1;
                    $exp_unit_outcomes[$i]['exp_unit_id'] = $outcome_data['experiment_unit'];
                    $exp_unit_outcomes[$i]['outcome_id'] = $value;
                    $exp_unit_outcomes[$i]['unit_id'] = '';
                    $exp_unit_outcomes[$i]['criteria'] = 0;
                    $exp_unit_outcomes[$i]['priority'] = 0;
                    $exp_unit_outcomes[$i]['max_value'] = 0;
                    $exp_unit_outcomes[$i]['value'] = 0;
                    $exp_unit_outcomes[$i]['unit_constant_id'] = 0;
                    $i++;
                }
            }
        }
    }
    if (!empty($variation['unit_specification']['experiment_units'])) {
        $j = 0;
        foreach ($variation['unit_specification']['experiment_units'] as  $condition_value) {
            $condition_data = ProcessExpProfile::Select('id', 'condition', 'experiment_unit')->where(['id' => $condition_value, 'variation_id' => $variation['id']])->first();
            if (!empty($condition_data['condition'])) {
                foreach ($condition_data['condition'] as  $value) {
                    $exp_unit_conditions[$j]['id'] = $j + 1;
                    $exp_unit_conditions[$j]['exp_unit_id'] = $condition_data['experiment_unit'];
                    $exp_unit_conditions[$j]['condition_id'] = $value;
                    $exp_unit_conditions[$j]['unit_id'] = 0;
                    $exp_unit_conditions[$j]['criteria'] = 0;
                    $exp_unit_conditions[$j]['priority'] = 0;
                    $exp_unit_conditions[$j]['value'] = 0;
                    $exp_unit_conditions[$j]['max_value'] = 0;
                    $exp_unit_conditions[$j]['unit_constant_id'] = 0;
                    $j++;
                }
            }
        }
    }
    if (!empty($exp_unit_conditions)) {
        $exp_u_con_sort = array_column($exp_unit_conditions, 'exp_unit_id');
        array_multisort($exp_u_con_sort, SORT_ASC, $exp_unit_conditions);
    }
    if (!empty($exp_unit_outcomes)) {
        $exp_u_outcome_sort = array_column($exp_unit_outcomes, 'exp_unit_id');
        array_multisort($exp_u_outcome_sort, SORT_ASC, $exp_unit_outcomes);
    }
    $simulate_input = new SimulateInput;
    $simulate_input->experiment_id = $variation->experiment_id;
    $simulate_input->variation_id = $variation_id;
    $simulate_input->name = $request->name;
    $simulate_input->notes = $request->description;
    $simulate_input->raw_material = $master_product_io;
    $simulate_input->master_condition = $master_conditions;
    $simulate_input->master_outcome = $master_outcomes;
    $simulate_input->unit_condition = $exp_unit_conditions;
    $simulate_input->unit_outcome = $exp_unit_outcomes;
    $simulate_input->simulate_input_type = 'reverse';
    $simulate_input->simulation_type = [];
    $simulate_input->created_by = Auth::user()->id;
    $simulate_input->updated_by = Auth::user()->id;
    $simulate_input->save();
    // }
    return true;
}

function getExpunit($peid, $exp_unit_id)
{
    $process_exp_info = ProcessExperiment::find(___decrypt($peid));
    $expname = 0;
    if (!empty($process_exp_info)) {
        foreach ($process_exp_info->experiment_unit as $exp_unit) {
            if ($exp_unit['id'] == $exp_unit_id) {
                $expname = $exp_unit['exp_unit'];
            }
        }
    }
    return  $expname;
}

function getProcessExpDetail($id)
{
    $process_exp = ProcessExperiment::select('id', 'experiment_unit')->where('id', ___decrypt($id))->first();
    return $process_exp;
}

function get_process_experiment_unit($process_experiment_id, $experiment_unit_id = '0')
{
    $process_exp = ProcessExperiment::Select('id', 'experiment_unit')->where('id', $process_experiment_id)->first();
    foreach ($process_exp->experiment_unit as $key => $value) {
        if ($value['id'] == $experiment_unit_id) {
            $data_exp['id'] = $value['id'];
            $data_exp['exp_unit_id'] = $value['exp_unit'];
            $data_exp['exp_unit_name'] = $value['unit'];
        }
    }
    if (!empty($data_exp)) {
        $exp_data = ExperimentUnit::where('id', $data_exp['exp_unit_id'])->first();
        $equipmentdata = EquipmentUnit::select('condition', 'outcome', 'stream_flow')->where('id', $exp_data->equipment_unit_id)->first();
        $conditions = [];
        if (!empty($equipmentdata->condition)) {
            foreach ($equipmentdata->condition as $condition) {
                $condition_info = ExperimentConditionMaster::find($condition);
                $conditions[] = [
                    "id" => $condition_info->id,
                    "condition_name" => $condition_info->name,
                    "unit_type" => [
                        "unit_id" => $condition_info->unit_types->id,
                        "unit_name" => $condition_info->unit_types->unit_name,
                        "default_unit" => !empty($condition_info->unit_types->default_unit) ? $condition_info->unit_types->default_unit : '',
                        "unit_constants" => $condition_info->unit_types->unit_constant,
                    ]
                ];
            }
        }
        $outcomes = [];
        if (!empty($equipmentdata->outcome)) {
            foreach ($equipmentdata->outcome as $outcome) {
                $outcome_info = ExperimentOutcomeMaster::find($outcome);
                $outcomes[] = [
                    "id" => $outcome_info->id,
                    "outcome_name" => $outcome_info->name,
                    "unit_type" => [
                        "unit_id" => $outcome_info->unit_types->id,
                        "unit_name" => $outcome_info->unit_types->unit_name,
                        "default_unit" => !empty($outcome_info->unit_types->default_unit) ? $outcome_info->unit_types->default_unit : '',
                        "unit_constants" => $outcome_info->unit_types->unit_constant,
                    ]
                ];
            }
        }
        $experiment_unit_info = [
            "id" => $exp_data->id,
            "experiment_unit" => $data_exp,
            "condition" => $conditions,
            "outcome" => $outcomes,
            "stream_flow" => $exp_data->stream_flow
        ];
    } else {
        $experiment_unit_info = 'no_data';
    }

    return $experiment_unit_info;
}

function get_experiment_unit_details($experiment_id, $experiment_unit_id)
{
    $process_exp = ProcessExperiment::Select('id', 'experiment_unit')->where('id', $experiment_id)->first();

    $data_exp = [];
    foreach ($process_exp->experiment_unit as $key => $value) {
        if ($value['id'] == $experiment_unit_id) {
            $data_exp['id'] = $value['id'];
            $data_exp['exp_unit_id'] = $value['exp_unit'];
            $data_exp['exp_unit_name'] = $value['unit'];
        }
    }
    return $data_exp;
}

function get_experiment_unit($experiment_unit_id)
{
    $experiment_unit = ExperimentUnit::select('id', 'experiment_unit_name', 'equipment_unit_id')->where('id', $experiment_unit_id)->with('exp_equip_unit')->first();
    if (!empty($experiment_unit->equipment_unit_id)) {
        $equipmentdata = EquipmentUnit::select('condition', 'outcome', 'stream_flow')->where('id', $experiment_unit->equipment_unit_id)->first();
    }
    $conditions = [];
    if (!empty($equipmentdata->condition)) {
        $condition_infos = ExperimentConditionMaster::whereIn('id', $equipmentdata->condition)->with('unit_types')->get();
        foreach ($condition_infos as $ck => $condition_info) {
            $conditions[] = [
                "id" => $condition_info->id,
                "condition_name" => $condition_info->name,
                "unit_type" => [
                    "unit_id" => !empty($condition_info->unit_types->id) ? $condition_info->unit_types->id : '',
                    "unit_name" => !empty($condition_info->unit_types->unit_name) ? $condition_info->unit_types->unit_name : '',
                    "default_unit" => !empty(json_decode($condition_info->unit_types->default_unit)) ? json_decode($condition_info->unit_types->default_unit) : '',
                    "unit_constants" => !empty($condition_info->unit_types->unit_constant) ? $condition_info->unit_types->unit_constant : '',
                ]
            ];
        }
    }
    $outcomes = [];
    if (!empty($equipmentdata->outcome)) {
        $outcome_infos = ExperimentOutcomeMaster::whereIn('id', $equipmentdata->outcome)->with('unit_types')->get();
        foreach ($outcome_infos as $ok => $outcome_info) {
            $outcomes[] = [
                "id" => $outcome_info->id,
                "outcome_name" => $outcome_info->name,
                "unit_type" => [
                    "unit_id" => $outcome_info->unit_types->id,
                    "unit_name" => $outcome_info->unit_types->unit_name,
                    "default_unit" => !empty(json_decode($outcome_info->unit_types->default_unit)) ? json_decode($outcome_info->unit_types->default_unit) : '',
                    "unit_constants" => $outcome_info->unit_types->unit_constant,
                ]
            ];
        }
    }
    $experiment_unit_info = [
        "id" =>  !empty($experiment_unit->id) ? $experiment_unit->id : 0,
        "experiment_unit_name" => !empty($experiment_unit->experiment_unit_name) ? $experiment_unit->experiment_unit_name : '',
        "unit_image" => [
            "id" => !empty($experiment_unit->exp_equip_unit->id) ? $experiment_unit->exp_equip_unit->id : '',
            "equipment_name" => !empty($experiment_unit->exp_equip_unit->equipment_name) ? $experiment_unit->exp_equip_unit->equipment_name : '',
            "parameter_details" => !empty($experiment_unit->exp_equip_unit->parameters_details) ? $experiment_unit->exp_equip_unit->parameters_details : '',
            "unit_image_info" => [
                "unit_image_name" => !empty($experiment_unit->exp_equip_unit->exp_unit_image->name) ? $experiment_unit->exp_equip_unit->exp_unit_image->name : '',
                "unit_image_url" => !empty($experiment_unit->exp_equip_unit->exp_unit_image->image) ? $experiment_unit->exp_equip_unit->exp_unit_image->image : '',
            ]
        ],
        "stream_flow" => !empty($equipmentdata->stream_flow) ? $equipmentdata->stream_flow : [],
        "condition" => !empty($conditions) ? $conditions : [],
        "outcome" => !empty($outcomes) ? $outcomes : []
    ];
    return $experiment_unit_info;
}


function get_flow_type($flow_type_id)
{
    $flow_type = SimulationFlowType::find($flow_type_id);
    if ($flow_type->type == "1") {
        $type = "Mass Input";
    } else if ($flow_type->type == "2") {
        $type = "Mass Output";
    } else if ($flow_type->type == "3") {
        $type = "Others";
    }
    $flow_type_info = [
        'id' => $flow_type->id,
        'name' => $flow_type->flow_type_name,
        'flow_type' => [
            'id' => $flow_type->type,
            'flow_type_name' => $type
        ],
    ];
    return $flow_type_info;
}


function getMassBalanceDetail($processId, $simulation_stage_id, $data_source_type, $data_source_id, $type)
{
    $ps_details = ProcessProfile::where([['process_id', $processId], ['simulation_type', ___decrypt($simulation_stage_id)]])->get();
    $p_details = [];
    $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
    $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
    $pcinputflow = array_column($buiFlowTypeInput->toArray(), 'id');
    $pcoutputflow = array_column($buiFlowTypeOutput->toArray(), 'id');
    $prop_details = $ps_details->toArray();
    $pc_input = [];
    $pc_output = [];
    foreach ($prop_details as $key => $value) {
        if (!empty($value['mass_basic_io'])) {
            $p_details['basic_user_input']['data_source_type'] = $data_source_type;
            $p_details['basic_user_input']['data_source_id'] = 1;
            foreach ($value['mass_basic_io'][$type] as $k => $v) {
                if ($type == "input" && in_array($v['flowtype'], $pcinputflow)) {
                    $p_details['basic_user_input']['product_list'][$k]['product_id'] = (int)$v['product_input'];
                    $p_details['basic_user_input']['product_list'][$k]['flow_type_id'] = (int)$v['flowtype'];
                    $p_details['basic_user_input']['product_list'][$k]['mass_flow_rate'] = (float)$v['massflow'];
                    $p_details['basic_user_input']['product_list'][$k]['unit_id'] = (int)$v['unit'];
                    $p_details['basic_user_input']['product_list'][$k]['unit_constant_id'] = (int)$v['unit_constant_id'];
                }
                if ($type == "output" && in_array($v['flowtype'], $pcoutputflow)) {
                    $p_details['basic_user_input']['product_list'][$k]['product_id'] = (int)$v['product_output'];
                    $p_details['basic_user_input']['product_list'][$k]['flow_type_id'] = (int)$v['flowtype'];
                    $p_details['basic_user_input']['product_list'][$k]['mass_flow_rate'] = (float)$v['massflow'];
                    $p_details['basic_user_input']['product_list'][$k]['unit_id'] = (int)$v['unit'];
                    $p_details['basic_user_input']['product_list'][$k]['unit_constant_id'] = (int)$v['unit_constant_id'];
                }
            }
        }
        $pc_input = [];
        $pc_output = [];
        if (!empty($value['mass_basic_pc'])) {
            $mass_basic_pc = array_merge($value['mass_basic_pc']);
            foreach ($mass_basic_pc as $pckey => $pcval) {
                $p_details['process_chemstry']['data_source_type'] = $data_source_type;
                $p_details['process_chemstry']['data_source_id'] = 2;
                foreach ($pcval['input'] as $kc => $vc) {
                    if ($type == "input" && in_array($vc['flowtype'], $pcinputflow)) {
                        $pc_input[$pckey][$kc]['product_id'] = (int)$vc['product'];
                        $pc_input[$pckey][$kc]['flow_type_id'] = (int)$vc['flowtype'];
                        $pc_input[$pckey][$kc]['mass_flow_rate'] = (float)$vc['mass_flow_rate'];
                        $pc_input[$pckey][$kc]['unit_constant_id'] = (int)$vc['unit_constant_id'];
                        $pc_input[$pckey][$kc]['unit_id'] = (int)$vc['unit_id'];
                    }
                    if ($type == "output" && in_array($vc['flowtype'], $pcoutputflow)) {
                        $pc_output[$pckey][$kc]['product_id'] = (int)$vc['product'];
                        $pc_output[$pckey][$kc]['flow_type_id'] = (int)$vc['flowtype'];
                        $pc_output[$pckey][$kc]['mass_flow_rate'] = (float)$vc['mass_flow_rate'];
                        $pc_output[$pckey][$kc]['unit_constant_id'] = (int)$vc['unit_constant_id'];
                        $pc_output[$pckey][$kc]['unit_id'] = (int)$vc['unit_id'];
                    }
                }
            }
            $pcarrInput = [];
            if (!empty($pc_input)) {
                foreach ($pc_input as $pi => $pctypeInput) {
                    if (!empty($pctypeInput)) {
                        foreach ($pctypeInput as $pci) {
                            $pcarrInput[] = [
                                "product_id" => $pci['product_id'],
                                "flow_type_id" => $pci['flow_type_id'],
                                "mass_flow_rate" => $pci['mass_flow_rate'],
                                "unit_constant_id" => $pci['unit_constant_id'],
                                "unit_id" => $pci['unit_id']
                            ];
                        }
                    }
                }
            }
            $pcarrOutput = [];
            if (!empty($pc_output)) {
                foreach ($pc_output as $po => $pctypeOutput) {
                    if (!empty($pctypeOutput)) {
                        foreach ($pctypeOutput as $pco) {
                            $pcarrOutput[] = [
                                "product_id" => $pco['product_id'],
                                "flow_type_id" => $pco['flow_type_id'],
                                "mass_flow_rate" => $pco['mass_flow_rate'],
                                "unit_constant_id" => $pco['unit_constant_id'],
                                "unit_id" => $pco['unit_id']
                            ];
                        }
                    }
                }
            }
            if ($type == "output") {
                $p_details['process_chemstry']['product_list'] = $pcarrOutput;
            }
            if ($type == "input") {
                $p_details['process_chemstry']['product_list'] = $pcarrInput;
            }
        }
        $pd_input = [];
        $pd_output = [];
        if (!empty($value['mass_basic_pd'])) {
            $mass_basic_pdArr = array_merge($value['mass_basic_pd']);
            foreach ($mass_basic_pdArr as $pdkey => $pdval) {
                if ($pdkey != "sel") {
                    if (!empty($pdval['input'])) {
                        $p_details['process_detail']['data_source_type'] = $data_source_type;
                        $p_details['process_detail']['data_source_id'] = 3;
                        foreach ($pdval['input'] as $kk => $vv) {
                            if ($type == "input" && in_array($vv['flowtype'], $pcinputflow)) {
                                $pd_input[$pdkey][$kk]['product_id'] = (int)$vv['product'];
                                $pd_input[$pdkey][$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                $pd_input[$pdkey][$kk]['mass_flow_rate'] = (float)$vv['mass_flow_rate'];
                                $pd_input[$pdkey][$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                $pd_input[$pdkey][$kk]['unit_id'] = (int)$vv['unit_id'];
                            }
                            if ($type == "output" && in_array($vv['flowtype'], $pcoutputflow)) {
                                $pd_output[$pdkey][$kk]['product_id'] = (int)$vv['product'];
                                $pd_output[$pdkey][$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                $pd_output[$pdkey][$kk]['mass_flow_rate'] = (float)$vv['mass_flow_rate'];
                                $pd_output[$pdkey][$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                $pd_output[$pdkey][$kk]['unit_id'] = (int)$vv['unit_id'];
                            }
                        }
                    }
                }
            }
            $pdarrInput = [];
            if (!empty($pd_input)) {
                foreach ($pd_input as $pi => $pdtypeInput) {
                    if (!empty($pdtypeInput)) {
                        foreach ($pdtypeInput as $pci) {
                            $pdarrInput[] = [
                                "product_id" => $pci['product_id'],
                                "product_id" => $pci['product_id'],
                                "flow_type_id" => $pci['flow_type_id'],
                                "mass_flow_rate" => $pci['mass_flow_rate'],
                                "unit_constant_id" => $pci['unit_constant_id'],
                                "unit_id" => $pci['unit_id']
                            ];
                        }
                    }
                }
            }
            $pdarrOutput = [];
            if (!empty($pd_output)) {
                foreach ($pd_output as $po => $pdtypeOutput) {
                    if (!empty($pdtypeOutput)) {
                        foreach ($pdtypeOutput as $pco) {
                            $pdarrOutput[] = [
                                "product_id" => $pco['product_id'],
                                "product_id" => $pco['product_id'],
                                "flow_type_id" => $pco['flow_type_id'],
                                "mass_flow_rate" => $pco['mass_flow_rate'],
                                "unit_constant_id" => $pco['unit_constant_id'],
                                "unit_id" => $pco['unit_id']
                            ];
                        }
                    }
                }
            }
            if ($type == "output") {
                $p_details['process_detail']['product_list'] = $pdarrOutput;
            }
            if ($type == "input") {
                $p_details['process_detail']['product_list'] = $pdarrInput;
            }
        }
    }
    $data = [];
    if (!empty($data_source_id) && $data_source_id == 1) {
        if (!empty($p_details['basic_user_input'])) {
            $data = array_merge($p_details['basic_user_input']);
        }
    } elseif (!empty($data_source_id) && $data_source_id == 2) {
        if (!empty($p_details['process_chemstry'])) {
            $data = array_merge($p_details['process_chemstry']);
        }
    } elseif (!empty($data_source_id) &&  $data_source_id == 3) {
        if (!empty($p_details['process_detail'])) {
            $data = array_merge($p_details['process_detail']);
        }
    }
    if ($data_source_id == 0) {
        foreach ($p_details as $pk => $pv) {
            $data[] = $pv;
        }
        $data = array_merge($data);
    }
    return  $data;
}


function getEnergyBalanceDetail($processId, $simulation_stage_id, $data_source_type, $data_source_id, $type)
{
    $ps_details = ProcessProfile::where([['process_id', $processId], ['simulation_type', ___decrypt($simulation_stage_id)]])->get();
    $p_details = [];
    $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
    $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
    $pcinputflow = array_column($buiFlowTypeInput->toArray(), 'id');
    $pcoutputflow = array_column($buiFlowTypeOutput->toArray(), 'id');
    $prop_details = $ps_details->toArray();
    foreach ($prop_details as $key => $value) {
        if (!empty($value['energy_basic_io'])) {
            $p_details['basic_user_input']['data_source_type'] = $data_source_type;
            $p_details['basic_user_input']['data_source_id'] = 1;
            foreach ($value['energy_basic_io'][$type] as $k => $v) {
                if ($type == "input" && in_array($v['flowtype'], $pcinputflow)) {
                    $p_details['basic_user_input']['product_list'][$k]['energy_utility_id'] = (int)$v['product_input'];
                    $p_details['basic_user_input']['product_list'][$k]['flow_type_id'] = (int)$v['flowtype'];
                    $p_details['basic_user_input']['product_list'][$k]['mass_flow_rate'] = (float)$v['input_flow_rate'];
                    $p_details['basic_user_input']['product_list'][$k]['unit_id'] = (int)$v['unit'];
                    $p_details['basic_user_input']['product_list'][$k]['unit_constant_id'] = (int)$v['unit_constant_id'];
                }
                if ($type == "output" && in_array($v['flowtype'], $pcoutputflow)) {
                    $p_details['basic_user_input']['product_list'][$k]['energy_utility_id'] = (int)$v['product_output'];
                    $p_details['basic_user_input']['product_list'][$k]['flow_type_id'] = (int)$v['flowtype'];
                    $p_details['basic_user_input']['product_list'][$k]['mass_flow_rate'] = (float)$v['input_flow_rate'];
                    $p_details['basic_user_input']['product_list'][$k]['unit_id'] = (int)$v['unit'];
                    $p_details['basic_user_input']['product_list'][$k]['unit_constant_id'] = (int)$v['unit_constant_id'];
                }
            }
        }
        if (!empty($value['energy_process_level'])) {
            $energy_process_level = array_merge($value['energy_process_level']);
            foreach ($energy_process_level as $pckey => $pcval) {
                $p_details['energy_process_level']['data_source_type'] = $data_source_type;
                $p_details['energy_process_level']['data_source_id'] = 2;
                if ($pckey != "sel") {
                    $pl_input = [];
                    foreach ($pcval['input'] as $k => $v) {
                        if ($type == "input" && in_array($v['flowtype'], $pcinputflow)) {
                            $pl_input[$k]['energy_utility_id'] = (int)$v['energy'];
                            $pl_input[$k]['flow_type_id'] = (int)$v['flowtype'];
                            $pl_input[$k]['mass_flow_rate'] = (float)$v['energy_value'];
                            $pl_input[$k]['unit_constant_id'] = (int)$v['unit_constant_id'];
                            $pl_input[$k]['unit_id'] = (int)$v['unit'];
                        }
                        if ($type == "output" && in_array($v['flowtype'], $pcoutputflow)) {
                            $pl_input[$k]['energy_utility_id'] = (int)$v['energy'];
                            $pl_input[$k]['flow_type_id'] = (int)$v['flowtype'];
                            $pl_input[$k]['mass_flow_rate'] = (float)$v['energy_value'];
                            $pl_input[$k]['unit_constant_id'] = (int)$v['unit_constant_id'];
                            $pl_input[$k]['unit_id'] = (int)$v['unit'];
                        }
                    }
                    $p_details['energy_process_level']['product_list'][$pckey][$k] = array_merge($pl_input);
                }
            }
        }
        if (!empty($value['energy_detailed_level'])) {
            $energy_detailed_levelArr = array_merge($value['energy_detailed_level']);
            foreach ($energy_detailed_levelArr as $pdkey => $pdval) {
                if ($pdkey != "sel") {
                    $edl_input = [];
                    if (!empty($pdval['input'])) {
                        $p_details['energy_detailed_level']['data_source_type'] = $data_source_type;
                        $p_details['energy_detailed_level']['data_source_id'] = 3;
                        foreach ($pdval['input'] as $kk => $vv) {
                            if ($type == "input" && in_array($vv['flowtype'], $pcinputflow)) {
                                $edl_input[$kk]['energy_utility_id'] = (int)$vv['energy'];
                                $edl_input[$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                $edl_input[$kk]['mass_flow_rate'] = (float)$vv['energy_value'];
                                $edl_input[$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                $edl_input[$kk]['unit_id'] = (int)$vv['unit'];
                            }
                            if ($type == "output" && in_array($vv['flowtype'], $pcoutputflow)) {
                                $edl_input[$kk]['energy_utility_id'] = (int)$vv['energy'];
                                $edl_input[$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                $edl_input[$kk]['mass_flow_rate'] = (float)$vv['energy_value'];
                                $edl_input[$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                $edl_input[$kk]['unit_id'] = (int)$vv['unit'];
                            }
                        }
                        $p_details['energy_detailed_level']['product_list'][$pdkey] = array_merge($edl_input);
                    }
                }
            }
        }
    }
    $data = [];
    if (!empty($data_source_id) && $data_source_id == 1) {
        if (!empty($p_details['basic_user_input'])) {
            $data = array_merge($p_details['basic_user_input']);
        }
    } elseif (!empty($data_source_id) && $data_source_id == 2) {
        if (!empty($p_details['energy_process_level'])) {
            $data = array_merge($p_details['energy_process_level']);
        }
    } elseif (!empty($data_source_id) &&  $data_source_id == 3) {
        if (!empty($p_details['energy_detailed_level'])) {
            $data = array_merge($p_details['energy_detailed_level']);
        }
    }
    if ($data_source_id == 0) {
        foreach ($p_details as $pk => $pv) {
            $data[] = $pv;
        }
    }
    return $data;
}

function getMassBalanceofPC($processId, $simulation_stage_id)
{
    $ps_details = ProcessProfile::where([['process_id', $processId], ['simulation_type', ___decrypt($simulation_stage_id)]])->get();
    $p_details = [];
    $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
    $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
    $pcinputflow = array_column($buiFlowTypeInput->toArray(), 'id');
    $pcoutputflow = array_column($buiFlowTypeOutput->toArray(), 'id');
    $prop_details = $ps_details->toArray();
    $pc_input = [];
    $pc_output = [];
    foreach ($prop_details as $key => $value) {
        if (!empty($value['mass_basic_pc'])) {
            $mass_basic_pc = array_merge($value['mass_basic_pc']);
            foreach ($mass_basic_pc as $pckey => $pcval) {
                foreach ($pcval['input'] as $kc => $vc) {
                    if (in_array($vc['flowtype'], $pcinputflow)) {
                        $pc_input[$pckey][$kc]['product_id'] = (int)$vc['product'];
                        $pc_input[$pckey][$kc]['flow_type_id'] = (int)$vc['flowtype'];
                        $pc_input[$pckey][$kc]['mass_flow_rate'] = (float)$vc['mass_flow_rate'];
                        $pc_input[$pckey][$kc]['unit_constant_id'] = (int)$vc['unit_constant_id'];
                        $pc_input[$pckey][$kc]['unit_id'] = (int)$vc['unit_id'];
                    } else {
                        $pc_output[$pckey][$kc]['product_id'] = (int)$vc['product'];
                        $pc_output[$pckey][$kc]['flow_type_id'] = (int)$vc['flowtype'];
                        $pc_output[$pckey][$kc]['mass_flow_rate'] = (float)$vc['mass_flow_rate'];
                        $pc_output[$pckey][$kc]['unit_constant_id'] = (int)$vc['unit_constant_id'];
                        $pc_output[$pckey][$kc]['unit_id'] = (int)$vc['unit_id'];
                    }
                }
            }
            $pcarrInput = [];
            if (!empty($pc_input)) {
                foreach ($pc_input as $pi => $pctypeInput) {
                    if (!empty($pctypeInput)) {
                        foreach ($pctypeInput as $pci) {
                            $pcarrInput[] = [
                                "product_id" => $pci['product_id'],
                                "flow_type_id" => $pci['flow_type_id'],
                                "flow_rate" => $pci['mass_flow_rate'],
                                "unit_constant_id" => $pci['unit_constant_id'],
                                "unit_id" => $pci['unit_id']
                            ];
                        }
                    }
                }
            }
            $pcarrOutput = [];
            if (!empty($pc_output)) {
                foreach ($pc_output as $po => $pctypeOutput) {
                    if (!empty($pctypeOutput)) {
                        foreach ($pctypeOutput as $pco) {
                            $pcarrOutput[] = [
                                "product_id" => $pco['product_id'],
                                "product_id" => $pco['product_id'],
                                "flow_type_id" => $pco['flow_type_id'],
                                "flow_rate" => $pco['mass_flow_rate'],
                                "unit_constant_id" => $pco['unit_constant_id'],
                                "unit_id" => $pco['unit_id']
                            ];
                        }
                    }
                }
            }
            $p_details['mass_balance_input'] = $pcarrInput;
            $p_details['mass_balance_output'] = $pcarrOutput;
        }
    }
    return $p_details;
}

function getMassBalanceofPD($processId, $simulation_stage_id)
{
    $ps_details = ProcessProfile::where([['process_id', $processId], ['simulation_type', ___decrypt($simulation_stage_id)]])->get();
    $p_details = [];
    $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
    $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
    $pcinputflow = array_column($buiFlowTypeInput->toArray(), 'id');
    $pcoutputflow = array_column($buiFlowTypeOutput->toArray(), 'id');
    $prop_details = $ps_details->toArray();
    $pd_input = [];
    $pd_output = [];
    foreach ($prop_details as $key => $value) {
        if (!empty($value['mass_basic_pd'])) {
            $mass_basic_pdArr = array_merge($value['mass_basic_pd']);
            foreach ($mass_basic_pdArr as $pdkey => $pdval) {
                if ($pdkey != "sel") {
                    if (!empty($pdval['input'])) {
                        foreach ($pdval['input'] as $kk => $vv) {
                            if (in_array($vv['flowtype'], $pcinputflow)) {
                                $pd_input[$pdkey][$kk]['product_id'] = (int)$vv['product'];
                                $pd_input[$pdkey][$kk]['product_properties'] = get_product_properties_helper((int)$vv['product']);
                                $pd_input[$pdkey][$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                $pd_input[$pdkey][$kk]['mass_flow_rate'] = (float)$vv['mass_flow_rate'];
                                $pd_input[$pdkey][$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                $pd_input[$pdkey][$kk]['unit_id'] = (int)$vv['unit_id'];
                            } else {
                                $pd_output[$pdkey][$kk]['product_id'] = (int)$vv['product'];
                                $pd_output[$pdkey][$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                $pd_output[$pdkey][$kk]['mass_flow_rate'] = (float)$vv['mass_flow_rate'];
                                $pd_output[$pdkey][$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                $pd_output[$pdkey][$kk]['unit_id'] = (int)$vv['unit_id'];
                            }
                        }
                    }
                }
            }
            $pdarrInput = [];
            if (!empty($pd_input)) {
                foreach ($pd_input as $pi => $pdtypeInput) {
                    if (!empty($pdtypeInput)) {
                        foreach ($pdtypeInput as $pci) {
                            $pdarrInput[] = [
                                "product_id" => $pci['product_id'],
                                "flow_type_id" => $pci['flow_type_id'],
                                "flow_rate" => $pci['mass_flow_rate'],
                                "unit_constant_id" => $pci['unit_constant_id'],
                                "unit_id" => $pci['unit_id']
                            ];
                        }
                    }
                }
            }
            $pdarrOutput = [];
            if (!empty($pd_output)) {
                foreach ($pd_output as $po => $pdtypeOutput) {
                    if (!empty($pdtypeOutput)) {
                        foreach ($pdtypeOutput as $pco) {
                            $pdarrOutput[] = [
                                "product_id" => $pco['product_id'],
                                "flow_type_id" => $pco['flow_type_id'],
                                "flow_rate" => $pco['mass_flow_rate'],
                                "unit_constant_id" => $pco['unit_constant_id'],
                                "unit_id" => $pco['unit_id']
                            ];
                        }
                    }
                }
            }
            $p_details['mass_balance_input'] = $pdarrInput;
            $p_details['mass_balance_output'] = $pdarrOutput;
        }
    }
    return $p_details;
}

function getMassBalanceofEnergyLevel($processId, $simulation_stage_id)
{
    $ps_details = ProcessProfile::where([['process_id', $processId], ['simulation_type', ___decrypt($simulation_stage_id)]])->get();
    $p_details = [];
    $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
    $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
    $pcinputflow = array_column($buiFlowTypeInput->toArray(), 'id');
    $pcoutputflow = array_column($buiFlowTypeOutput->toArray(), 'id');
    $prop_details = $ps_details->toArray();
    $pd_input = [];
    $pd_output = [];
    if (!empty($prop_details)) {
        foreach ($prop_details as $key => $value) {
            if (!empty($value['energy_process_level'])) {
                $mass_basic_pdArr = array_merge($value['energy_process_level']);
                foreach ($mass_basic_pdArr as $pdkey => $pdval) {
                    if ($pdkey != "sel") {
                        if (!empty($pdval['input'])) {
                            foreach ($pdval['input'] as $kk => $vv) {
                                if (in_array($vv['flowtype'], $pcinputflow)) {
                                    $pd_input[$pdkey][$kk]['utility_id'] = (int)$vv['energy'];
                                    $pd_input[$pdkey][$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                    $pd_input[$pdkey][$kk]['mass_flow_rate'] = (float)$vv['energy_value'];
                                    $pd_input[$pdkey][$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                    $pd_input[$pdkey][$kk]['unit_id'] = (int)$vv['unit'];
                                    $pd_input[$pdkey][$kk]['utility_type'] = $vv['utility_type'];
                                } else {
                                    $pd_output[$pdkey][$kk]['utility_id'] = (int)$vv['energy'];
                                    $pd_output[$pdkey][$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                    $pd_output[$pdkey][$kk]['mass_flow_rate'] = (float)$vv['energy_value'];
                                    $pd_output[$pdkey][$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                    $pd_output[$pdkey][$kk]['unit_id'] = (int)$vv['unit'];
                                    $pd_output[$pdkey][$kk]['utility_type'] = $vv['utility_type'];
                                }
                            }
                        }
                    }
                }
                $pdarrInput = [];
                if (!empty($pd_input)) {
                    foreach ($pd_input as $pi => $pdtypeInput) {
                        if (!empty($pdtypeInput)) {
                            foreach ($pdtypeInput as $pci) {
                                $pdarrInput[] = [
                                    "energy_id" => $pci['utility_id'],
                                    "flow_type_id" => $pci['flow_type_id'],
                                    "flow_rate" => $pci['mass_flow_rate'],
                                    "unit_constant_id" => $pci['unit_constant_id'],
                                    "unit_id" => $pci['unit_id'],
                                    "utility_type" => $pci['utility_type']
                                ];
                            }
                        }
                    }
                }
                $pdarrOutput = [];
                if (!empty($pd_output)) {
                    foreach ($pd_output as $po => $pdtypeOutput) {
                        if (!empty($pdtypeOutput)) {
                            foreach ($pdtypeOutput as $pco) {
                                $pdarrOutput[] = [
                                    "energy_id" => $pco['utility_id'],
                                    "flow_type_id" => $pco['flow_type_id'],
                                    "flow_rate" => $pco['mass_flow_rate'],
                                    "unit_constant_id" => $pco['unit_constant_id'],
                                    "unit_id" => $pco['unit_id'],
                                    "utility_type" => $pci['utility_type']
                                ];
                            }
                        }
                    }
                }
                $p_details['energy_balance_input'] = $pdarrInput;
                $p_details['energy_balance_output'] = $pdarrOutput;
            }
        }
    }
    return $p_details;
}

function getMassBalanceofEnergyDetailed($processId, $simulation_stage_id)
{
    $ps_details = ProcessProfile::where([['process_id', $processId], ['simulation_type', ___decrypt($simulation_stage_id)]])->get();
    $p_details = [];
    $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
    $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
    $pcinputflow = array_column($buiFlowTypeInput->toArray(), 'id');
    $pcoutputflow = array_column($buiFlowTypeOutput->toArray(), 'id');
    $prop_details = $ps_details->toArray();
    $pd_input = [];
    $pd_output = [];
    if (!empty($prop_details)) {
        foreach ($prop_details as $key => $value) {
            if (!empty($value['energy_detailed_level'])) {
                $mass_basic_pdArr = array_merge($value['energy_detailed_level']);
                foreach ($mass_basic_pdArr as $pdkey => $pdval) {
                    if ($pdkey != "sel") {
                        if (!empty($pdval['input'])) {
                            foreach ($pdval['input'] as $kk => $vv) {
                                if (in_array($vv['flowtype'], $pcinputflow)) {
                                    $pd_input[$pdkey][$kk]['utility_id'] = (int)$vv['energy'];
                                    $pd_input[$pdkey][$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                    $pd_input[$pdkey][$kk]['mass_flow_rate'] = (float)$vv['energy_value'];
                                    $pd_input[$pdkey][$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                    $pd_input[$pdkey][$kk]['unit_id'] = (int)$vv['unit'];
                                    $pd_input[$pdkey][$kk]['utility_type'] = $vv['utility_type'];
                                } else {
                                    $pd_output[$pdkey][$kk]['utility_id'] = (int)$vv['energy'];
                                    $pd_output[$pdkey][$kk]['flow_type_id'] = (int)$vv['flowtype'];
                                    $pd_output[$pdkey][$kk]['mass_flow_rate'] = (float)$vv['energy_value'];
                                    $pd_output[$pdkey][$kk]['unit_constant_id'] = (int)$vv['unit_constant_id'];
                                    $pd_output[$pdkey][$kk]['unit_id'] = (int)$vv['unit'];
                                    $pd_output[$pdkey][$kk]['utility_type'] = $vv['utility_type'];
                                }
                            }
                        }
                    }
                }
                $pdarrInput = [];
                if (!empty($pd_input)) {
                    foreach ($pd_input as $pi => $pdtypeInput) {
                        if (!empty($pdtypeInput)) {
                            foreach ($pdtypeInput as $pci) {
                                $pdarrInput[] = [
                                    "energy_id" => $pci['utility_id'],
                                    "flow_type_id" => $pci['flow_type_id'],
                                    "flow_rate" => $pci['mass_flow_rate'],
                                    "unit_constant_id" => $pci['unit_constant_id'],
                                    "unit_id" => $pci['unit_id'],
                                    "utility_type" => $pci['utility_type']
                                ];
                            }
                        }
                    }
                }
                $pdarrOutput = [];
                if (!empty($pd_output)) {
                    foreach ($pd_output as $po => $pdtypeOutput) {
                        if (!empty($pdtypeOutput)) {
                            foreach ($pdtypeOutput as $pco) {
                                $pdarrOutput[] = [
                                    "energy_id" => $pco['utility_id'],
                                    "flow_type_id" => $pco['flow_type_id'],
                                    "flow_rate" => $pco['mass_flow_rate'],
                                    "unit_constant_id" => $pco['unit_constant_id'],
                                    "unit_id" => $pco['unit_id'],
                                    "utility_type" => $pci['utility_type']
                                ];
                            }
                        }
                    }
                }
                $p_details['energy_balance_input'] = $pdarrInput;
                $p_details['energy_balance_output'] = $pdarrOutput;
            }
        }
    }
    return $p_details;
}
