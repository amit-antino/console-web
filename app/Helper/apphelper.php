<?php

use App\Models\Country;
use App\Models\Product\Chemical;
use App\Models\MFG\ProcessSimulation;
use App\Models\MFG\ProcessProfile;
use App\Models\OtherInput\EnergyUtility;
use App\Models\Master\MasterUnit;
use App\Models\Organization\Experiment\ExperimentClassification;
use App\Models\Master\ProcessSimulation\SimulationType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\ListProduct;
use App\Models\Master\EnergyUtilities\EnergySubPropertyMaster;
use App\Models\OtherInput\EnergyUtilityProperty;
use App\Models\Organization\Lists\RegulatoryList;
use App\Models\Master\Chemical\Hazard\CodeStatement;
use App\Models\Master\Chemical\Hazard\Hazard;
use App\Models\Tenant\Tenant;
use App\Models\Models\ModelDetail;
use App\Models\ProcessExperiment\DatasetModel;
use Hashids\Hashids;
use App\Models\Master\Chemical\Hazard\HazardPictogram;
use Illuminate\Support\Facades\Session;

function split_name($name)
{
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));
    return array($first_name, $last_name);
}

function whodel($id)
{
    $data = array('id' => ___decrypt($id), 'status' => 'inactive', 'updated_by' => Auth::user()->id);
    ProcessSimulation::where('id', ___decrypt($id))->update($data);
}

