<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use App\Models\Experiment\CriteriaMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\MasterUnit;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\Experiment\ProcessDiagram;
use App\Models\Product\Chemical;

class SimulationOutputController extends Controller
{
    public function store(Request $request)
    {
        if ($request->simulation_type_condition == 'Dynamic') {
            $validator = Validator::make($request->all(), [
                'simulation_type_condition' => 'required',
                'time_value' => 'required',
                'time_unit_type' => 'required',
                'time_interval_value' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'simulation_type_condition' => 'required',
            ]);
        }
        if ($request->time_value < $request->time_interval_value) {
            $validator->after(function ($validator) {
                $validator->errors()->add('time_value', 'Time Interval Value should be greater.');
            });
        }
        if ($validator->fails()) {
            $this->message = $validator->errors();
            return $this->populateresponse();
        } else {
            $simulate_input_id = ___decrypt($request->simulate_input_id);
            $update_dataset = SimulateInput::find($simulate_input_id);
            $simulation_type = [];
            if ($request->simulation_type_condition == 'Dynamic') {
                $simulation_type['simulation_type_value'] = $request->simulation_type_condition;
                $simulation_type['time_value'] = $request->time_value;
                $simulation_type['time_unit_type'] = $request->time_unit_type;
                $simulation_type['time_interval_value'] = $request->time_interval_value;
                $simulation_type['time_interval_unit_type'] = $request->time_interval_unit_type;
            } else {
                $simulation_type['simulation_type_value'] = $request->simulation_type_condition;
            }
            $update_dataset->simulation_type = $simulation_type;
            $update_dataset->save();
            $updated_simulation_output = $simulation_type;
            $time_unit = MasterUnit::find(14);
            $html = view('pages.console.experiment.experiment.configuration.simulation_output.simulation_type.list', [
                'simulation_type' => $updated_simulation_output,
                'time_unit' => $time_unit,
            ])->render();
            $this->html = $html;
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Simulation Inputs saved successfully";
        }
        return $this->populateresponse();
    }

