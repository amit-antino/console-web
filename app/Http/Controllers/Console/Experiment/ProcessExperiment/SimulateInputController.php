<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Classes\ExperimentCommon;
use App\Http\Controllers\Controller;
use App\Models\ProcessExperiment\SimulateInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\ProcessExperiment\ExperimentUnit;
use App\Models\Organization\Experiment\EquipmentUnit;
use App\Models\Master\ProcessSimulation\SimulationFlowType;
use App\Models\ProcessExperiment\KbProcessExperiment;
use App\Models\ProcessExperiment\Variation;
use App\Models\Experiment\ProcessDiagram;
use App\Models\ProcessExperiment\ProcessExpProfileMaster;
use App\Models\ProcessExperiment\ProcessExpProfile;
use App\Models\Experiment\ExperimentConditionMaster;
use App\Models\Experiment\ExperimentOutcomeMaster;
use App\Models\OtherInput\Reaction;
use App\Models\Experiment\SimulateInputExcelTemplate;
use App\Models\Experiment\sim_inp_template_upload;
use App\Models\Experiment\JobsQueue;
use App\Models\Master\Chemical;
use App\Models\OtherInput\EnergyUtility;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\GenerateReport;


class SimulateInputController extends Controller
{
    public function list(Request $request)
    {
        $simulate_input_id = ___decrypt($request->id);
        $simulate_input_type = $request->simulate_input_type;
        $viewflag = $request->viewflag;
        if ($request->simulate_input_type == 'forward') {
            if ($request->type == "condition_list_master") {
                $master_condition = master_condition_list($simulate_input_id);
                $html = view('pages.console.experiment.experiment.configuration.simulation_output.master_condition.list', ['master_condition' => $master_condition, 'simulate_input_id' => $simulate_input_id, 'simulate_inut_type' => $simulate_input_type, 'viewflag' => $viewflag])->render();
            } elseif ($request->type == "output_master_outcome_list") {
                $master_outcome = master_outcome_list($simulate_input_id);
                $html = view('pages.console.experiment.experiment.configuration.simulation_output.master_outcome.list', ['master_outcome' => $master_outcome, 'simulate_input_id' => $simulate_input_id, 'simulate_inut_type' => $simulate_input_type, 'viewflag' => $viewflag])->render();
            } elseif ($request->type == "exp_unit_condition_list") {
                $unit_condition = unit_condition_list($simulate_input_id);
                $html = view('pages.console.experiment.experiment.configuration.simulation_output.experiment_unit_condition.list', ['unit_condition' => $unit_condition, 'simulate_input_id' => $simulate_input_id, 'simulate_inut_type' => $simulate_input_type, 'viewflag' => $viewflag])->render();
            } elseif ($request->type == "exp_unit_outcome_list") {
                $unit_outcome = unit_outcome_list($simulate_input_id);
                $html = view('pages.console.experiment.experiment.configuration.simulation_output.experiment_unit_outcome.list', ['unit_outcome' => $unit_outcome, 'simulate_input_id' => $simulate_input_id, 'simulate_inut_type' => $simulate_input_type, 'viewflag' => $viewflag])->render();
            }
        } else {
            if ($request->type == "condition_list_master") {
                $master_condition = master_condition_list($simulate_input_id);
                $html = view('pages.console.experiment.experiment.configuration.simulation_set_point.master_condition.list', ['master_condition' => $master_condition, 'simulate_input_id' => $simulate_input_id, 'simulate_inut_type' => $simulate_input_type, 'viewflag' => $viewflag])->render();
            } elseif ($request->type == "output_master_outcome_list") {
                $master_outcome = master_outcome_list($simulate_input_id);
                $html = view('pages.console.experiment.experiment.configuration.simulation_set_point.master_outcome.list', ['master_outcome' => $master_outcome, 'simulate_input_id' => $simulate_input_id, 'simulate_inut_type' => $simulate_input_type, 'viewflag' => $viewflag])->render();
            } elseif ($request->type == "exp_unit_condition_list") {
                $unit_condition = unit_condition_list($simulate_input_id);
                $html = view('pages.console.experiment.experiment.configuration.simulation_set_point.exp_unit_condition.list', ['unit_condition' => $unit_condition, 'simulate_input_id' => $simulate_input_id, 'simulate_inut_type' => $simulate_input_type, 'viewflag' => $viewflag])->render();
            } elseif ($request->type == "exp_unit_outcome_list") {
                $unit_outcome = unit_outcome_list($simulate_input_id);
                $html = view('pages.console.experiment.experiment.configuration.simulation_set_point.exp_unit_outcome.list', ['unit_outcome' => $unit_outcome, 'simulate_input_id' => $simulate_input_id, 'simulate_inut_type' => $simulate_input_type, 'viewflag' => $viewflag])->render();
            }
        }
        $this->html = $html;
        $this->status = true;
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $simulate = SimulateInput::Select('id', 'name', 'simulate_input_type', 'notes', 'variation_id')->where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.edit_simulation_input', ['simulate' => $simulate])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'simulation_input_type' => 'required'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $simulate = SimulateInput::find(___decrypt($id));
            $simulate['name'] = $request->name;
            $simulate['simulate_input_type'] = $request->simulation_input_type;
            $simulate['notes'] = $request->description;
            $simulate['updated_by'] = Auth::user()->id;
            $simulate['updated_at'] = now();
            $simulate->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = " Simulation Inputs Updated Successfully!";
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
            SimulateInput::where('id', ___decrypt($id))->update(['status' => $status]);
        } else {
            SimulateInput::find(___decrypt($id))->delete();
        }
        $expCommon = new ExperimentCommon();
        $process_exp_list = $expCommon->experiment_list('redis_update');
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $ID = explode(',', ($id_string));
        foreach ($ID as $idval) {
            $IDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (SimulateInput::whereIn('id', $IDS)->update($update)) {
            SimulateInput::destroy($IDS);
        }
        $this->status = true;
        $this->redirect = url('/experiment/experiment');
        return $this->populateresponse();
    }

