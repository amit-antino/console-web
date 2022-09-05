<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Classes\ExperimentCommon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Experiment\CriteriaMaster;
use App\Models\Experiment\PriorityMaster;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\ProcessExperiment\Variation;

class SimulationSetPointController extends Controller
{
    public function rawMaterialList(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'unit_id' => 'required',
                'product_arr.*.product_id' => 'required',
                'product_arr.*.criteria' => 'required',
                'product_arr.*.value' => 'required',
            ],
            [
                'product_arr.*.product_id.required' => 'The product field is required.',
                'product_arr.*.criteria.required' => 'The criteria field is required.',
                'product_arr.*.value.required' => 'The value % field is required.',
            ]
        );
        if (!empty($request->product_arr)) {
            $sum = 0;
            foreach ($request->product_arr as $pro_count) {
                $sum += $pro_count['value'];
            }
        }
        // if ($sum > 100) {
        //     $validator->after(function ($validator) {
        //         $validator->errors()->add('unit_constant_id', 'You can not total value Add more than 100.');
        //     });
        // }
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $pfd_stream_id = ___decrypt($request->pfd_stream_id);
            $simulate_raw = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'raw_material')->where(['id' => ___decrypt($request->simulate_input_id)])->first();
            $data = $simulate_raw->raw_material;
            $raw_material_output = [];
            $count = 0;
            foreach ($data as $raw_material) {
                //  dd($raw_material, $pfd_stream_id, $data);
                if ($pfd_stream_id == $raw_material['pfd_stream_id']) {
                    // dd($pfd_stream_id,$request->product_arr);
                    $raw_material_output[$count]['id'] = $count + 1;
                    $raw_material_output[$count]['pfd_stream_id'] = !empty($request->pfd_stream_id) ? ___decrypt($request->pfd_stream_id) : '';
                    $key_count = 0;
                    if (!empty($request->product_arr)) {
                        foreach ($request->product_arr as $key_count => $product) {
                            if (!empty($product['product_id'])) {
                                $product_data_new[$key_count]['product_id'] = !empty($product['product_id']) ? ___decrypt($product['product_id']) : '';
                                $product_data_new[$key_count]['criteria'] = !empty($product['criteria']) ? ___decrypt($product['criteria']) : '';
                                $product_data_new[$key_count]['value'] = !empty($product['value']) ? $product['value'] : 0;
                                $product_data_new[$key_count]['max_value'] = !empty($product['max_value']) ? $product['max_value'] : 0;
                                $product_data_new[$key_count]['value_flow_rate'] = !empty($product['value_flow_rate']) ? $product['value_flow_rate'] : 0;
                                $product_data_new[$key_count]['unit_constant_id'] = !empty($product['unit_constant_id']) ? ___decrypt($product['unit_constant_id']) : 0;
                            }
                        }
                    }
                    // dd($request->product_arr,$product_data_new);
                    $raw_material_output[$count]['product'] = $product_data_new;
                    $raw_material_output[$count]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : 0;
                    $raw_material_output[$count]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : 0;
                    $raw_material_output[$count]['value_flow_rate'] = !empty($request->value_flow_rate) ? $request->value_flow_rate : 0;
                } else {
                    $raw_material_output[$count]['id'] = $count + 1;
                    $raw_material_output[$count]['pfd_stream_id'] = $raw_material['pfd_stream_id'];
                    $product_data = [];
                    if (!empty($raw_material['product'])) {
                        foreach ($raw_material['product'] as $key_count => $product) {
                            $product_data[$key_count]['product_id'] = !empty($product['product_id']) ? $product['product_id'] : '';
                            $product_data[$key_count]['criteria'] = !empty($product['criteria']) ? $product['criteria'] : '';
                            $product_data[$key_count]['value'] = !empty($product['value']) ? $product['value'] : 0;
                            $product_data[$key_count]['max_value'] = !empty($product['max_value']) ? $product['max_value'] : 0;
                            $product_data[$key_count]['value_flow_rate'] = !empty($product['value_flow_rate']) ? $product['value_flow_rate'] : 0;
                            $product_data[$key_count]['unit_constant_id'] = !empty($product['unit_constant_id']) ? $product['unit_constant_id'] : 0;
                        }
                    }
                    $raw_material_output[$count]['product'] = $product_data;
                    $raw_material_output[$count]['unit_id'] = !empty($raw_material['unit_id']) ? $raw_material['unit_id'] : 0;
                    $raw_material_output[$count]['value_flow_rate'] = !empty($raw_material['value_flow_rate']) ? $raw_material['value_flow_rate'] : 0;
                    $raw_material_output[$count]['unit_constant_id'] = !empty($raw_material['unit_constant_id']) ? $raw_material['unit_constant_id'] : 0;
                }
                $count++;
            }
            // dd($pfd_stream_id,$raw_material_output);
            $simulate_raw->raw_material = $raw_material_output;
            $simulate_raw->updated_by = Auth::user()->id;
            $simulate_raw->save();
            $html = view('pages.console.experiment.experiment.configuration.simulation_set_point.raw_material.list', [
                'request' => $request,
                'simulate_input' => $simulate_raw,
                'raw_material' => raw_material(___decrypt($request->simulate_input_id)),
            ])->render();
            $this->html = $html;
            $this->status = true;
            $this->modal = true;
            $this->redirect = true; //'reload_fail';
            $this->message = "Simulation Inputs saved successfully";
        }
        return $this->populateresponse();
    }

    public function simulation_config_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'simulation_input_type' => 'required',
        ]);
        $variation = Variation::find($request->variation_id);
        if (empty($variation->process_flow_table)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('name', 'Add variation data to create simulation input.');
            });
        }
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            if (!empty($request->variation_id)) {
                if ($request->simulation_input_type == 'reverse') {
                    insert_simulate_input_reverse($request->variation_id, $request);
                } else {
                    insert_simulate_input($request->variation_id, $request);
                }
            }
            $expCommon = new ExperimentCommon();
            $process_exp_list = $expCommon->experiment_list('redis_update');
            $this->redirect = true;
            $this->status = true;
            $this->modal = true;
            $this->message = "Simulation Input is Created Successfully";
        }
        return $this->populateresponse();
    }

    public function masterOutcomeList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'priority' => 'required',
            'criteria' => 'required',
            'value' => 'required',
            'unit_constant_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $id = ___decrypt($request->id);
            $simulate_input_id = ___decrypt($request->simulate_input_id);
            $simulation_output =  SimulateInput::find($simulate_input_id);
            $data = $simulation_output->master_outcome;
            $key_count = 0;
            foreach ($data as $key_count => $master_data) {
                if ($id != $master_data['id']) {
                    $master_outcome[$key_count]['id'] = $master_data['id'];
                    $master_outcome[$key_count]['outcome_id'] = $master_data['outcome_id'];
                    $master_outcome[$key_count]['unit_id'] = $master_data['unit_id'];
                    $master_outcome[$key_count]['criteria'] = $master_data['criteria'];
                    $master_outcome[$key_count]['priority'] = $master_data['priority'];
                    $master_outcome[$key_count]['value'] = $master_data['value'];
                    $master_outcome[$key_count]['max_value'] = $master_data['max_value'];
                    $master_outcome[$key_count]['unit_constant_id'] = $master_data['unit_constant_id'];
                } else {
                    $master_outcome[$key_count]['id'] = !empty($request->id) ? ___decrypt($request->id) : '';
                    $master_outcome[$key_count]['outcome_id'] = !empty($request->outcome_id) ? ___decrypt($request->outcome_id) : '';
                    $master_outcome[$key_count]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : '';
                    $master_outcome[$key_count]['criteria'] = !empty($request->criteria) ? ___decrypt($request->criteria) : '';
                    $master_outcome[$key_count]['priority'] = !empty($request->priority) ? ___decrypt($request->priority) : '';
                    $master_outcome[$key_count]['value'] = !empty($request->value) ? $request->value : 0;
                    $master_outcome[$key_count]['max_value'] = !empty($request->max_value) ? $request->max_value : 0;
                    $master_outcome[$key_count]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : '';
                }
                $simulation_output->master_outcome = $master_outcome;
                $simulation_output->updated_by = Auth::user()->id;
                $simulation_output->save();
            }
            $master_outcome_list = master_outcome_list($simulate_input_id, $id);
            $html = view('pages.console.experiment.experiment.configuration.simulation_set_point.master_outcome.list', [
                'master_outcome' => $master_outcome_list,
                'id' => $id,
                'simulate_input_id' => $simulate_input_id,
            ])->render();
            $this->html = $html;
            $this->status = true;
            $this->modal = true;
            $this->redirect = 'reload_fail';
            $this->message = "Simulation Inputs saved successfully";
        }
        return $this->populateresponse();
    }

    public function masterExpOutcomeEditPopup(Request $request)
    {
        $id = ___decrypt($request->id);
        $simulate_input_id = ___decrypt($request->simulate_input_id);
        $master_outcome = master_outcome_single($simulate_input_id, $id);
        $criteria = CriteriaMaster::where(['status' => 'active'])->get();
        $priority = PriorityMaster::where('status', 'active')->get();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_set_point.master_outcome.edit', [
                'count' => $id,
                'id' => $id,
                'master_outcome' => $master_outcome,
                'simulate_input_id' => $simulate_input_id,
                'criteria' => $criteria,
                'priority' => $priority,
            ])->render()
        ]);
    }

    public function masterConditionList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'criteria' => 'required',
            'value' => 'required',
            'unit_constant_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $id = ___decrypt($request->id);
            $update_simulate_input = SimulateInput::find(___decrypt($request->simulate_input_id));
            $data = $update_simulate_input->master_condition;
            $count_key = 0;
            foreach ($data as  $count_key => $master_data) {
                if ($id != $master_data['id']) {
                    $master_condition[$count_key]['id'] = $master_data['id'];
                    $master_condition[$count_key]['condition_id'] = $master_data['condition_id'];
                    $master_condition[$count_key]['criteria'] = $master_data['criteria'];
                    $master_condition[$count_key]['unit_id'] = $master_data['unit_id'];
                    $master_condition[$count_key]['value'] = $master_data['value'];
                    $master_condition[$count_key]['max_value'] = isset($master_data['max_value']) ? $master_data['max_value'] : 0;
                    $master_condition[$count_key]['unit_constant_id'] = $master_data['unit_constant_id'];
                } else {
                    $master_condition[$count_key]['id'] = !empty($request->id) ? ___decrypt($request->id) : '';
                    $master_condition[$count_key]['condition_id'] = !empty($request->condition_id) ? ___decrypt($request->condition_id) : '';
                    $master_condition[$count_key]['criteria'] = !empty($request->criteria) ? ___decrypt($request->criteria) : '';
                    $master_condition[$count_key]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : '';
                    $master_condition[$count_key]['value'] = !empty($request->value) ? $request->value : 0;
                    $master_condition[$count_key]['max_value'] = !empty($request->max_value) ? $request->max_value : 0;
                    $master_condition[$count_key]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : '';
                }
            }
            $update_simulate_input->master_condition = $master_condition;
            $update_simulate_input->save();
            $new_master_condition = master_condition_list(___decrypt($request->simulate_input_id));
            $html = view('pages.console.experiment.experiment.configuration.simulation_set_point.master_condition.list', [
                'master_condition' => $new_master_condition,
                'simulate_input_id' => ___decrypt($request->simulate_input_id),
            ])->render();
            $this->html = $html;
            $this->status = true;
            $this->modal = true;
            $this->redirect = 'reload_fail';
            $this->message = "Simulation Inputs saved successfully";
        }
        return $this->populateresponse();
    }

    public function masterConditionEditPopup(Request $request)
    {
        $simulate_input_id =  ___decrypt($request->simulate_input_id);
        $id =  ___decrypt($request->id);
        $master_condition = master_condition_single($simulate_input_id, $id);
        $criteria = CriteriaMaster::where(['status' => 'active'])->get();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_set_point.master_condition.edit', [
                'master_condition' => $master_condition,
                'id' => $id,
                'count' => $id,
                'simulate_input_id' => $simulate_input_id,
                'criteria' => $criteria,
            ])->render()
        ]);
    }

    public function unitConditionList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'criteria' => 'required',
            'value' => 'required',
            'unit_constant_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $id = ___decrypt($request->id);
            $simulate_input_id = ___decrypt($request->simulate_input_id);
            $update_simulate_input =  SimulateInput::find($simulate_input_id);
            $data = $update_simulate_input->unit_condition;
            $count_key = 0;
            foreach ($data as $count_key => $master_data) {
                if ($id != $master_data['id']) {
                    $exp_unit_condition[$count_key]['id'] = $master_data['id'];
                    $exp_unit_condition[$count_key]['exp_unit_id'] = $master_data['exp_unit_id'];
                    $exp_unit_condition[$count_key]['condition_id'] = $master_data['condition_id'];
                    $exp_unit_condition[$count_key]['unit_id'] = $master_data['unit_id'];
                    $exp_unit_condition[$count_key]['criteria'] = $master_data['criteria'];
                    $exp_unit_condition[$count_key]['value'] = $master_data['value'];
                    $exp_unit_condition[$count_key]['max_value'] = !empty($master_data['max_value']) ? $master_data['max_value'] : 0;
                    $exp_unit_condition[$count_key]['unit_constant_id'] = $master_data['unit_constant_id'];
                } else {
                    $exp_unit_condition[$count_key]['id'] = $id;
                    $exp_unit_condition[$count_key]['condition_id'] = !empty($request->condition_id) ? ___decrypt($request->condition_id) : '';
                    $exp_unit_condition[$count_key]['exp_unit_id'] = !empty($request->exp_unit_id) ? ___decrypt($request->exp_unit_id) : '';
                    $exp_unit_condition[$count_key]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : '';
                    $exp_unit_condition[$count_key]['criteria'] = !empty($request->criteria) ? ___decrypt($request->criteria) : '';
                    $exp_unit_condition[$count_key]['value'] = !empty($request->value) ? $request->value : 0;
                    $exp_unit_condition[$count_key]['max_value'] = !empty($request->max_value) ? $request->max_value : 0;
                    $exp_unit_condition[$count_key]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : '';
                }
            }
            $update_simulate_input->unit_condition = $exp_unit_condition;
            $update_simulate_input->updated_by = Auth::user()->id;
            $update_simulate_input->save();
            $updated_simulation_output = unit_condition_list($simulate_input_id);
            $html = view('pages.console.experiment.experiment.configuration.simulation_set_point.exp_unit_condition.list', [
                'unit_condition' => $updated_simulation_output,
                'simulate_input_id' => $simulate_input_id,
            ])->render();
            $this->html = $html;
            $this->status = true;
            $this->modal = true;
            $this->redirect = 'reload_fail';
            $this->message = "Simulation Inputs saved successfully";
        }
        return $this->populateresponse();
    }

    public function unitConditionEditPopup(Request $request)
    {
        $id = ___decrypt($request->id);
        $simulate_input_id = ___decrypt($request->simulate_input_id);
        $unit_condition = unit_condition_single($simulate_input_id, $id);
        $criteria = CriteriaMaster::where(['status' => 'active'])->get();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_set_point.exp_unit_condition.edit', [
                'count' => $id,
                'simulate_input_id' => $simulate_input_id,
                'id' => $id,
                'unit_condition' => $unit_condition,
                'criteria' => $criteria,
            ])->render()
        ]);
    }

    public function expUnitOutcomeList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'priority' => 'required',
            'criteria' => 'required',
            'value' => 'required',
            'unit_constant_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $id = ___decrypt($request->id);
            $simulate_input_id = ___decrypt($request->simulate_input_id);
            $simulation_input = SimulateInput::find($simulate_input_id);
            $data = $simulation_input->unit_outcome;
            $key_count = 0;
            foreach ($data as $key_count => $master_data) {
                if ($id != $master_data['id']) {
                    $exp_unit_outcome[$key_count]['id'] = $master_data['id'];
                    $exp_unit_outcome[$key_count]['exp_unit_id'] = $master_data['exp_unit_id'];
                    $exp_unit_outcome[$key_count]['outcome_id'] = $master_data['outcome_id'];
                    $exp_unit_outcome[$key_count]['unit_id'] = $master_data['unit_id'];
                    $exp_unit_outcome[$key_count]['criteria'] = $master_data['criteria'];
                    $exp_unit_outcome[$key_count]['priority'] = $master_data['priority'];
                    $exp_unit_outcome[$key_count]['value'] = $master_data['value'];
                    $exp_unit_outcome[$key_count]['max_value'] = !empty($master_data['max_value']) ? $master_data['max_value'] : 0;
                    $exp_unit_outcome[$key_count]['unit_constant_id'] = $master_data['unit_constant_id'];
                } else {
                    $exp_unit_outcome[$key_count]['id'] = $id;
                    $exp_unit_outcome[$key_count]['outcome_id'] = !empty($request->outcome_id) ? ___decrypt($request->outcome_id) : '';
                    $exp_unit_outcome[$key_count]['exp_unit_id'] = !empty($request->exp_unit_id) ? ___decrypt($request->exp_unit_id) : '';
                    $exp_unit_outcome[$key_count]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : '';
                    $exp_unit_outcome[$key_count]['criteria'] = !empty($request->criteria) ? ___decrypt($request->criteria) : '';
                    $exp_unit_outcome[$key_count]['priority'] = !empty($request->priority) ? ___decrypt($request->priority) : '';
                    $exp_unit_outcome[$key_count]['value'] = !empty($request->value) ? $request->value : 0;
                    $exp_unit_outcome[$key_count]['max_value'] = !empty($request->max_value) ? $request->max_value : 0;
                    $exp_unit_outcome[$key_count]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : '';
                }
            }
            $simulation_input->unit_outcome = $exp_unit_outcome;
            $simulation_input->updated_by = Auth::user()->id;
            $simulation_input->save();
            $updated_unit_outcome = unit_outcome_list($simulate_input_id, $id);
            $html = view('pages.console.experiment.experiment.configuration.simulation_set_point.exp_unit_outcome.list', [
                'unit_outcome' => $updated_unit_outcome,
                'simulate_input_id' => $simulate_input_id,
            ])->render();
            $this->html = $html;
            $this->status = true;
            $this->modal = true;
            $this->redirect = 'reload_fail';
            $this->message = "Simulation Inputs saved successfully";
        }
        return $this->populateresponse();
    }

    public function expUnitOutcomeEditPopup(Request $request)
    {
        $criteria = CriteriaMaster::where(['status' => 'active'])->get();
        $priority = PriorityMaster::where('status', 'active')->get();
        $id = ___decrypt($request->id);
        $simulate_input_id = ___decrypt($request->simulate_input_id);
        $unit_outcome = unit_outcome_single($simulate_input_id, $id);
        return response()->json([
            'status' => true,
            'html' => view(
                'pages.console.experiment.experiment.configuration.simulation_set_point.exp_unit_outcome.edit',
                [
                    'unit_outcome' => $unit_outcome,
                    'simulate_input_id' => $simulate_input_id,
                    'criteria' => $criteria,
                    'priority' => $priority,
                    'id' => $id,
                    'count' => $id,
                ]
            )->render()
        ]);
    }

    public function rangeValueField(Request $request)
    {
        $count = $request->count;
       
        //$criteria = CriteriaMaster::find(___decrypt($request->parameters));
        $criteria = CriteriaMaster::where(['status' => 'active'])->get();
        //if ($criteria->is_range_type == 'true') {
        if (___decrypt($request->parameters)==4) {
            return response()->json([
                'status' => true,
                'html' => view('pages.console.experiment.experiment.configuration.simulation_set_point.exp_unit_condition.value', [
                    'count' => !empty($count) ? $count : 0,
                    'type' => $request->type,
                    'criteria'=>$criteria
                ])->render()
            ]);
        } else {
            return response()->json([
                'status' => true,
                'html' => ''
            ]);
        }
    }
}