function getdatasource($request)
{
    $profileId = ProcessProfile::select('data_source_mass')->where([['process_id', $request->id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
    if ($profileId != NULL) {
        if ($profileId['data_source_mass'] != "0") {
            $data_source_mass = $profileId['data_source_mass'];
        } else {
            $data_source_mass = "0";
        }
    } else {
        $data_source_mass = "0";
    }
    return $data_source_mass;
}

function getdatasourceEnergy($request)
{
    $profileId = ProcessProfile::select('data_source_energy')->where([['process_id', $request->id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
    if ($profileId != NULL) {
        if ($profileId['data_source_energy'] != "0") {
            $data_source_energy = $profileId['data_source_energy'];
        } else {
            $data_source_energy = "0";
        }
    } else {
        $data_source_energy = "0";
    }
    return $data_source_energy;
}

function getbuiValue($request)
{
    $id = ProcessProfile::select('id')->where([['process_id', $request->id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
    if ($id != NULL || $id != "") {
        $profileBui = ProcessProfile::find($id['id']);
        $data['profileBui'] = $profileBui;
        $mass_balance = $data['profileBui']['mass_basic_io'];
    }
    if (!empty($mass_balance['input'])) {
        $mass_balance_input = $mass_balance['input'];
    } else {
        $mass_balance_input = [];
    }
    if (!empty($mass_balance['output'])) {
        $mass_balance_output = $mass_balance['output'];
    } else {
        $mass_balance_output = [];
    }
    $data['mass_balance_input'] = $mass_balance_input;
    $data['mass_balance_output'] = $mass_balance_output;
    return $data;
}

function getEnergybuiValue($request)
{
    $id = ProcessProfile::select('id')->where([['process_id', $request->id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
    if ($id != NULL || $id != "") {
        $profileBuiEnergy = ProcessProfile::find($id['id']);
        $data['profileBuiEnergy'] = $profileBuiEnergy;
        $utility_balance = $data['profileBuiEnergy']['energy_basic_io'];
    }
    if (!empty($utility_balance['input'])) {
        $utility_balance_input = $utility_balance['input'];
    } else {
        $utility_balance_input = [];
    }
    if (!empty($utility_balance['output'])) {
        $utility_balance_output = $utility_balance['output'];
    } else {
        $utility_balance_output = [];
    }
    $myuinput = [];
    foreach ($utility_balance_input as $uik => $uiv) {
        $myuinput[$uik]['id'] = ___encrypt($uiv['id']);
        $myuinput[$uik]['unit'] = ___encrypt($uiv['unit']);
        $myuinput[$uik]['unit_constant_id'] = ___encrypt($uiv['unit_constant_id']);
        $myuinput[$uik]['flowtype'] = ___encrypt($uiv['flowtype']);
        $myuinput[$uik]['product_input'] = ___encrypt($uiv['product_input']);
        $myuinput[$uik]['input_flow_rate'] = (isset($uiv['input_flow_rate'])) ? $uiv['input_flow_rate'] : '0';
    }
    $data['utility_balance_input'] =   $myuinput;
    $myuoutput = [];
    foreach ($utility_balance_output as $uik => $uiv) {
        $myuoutput[$uik]['id'] = ___encrypt($uiv['id']);
        $myuoutput[$uik]['unit_constant_id'] = ___encrypt($uiv['unit_constant_id']);
        $myuoutput[$uik]['unit'] = ___encrypt($uiv['unit']);
        $myuoutput[$uik]['flowtype'] = ___encrypt($uiv['flowtype']);
        $myuoutput[$uik]['product_output'] = ___encrypt($uiv['product_output']);
        $myuoutput[$uik]['output_flow_rate'] = (isset($uiv['output_flow_rate'])) ? $uiv['output_flow_rate'] : '0';
    }
    $data['utility_balance_output'] = $myuoutput;
    return $data;
}

function get_mass_basic_io($mass_basic_io)
{
    try {
        $ps_mass_basic_io = [];
        if (!empty($mass_basic_io)) {
            foreach ($mass_basic_io as $io) {
                $property = get_product_properties_helper($io['product']);
                $ps_mass_basic_io[] = [
                    "product_id" => $io['product'],
                    "product_properties" => $property,
                    "io_type" => $io['io'],
                    "flow_type_id" => $io['flow_type'],
                    "unit_id" => 10,
                    "unit_constant" => $io['unit_type'],
                    "flow_rate" => $io['mass_flow'],
                    "phase" => !empty($io['phase'])?$io['phase']:''
                ];
            }
        }
        return $ps_mass_basic_io;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_mass_basic_io_old($process_simulation_id, $simulation_stage_id)
{
    try {
        $process_simulation_profile = ProcessProfile::where('process_id', $process_simulation_id)->where('simulation_type', $simulation_stage_id)->get();
        $ps_mass_basic_input = [];
        $ps_mass_basic_output = [];
        if (!empty($process_simulation_profile)) {
            foreach ($process_simulation_profile as $ps_profile) {
                if (!empty($ps_profile->mass_basic_io)) {
                    foreach ($ps_profile->mass_basic_io['input'] as $mass_basic_input) {
                        $ps_mass_basic_input[] = [
                            "product_id" => json_decode($mass_basic_input['product_input'], true),
                            "flow_type_id" => json_decode($mass_basic_input['flowtype'], true),
                            "unit_id" => 10,
                            "unit_constant" => json_decode($mass_basic_input['unit'], true),
                            "flow_rate" => json_decode($mass_basic_input['massflow'], true)
                        ];
                    }
                    foreach ($ps_profile->mass_basic_io['output'] as $mass_basic_output) {
                        $ps_mass_basic_output[] = [
                            "product_id" => json_decode($mass_basic_output['product_output'], true),
                            "flow_type_id" => json_decode($mass_basic_output['flowtype'], true),
                            "unit_id" => 10,
                            "unit_constant" => json_decode($mass_basic_output['unit'], true),
                            "flow_rate" => json_decode($mass_basic_output['massflow'], true)
                        ];
                    }
                }
            }
            $ps_mass_basic_io = [
                "mass_balance_input" => $ps_mass_basic_input,
                "mass_balance_output" => $ps_mass_basic_output
            ];
            return $ps_mass_basic_io;
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_mass_process_chemistry($process_simulation_id, $simulation_stage_id, $flag = 0)
{
    try {
        $process_simulation_profile = ProcessProfile::where('process_id', $process_simulation_id)->where('simulation_type', $simulation_stage_id)->get();
        $reactor_details = [];
        $streams = [];
        $opr = [];
        $catalst = [];
        if (!empty($process_simulation_profile)) {
            foreach ($process_simulation_profile as $ps_profile) {
                if (!empty($ps_profile->mass_basic_pc)) {
                    foreach ($ps_profile->mass_basic_pc as $key => $reactor) {
                        foreach ($reactor['input'] as $sk => $stream) {
                            $streams[$key][$sk] = [
                                "product_id" => json_decode($stream['product'], true),
                                "flow_type_id" => json_decode($stream['flowtype'], true),
                                "total_mass_flow_rate" => array_sum($stream['product_compostion']),
                                "unit_id" => json_decode($stream['unit_id'], true),
                                "unit_constant_id" => json_decode($stream['unit_constant_id'], true),
                                "product_associates" => getproductCompostion($stream['product_compostion'])
                            ];
                        }
                        if (!empty($reactor['opr'])) {
                            $opr[$key] = [
                                "stage_type" => ($reactor['opr']['stage_type'] == "ncat") ? "Non-Catalyzed" : (($reactor['opr']['stage_type'] == "cat") ? "Chemo-Catalyzed"  : "Bio-Catalyzed"),
                                "reaction_temperature" => (!empty($reactor['opr']['reactiontempInput'])) ? ["value" => json_decode($reactor['opr']['reactiontempInput'], true), "unit_id" => 12, "unit_constant_id" => json_decode($reactor['opr']['reactiotemp'], true)] : [],
                                "heat_of_reaction" => (!empty($reactor['opr']['heatreactioninput'])) ? ["value" => json_decode($reactor['opr']['heatreactioninput'], true), "unit_id" => 15, "unit_constant_id" => json_decode($reactor['opr']['heatreactionsel'], true)] : [],
                                "reaction_type" => ($reactor['opr']['reaction_type'] == "exo") ? "Exothermic" : "Endothermic",
                                "reaction_pressure" => (!empty($reactor['opr']['reactPressureinput'])) ? ["value" => json_decode($reactor['opr']['reactPressureinput'], true), "unit_id" => 5, "unit_constant_id" => json_decode($reactor['opr']['reactPressureoption'], true)] : [],
                                "reaction_time" => (!empty($reactor['opr']['reacttimeInput'])) ? ["value" => json_decode($reactor['opr']['reacttimeInput'], true), "unit_id" => 14, "unit_constant_id" => json_decode($reactor['opr']['reacttimeoption'], true)] : [],
                                "feedstock_pretreatment" => ($reactor['opr']['feedbackReq'] == "1") ? "yes" : "no",
                                "main_product_concentration" => (!empty($reactor['opr']['main_product_concentration'])) ? ["value" => json_decode($reactor['opr']['main_product_concentration'], true), "unit_id" => 18, "unit_constant_id" => json_decode($reactor['opr']['main_product_concentration_unit'], true)] : [],
                                "type_of_metabolite" => ($reactor['opr']['type_of_metabolite'] == "ext") ? "Extracellular" : "Intracelullar",
                                "presence_of_solids" => ($reactor['opr']['presence_of_solids'] == "SOl") ? "Solids Present" : "No Solids Present",
                                "distillation" => ($reactor['opr']['need_for_distillation'] == "y") ? "yes" : "No",
                                "complex_separation_alternatives" => ($reactor['opr']['complx_separation_alter_need'] == "y") ? "yes" : "No",
                            ];
                        }
                        if (!empty($reactor['catalyst_tab'])) {
                            $compostion = [];
                            if (!empty($reactor['catalyst_tab']['catalyst_composition'])) {
                                foreach ($reactor['catalyst_tab']['catalyst_composition'] as $ck => $cv) {
                                    $compostion[$ck]['component_name'] = $cv['component_name'];
                                    $compostion[$ck]['fraction'] = json_decode($cv['fraction'], true);
                                }
                            }
                            $catalst[$key] = [
                                "catalyst_name" => (!empty($reactor['catalyst_tab']['catalyst_name'])) ? $reactor['catalyst_tab']['catalyst_name'] : "",
                                "catalyst_WHSV " => (!empty($reactor['catalyst_tab']['whsv_name'])) ? ["value" => json_decode($reactor['catalyst_tab']['whsv_name'], true), "unit_id" => 20, "unit_constant_id" => json_decode($reactor['catalyst_tab']['whsv_unit'], true)] : [],
                                "catalyst_LHSV " => (!empty($reactor['catalyst_tab']['lhsv_name'])) ? ["value" => json_decode($reactor['catalyst_tab']['lhsv_name'], true), "unit_id" => 20, "unit_constant_id" => json_decode($reactor['catalyst_tab']['lhsv_unit'], true)] : [],
                                "catalyst_composition " => (!empty($compostion)) ? $compostion : [],
                                "stream_time " => (!empty($reactor['catalyst_tab']['stream_time'])) ? ["value" => json_decode($reactor['catalyst_tab']['stream_time'], true), "unit_id" => 14, "unit_constant_id" => json_decode($reactor['catalyst_tab']['stream_time_unit'], true)] : [],
                                "regeneration_time " => (!empty($reactor['catalyst_tab']['regenration_time'])) ? ["value" => json_decode($reactor['catalyst_tab']['regenration_time'], true), "unit_id" => 14, "unit_constant_id" => json_decode($reactor['catalyst_tab']['regenration_time_unit'], true)] : [],
                                "lifetime " => (!empty($reactor['catalyst_tab']['lifetime'])) ? ["value" => json_decode($reactor['catalyst_tab']['lifetime'], true), "unit_id" => 14, "unit_constant_id" => json_decode($reactor['catalyst_tab']['lifetime_unit'], true)] : [],
                                "regeneration_technique" => (!empty($reactor['catalyst_tab']['regenration_tech'])) ? $reactor['catalyst_tab']['regenration_tech'] : "",
                            ];
                        }
                        $reactor_details[] = [
                            "reactor_id" => $key,
                            "reactor_details" => $streams[$key],
                            "operating_conditions" => (isset($opr[$key])) ? $opr[$key] : [],
                            "catalyst" => (isset($catalst[$key])) ? $catalst[$key] : []
                        ];
                    }
                }
            }
            if ($flag != 1) {
                $data['mass_balance'] = getMassBalanceofPC($process_simulation_id, $simulation_stage_id);
            }
            $data['reaction_detail'] = $reactor_details;
            return $data;
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function getproductCompostion($data)
{
    $prodAssociated = [];
    foreach ($data as $key => $value) {
        $exp = explode("##", $key);
        if ($exp[1] != 0) {
            $prodAssociated[] = [
                "product_id" => json_decode($exp[1], true),
                "mass_flow_rate" => json_decode($value, true)
            ];
        }
    }
    return $prodAssociated;
}

function get_mass_process_detailed($process_simulation_id, $simulation_stage_id, $flag = 0)
{
    try {
        $process_simulation_profile = ProcessProfile::where('process_id', $process_simulation_id)->where('simulation_type', $simulation_stage_id)->get();
        $reactor_details = [];
        $streams = [];
        if (!empty($process_simulation_profile)) {
            foreach ($process_simulation_profile as $ps_profile) {
                if (!empty($ps_profile->mass_basic_pd)) {
                    foreach ($ps_profile->mass_basic_pd as $key => $reactor) {
                        if ($key != "sel") {
                            foreach ($reactor['input'] as  $sk =>  $stream) {
                                $streams[$key][$sk] = [
                                    "product_id" => json_decode($stream['product'], true),
                                    "flow_type_id" => json_decode($stream['flowtype'], true),
                                    "total_mass_flow_rate" => array_sum($stream['product_compostion']),
                                    "unit_id" => json_decode($stream['unit_id'], true),
                                    "unit_constant_id" => json_decode($stream['unit_constant_id'], true),
                                    "product_associates" => getproductCompostion($stream['product_compostion'])
                                ];
                            }
                            $reactor_details[] = [
                                "reactor_id" => $key,
                                "reactor_details" => $streams[$key]
                            ];
                        }
                    }
                }
                if ($flag != 1) {
                    $data['mass_balance'] = getMassBalanceofPD($process_simulation_id, $simulation_stage_id);
                }
                $data['reaction_detail'] = $reactor_details;
            }
            return $data;
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_energy_basic_io($energy_basic_io)
{
    try {
        $ps_energy_basic_io = [];
        if (!empty($energy_basic_io)) {
            foreach ($energy_basic_io as $io) {
                $ps_energy_basic_io[] = [
                    "energy_id" => $io['energy'],
                    "io_type" => $io['io'],
                    "flow_type_id" => $io['flow_type'],
                    "unit_id" => get_flowrate_unit($io['energy']),
                    "unit_constant" => $io['unit_type'],
                    "flow_rate" => $io['energy_flow']
                ];
            }
        }
        return $ps_energy_basic_io;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_energy_basic_io_old($process_simulation_id, $simulation_stage_id)
{
    try {
        $process_simulation_profile = ProcessProfile::where('process_id', $process_simulation_id)->where('simulation_type', $simulation_stage_id)->get();
        $pc_energy_basic_input = [];
        $pc_energy_basic_output = [];
        if (!empty($process_simulation_profile)) {
            foreach ($process_simulation_profile as $ps_profile) {
                if (!empty($ps_profile->energy_basic_io)) {
                    if (!empty($ps_profile->energy_basic_io['input'])) {
                        foreach ($ps_profile->energy_basic_io['input'] as $key => $energy_basic_input) {
                            $pc_energy_basic_input[] = [
                                "energy_id" => json_decode($energy_basic_input['product_input'], true),
                                "flow_type_id" => json_decode($energy_basic_input['flowtype'], true),
                                "unit_id" => 10,
                                "unit_constant" => json_decode($energy_basic_input['unit'], true),
                                "flow_rate" => (isset($energy_basic_input['input_flow_rate'])) ? json_decode($energy_basic_input['input_flow_rate'], true) : '0'
                            ];
                        }
                    } else {
                        $pc_energy_basic_input = [];
                    }
                    if (!empty($ps_profile->energy_basic_io['output'])) {
                        foreach ($ps_profile->energy_basic_io['output'] as $key => $energy_basic_output) {
                            $pc_energy_basic_output[] = [
                                "energy_id" => json_decode($energy_basic_output['product_output'], true),
                                "flow_type_id" =>  json_decode($energy_basic_output['flowtype'], true),
                                "unit_id" => 10,
                                "unit_constant" =>  json_decode($energy_basic_output['unit'], true),
                                "flow_rate" => (isset($energy_basic_output['output_flow_rate'])) ?  json_decode($energy_basic_output['output_flow_rate'], true) : '0'
                            ];
                        }
                    } else {
                        $pc_energy_basic_output = [];
                    }
                }
            }
            $ps_energy_basic_io = [
                "energy_balance_input" => $pc_energy_basic_input,
                "energy_balance_output" => $pc_energy_basic_output
            ];
            return $ps_energy_basic_io;
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_energy_process_level($process_simulation_id, $simulation_stage_id, $flag = 0)
{
    try {
        $process_simulation_profile = ProcessProfile::where('process_id', $process_simulation_id)->where('simulation_type', $simulation_stage_id)->get();
        $reactor_details = [];
        $streams = [];
        $data = [];
        if (!empty($process_simulation_profile)) {
            foreach ($process_simulation_profile as $ps_profile) {
                if (!empty($ps_profile->energy_process_level)) {
                    foreach ($ps_profile->energy_process_level as $key => $reactor) {
                        if ($key != "sel") {
                            foreach ($reactor['input'] as $sk => $stream) {
                                $streams[$key][$sk] = [
                                    "utility_id" => json_decode($stream['energy'], true),
                                    "flow_type_id" => json_decode($stream['flowtype'], true),
                                    "total_mass_flow_rate" => json_decode($stream['energy_value'], true),
                                    "unit_id" => $stream['unit'],
                                    "unit_constant_id" => json_decode($stream['unit_constant_id'], true),
                                    "utility_type" => $stream['utility_type']
                                ];
                            }
                            $reactor_details[] = [
                                "source_id" => json_encode($key),
                                "source_details" => $streams[$key]
                            ];
                        }
                    }
                }
                if ($flag != 1) {
                    $data['mass_balance'] = getMassBalanceofEnergyLevel($process_simulation_id, $simulation_stage_id, $flag = 0);
                }
                $data['source_details'] = $reactor_details;
            }
            return $data;
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_energy_detailed_level($process_simulation_id, $simulation_stage_id, $flag = 0)
{
    try {
        $process_simulation_profile = ProcessProfile::where('process_id', $process_simulation_id)->where('simulation_type', $simulation_stage_id)->get();
        $reactor_details = [];
        $streams = [];
        if (!empty($process_simulation_profile)) {
            foreach ($process_simulation_profile as $ps_profile) {
                if (!empty($ps_profile->energy_detailed_level)) {
                    foreach ($ps_profile->energy_detailed_level as $key => $reactor) {
                        if ($key != "sel") {
                            foreach ($reactor['input'] as $sk => $stream) {
                                $streams[$key][$sk] = [
                                    "utility_id" => json_decode($stream['energy'], true),
                                    "flow_type_id" => json_decode($stream['flowtype'], true),
                                    "total_mass_flow_rate" => json_decode($stream['energy_value'], true),
                                    "unit_id" => $stream['unit'],
                                    "unit_constant_id" => json_decode($stream['unit_constant_id'], true),
                                    "utility_type" => $stream['utility_type']
                                ];
                            }
                            $reactor_details[] = [
                                "source_id" => json_encode($key),
                                "source_details" => $streams[$key]
                            ];
                        }
                    }
                }
                if ($flag != 1) {
                    $data['mass_balance'] = getMassBalanceofEnergyDetailed($process_simulation_id, $simulation_stage_id);
                }
                $data['source_details'] = $reactor_details;
            }
            return $data;
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_equipment_capital_cost($dataset_id)
{
    try {
        $process_simulation_profile = ProcessProfile::where('id', $dataset_id)->get();
        $equipment_capital_cost_info = [];
        if (!empty($process_simulation_profile)) {
            foreach ($process_simulation_profile as $ps_profile) {
                if (!empty($ps_profile->equipment_capital_cost)) {
                    foreach ($ps_profile->equipment_capital_cost as $key => $equipment_capital_cost) {
                        foreach ($equipment_capital_cost as $ec) {
                            $equipment_capital_cost_info[] = [
                                "process_plant_size" => [
                                    "value" => $ec['process_plant_size'],
                                    "unit_id" => $ec['pps_unit_type'],
                                    "unit_constant_id" => $ec['pps_unit'],
                                    "flow_type_info" => ["flow_type_id" => $ec['flowtype_id'], "product_id" => $ec['pps_refrence_id']]
                                ],
                                "capex_info" => ["capex_estimate" => $ec['capex_estimate'], "unit_id" => $ec['capex_price_unit_type'], "unit_constant_id" => $ec['capex_price_unit']],
                                "is_recommended" => $ec['is_default']
                            ];
                        }
                    }
                }
            }
            return $equipment_capital_cost_info;
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function getChemicalHelper($id)
{
    $data = ProcessSimulation::select(['product'])->find($id);
    $pr_id = $data['product'];
    $id_col = array_column($pr_id, 'product');
    $nearr = [];
    foreach ($id_col as $val) {
        $exp = explode('ch_', $val);
        array_push($nearr, $exp[1]);
    }
    $selectProdct = Chemical::select(['id', 'chemical_name'])->find($nearr);
    return $selectProdct->toArray();
}

function getEnergyHelper($id)
{
    $data = ProcessSimulation::select(['energy'])->find($id);
    $pr_id = $data['energy'];
    $id_col = array_column($pr_id, 'energy');
    $nearr = [];
    foreach ($id_col as $val) {
        $exp = explode('en_', $val);
        array_push($nearr, $exp[1]);
    }
    $selectProdct = EnergyUtility::select(['id', 'energy_name'])->find($nearr);
    return $selectProdct->toArray();
}

function getprocessname($id)
{
    $data = ProcessSimulation::select(['process_name'])->find($id);

    return $data['process_name'];
}

function get_ps_profile_stage_info($dataset_id){
    $process_simulation_profile = ProcessProfile::where('id', $dataset_id)->first();
    $process_simulation_info = [];
    $ps_profile_details = [];
    $data_sources = get_simulation_stage($process_simulation_profile->simulation_type);
    $mass_data_source = [];
    $energy_data_source = [];
    if (!empty($process_simulation_profile['data_source']['mass_balance'])) {
        if ($process_simulation_profile['data_source']['mass_balance'] == 'Basic User Input') {
            $mass_basic_io = get_mass_basic_io($process_simulation_profile['mass_basic_io']);
            $reaction_detail = [];
        }
        $mass_data_source = [
            "data_source_id" => $process_simulation_profile['data_source']['mass_balance'],
            "overall_mass_balance" => !empty($mass_basic_io) ? $mass_basic_io : [],
            "reaction_detail" => $reaction_detail
        ];
    }

    $energy_data_source = [];
    if (!empty($process_simulation_profile['data_source']['energy_utilities'])) {
        if ($process_simulation_profile['data_source']['energy_utilities'] == 'Basic User Input') {
            $energy_utility_io = get_energy_basic_io($process_simulation_profile['energy_basic_io']);
            $reaction_detail = [];
        }
        $energy_data_source = [
            "data_source_id" => $process_simulation_profile['data_source']['energy_utilities'],
            "overall_mass_balance" => !empty($energy_utility_io) ? $energy_utility_io : [],
            "reaction_detail" => $reaction_detail
        ];
    }
    if (!empty($process_simulation_profile)) {
        $ps_profile_details = [
            "id" => $process_simulation_profile->id,
            "simulation_type_id" => $process_simulation_profile->SimulationType->id,
            "simulation_type_name" => $process_simulation_profile->SimulationType->simulation_name,
            "dataset_name" => $process_simulation_profile->dataset_name,
            "data_source" => $process_simulation_profile->data_source,
            "mass_data_source_info" => $mass_data_source,
            "energy_data_source_info" => $energy_data_source,
            "equipment_capital_cost" => get_equipment_capital_cost($dataset_id),
            "key_process_info" => $process_simulation_profile->key_process_info,
            "quality_assesment" => $process_simulation_profile->quality_assesment
        ];
        $process_simulation_info = [
            "id" => $process_simulation_profile->process_id,
            "name" => $process_simulation_profile->processSimulation->process_name,
            "dataset" => $ps_profile_details
        ];
    }
    return $process_simulation_info;
}

function getUnit($id)
{
    $masterUnit = MasterUnit::find($id);
    $masflowconstanArr = $masterUnit['unit_constant'];
    $massUnit = [];
    foreach ($masflowconstanArr as $key => $unitVal) {
        $massUnit[$unitVal['id']] = $unitVal['unit_symbol'];
    }
    return $massUnit;
}

function getdefaultUnit($id)
{
    $masterUnit = MasterUnit::find($id);
    $default_unit = !empty($masterUnit['default_unit'])?$masterUnit['default_unit']:0;
    return $default_unit;
}

function getUnitEncrypt($id)
{
    $masterUnit = MasterUnit::find($id);
    $masflowconstanArr = $masterUnit['unit_constant'];
    $massUnit = [];
    foreach ($masflowconstanArr as $key => $unitVal) {
        $massUnit[___encrypt($unitVal['id'])] = $unitVal['unit_name'];
    }
    return $massUnit;
}

function getUnitname($id)
{
    $masterUnit = MasterUnit::find($id);
    $massUnit = [];
    if (!empty($masterUnit))
        $massUnit[___encrypt($masterUnit['id'])] = $masterUnit['unit_name'];
    return $massUnit;
}

function getUnitEnergybalance()
{
    $masterUnit = MasterUnit::find(10);
    $masflowconstanArr = $masterUnit['unit_constant'];
    $massUnit = [];
    foreach ($masflowconstanArr as $key => $unitVal) {
        $massUnit['flow_' . $unitVal['id']] = $unitVal['unit_symbol'];
    }
    $masterVolumeUnit = MasterUnit::find(4);
    $VolumeconstanArr = $masterVolumeUnit['unit_constant'];
    $volUnit = [];
    foreach ($VolumeconstanArr as $key => $unitVal) {
        $volUnit['vol_' . $unitVal['id']] = $unitVal['unit_symbol'];
    }
    $masterPowerUnit = MasterUnit::find(36);
    $powerconstanArr = $masterPowerUnit['unit_constant'];
    $powerUnit = [];
    foreach ($powerconstanArr as $key => $unitVal) {
        $powerUnit['pow_' . $unitVal['id']] = $unitVal['unit_symbol'];
    }
    $dataMerge = array_merge($massUnit, $volUnit, $powerUnit);
    return $dataMerge;
}

//ProcessDiagram


function createProductExp($request)
{
    $prdIds = $request['new_product']['prd_ids'];
    $prdNames = $request['new_product']['prd_name'];
    $str_ids = $request['new_product']['str_ids'];
    $data_source = $request['new_product']['data_source'];
    $checkIds = $request['new_product']['chk_ids'];
    $new_prd_ids = $request['new_product']['new_prd_ids'];
    $processid = $request['new_product']['process_id'];
    $saveArr = [];
    if (!empty($str_ids)) {
        foreach ($str_ids as $sk => $newstrid) {
            $newstridarr[$sk] = ($newstrid - 1);
        }
    }
    if (!empty($newstridarr)) {
        foreach ($newstridarr as $ck => $cv) {
            if ($checkIds[$ck] != 0 && $new_prd_ids[$ck] == 0) {
                $chemname = getsingleChemicaldetail($prdIds[$ck]);
                if ($prdNames[$ck] != "") {
                    $saveArr[$cv]['chemical_name'] = $prdNames[$ck];
                } else {
                    $saveArr[$cv]['chemical_name'] = $chemname['chemical_name'] . "PID" . $prdIds[$ck];
                }
                $saveArr[$cv]['chem_id'] = $prdIds[$ck];
                $saveArr[$cv]['process_id'] = $processid;
                $saveArr[$cv]['stream_id'] = $str_ids[$ck];
                $saveArr[$cv]['category_id'] = $chemname['category_id'];
                $saveArr[$cv]['classification_id'] = 3;
                $saveArr[$cv]['updated_by'] = Auth::user()->id;
                $saveArr[$cv]['created_by'] = Auth::user()->id;
                $saveArr[$cv]['data_source'] = $data_source;
            } else {
                //update code here
            }
        }
    }
    $id = [];
    if (!empty($saveArr)) {
        foreach ($saveArr as $key => $value) {
            $id[$key] = Chemical::insertGetId(
                [
                    'chemical_name' => $value['chemical_name'], 'product_type_id' => 1, 'category_id' => $value['category_id'], 'classification_id' => $value['classification_id'],
                    'updated_by' => $value['updated_by'], 'created_by' => $value['created_by']
                ]
            );
        }
    }
}

function updateProp($new_prd_ids, $dynamic_prop_json_update, $prop_json_update)
{
    $create_property = [];
    if (!empty($new_prd_ids)) {
        foreach ($new_prd_ids as $key => $val) {
            if ($val != 0) {
                if (!empty($dynamic_prop_json_update)) {
                    foreach ($dynamic_prop_json_update as $dkey => $dval) {
                        if ($dkey == $key) {
                            foreach ($dval as $dkd => $dd) {
                                $newdd = array($dd);
                                $create_property[] = [
                                    "dynamic_prop_json" => $newdd, "product_id" => $val, "prop_json" => $prop_json_update[$key],
                                    "property_id" => 2, "sub_property_id" => 3, "order_by" => 1, "created_by" => Auth::user()->id, "updated_by" => Auth::user()->id
                                ];
                            }
                        }
                    }
                }
            }
        }
    }
    return $create_property;
}

function getpropData()
{
    $propData = [];
    $cnt = 2;
    for ($i = 0; $i < 2; $i++) {
        $propData[$i]['id'] = $i;
        if ($i == 0) {
            $propData[$i]['value'] = "";
            $propData[$i]['field_type_id'] = "8";
        } else {
            $propData[$i]['value'] = "";
            $propData[$i]['field_type_id'] = "9";
        }
    }
    return $propData;
}

function updateSimulation($arr, $id)
{
    $simulationData = ProcessSimulation::find($id);
    $simulationData->product = $arr;
    $simulationData->updated_by = Auth::user()->id;
    $simulationData->updated_at = now();
    $flg = $simulationData->save();
    return $flg;
}


function getsinglemassflowrate($id)
{
    $masterUnit = MasterUnit::select('unit_constant')->where('id', 10)->first();
    $masflowconstanArr = $masterUnit['unit_constant'];
    $unit = $masflowconstanArr[($id - 1)]['unit_symbol'];
    return $unit;
}

function get_simulation_stage($stage_id)
{
    $simulation_stage = SimulationType::find($stage_id);
    $simulation_stages = [
        "id" => $simulation_stage->id,
        "simulation_name" => $simulation_stage->simulation_name,
        "mass_balance" => $simulation_stage->mass_balance,
        "enery_utilities" => $simulation_stage->enery_utilities
        // "enery_utilities" => json_decode($simulation_stage->enery_utilities, true)
    ];
    return $simulation_stages;
}

function getsingleEnergyName($energy_id)
{
    try {
        $data = EnergyUtility::select('energy_name')->where('id', $energy_id)->first();
        return $data['energy_name'];
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_energy_details($energy_id)
{
    $energy_utility = EnergyUtility::select('id', 'energy_name', 'base_unit_type', 'vendor_id', 'status')->where('id', $energy_id)->with('unit_type', 'vendor')->get()->first();
    $energy_utility_info = [
        "id" => $energy_utility->id,
        "name" => $energy_utility->energy_name,
        "base_unit_type" => [
            "id" => $energy_utility->unit_type->id,
            "unit_name" => $energy_utility->unit_type->unit_name,
            "unit_constant" => $energy_utility->unit_type->unit_constant
        ],
        "vendor_info" => [
            "id" => !empty($energy_utility->vendor->id) ? $energy_utility->vendor->id : 0,
            "vendor_name" => !empty($energy_utility->vendor->name) ? $energy_utility->vendor->name : ''
        ],
        "status" => $energy_utility->status,
    ];
    return $energy_utility_info;
}

function get_flowrate_unit($unit_id)
{
    $energy_details = get_energy_details($unit_id);
    switch ($energy_details['base_unit_type']['id']) {
        case "7":
            $master_unit_id = 10;
            break;
        case "2":
            $master_unit_id = 4;
            break;
        case "6":
            $master_unit_id = 36;
            break;
        case "326":
            $master_unit_id = 326;
            break;
        default:
            $master_unit_id = 0;
    }
    //$unit_name = get_unit_constant($master_unit_id,$unit_constant_id);
    return $master_unit_id;
}

function get_energy_details_arr($energy_id)
{
    $energy_utilitys = EnergyUtility::select('id', 'energy_name', 'base_unit_type', 'vendor_id', 'status')->whereIn('id', $energy_id)->with('unit_type', 'vendor')->get();
    $energy_utility_info = [];
    if (!empty($energy_utilitys)) {
        foreach ($energy_utilitys as $k => $energy_utility) {
            $energy_utility_info[] = [
                "id" => $energy_utility->id,
                "name" => $energy_utility->energy_name,
                "base_unit_type" => [
                    "id" => $energy_utility->unit_type->id,
                    "unit_name" => $energy_utility->unit_type->unit_name,
                    "unit_constant" => $energy_utility->unit_type->unit_constant
                ],
                "vendor_info" => [
                    "id" => !empty($energy_utility->vendor->id) ? $energy_utility->vendor->id : 1,
                    "vendor_name" => !empty($energy_utility->vendor->name) ? $energy_utility->vendor->name : ''
                ],
                "status" => $energy_utility->status,
            ];
        }
    }
    return $energy_utility_info;
}

function experiment_classification($exp_classification_id)
{
    if (is_array($exp_classification_id)) {
        $classifications = ExperimentClassification::Select('id', 'name')->whereIn('id', $exp_classification_id)->get();
        return $classifications;
    } else {
        $classification = ExperimentClassification::find($exp_classification_id);
        $classification_info = [
            "id" => $classification->id,
            "name" => $classification->name
        ];
        return $classification_info;
    }
}


function required_parameter($str = "")
{
    $data = [
        'success' => true,
        'status_code' => 400,
        'status' => true,
        'data' => "The request is missing a required parameter = " . $str
    ];
    return $data;
}

function array_replace_key($search, $replace, array $subject)
{
    $updatedArray = [];
    foreach ($subject as $key => $value) {
        if (!is_array($value) && $key == $search) {
            $updatedArray = array_merge($updatedArray, [$replace => $value]);
            continue;
        }
        $updatedArray = array_merge($updatedArray, [$key => $value]);
    }
    return $updatedArray;
}


function uploadFileAws($request, $file_name, $folder_name)
{
    $file = $request->file($file_name);
    $imageName = 'uploads/' . $folder_name . '/' . time() . $file->getClientOriginalName();
    Storage::disk('s3')->put($imageName, file_get_contents($file));
    Storage::disk('s3')->setVisibility($imageName, 'public');
    $url = Storage::disk('s3')->url($imageName);
    return $url;
}

function upload_file($request, $file_name, $folder_name, $sub_folder = null)
{
    $file       = $request->file($file_name);
    $extension  = $file->getClientOriginalExtension();
    $file_name  = $file->getClientOriginalName();
    $backupLoc =  'assets/uploads/' . $folder_name;
    if ($sub_folder != null) {
        if (!is_dir($backupLoc . '/' . $sub_folder)) {
            mkdir($backupLoc . '/' . $sub_folder, 0755, true);
        }
        $backupLoc = $backupLoc . '/' . $sub_folder;
    }
    if (!is_dir($backupLoc)) {
        mkdir($backupLoc, 0755, true);
    }
    $file->move($backupLoc, $file_name);
    return ($backupLoc . '/' . $file_name);
}

function getcatalyst_tab($data)
{
    $obj = [];
    $obj['catalyst_name'] = $data['catalyst_name'];
    $obj['whsv_name'] = $data['whsv_name'];
    $obj['whsv_unit'] = ___decrypt($data['whsv_unit']);
    $obj['lhsv_name'] = $data['lhsv_name'];
    $obj['lhsv_unit'] = ___decrypt($data['lhsv_unit']);
    $obj['catalyst_composition'] = $data['catalyst_composition'];
    $obj['stream_time'] = $data['stream_time'];
    $obj['stream_time_unit'] = ___decrypt($data['stream_time_unit']);
    $obj['regenration_tech'] = $data['regenration_tech'];
    $obj['regenration_time'] = $data['regenration_time'];
    $obj['lifetime'] = $data['lifetime'];
    $obj['lifetime_unit'] = ___decrypt($data['lifetime_unit']);
    $obj['regenration_time_unit'] = ___decrypt($data['regenration_time_unit']);
    return $obj;
}

function get_opr_condition_tab($data)
{
    $obj = [];
    $obj['stage_type'] = $data['stage_type'];
    $obj['reactiontempInput'] = $data['reactiontempInput'];
    $obj['reactiotemp'] = ___decrypt($data['reactiotemp']);
    $obj['heatreactioninput'] = $data['heatreactioninput'];
    $obj['heatreactionsel'] = ___decrypt($data['heatreactionsel']);
    $obj['reaction_type'] = $data['reaction_type'];
    $obj['reactPressureinput'] = $data['reactPressureinput'];
    $obj['reactPressureoption'] = ___decrypt($data['reactPressureoption']);
    $obj['reacttimeInput'] = $data['reacttimeInput'];
    $obj['reacttimeoption'] = ___decrypt($data['reacttimeoption']);
    $obj['feedbackReq'] = $data['feedbackReq'];
    $obj['main_product_concentration'] = $data['main_product_concentration'];
    $obj['main_product_concentration_unit'] = ___decrypt($data['main_product_concentration_unit']);
    $obj['type_of_metabolite'] = $data['type_of_metabolite'];
    $obj['presence_of_solids'] = $data['presence_of_solids'];
    $obj['need_for_distillation'] = $data['need_for_distillation'];
    $obj['complx_separation_alter_need'] = $data['complx_separation_alter_need'];
    return $obj;
}

function makeSlug($string)
{
    return str_replace(' ', '-', $string);
}

function _arefy($data)
{
    return json_decode(json_encode($data), true);
}

function ___encrypt($record_id)
{
    $hashids = new Hashids('', 10);
    $id = $hashids->encode($record_id);
    return $id;
}

function ___decrypt($encrypted_id)
{    $hashids = new Hashids('', 10);
    $numbers = $hashids->decode($encrypted_id);
    if(!empty($numbers[0])){
        return $numbers[0];
    }elseif(is_numeric($numbers)){
        return $numbers;
    }
}


function active_class($path, $active = 'active')
{
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function is_active_route($path)
{
    return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

function show_class($path)
{
    return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}

function dateFormate($date)
{
    $created_at = !empty(Auth::user()->settings['date_format']) ? Auth::user()->settings['date_format'] : '';
    if ($created_at == 'yyyy-mm-dd') {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    } elseif ($created_at == 'mm-dd-yyyy') {
        return \Carbon\Carbon::parse($date)->format('m-d-Y');
    } else {
        return \Carbon\Carbon::parse($date)->format('d-m-Y');
    }
}

function dateTimeFormate($date)
{
    $created_at = !empty(Auth::user()->settings['date_format']) ? Auth::user()->settings['date_format'] : '';
    if ($created_at == 'yyyy-mm-dd') {
        return \Carbon\Carbon::parse($date)->format('Y-m-d h:i:s');
    } elseif ($created_at == 'mm-dd-yyyy') {
        return \Carbon\Carbon::parse($date)->format('m-d-Y h:i:s');
    } else {
        return \Carbon\Carbon::parse($date)->format('d-m-Y h:i:s');
    }
}

function ___ago($date_time)
{
    return Carbon\Carbon::parse($date_time)->diffForHumans();
}

function redirect_notification($module_id)
{
    return url($module_id);
}


function get_unit_type($unit_id, $unit_constant_id)
{
    try {
        $unit_type = MasterUnit::find($unit_id);
        $unit_type_info = [];
        if (!empty($unit_type)) {
            foreach ($unit_type->unit_constant as $unit_constant) {
                if ($unit_constant_id == $unit_constant['id']) {
                    $unit_type_info = [
                        "id" => $unit_type->id,
                        "unit_name" => $unit_type->unit_name,
                        "unit_constant" => [
                            "id" => $unit_constant['id'],
                            "unit_name" => $unit_constant['unit_name'],
                            "unit_symbol" => $unit_constant['unit_symbol']
                        ]
                    ];
                }
            }
        }
        return $unit_type_info;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}




function get_mass_detail($request, $type)
{
    try {
        $processId = $request->process_simulation_id;
        $simulation_stage_id = $request->simulation_stage_id;
        if ((isset($request->data_source_type) && !empty($request->data_source_type))) {
            $data_source_type = $request->data_source_type;
            if ((isset($request->data_source_id) && !empty($request->data_source_id))) {
                $data_source_id = $request->data_source_id;
                if ($data_source_type == 1) {
                    $data = getMassBalanceDetail($processId, $simulation_stage_id, $data_source_type, $data_source_id, $type);
                } elseif ($data_source_type == 2) {
                    $data = getEnergyBalanceDetail($processId, $simulation_stage_id, $data_source_type, $data_source_id, $type);
                }
            } else {
                if ($data_source_type == 1) {
                    $data = getMassBalanceDetail($processId, $simulation_stage_id, $data_source_type, 0, $type);
                }
                if ($data_source_type == 2) {
                    $data = getEnergyBalanceDetail($processId, $simulation_stage_id, $data_source_type, 0, $type);
                }
            }
        } else {
            $data = [];
        }
        return $data;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function get_process_type($request)
{
    $data = ProcessSimulation::select(['process_type'])->find($request->process_simulation_id);
    $ps_details = ["process_type" => [
        "id" => $data->processType->id,
        "name" => $data->processType->name
    ]];
    return $ps_details;
}



function exnergy_property_list($product_id)
{
    $sub_prop_master = EnergySubPropertyMaster::select('id', 'property_id', 'sub_property_name', 'fields')->where(['status' => 'active', 'property_id' => $prop_type->id])->get();
    if (!empty($sub_prop_master)) {
        foreach ($sub_prop_master as $sub_prop) {
            EnergyUtilityProperty::where(['energy_id' => $energy_id, 'sub_property_id' => $sub_prop->id, 'status' => 'active'])->get();
        }
    }
}

function get_list_name($cas_no = [], $molecular_formula = '', $inchi_key = '', $ec_number = '', $other_name = [])
{
    $list_name = [];
    $list_id = [];
    $cas_arr = ["-"];

    if (!empty($cas_no)) {
        if (is_array($cas_no) && $cas_no != $cas_arr) {
            for ($i = 0; $i < count($cas_no); $i++) {
                if ($cas_no[$i] != "") {
                    $lists = ListProduct::Select('id', 'cas', 'list_id')->whereJsonContains('cas', $cas_no[$i])->get();
                    foreach ($lists as $list) {
                        $list_id[] = $list->list_id;
                    }
                }
            }
        } else {
            if ($cas_no != $cas_arr) {
                $lists = ListProduct::Select('id', 'cas', 'list_id')->whereJsonContains('cas', $cas_no)->get();
                foreach ($lists as $list) {
                    $list_id[] = $list->list_id;
                }
            }
        }
        if (!empty($list_id)) {
            $list_name[] = RegulatoryList::Select('id', 'list_name', 'hover_msg')->where('tenant_id', session()->get('tenant_id'))->whereIn('id', $list_id)->whereJsonContains('field_of_display', 'cas_no')->get();
        }
    }
    if (!empty($molecular_formula)) {
        $lists = ListProduct::Select('id', 'molecular_formula', 'list_id')->where('molecular_formula', $molecular_formula)->get();
        $list_id = [];
        foreach ($lists as $list) {
            $list_id[] = $list->list_id;
        }
        if (!empty($list_id)) {
            $list_name[] = RegulatoryList::Select('id', 'list_name', 'hover_msg')->whereIn('id', $list_id)->whereJsonContains('field_of_display', 'molecular_formula')->get();
        }
    }
    if (!empty($inchi_key)) {
        $lists = ListProduct::Select('id', 'inchi_key', 'list_id')->where('inchi_key', $inchi_key)->get();
        $list_id = [];
        foreach ($lists as $list) {
            $list_id[] = $list->list_id;
        }
        if (!empty($list_id)) {
            $list_name[] = RegulatoryList::Select('id', 'list_name', 'hover_msg')->whereIn('id', $list_id)->whereJsonContains('field_of_display', 'inchi_key')->get();
        }
    }
    if (!empty($ec_number)) {
        $lists = ListProduct::Select('id', 'ec_number', 'list_id')->where('ec_number', $ec_number)->get();
        $list_id = [];
        foreach ($lists as $list) {
            $list_id[] = $list->list_id;
        }
        if (!empty($list_id)) {
            $list_name[] = RegulatoryList::Select('id', 'list_name', 'hover_msg')->whereIn('id', $list_id)->whereJsonContains('field_of_display', 'ec_number')->get();
        }
    }
    if (!empty($other_name)) {
        if (is_array($other_name) && $other_name != $cas_arr) {
            for ($i = 0; $i < count($other_name); $i++) {
                $lists = ListProduct::Select('id', 'other_name', 'list_id')->where('other_name', $other_name[$i])->get();
                foreach ($lists as $list) {
                    $list_id[] = $list->list_id;
                }
            }
        } else {
            $lists = ListProduct::Select('id', 'other_name', 'list_id')->where('other_name', $other_name)->get();
            foreach ($lists as $list) {
                $list_id[] = $list->list_id;
            }
        }
        if (!empty($list_id)) {
            $list_name[] = RegulatoryList::Select('id', 'list_name', 'hover_msg')->where('tenant_id', session()->get('tenant_id'))->whereIn('id', $list_id)->whereJsonContains('field_of_display', 'cas_no')->get();
        }
    }
    return $list_name;
}

function get_pictogram_path($pictogram_id)
{
    if (!empty($pictogram_id)) {
        $pictogram = HazardPictogram::where('id', $pictogram_id)->first();
        $pictogram_path = $pictogram->hazard_pictogram;
        return $pictogram_path;
    }
}

function get_dynamic_list($units_id, $property_id = '', $unit_constant_id = '', $value = '')
{
    $select_list = [];
    if (!empty($units_id)) {
        $select_list['default_unit'] = '';
        if ($units_id == 'chemical_list') {
            $unit_list = Chemical::Select('id', 'chemical_name')->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->chemical_name) ? $units->chemical_name : '';
            }
        } elseif ($units_id == 'p_codes' || $property_id == 5 && $units_id == 177) {
            $unit_list = CodeStatement::where('type', 3)->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->code) ? $units->code : '' . ' ' . $title;
            }
        } elseif ($units_id == 'r_codes' || $property_id == 5 && $units_id == 180) {
            $unit_list = CodeStatement::where('type', 5)->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->code) ? $units->code : '' . ' ' . $title;
            }
        } elseif ($units_id == 'h_codes' || $property_id == 5 && $units_id == 166) {
            $unit_list = Hazard::get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->hazard_code) ? $units->hazard_code : '' . ' ' . $title;
            }
        } elseif ($units_id == 'EU-Classification' || $property_id == 5 && $units_id == 163) {
            $unit_list = CodeStatement::where('type', 1)->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->code) ? $units->code : '' . ' ' . $title;
            }
        } elseif ($units_id == 'NFPA flammability' || $property_id == 5 && $units_id == 173) {
            $unit_list = CodeStatement::where('type', 9)->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->code) ? $units->code : 0 . ' ' . $title;
            }
        } elseif ($units_id == 'NFPA health' || $property_id == 5 && $units_id == 174) {
            $unit_list = CodeStatement::where('type', 10)->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->code) ? $units->code : 0 . ' ' . $title;
            }
        } elseif ($units_id == 'NFPA reactivity' || $property_id == 5 && $units_id == 175) {
            $unit_list = CodeStatement::where('type', 6)->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->code) ? $units->code : 0 . ' ' . $title;
            }
        } elseif ($units_id == 'WGK substance Class' || $property_id == 5 && $units_id == 182) {
            $unit_list = CodeStatement::where('type', 7)->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->code) ? $units->code : 0 . ' ' . $title;
            }
        } elseif ($units_id == 'Gk-code' || $property_id == 5 && $units_id == 165) {
            $unit_list = CodeStatement::where('type', 8)->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->code) ? $units->code : 0 . ' ' . $title;
            }
        } elseif ($units_id == 'GHS-code' || $property_id == 5 && $units_id == 198) {
            $unit_list = CodeStatement::where('type', 11)->get();
            foreach ($unit_list as $keyss => $units) {
                $select_list['units'][$keyss]['id'] = !empty($units->id) ? $units->id : '';
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units->code) ? $units->code : '' . ' ' . $title;
            }
        } else {
            $unit_list = MasterUnit::Select('id', 'unit_name', 'unit_constant', 'default_unit')->where('id', $units_id)->first();
            $select_list['id'] = $unit_list->id;
            $select_list['name'] = $unit_list->unit_name;
            $select_list['unit_constant_id'] = $unit_constant_id;
            $select_list['value'] = $value;
            $select_list['default_unit'] = !empty($unit_list->default_unit) ? $unit_list->default_unit : '';
            foreach ($unit_list->unit_constant as $keyss => $units) {
                $title = !empty($units->title) ? $units->title : '';
                $select_list['units'][$keyss]['id'] = !empty($units['id']) ? $units['id'] : '';
                $select_list['units'][$keyss]['unit_name'] = !empty($units['unit_name']) ? $units['unit_name'] : '';
            }
        }
    }
    return $select_list;
}

function get_unit_constant($unit_id, $unit_constant_id)
{
    $master_unit = MasterUnit::where('id', $unit_id)->first();
    $unit_name = '';
    if (!empty($master_unit)) {
        foreach ($master_unit['unit_constant'] as $const) {
            if ($unit_constant_id == $const['id']) {
                $unit_name = $const['unit_name'];
            }
        }
    }
    return $unit_name;
}

function get_units_value($unit_id, $unit_constant_id)
{
    try {
        $unit_type = MasterUnit::find($unit_id);
        $unit_type_info = [];
        if (!empty($unit_type)) {
            foreach ($unit_type->unit_constant as $unit_constant) {
                if ($unit_constant_id == $unit_constant['id']) {
                    $unit_type_info = [
                        "unit_name" => $unit_type->unit_name,
                        "unit_constant" => [
                            "unit_name" => $unit_constant['unit_name'],
                            "unit_symbol" => $unit_constant['unit_symbol']
                        ]
                    ];
                }
            }
        }
        return $unit_type_info;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}


function sub_menu_name($name)
{
    $new_name = str_replace('_', ' ', $name);
    return ucfirst($new_name);
}
function country_name($id)
{
    $count = Country::where('id', $id)->first();
    $new_name = $count->name;
    return ucfirst($new_name);
}
function get_model_name($id)
{
    $model = ModelDetail::where('id', $id)->first();
    return !empty($model['name']) ? $model['name'] : '';
}
function get_dataset_name($id)
{
    $model = DatasetModel::where('id', $id)->first();
    return !empty($model['name']) ? $model['name'] : '';
}

function get_quide_doc($type = 'quick_start')
{
    $tenant_id = Session::get('tenant_id');
    $doc = '';
    $docs = Tenant::find($tenant_id);
    if ($type == 'quick_start') {
        $doc = !empty($docs->guide_document['quick_start_doc']) ? $docs->guide_document['quick_start_doc'] : '';
    } elseif ($type == 'experiment') {
        $doc = !empty($docs->guide_document['experiment_doc']) ? $docs->guide_document['experiment_doc'] : '';
    } elseif ($type == 'report') {
        $doc = !empty($docs->guide_document['report_doc']) ? $docs->guide_document['report_doc'] : '';
    } elseif ($type == 'benchmark_doc') {
        $doc = !empty($docs->guide_document['benchmark_doc']) ? $docs->guide_document['benchmark_doc'] : '';
    }

    return $doc;
}

function csvToJson($fname)
{
    // open csv file
    if (!($fp = fopen($fname, 'r'))) {
        die("Can't open file...");
    }
    //read csv headers
    $key = fgetcsv($fp);
    // parse csv rows into array
    $json = array();
    while ($row = fgetcsv($fp)) {
        $json[] = array_combine($key, $row);
    }
    // release file handle
    fclose($fp);
    // encode array to json
    return json_encode($json);
}

function jsonToCSV($json, $cfilename)
{
    // if (($json = file_get_contents($jfilename)) == false)
    //     die('Error reading json file...');
    $data = json_decode($json, true);
    $fp = fopen($cfilename, 'w');
    $header = false;
    foreach ($data as $row) {
        if (empty($header)) {
            $header = array_keys($row);
            fputcsv($fp, $header);
            $header = array_flip($header);
        }
        fputcsv($fp, array_merge($header, $row));
    }
    fclose($fp);
    return;
}

function getStatus()
{
    return array(
        0=>'pending',
        1=>'success'
    );
}