    public function bulkGenerateReport(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $ID = explode(',', ($id_string));
        $data=array("teneant"=>session()->get('tenant_id'),"data"=>json_encode($ID));
        $job=new JobsQueue;
        $job->jobs="report generation";
        $job->queue_data=json_encode($data);
        $job->status="0";
        $job->created_by=Auth::user()->id;
        $job->save();
        $this->status = true;
        $this->redirect = url('/experiment/experiment');
        return $this->populateresponse();
    }

    public function get_simulate_input_data(Request $request)
    {
        try {
            $simulate_input = SimulateInput::find($request->simulate_input_id);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        $simulate_input_info = [];
        $raw_material_list = [];
        $product_list = [];
        $master_condition_list = [];
        $unit_condition_list = [];
        $master_outcome_list = [];
        $unit_outcome_list = [];
        if (!empty($simulate_input)) {
            if ($simulate_input->simulate_input_type == "forward") {
                // Raw Materials
                foreach ($simulate_input['raw_material'] as $raw_material) {
                    $product_list = [];
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
                // Master Conditions
                foreach ($simulate_input['master_condition'] as $conditions) {
                    $master_condition_list[] = [
                        'id' => $conditions['id'],
                        'condition_id' => $conditions['condition_id'],
                        'unit_id' => $conditions['unit_id'],
                        'value' => (float)$conditions['value'],
                        'unit_constant_id' => $conditions['unit_constant_id']
                    ];
                }
                // Unit Conditions
                foreach ($simulate_input['unit_condition'] as $conditions) {
                    $unit_condition_list[] = [
                        'id' => $conditions['id'],
                        'condition_id' => $conditions['condition_id'],
                        'exp_unit_id' => $conditions['exp_unit_id'],
                        'unit_id' => $conditions['unit_id'],
                        'value' => (float)$conditions['value'],
                        'unit_constant_id' => $conditions['unit_constant_id']
                    ];
                }
                // Master Outcomes
                foreach ($simulate_input['master_outcome'] as $outcome) {
                    $master_outcome_list[] = [
                        'id' => $outcome['id'],
                        'outcome_id' => $outcome['outcome_id'],
                        'unit_id' => $outcome['unit_id'],
                        'value' => (float)$outcome['value'],
                        'unit_constant_id' => $outcome['unit_constant_id']
                    ];
                }
                // Unit Outcomes
                foreach ($simulate_input['unit_outcome'] as $outcome) {
                    $unit_outcome_list[] = [
                        'id' => $outcome['id'],
                        'outcome_id' => $outcome['outcome_id'],
                        'exp_unit_id' => $outcome['exp_unit_id'],
                        'unit_id' => $outcome['unit_id'],
                        'value' => (float)$outcome['value'],
                        'unit_constant_id' => $outcome['unit_constant_id']
                    ];
                }
            } else {
                // Raw Materials
                foreach ($simulate_input['raw_material'] as $key_raw => $raw_material) {
                    if (!empty($raw_material['product'])) {
                        foreach ($raw_material['product'] as $pro_count => $assosicated_product) {
                            if ($assosicated_product['criteria'] == 4) {
                                $product_list[] = [
                                    "product_id" => $assosicated_product['product_id'],
                                    "criteria" => $assosicated_product['criteria'],
                                    "value" => (float)$assosicated_product['value'],
                                    "max_value" => (float)$assosicated_product['max_value']
                                ];
                            } else {
                                $product_list[] = [
                                    "product_id" => $assosicated_product['product_id'],
                                    "criteria" => $assosicated_product['criteria'],
                                    "value" => (float)$assosicated_product['value']
                                ];
                            }
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
                // Master Conditions
                foreach ($simulate_input['master_condition'] as $key_con => $condition) {
                    if ($condition['criteria'] == 4) {
                        $master_condition_list[$key_con] = [
                            'id' => $condition['id'],
                            'condition_id' => $condition['condition_id'],
                            'criteria' => $condition['criteria'],
                            'unit_id' => $condition['unit_id'],
                            "value" => (float)$condition['value'],
                            "max_value" => (float)$condition['max_value'],
                            'unit_constant_id' => $condition['unit_constant_id']
                        ];
                    } else {
                        $master_condition_list[$key_con] = [
                            'id' => $condition['id'],
                            'condition_id' => $condition['condition_id'],
                            'criteria' => $condition['criteria'],
                            'unit_id' => $condition['unit_id'],
                            'value' => (float)$condition['value'],
                            'unit_constant_id' => $condition['unit_constant_id']
                        ];
                    }
                }
                // Unit Conditions
                foreach ($simulate_input['unit_condition'] as $key_unit_con => $condition) {
                    if ($condition['criteria'] == 4) {
                        $unit_condition_list[$key_unit_con] = [
                            'id' => $condition['id'],
                            'condition_id' => $condition['condition_id'],
                            'criteria' => $condition['criteria'],
                            'unit_id' => $condition['unit_id'],
                            "value" => (float)$condition['value'],
                            "max_value" => (float)$condition['max_value'],
                            'unit_constant_id' => $condition['unit_constant_id']
                        ];
                    } else {
                        $unit_condition_list[$key_unit_con] = [
                            'id' => $condition['id'],
                            'condition_id' => $condition['condition_id'],
                            'criteria' => $condition['criteria'],
                            'unit_id' => $condition['unit_id'],
                            'value' => (float)$condition['value'],
                            'unit_constant_id' => $condition['unit_constant_id']
                        ];
                    }
                }
                // Master Outcomes
                foreach ($simulate_input['master_outcome'] as $key_out => $outcome) {
                    if ($outcome['criteria'] == 4) {
                        $master_outcome_list[$key_out] = [
                            'id' => $outcome['id'],
                            'outcome_id' => $outcome['outcome_id'],
                            'criteria' => $outcome['criteria'],
                            'unit_id' => $outcome['unit_id'],
                            "value" => (float)$outcome['value'],
                            "max_value" => (float)$outcome['max_value'],
                            'unit_constant_id' => $outcome['unit_constant_id']
                        ];
                    } else {
                        $master_outcome_list[$key_out] = [
                            'id' => $outcome['id'],
                            'outcome_id' => $outcome['outcome_id'],
                            'criteria' => $outcome['criteria'],
                            'unit_id' => $outcome['unit_id'],
                            'value' => (float)$outcome['value'],
                            'unit_constant_id' => $outcome['unit_constant_id']
                        ];
                    }
                }
                // Unit Outcomes
                foreach ($simulate_input['unit_outcome'] as $key_unit_out => $outcome) {
                    if ($outcome['criteria'] == 4) {
                        $unit_outcome_list[$key_unit_out] = [
                            'id' => $outcome['id'],
                            'outcome_id' => $outcome['outcome_id'],
                            'criteria' => $outcome['criteria'],
                            'unit_id' => $outcome['unit_id'],
                            "value" => (float)$outcome['value'],
                            "max_value" => (float)$outcome['max_value'],
                            'unit_constant_id' => $outcome['unit_constant_id']
                        ];
                    } else {
                        $unit_outcome_list[$key_unit_out] = [
                            'id' => $outcome['id'],
                            'outcome_id' => $outcome['outcome_id'],
                            'criteria' => $outcome['criteria'],
                            'unit_id' => $outcome['unit_id'],
                            'value' => (float)$outcome['value'],
                            'unit_constant_id' => $outcome['unit_constant_id']
                        ];
                    }
                }
            }
            // Simulate Input Data
            $simulate_input_info = [
                'id' => $simulate_input['id'],
                'experiment_id' => $simulate_input['experiment_id'],
                'variation_id' => $simulate_input['variation_id'],
                'simulate_input_type' => $simulate_input['simulate_input_type'],
                'raw_materials' => $raw_material_list,
                'master_conditions' => $master_condition_list,
                'unit_conditions' => $unit_condition_list,
                'master_outcomes' => $master_outcome_list,
                'unit_outcomes' => $unit_outcome_list
            ];
            $response = [
                'data' => $simulate_input_info,
                'status_code' => 200,
                'status' => true,
                'message' => "Success"
            ];
        } else {
            $response = [
                'data' => $simulate_input_info,
                'status_code' => 500,
                'status' => false,
                'message' => $message
            ];
        }
        return response()->json($response);
    }

    public function get_simulate_input_data_new(Request $request)
    {
        try {
            $simulate_input = SimulateInput::find($request->simulate_input_id);
            $experimentinfo = ProcessExperiment::find($simulate_input->experiment_id);
            $variationInfo = Variation::find($simulate_input->variation_id);
            $processVarMaster = ProcessExpProfileMaster::where('process_exp_id', $simulate_input->experiment_id)->get();
            $processVarExperiment = ProcessExpProfile::where([['process_exp_id', $simulate_input->experiment_id], ['variation_id', $simulate_input->variation_id]])->whereIn('experiment_unit', $variationInfo->unit_specification['experiment_units'])->get();
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        $productList = !(is_null($experimentinfo)) ? Chemical::whereIn("id", $experimentinfo->chemical)->get() : [];
        $mainProductInput = !(is_null($experimentinfo)) ? Chemical::select('id as product_id','chemical_name','product_type_id','molecular_formula','category_id','classification_id','smiles','cas_no','iupac','inchi','inchi_key','ec_number')->whereIn("id", $experimentinfo->main_product_input)->get() : [];
        $mainProductOutput = !(is_null($experimentinfo)) ? Chemical::select('id as product_id','chemical_name','product_type_id','molecular_formula','category_id','classification_id','smiles','cas_no','iupac','inchi','inchi_key','ec_number')->whereIn("id", $experimentinfo->main_product_output)->get() : [];
        $energyUtility = !(is_null($experimentinfo)) ? EnergyUtility::whereIn("id", $experimentinfo->energy_id)->get() : [];
        $experimentUnits = [];
        if (!is_null($experimentinfo)) {
            if ($experimentinfo->experiment_unit != NULL) {
                foreach ($experimentinfo->experiment_unit as $key => $val) {
                    $exp_unit_id = $val['exp_unit'];
                    $expInfo = ExperimentUnit::find($exp_unit_id);
                    $equipInfo = EquipmentUnit::find($expInfo->equipment_unit_id);
                    $equip = array(
                        "equipment_unit_id" => $equipInfo->id,
                        "equipment_name" => $equipInfo['equipment_name'],
                        "condition" => !(is_null($equipInfo->condition)) ? ExperimentConditionMaster::select('id as condition_id','name','unittype')->whereIn("id", $equipInfo->condition)->get() : [],
                        "outcome" => !(is_null($equipInfo->outcome)) ? ExperimentOutcomeMaster::select('id as outcome_id','name','unittype')->whereIn("id", $equipInfo->outcome)->get() : [],
                        "stream_flow" => $equipInfo['stream_flow'],
                    );
                    $exp = array(
                        'exp_unit_id' => $val['id'],
                        'unit' => $val['unit'],
                        'experiment_unit_id' => $exp_unit_id,
                        'experiment_unit_name' => $expInfo->experiment_unit_name,
                        'equipment_unit' => $equip,
                    );
                    $experimentUnits[] = $exp;
                }
            }
        }
        $varidationDetails = [];
        if (!is_null($variationInfo)) {
            if ($simulate_input->variation_id != NULL) {
                $masterUnitConditions = [];
                $masterUnitOutcomes = [];
                if (!is_null($processVarMaster)) {
                    foreach ($processVarMaster as $key => $mas) {
                        $masterUnitConditions[] = !(is_null($processVarMaster)) ? ExperimentConditionMaster::whereIn("id", $mas->condition)->get() : [];
                        $masterUnitOutcomes = !(is_null($processVarMaster)) ? ExperimentOutcomeMaster::whereIn("id", $mas->outcome)->get() : [];
                    }
                }
                $experimentUnitConditions = [];
                $experimentUnitOutcomes = [];
                if (!is_null($processVarExperiment)) {
                    foreach ($processVarExperiment as $key => $exp) {
                        $experimentUnitConditions[] = !(is_null($processVarExperiment)) ? ExperimentConditionMaster::whereIn("id", $exp->condition)->get() : [];
                        $experimentUnitOutcomes = !(is_null($processVarExperiment)) ? ExperimentOutcomeMaster::whereIn("id", $exp->outcome)->get() : [];
                    }
                }
                $varidationDetails = array(
                    "variation_id" => $variationInfo['id'],
                    "name" => $variationInfo['name'],
                    "process_flow_table" => !(is_null($variationInfo)) ? ProcessDiagram::select('id as process_flow_id','name','flowtype','products')->whereIn("id", $variationInfo->process_flow_table)->get() : [],
                    // "process_flow_chart" => $variationInfo['process_flow_chart'],
                    // "unit_specification" => $variationInfo['unit_specification'],
                    // "models" => $variationInfo['models'],
                    // "dataset" => $variationInfo['dataset'],
                    // "datamodel" => $variationInfo['datamodel'],
                    // "master_unit_conditions" => $masterUnitConditions,
                    // "master_unit_outcomes" => $masterUnitOutcomes,
                    // "experiment_unit_conditions" => $experimentUnitConditions,
                    // "experiment_unit_outcomes" => $experimentUnitOutcomes
                );
            }
        }
        $simulate_input_info = [];
        $raw_material_list = [];
        $product_list = [];
        $master_condition_list = [];
        $unit_condition_list = [];
        $master_outcome_list = [];
        $unit_outcome_list = [];
        if (!empty($simulate_input)) {
            if ($simulate_input->simulate_input_type == "forward") {
                // Raw Materials
                foreach ($simulate_input['raw_material'] as $raw_material) {
                    $product_list = [];
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
                // Master Conditions
                foreach ($simulate_input['master_condition'] as $conditions) {
                    $master_condition_list[] = [
                        'id' => $conditions['id'],
                        'condition_id' => $conditions['condition_id'],
                        'unit_id' => $conditions['unit_id'],
                        'value' => (float)$conditions['value'],
                        'unit_constant_id' => $conditions['unit_constant_id']
                    ];
                }
                // Unit Conditions
                foreach ($simulate_input['unit_condition'] as $conditions) {
                    $unit_condition_list[] = [
                        'id' => $conditions['id'],
                        'condition_id' => $conditions['condition_id'],
                        'exp_unit_id' => $conditions['exp_unit_id'],
                        'unit_id' => $conditions['unit_id'],
                        'value' => (float)$conditions['value'],
                        'unit_constant_id' => $conditions['unit_constant_id']
                    ];
                }
                // Master Outcomes
                foreach ($simulate_input['master_outcome'] as $outcome) {
                    $master_outcome_list[] = [
                        'id' => $outcome['id'],
                        'outcome_id' => $outcome['outcome_id'],
                        'unit_id' => $outcome['unit_id'],
                        'value' => (float)$outcome['value'],
                        'unit_constant_id' => $outcome['unit_constant_id']
                    ];
                }
                // Unit Outcomes
                foreach ($simulate_input['unit_outcome'] as $outcome) {
                    $unit_outcome_list[] = [
                        'id' => $outcome['id'],
                        'outcome_id' => $outcome['outcome_id'],
                        'exp_unit_id' => $outcome['exp_unit_id'],
                        'unit_id' => $outcome['unit_id'],
                        'value' => (float)$outcome['value'],
                        'unit_constant_id' => $outcome['unit_constant_id']
                    ];
                }
            } else {
                // Raw Materials
                foreach ($simulate_input['raw_material'] as $key_raw => $raw_material) {
                    if (!empty($raw_material['product'])) {
                        foreach ($raw_material['product'] as $pro_count => $assosicated_product) {
                            if ($assosicated_product['criteria'] == 4) {
                                $product_list[] = [
                                    "product_id" => $assosicated_product['product_id'],
                                    "criteria" => $assosicated_product['criteria'],
                                    "value" => (float)$assosicated_product['value'],
                                    "max_value" => (float)$assosicated_product['max_value']
                                ];
                            } else {
                                $product_list[] = [
                                    "product_id" => $assosicated_product['product_id'],
                                    "criteria" => $assosicated_product['criteria'],
                                    "value" => (float)$assosicated_product['value']
                                ];
                            }
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
                // Master Conditions
                foreach ($simulate_input['master_condition'] as $key_con => $condition) {
                    if ($condition['criteria'] == 4) {
                        $master_condition_list[$key_con] = [
                            'id' => $condition['id'],
                            'condition_id' => $condition['condition_id'],
                            'criteria' => $condition['criteria'],
                            'unit_id' => $condition['unit_id'],
                            "value" => (float)$condition['value'],
                            "max_value" => (float)$condition['max_value'],
                            'unit_constant_id' => $condition['unit_constant_id']
                        ];
                    } else {
                        $master_condition_list[$key_con] = [
                            'id' => $condition['id'],
                            'condition_id' => $condition['condition_id'],
                            'criteria' => $condition['criteria'],
                            'unit_id' => $condition['unit_id'],
                            'value' => (float)$condition['value'],
                            'unit_constant_id' => $condition['unit_constant_id']
                        ];
                    }
                }
                // Unit Conditions
                foreach ($simulate_input['unit_condition'] as $key_unit_con => $condition) {
                    if ($condition['criteria'] == 4) {
                        $unit_condition_list[$key_unit_con] = [
                            'id' => $condition['id'],
                            'condition_id' => $condition['condition_id'],
                            'criteria' => $condition['criteria'],
                            'unit_id' => $condition['unit_id'],
                            "value" => (float)$condition['value'],
                            "max_value" => (float)$condition['max_value'],
                            'unit_constant_id' => $condition['unit_constant_id']
                        ];
                    } else {
                        $unit_condition_list[$key_unit_con] = [
                            'id' => $condition['id'],
                            'condition_id' => $condition['condition_id'],
                            'criteria' => $condition['criteria'],
                            'unit_id' => $condition['unit_id'],
                            'value' => (float)$condition['value'],
                            'unit_constant_id' => $condition['unit_constant_id']
                        ];
                    }
                }
                // Master Outcomes
                foreach ($simulate_input['master_outcome'] as $key_out => $outcome) {
                    if ($outcome['criteria'] == 4) {
                        $master_outcome_list[$key_out] = [
                            'id' => $outcome['id'],
                            'outcome_id' => $outcome['outcome_id'],
                            'criteria' => $outcome['criteria'],
                            'unit_id' => $outcome['unit_id'],
                            "value" => (float)$outcome['value'],
                            "max_value" => (float)$outcome['max_value'],
                            'unit_constant_id' => $outcome['unit_constant_id']
                        ];
                    } else {
                        $master_outcome_list[$key_out] = [
                            'id' => $outcome['id'],
                            'outcome_id' => $outcome['outcome_id'],
                            'criteria' => $outcome['criteria'],
                            'unit_id' => $outcome['unit_id'],
                            'value' => (float)$outcome['value'],
                            'unit_constant_id' => $outcome['unit_constant_id']
                        ];
                    }
                }
                // Unit Outcomes
                foreach ($simulate_input['unit_outcome'] as $key_unit_out => $outcome) {
                    if ($outcome['criteria'] == 4) {
                        $unit_outcome_list[$key_unit_out] = [
                            'id' => $outcome['id'],
                            'outcome_id' => $outcome['outcome_id'],
                            'criteria' => $outcome['criteria'],
                            'unit_id' => $outcome['unit_id'],
                            "value" => (float)$outcome['value'],
                            "max_value" => (float)$outcome['max_value'],
                            'unit_constant_id' => $outcome['unit_constant_id']
                        ];
                    } else {
                        $unit_outcome_list[$key_unit_out] = [
                            'id' => $outcome['id'],
                            'outcome_id' => $outcome['outcome_id'],
                            'criteria' => $outcome['criteria'],
                            'unit_id' => $outcome['unit_id'],
                            'value' => (float)$outcome['value'],
                            'unit_constant_id' => $outcome['unit_constant_id']
                        ];
                    }
                }
            }
            // Simulate Input Data
            $simulate_input_info = [
                'experiment_id' => $simulate_input['experiment_id'],
                'variation_id' => $simulate_input['variation_id'],
                'simulation_input_id' => $simulate_input['id'],
                'simulate_input_type' => $simulate_input['simulate_input_type'],
                'experiment_data'=>array(
                    'product_list'=>$productList,
                    'main_product_input'=>$mainProductInput,
                    'main_product_output'=>$mainProductOutput,
                    'energy_utility'=>$energyUtility,
                    'experiment_units'=>$experimentUnits
                ),
                'variation_data' => $varidationDetails,
                'simulation_input_data'=>array(
                    'raw_materials' => $raw_material_list,
                    'master_conditions' => $master_condition_list,
                    'unit_conditions' => $unit_condition_list,
                    'master_outcomes' => $master_outcome_list,
                    'unit_outcomes' => $unit_outcome_list
                ),
            ];
            $response = [
                'data' => $simulate_input_info,
                'status_code' => 200,
                'status' => true,
                'message' => "Success"
            ];
        } else {
            $response = [
                'data' => $simulate_input_info,
                'status_code' => 500,
                'status' => false,
                'message' => $message
            ];
        }
        return response()->json($response);
    }

    public function get_simulate_input_master_outcome_list(Request $request)
    {
        try {
            $master_outcome = master_outcome_list($request->simulate_input_id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $master_outcome
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

    public function get_simulate_input_unit_outcome_list(Request $request)
    {
        try {
            $unit_outcome = unit_outcome_list($request->simulate_input_id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $unit_outcome
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

    public function get_simulate_input_master_condition_list(Request $request)
    {
        try {
            $master_condition_list = master_condition_list($request->simulate_input_id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $master_condition_list
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

    public function get_simulate_input_unit_condition_list(Request $request)
    {
        try {
            $unit_condition_list = unit_condition_list($request->simulate_input_id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $unit_condition_list
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

    public function get_simulate_input_master_outcome(Request $request)
    {
        try {
            $master_outcome = master_outcome_single($request->simulate_input_id, $request->id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $master_outcome
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

    public function get_simulate_input_unit_outcome(Request $request)
    {
        try {
            $unit_outcome = unit_outcome_single($request->simulate_input_id, $request->id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $unit_outcome
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

    public function get_simulate_input_master_condition(Request $request)
    {
        try {
            $master_condition_list = master_condition_single($request->simulate_input_id, $request->id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $master_condition_list
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

    public function get_simulate_input_unit_condition(Request $request)
    {
        try {
            $unit_condition_list = unit_condition_single($request->simulate_input_id, $request->id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $unit_condition_list
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

    public function copy_to_knowledge($id)
    {
        $simulate_input_id = ___decrypt($id);
        $simulate = SimulateInput::where('id', $simulate_input_id)->first();
        $process_experiment = ProcessExperiment::find($simulate->experiment_id);
        $classifications = [];
        foreach ($process_experiment->classification_id as $classification) {
            $classifications[] = experiment_classification($classification);
            $classification_name = [];
            foreach ($classifications as $classification) {
                $classification_name[] = $classification['name'];
            }
        }
        $product_list = [];
        foreach ($process_experiment->chemical as $product) {
            $product_list[] = get_product_details($product);
            $product_name = [];
            foreach ($product_list as $product) {
                $product_name[] = $product['name'];
            }
        }
        $main_product_inputs = [];
        foreach ($process_experiment->main_product_input as $main_product_input) {
            $main_product_inputs[] = get_product_details($main_product_input);
            $main_product_inputs_name = [];
            foreach ($main_product_inputs as $main_product_input) {
                $main_product_inputs_name[] = $main_product_input['name'];
            }
        }
        $main_product_outputs = [];
        foreach ($process_experiment->main_product_output as $main_product_output) {
            $main_product_outputs[] = get_product_details($main_product_output);
            $main_product_outputs_name = [];
            foreach ($main_product_outputs as $main_product_output) {
                $main_product_outputs_name[] = $main_product_output['name'];
            }
        }
        $energy_list = [];
        foreach ($process_experiment->energy_id as $energy) {
            $energy_info = get_energy_details($energy);
            $energy_list[] = [
                "energy_name" => $energy_info['name']
            ];
        }
        $experiment_units = [];
        if (!empty($process_experiment->experiment_unit)) {
            foreach ($process_experiment->experiment_unit as $experiment_unit) {
                $experiment_units[] = [
                    "id" => $experiment_unit['id'],
                    "experiment_unit_name" => $experiment_unit['unit'],
                    "experiment_equipment_unit" => get_experiment_unit($experiment_unit['exp_unit']),
                ];
            }
        }
        $variation = Variation::where('id', $simulate->variation_id)->first();
        $arr = [];
        if (!empty($variation->process_flow_table)) {
            $arr = $variation->process_flow_table;
        }
        $mass_flow_types = [];
        $flow_types = SimulationFlowType::whereIn('type', [1, 2, 3])->get();
        $processDiagram = ProcessDiagram::whereIn('id', $arr)->get();
        $processDiagramArr = [];
        if (!empty($processDiagram)) {
            //$processDiagramArr = $processDiagram->toArray();
            foreach ($processDiagram as $pd) {
                if (!empty($flow_types)) {
                    foreach ($flow_types as $flow_type) {
                        if ($pd->flowtype == $flow_type->id) {
                            $pd_flow_type = $flow_type->name;
                        }
                    }
                }
                $openstream = '';
                if ($pd->openstream == 1) {
                    $openstream = 'open';
                }

                $processDiagramArr[] = [
                    'id' => $pd->id,
                    'name' => $pd->name,
                    'flowtype' => $pd_flow_type,
                    'from_unit' => $pd->from_unit,
                    'to_unit' => $pd->to_unit,
                    'openstream' => $openstream
                ];
            }
        }
        $unit_specification = [];
        $master_unit_data = [];
        $pe_profile_master_data = ProcessExpProfileMaster::where('id', ($variation->unit_specification['master_units']))->first();
        if (!empty($pe_profile_master_data)) {
            $master_condition = [];
            if (!empty($pe_profile_master_data->condition)) {
                $condata = ExperimentConditionMaster::Select('name')->whereIn('id', $pe_profile_master_data->condition)->get();
                foreach ($condata as $con) {
                    $master_condition[] = $con->name;
                }
            }
            $master_outcome = [];
            if (!empty($pe_profile_master_data->outcome)) {
                $outdata = ExperimentOutcomeMaster::Select('name')->whereIn('id', $pe_profile_master_data->outcome)->get();
                foreach ($outdata as $out) {
                    $master_outcome[] = $out->name;
                }
            }
            $master_reaction = [];
            if (!empty($pe_profile_master_data->reaction)) {
                $recdata = Reaction::Select('name')->whereIn('id', $pe_profile_master_data->reaction)->get();
                foreach ($recdata as $rec) {
                    $master_reaction[] = $rec->name;
                }
            }
            // Existing Data in Table
            $master_unit_data['condition'] = $master_condition;
            $master_unit_data['outcome'] = $master_outcome;
            $master_unit_data['reaction'] = $master_reaction;
            // Data that are needed to be displayed in the frontend
        }
        $experiment_unit_data = [];
        $pe_profile_data = ProcessExpProfile::where('id', ($variation->unit_specification['experiment_units']))->get();
        foreach ($pe_profile_data as $ex_unit_data) {
            $ex_unit = ExperimentUnit::where('ids', $ex_unit_data->experiment_unit)->first();
            $ex_unit_condition = [];
            if (!empty($pe_profile_master_data->condition)) {
                $condata = ExperimentConditionMaster::Select('name')->whereIn('id', $ex_unit_data->condition)->get();
                foreach ($condata as $con) {
                    $ex_unit_condition[] = $con->name;
                }
            }
            $ex_unit_outcome = [];
            if (!empty($pe_profile_master_data->outcome)) {
                $outdata = ExperimentOutcomeMaster::Select('name')->whereIn('id', $ex_unit_data->outcome)->get();
                foreach ($outdata as $out) {
                    $ex_unit_outcome[] = $out->name;
                }
            }
            $ex_unit_reaction = [];
            if (!empty($pe_profile_master_data->reaction)) {
                $recdata = Reaction::Select('name')->whereIn('id', $ex_unit_data->reaction)->get();
                foreach ($recdata as $rec) {
                    $ex_unit_reaction[] = $rec->name;
                }
            }
            $experiment_unit_data['unit'] = $ex_unit->name;
            $experiment_unit_data['condition'] = $ex_unit_condition;
            $experiment_unit_data['outcome'] = $ex_unit_outcome;
            $experiment_unit_data['reaction'] = $ex_unit_reaction;
        }
        $variation_info = [];
        $variation_info = [
            "process_experiment_id" => $simulate->variation_id,
            "mass_flow_types" => $process_diagram_value['name'],
            "processDiagramArr" => $processDiagramArr,
            "variation_id" => !empty($request->variation_id) ? $request->variation_id : '',
            //"viewflag" => $request->viewflag
        ];
        $kbData = new KbProcessExperiment();
        $kbData->process_experiment_name = $process_experiment->process_experiment_name;
        $kbData->tenant_id = session()->get('tenant_id');
        $kbData->project_id = $process_experiment->project_id;
        $kbData->category = $process_experiment->experiment_category->name;
        $kbData->classification = json_encode($classification_name);
        $kbData->data_source = $process_experiment->data_source;
        $kbData->chemical = json_encode($product_name);
        $kbData->main_product_input = json_encode($main_product_inputs_name);
        $kbData->main_product_output = json_encode($main_product_outputs_name);
        $kbData->energy = json_encode($energy_list);
        $kbData->description = $process_experiment->description;
        $kbData->tags = json_encode($process_experiment->tags);
        $kbData->save();
        $this->status = true;
        $this->modal = true;
        $this->redirect = url('/mfg_process/simulation');
        $this->message = "Knowledge Bank Copy Successfully!";
        return $this->populateresponse();
    }

    public function uploadSimulationInputExcel(Request $request)
    {
        $data = explode('.', $request->file->getClientOriginalName());
        if (!file_exists(public_path('assets/uploads/simulation_input_excel/'.session()->get('tenant_id').'/'. $request->file->getClientOriginalName()))) {
            $res = upload_file($request, 'file', 'simulation_input_excel',session()->get('tenant_id'));
            $filenm = explode('/', $res);
            $filenm = end($filenm);
            $inputFileName = public_path('assets/uploads/simulation_input_excel/'.session()->get('tenant_id').'/'. $filenm);
            $rows =  Excel::toArray([], $inputFileName);
            $info = explode('#', $rows[0][2][0]);
            $template_id = $info[1];
            $type = $info[2];
            if (isset($data[1]) && $data[1] == "xlsx") {
                $template = SimulateInputExcelTemplate::find(___decrypt($template_id));
                $variation = Variation::find($template->variation_id);
                if (!is_null($template)) {
                    if (isset($rows[0][3]) && $rows[0][3][1]!=null) {
                        $sinput = new sim_inp_template_upload();
                        $sinput->template_id = ___decrypt($template_id);
                        $sinput->template_name = $template->template_name;
                        $sinput->variation_id = $variation->id;
                        $sinput->type = $type;
                        $sinput->excel_file = $filenm;
                        $sinput->tenant_id=session()->get('tenant_id');
                        $sinput->status = 0;
                        $sinput->entry_by = Auth::user()->id;
                        $sinput->ip_add = $request->ip();
                        $sinput->created_at = date('Y-m-d h:i:s');
                        $sinput->updated_at = date('Y-m-d h:i:s');
                        $sinput->save();
                        $response = array("success" => 1, "msg" => "Template imported successfully.");
                    } else
                        $response = array("success" => 0, "msg" => "Empty template can't be imported, please add the data.");
                } else
                    $response = array("success" => 0, "msg" => "Invalid template file.");
            } else
                $response = array("success" => 0, "msg" => "Not valid file uploaded.");

            if ($response['success'] == 0)
                unlink(public_path('assets/uploads/simulation_input_excel/'.session()->get('tenant_id').'/' . $filenm));
        } else {
            $response = array("success" => 0, "msg" => "File already exist.");
        }
        echo json_encode($response);
    }

    public function importSimInput(Request $request)
    {
        $template_data = [];
        if (!empty($request->details1[1])) {
            foreach ($request->details1 as $data) {
                foreach ($data as $key => $sim_data) {
                    if (str_contains($key, 'Simulation Input Name')) {
                        $template_data = explode('#', $key);
                    }
                }
            }
        }
        if (empty($template_data[1]) || empty($template_data[2])) {
            $this->success = false;
            $this->status = true;
            $this->modal = true;
            //  $this->redirect = url('/experiment/experiment/' . ___encrypt($template['variation_id']) . '/sim_config');
            $this->message = "Import CSV data missing type and templated id.";
            return $this->populateresponse();
        }
        $template = SimulateInputExcelTemplate::find(___decrypt($template_data[1]));
        $variation = Variation::find($template->variation_id);
        $cnt = 0;
        $raw_material = [];
        $master_condition = [];
        $master_outcome = [];
        $exp_condition = [];
        $exp_outcome = [];
        $sim_name = '';
        foreach ($request->details1 as $data) {
            foreach ($data as $key => $sim_data) {
                if (str_contains($key, 'Simulation Input Name')) {
                    $sim_name = $sim_data;
                }
                if ($key == "Raw Material") {
                    $raw_material = [];
                    $id = 1;
                    foreach ($sim_data as $streams_index) {
                        foreach ($streams_index as $k => $streams) {
                            $products = [];
                            if (!empty($streams) && is_array($streams)) {
                                foreach ($streams as $pi => $product_index) {
                                    foreach ($product_index as $p => $product) {
                                        $p_details = explode("#", $p);
                                        if (!empty($p_details[2]) && ___decrypt($p_details[2]) == 4) {
                                        }
                                        if ($pi == 0) {
                                            $value_flow_rate = !empty($product) ? $product : 0;
                                            $unit_constant_id = ___decrypt($p_details[1]);
                                        } else {
                                            if (!empty($p_details[2]) && ___decrypt($p_details[2]) == 4) {
                                                $pro_val = explode(',', $product);
                                                $products[] = [
                                                    "product_id" => ___decrypt($p_details[1]),
                                                    "criteria" => !empty($p_details[2]) ? ___decrypt($p_details[2]) : 0,
                                                    "value" => !empty($pro_val[0]) ? $pro_val[0] : 0,
                                                    "max_value" => !empty($pro_val[1]) ? $pro_val[1] : 0,
                                                    "value_flow_rate" => 0,
                                                    "unit_constant_id" => 0
                                                ];
                                            } else {
                                                $products[] = [
                                                    "product_id" => ___decrypt($p_details[1]),
                                                    "criteria" => !empty($p_details[2]) ? ___decrypt($p_details[2]) : 0,
                                                    "value" => !empty($product) ? $product : 0,
                                                    "value_flow_rate" => 0,
                                                    "unit_constant_id" => 0
                                                ];
                                            }
                                        }
                                    }
                                }
                            }
                            $k_details = explode("#", $k);
                            $raw_material[] = [
                                'id' => $id,
                                'pfd_stream_id' => !empty($k_details[1]) ? ___decrypt($k_details[1]) : 0,
                                'unit_id' => !empty($k_details[2]) ? ___decrypt($k_details[2]) : 0,
                                'value_flow_rate' => !empty($value_flow_rate) ? $value_flow_rate : 0,
                                'unit_constant_id' => $unit_constant_id,
                                'product' => $products,
                            ];
                            $id++;
                        }
                    }
                }

                if ($key == "Master Condition") {
                    $id = 1;
                    foreach ($sim_data as $condition_index) {
                        if (!empty($condition_index) && is_array($condition_index)) {
                            foreach ($condition_index as $c => $condition) {
                                $c_details = explode("#", $c);
                                if (!empty($c_details[4]) && ___decrypt($c_details[4]) == 4) {
                                    $val = explode(',', $condition);
                                    $master_condition[] = [
                                        "id" => $id,
                                        "value" => !empty($val[0]) ? $val[0] : 0,
                                        "max_value" => !empty($val[1]) ? $val[1] : 0,
                                        "criteria" => !empty($c_details[4]) ? ___decrypt($c_details[4]) : 0,
                                        "unit_id" => ___decrypt($c_details[2]),
                                        "condition_id" => ___decrypt($c_details[1]),
                                        "unit_constant_id" => ___decrypt($c_details[3]),
                                    ];
                                } else {
                                    $master_condition[] = [
                                        "id" => $id,
                                        "value" => !empty($condition) ? $condition : 0,
                                        "criteria" => !empty($c_details[4]) ? ___decrypt($c_details[4]) : 0,
                                        "unit_id" => ___decrypt($c_details[2]),
                                        "condition_id" => ___decrypt($c_details[1]),
                                        "unit_constant_id" => ___decrypt($c_details[3]),
                                    ];
                                }
                            }
                            $id++;
                        }
                    }
                }

                if ($key == "Master Outcome") {
                    $id = 1;
                    foreach ($sim_data as $outcome_index) {
                        if (!empty($outcome_index) && is_array($outcome_index)) {
                            foreach ($outcome_index as $o => $outcome) {
                                $o_details = explode("#", $o);
                                if (!empty($o_details[4]) && ___decrypt($o_details[4]) == 4) {
                                    $val = explode(',', $outcome);
                                    $master_outcome[] = [
                                        "id" => $id,
                                        "value" => !empty($val[0]) ? $val[0] : 0,
                                        "max_value" => !empty($val[1]) ? $val[1] : 0,
                                        "unit_id" => ___decrypt($o_details[2]),
                                        "criteria" => !empty($o_details[4]) ? ___decrypt($o_details[4]) : 0,
                                        "priority" => 0,
                                        "outcome_id" => ___decrypt($o_details[1]),
                                        "unit_constant_id" => ___decrypt($o_details[3]),
                                    ];
                                } else {
                                    $master_outcome[] = [
                                        "id" => $id,
                                        "value" => !empty($outcome) ? $outcome : 0,
                                        "unit_id" => ___decrypt($o_details[2]),
                                        "criteria" => !empty($o_details[4]) ? ___decrypt($o_details[4]) : 0,
                                        "priority" => 0,
                                        "outcome_id" => ___decrypt($o_details[1]),
                                        "unit_constant_id" => ___decrypt($o_details[3]),
                                    ];
                                }
                                $id++;
                            }
                        }
                    }
                }

                if ($key == "Exp Unit Condition") {
                    $id = 1;
                    foreach ($sim_data as $exp_unit_index) {
                        foreach ($exp_unit_index as $exp_unit => $exp_unit_data) {
                            $exp_unit_details = explode("#", $exp_unit);
                            foreach ($exp_unit_data as $condition_index) {
                                foreach ($condition_index as $c => $condition) {
                                    $c_details = explode("#", $c);
                                    if (!empty($c_details[4]) && ___decrypt($c_details[4]) == 4) {
                                        $val = explode(',', $condition);
                                        $exp_condition[] = [
                                            "id" => $id,
                                            "value" => !empty($val[0]) ? $val[0] : 0,
                                            "max_value" => !empty($val[1]) ? $val[1] : 0,
                                            "unit_id" => !empty($c_details[2]) ? ___decrypt($c_details[2]) : 0,
                                            "criteria" => !empty($c_details[4]) ? ___decrypt($c_details[4]) : 0,
                                            "priority" => 0,
                                            "exp_unit_id" => ___decrypt($exp_unit_details[1]),
                                            "condition_id" => ___decrypt($c_details[1]),
                                            "unit_constant_id" => ___decrypt($c_details[3]),
                                        ];
                                    } else {
                                        $exp_condition[] = [
                                            "id" => $id,
                                            "value" => !empty($condition) ? $condition : 0,
                                            "unit_id" => ___decrypt($c_details[2]),
                                            "criteria" => !empty($c_details[4]) ? ___decrypt($c_details[4]) : 0,
                                            "priority" => 0,
                                            "exp_unit_id" => ___decrypt($exp_unit_details[1]),
                                            "condition_id" => ___decrypt($c_details[1]),
                                            "unit_constant_id" => ___decrypt($c_details[3]),
                                        ];
                                    }
                                    $id++;
                                }
                            }
                        }
                    }
                }

                if ($key == "Exp Unit Outcome") {
                    $id = 1;
                    foreach ($sim_data as $exp_unit_index) {
                        foreach ($exp_unit_index as $exp_unit => $exp_unit_data) {
                            $exp_unit_details = explode("#", $exp_unit);
                            foreach ($exp_unit_data as $outcome_index) {
                                foreach ($outcome_index as $o => $outcome) {
                                    $o_details = explode("#", $o);
                                    if (!empty($o_details[4]) && ___decrypt($o_details[4]) == 4) {
                                        $val = explode(',', $outcome);
                                        $exp_outcome[] = [
                                            "id" => $id,
                                            "value" => !empty($val[0]) ? $val[0] : 0,
                                            "max_value" => !empty($val[1]) ? $val[1] : 0,
                                            "unit_id" => ___decrypt($o_details[2]),
                                            "criteria" => !empty($o_details[4]) ? ___decrypt($o_details[4]) : 0,
                                            "priority" => 0,
                                            "exp_unit_id" => ___decrypt($exp_unit_details[1]),
                                            "outcome_id" => ___decrypt($o_details[1]),
                                            "unit_constant_id" => ___decrypt($o_details[3]),
                                        ];
                                    } else {
                                        $exp_outcome[] = [
                                            "id" => $id,
                                            "value" => !empty($outcome) ? $outcome : 0,
                                            "unit_id" => ___decrypt($o_details[2]),
                                            "criteria" => !empty($o_details[4]) ? ___decrypt($o_details[4]) : 0,
                                            "priority" => 0,
                                            "exp_unit_id" => ___decrypt($exp_unit_details[1]),
                                            "outcome_id" => ___decrypt($o_details[1]),
                                            "unit_constant_id" => ___decrypt($o_details[3]),
                                        ];
                                    }
                                    $id++;
                                }
                            }
                        }
                    }
                }
            }
        }

        $Data = new SimulateInput();
        $Data->experiment_id = $variation['experiment_id'];
        $Data->variation_id = $template['variation_id'];
        $Data->template_id = $template->id;
        $Data->simulate_input_type = $template_data[2];
        $Data->name = $sim_name . ' (' . $template->template_name . ')';
        $Data->raw_material = $raw_material;
        $Data->master_condition = $master_condition;
        $Data->master_outcome = $master_outcome;
        $Data->unit_condition = $exp_condition;
        $Data->unit_outcome = $exp_outcome;
        $Data->created_by = Auth::user()->id;
        $Data->updated_by = Auth::user()->id;
        $Data->save();

        $this->success = true;
        $this->status = true;
        $this->modal = true;
        $this->redirect = url('/experiment/experiment/' . ___encrypt($template['variation_id']) . '/sim_config');
        $this->message = " Simulation Inputs Imported Successfully!";
        return $this->populateresponse();
    }
}