    public function add_more_raw_product(Request $request)
    {
        $var = ProcessDiagram::find(___decrypt($request->pfd_stream_id));
        $prods_id = !empty($var->products) ? $var->products : [];
        $data['product'] = Chemical::Select('id', 'chemical_name')->WhereIn('id', $prods_id)->get();
        $data['count'] = intval($request->count) + 1;
        $data['total'] = 0;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_output.raw_material.add_more_product', [
                'data' => $data,
            ])->render()
        ]);
    }

    public function add_more_raw_product_set_point(Request $request)
    {
        $var = ProcessDiagram::find(___decrypt($request->pfd_stream_id));
        $prods_id = !empty($var->products) ? $var->products : [];
        $data['product'] = Chemical::Select('id', 'chemical_name')->WhereIn('id', $prods_id)->get();
        $data['count'] = intval($request->count) + 1;
        $data['total'] = 0;
        $criteria = CriteriaMaster::where(['status' => 'active'])->get();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_set_point.raw_material.add_more_product', [
                'data' => $data,
                'criteria' => $criteria,
            ])->render()
        ]);
    }

    // Raw material list store function
    public function rawMaterialList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'value_flow_rate' => 'required',
            'unit_constant_id' => 'required',
            'product_arr.*.product_id' => 'required',
            'product_arr.*.value' => 'required',
        ], [
            'product_arr.*.product_id.required' => 'The product feild is required.',
            'product_arr.*.value.required' => 'The value % feild is required.',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $pfd_stream_id = ___decrypt($request->pfd_stream_id);
            $simulate_raw = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'raw_material')->where(['id' => ___decrypt($request->simulate_input_id)])->first();
            $data = $simulate_raw->raw_material;
            $raw_material_output = [];
            $count = 0;
            foreach ($data as $raw_material) {
                if ($pfd_stream_id != $raw_material['pfd_stream_id']) {
                    $raw_material_output[$count]['id'] = $count + 1;
                    $raw_material_output[$count]['pfd_stream_id'] = $raw_material['pfd_stream_id'];
                    $product_data = [];
                    if (!empty($raw_material['product'])) {
                        foreach ($raw_material['product'] as $key_count => $product) {
                            $product_data[$key_count]['product_id'] = !empty($product['product_id']) ? $product['product_id'] : '';
                            $product_data[$key_count]['value'] = !empty($product['value']) ? $product['value'] : 0;
                            $product_data[$key_count]['value_flow_rate'] = !empty($product['value_flow_rate']) ? $product['value_flow_rate'] : 0;
                            $product_data[$key_count]['unit_constant_id'] = !empty($product['unit_constant_id']) ? $product['unit_constant_id'] : 0;
                        }
                    }
                    $raw_material_output[$count]['product'] = $product_data;
                    $raw_material_output[$count]['unit_id'] = !empty($raw_material['unit_id']) ? $raw_material['unit_id'] : 0;
                    $raw_material_output[$count]['value_flow_rate'] = !empty($raw_material['value_flow_rate']) ? $raw_material['value_flow_rate'] : 0;
                    $raw_material_output[$count]['unit_constant_id'] = !empty($raw_material['unit_constant_id']) ? $raw_material['unit_constant_id'] : 0;
                    $count++;
                } else {
                    $raw_material_output[$count]['id'] = $count + 1;
                    $raw_material_output[$count]['pfd_stream_id'] = !empty($request->pfd_stream_id) ? ___decrypt($request->pfd_stream_id) : '';
                    $product_data = [];
                    if (!empty($request->product_arr)) {
                        foreach ($request->product_arr as $key_count => $product) {
                            if (!empty($product['product_id'])) {
                                $product_data[$key_count]['product_id'] = !empty($product['product_id']) ? ___decrypt($product['product_id']) : '';
                                $product_data[$key_count]['value'] = !empty($product['value']) ? $product['value'] : 0;
                                $product_data[$key_count]['value_flow_rate'] = !empty($product['value_flow_rate']) ? $product['value_flow_rate'] : 0;
                                $product_data[$key_count]['unit_constant_id'] = !empty($product['unit_constant_id']) ? ___decrypt($product['unit_constant_id']) : 0;
                            }
                        }
                    }
                    $raw_material_output[$count]['product'] = $product_data;
                    $raw_material_output[$count]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : 0;
                    $raw_material_output[$count]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : 0;
                    $raw_material_output[$count]['value_flow_rate'] = !empty($request->value_flow_rate) ? $request->value_flow_rate : 0;
                    $count++;
                }
            }
            $simulate_raw->raw_material = $raw_material_output;
            $simulate_raw->updated_by = Auth::user()->id;
            $simulate_raw->save();
            $html = view('pages.console.experiment.experiment.configuration.simulation_output.raw_material.list', [
                'request' => $request,
                'simulate_input' => $simulate_raw,
                'raw_material' => raw_material(___decrypt($request->simulate_input_id)),
            ])->render();
            $this->html = $html;
            $this->status = true;
            $this->modal = true;
            $this->redirect = 'reload_fail';
            $this->message = "Simulation Inputs saved successfully";
        }
        return $this->populateresponse();
    }

    // Exp Unit Condition List and store
    public function expUnitConditionList(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
                    $exp_unit_condition[$count_key]['value'] = $master_data['value'];
                    $exp_unit_condition[$count_key]['unit_constant_id'] = $master_data['unit_constant_id'];
                } else {
                    $exp_unit_condition[$count_key]['id'] = $id;
                    $exp_unit_condition[$count_key]['condition_id'] = !empty($request->condition_id) ? ___decrypt($request->condition_id) : '';
                    $exp_unit_condition[$count_key]['exp_unit_id'] = !empty($request->exp_unit_id) ? ___decrypt($request->exp_unit_id) : '';
                    $exp_unit_condition[$count_key]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : '';
                    $exp_unit_condition[$count_key]['value'] = !empty($request->value) ? $request->value : 0;
                    $exp_unit_condition[$count_key]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : '';
                }
            }
            $update_simulate_input->unit_condition = $exp_unit_condition;
            $update_simulate_input->updated_by = Auth::user()->id;
            $update_simulate_input->save();
            $updated_simulation_output = unit_condition_list($simulate_input_id);
            $html = view('pages.console.experiment.experiment.configuration.simulation_output.experiment_unit_condition.list', [
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

    public function editExpUnitConditionPopup(Request $request)
    {
        $id = ___decrypt($request->id);
        $simulate_input_id = ___decrypt($request->simulate_input_id);
        $unit_condition = unit_condition_single($simulate_input_id, $id);
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_output.experiment_unit_condition.edit', [
                'count' => $id,
                'simulate_input_id' => $simulate_input_id,
                'id' => $id,
                'unit_condition' => $unit_condition,

            ])->render()
        ]);
    }

    // Exp Unit Outcome Store and list
    public function expUnitOutcomeList(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
                    $exp_unit_outcome[$key_count]['value'] = $master_data['value'];
                    $exp_unit_outcome[$key_count]['unit_constant_id'] = $master_data['unit_constant_id'];
                } else {
                    $exp_unit_outcome[$key_count]['id'] = $id;
                    $exp_unit_outcome[$key_count]['outcome_id'] = !empty($request->outcome_id) ? ___decrypt($request->outcome_id) : '';
                    $exp_unit_outcome[$key_count]['exp_unit_id'] = !empty($request->exp_unit_id) ? ___decrypt($request->exp_unit_id) : '';
                    $exp_unit_outcome[$key_count]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : '';
                    $exp_unit_outcome[$key_count]['value'] = !empty($request->value) ? $request->value : 0;
                    $exp_unit_outcome[$key_count]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : '';
                }
            }
            $simulation_input->unit_outcome = $exp_unit_outcome;
            $simulation_input->updated_by = Auth::user()->id;
            $simulation_input->save();
            $updated_unit_outcome = unit_outcome_list($simulate_input_id, $id);
            $html = view('pages.console.experiment.experiment.configuration.simulation_output.experiment_unit_outcome.list', [
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

    public function editExpUnitOutcomePopup(Request $request)
    {
        $id = ___decrypt($request->id);
        $simulate_input_id = ___decrypt($request->simulate_input_id);
        $unit_outcome = unit_outcome_single($simulate_input_id, $id);
        return response()->json([
            'status' => true,
            'html' => view(
                'pages.console.experiment.experiment.configuration.simulation_output.experiment_unit_outcome.edit',
                [
                    'unit_outcome' => $unit_outcome,
                    'simulate_input_id' => $simulate_input_id,
                    'id' => $id,
                    'count' => $id,
                ]
            )->render()
        ]);
    }

    // Master Outcome store and list
    public function masterOutcomeOutPut(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
                    $master_outcome[$key_count]['value'] = $master_data['value'];
                    $master_outcome[$key_count]['unit_constant_id'] = $master_data['unit_constant_id'];
                } else {
                    $master_outcome[$key_count]['id'] = !empty($request->id) ? ___decrypt($request->id) : '';
                    $master_outcome[$key_count]['outcome_id'] = !empty($request->outcome_id) ? ___decrypt($request->outcome_id) : '';
                    $master_outcome[$key_count]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : '';
                    $master_outcome[$key_count]['value'] = !empty($request->value) ? $request->value : 0;
                    $master_outcome[$key_count]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : '';
                }
                $simulation_output->master_outcome = $master_outcome;
                $simulation_output->updated_by = Auth::user()->id;
                $simulation_output->save();
            }
            $master_outcome_list = master_outcome_list($simulate_input_id, $id);
            $html = view('pages.console.experiment.experiment.configuration.simulation_output.master_outcome.list', [
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

    public function outcomeMasterPopup(Request $request)
    {
        $id = ___decrypt($request->id);
        $simulate_input_id = ___decrypt($request->simulate_input_id);
        $master_outcome = master_outcome_single($simulate_input_id, $id);
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_output.master_outcome.edit', [
                'count' => $id,
                'id' => $id,
                'master_outcome' => $master_outcome,
                'simulate_input_id' => $simulate_input_id,
            ])->render()
        ]);
    }

    // Master Condition store and list
    public function masterConditionOutPutList(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
                    $master_condition[$count_key]['unit_id'] = $master_data['unit_id'];
                    $master_condition[$count_key]['value'] = $master_data['value'];
                    $master_condition[$count_key]['unit_constant_id'] = $master_data['unit_constant_id'];
                } else {
                    $master_condition[$count_key]['id'] = !empty($request->id) ? ___decrypt($request->id) : '';
                    $master_condition[$count_key]['condition_id'] = !empty($request->condition_id) ? ___decrypt($request->condition_id) : '';
                    $master_condition[$count_key]['unit_id'] = !empty($request->unit_id) ? ___decrypt($request->unit_id) : '';
                    $master_condition[$count_key]['value'] = !empty($request->value) ? $request->value : 0;
                    $master_condition[$count_key]['unit_constant_id'] = !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : '';
                }
            }
            $update_simulate_input->master_condition = $master_condition;
            $update_simulate_input->save();
            $new_master_condition = master_condition_list(___decrypt($request->simulate_input_id));
            $html = view('pages.console.experiment.experiment.configuration.simulation_output.master_condition.list', [
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

    public function conditionMasterPopup(Request $request)
    {
        $simulate_input_id =  ___decrypt($request->simulate_input_id);
        $id =  ___decrypt($request->id);
        $master_condition = master_condition_single($simulate_input_id, $id);
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_output.master_condition.edit', [
                'master_condition' => $master_condition,
                'id' => $id,
                'count' => $id,
                'simulate_input_id' => $simulate_input_id,
            ])->render()
        ]);
    }

    public function get_pe_profile_config_dataset_forward_stream_list(Request $request)
    {
        try {
            $simulate_input = SimulateInput::find($request->simulate_input_id);
            $raw_materials = $simulate_input->raw_material;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        $raw_material_list = [];
        if (!empty($raw_materials)) {
            $response = [
                'response' => $raw_materials,
                'status_code' => 200,
                'status' => true,
                'message' => "Success"
            ];
        } else {
            $response = [
                'response' => $raw_material_list,
                'status_code' => 500,
                'status' => false,
                'message' => $message
            ];
        }
        return response()->json($response);
    }

    public function get_pe_profile_config_dataset_forward_stream(Request $request)
    {
        try {
            $simulate_input = SimulateInput::find($request->simulate_input_id);
            $raw_materials = $simulate_input->raw_material;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        $raw_material_list = [];
        $product_list = [];
        if (!empty($raw_materials)) {
            foreach ($raw_materials as $raw_material) {
                if (!empty($raw_material['product'])) {
                    foreach ($raw_material['product'] as $assosicated_product) {
                        $product_list[] = [
                            "product_id" => $assosicated_product['product_id'],
                            "value" => (float)$assosicated_product['value']
                        ];
                    }
                    $raw_material_list[] = [
                        'id' => $raw_material['pfd_stream_id'],
                        'flow_rate_value' => (float)$raw_material['value_flow_rate'],
                        'unit_id' => $raw_material['unit_id'],
                        'unit_constant_id' => $raw_material['unit_constant_id'],
                        'product_list' => $product_list
                    ];
                }
            }
            $response = [
                'data' => $raw_material_list,
                'status_code' => 200,
                'status' => true,
                'message' => "Success"
            ];
        } else {
            $response = [
                'data' => $raw_material_list,
                'status_code' => 500,
                'status' => false,
                'message' => $message
            ];
        }
        return response()->json($response);
    }

    public function get_pe_profile_config_dataset_forward_master_condition_list(Request $request)
    {
        try {
            $simulate_input = SimulateInput::find($request->simulate_input_id);
            $master_conditions = $simulate_input->master_condition;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        $master_condition_list = [];
        if (!empty($master_conditions)) {
            foreach ($master_conditions as $conditions) {
                $master_condition_list[] = [
                    'id' => $conditions['id'],
                    'condition_id' => $conditions['condition_id'],
                    'unit_id' => $conditions['unit_id'],
                    'value' => (float)$conditions['value'],
                    'unit_constant_id' => $conditions['unit_constant_id']
                ];
            }
            $response = [
                'data' => $master_condition_list,
                'status_code' => 200,
                'status' => true,
                'message' => "Success"
            ];
        } else {
            $response = [
                'data' => $master_condition_list,
                'status_code' => 500,
                'status' => false,
                'message' => $message
            ];
        }
        return response()->json($response);
    }

    public function get_pe_profile_config_dataset_forward_master_condition(Request $request)
    {
        try {
            $simulate_input = SimulateInput::find($request->simulate_input_id);
            $master_conditions = $simulate_input->master_condition;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        $master_condition = [];
        if (!empty($master_conditions)) {
            foreach ($master_conditions as $condition) {
                if ($request->condition_id == $condition['condition_id']) {
                    $master_condition = [
                        'id' => $condition['id'],
                        'condition_id' => $condition['condition_id'],
                        'unit_id' => $condition['unit_id'],
                        'value' => (float)$condition['value'],
                        'unit_constant_id' => $condition['unit_constant_id']
                    ];
                }
            }
            $response = [
                'data' => $master_condition,
                'status_code' => 200,
                'status' => true,
                'message' => "Success"
            ];
        } else {
            $response = [
                'data' => $master_condition,
                'status_code' => 500,
                'status' => false,
                'message' => $message
            ];
        }
        return response()->json($response);
    }

    public function get_pe_profile_config_dataset_forward_master_outcome_list(Request $request)
    {
        try {
            $simulate_input = SimulateInput::find($request->simulate_input_id);
            $master_outcomes = $simulate_input->master_outcome;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        $master_outcome_list = [];
        if (!empty($master_outcomes)) {
            foreach ($master_outcomes as $outcome) {
                $master_outcome_list[] = [
                    'id' => $outcome['id'],
                    'condition_id' => $outcome['condition_id'],
                    'unit_id' => $outcome['unit_id'],
                    'value' => (float)$outcome['value'],
                    'unit_constant_id' => $outcome['unit_constant_id']
                ];
            }
            $response = [
                'data' => $master_outcome_list,
                'status_code' => 200,
                'status' => true,
                'message' => "Success"
            ];
        } else {
            $response = [
                'data' => $master_outcome_list,
                'status_code' => 500,
                'status' => false,
                'message' => $message
            ];
        }
        return response()->json($response);
    }

}
