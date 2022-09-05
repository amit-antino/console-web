<?php

namespace App\Http\Controllers\Console\MFG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MFG\ProcessSimulation;
use App\Models\MFG\ProcessProfile;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;
use App\Models\Master\ProcessSimulation\SimulationFlowType;
use App\Models\OtherInput\EnergyUtility;
use App\Models\Master\MasterUnit;
use App\Models\Product\Chemical;

class ProcessProfileController extends Controller
{
    public function reactorProfileSave(Request $request)
    {
        $checkStag = [];
        for ($ch = 1; $ch <= $request->selstage; $ch++) {
            $checkStag[] = $ch;
        }
        $id = ProcessProfile::select('id')->where([['process_id', $request->process_id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        $md = [];
        if ($id == NULL) {
            $simulationData = new ProcessProfile();
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->created_by = Auth::user()->id;
        } else {
            $simulationData = ProcessProfile::find($id['id']);
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->updated_at = now();
            $sim = $simulationData->toArray();
            $md = $sim['mass_basic_pc'];
        }
        if (isset($request->opr_condition)) {
            if (!empty($md)) {
                $mdkey = array_keys($md);
                $result = array_diff($mdkey, $checkStag);
                foreach ($result as $rv) {
                    unset($md[$rv]);
                }
            }
            $opr_condition_arr = get_opr_condition_tab($request->opr_condition);
            $md[$request->reactorID]['opr'] = $opr_condition_arr;
            $val_cas = $md;
        }
        if (isset($request->catalyst_tab)) {
            if (!empty($md)) {
                $mdkey = array_keys($md);
                $result = array_diff($mdkey, $checkStag);
                foreach ($result as $rv) {
                    unset($md[$rv]);
                }
            }
            $catalyst_tab_arr = getcatalyst_tab($request->catalyst_tab);
            $md[$request->reactorID]['catalyst_tab'] = $catalyst_tab_arr;
            $val_cas = $md;
        }
        $flag = 0;
        if (isset($request->tab) && $request->tab == "input_output") {
            if (!empty($md)) {
                $mdkey = array_keys($md);
                $result = array_diff($mdkey, $checkStag);
                if (!empty($result)) {
                    $flag = 1;
                    foreach ($result as $rv) {
                        unset($md[$rv]);
                    }
                }
            }
            if (!empty($md) && array_key_exists($request->reactorID, $md)) {
                $val_cas1 = [];
                if (!empty($request->product)) {
                    foreach ($request->product as $key => $c_no) {
                        $val_cas1[$key]['id'] = json_encode($key);
                        $val_cas1[$key]['product'] =  ___decrypt($request->product[$key]);
                        $val_cas1[$key]['flowtype'] = ___decrypt($request->flowtype[$key]);
                        $val_cas1[$key]['unit_id'] = json_encode(10);
                        $val_cas1[$key]['unit_constant_id'] = ___decrypt($request->unit[$key]);
                        if (!empty($request->objassprd[$key])) {
                            $val_cas1[$key]['mass_flow_rate'] = json_encode(array_sum($request->objassprd[$key]));
                        } else {
                            $val_cas1[$key]['mass_flow_rate'] = 0;
                        }
                        foreach ($request->ass as $k => $v) {
                            if ($v != "0") {
                                $val_cas1[$key]['product_compostion'][$k . "##" . ___decrypt($v)] = $request->objassprd[$key][$k];
                            }
                        }
                    }
                }
                $md[$request->reactorID]["input"] = $val_cas1;
                $val_cas = $md;
            } else {
                $val_cas = [];
                if (!empty($request->product)) {
                    foreach ($request->product as $key => $c_no) {
                        $val_cas[$request->reactorID]["input"][$key]['id'] = json_encode($key);
                        $val_cas[$request->reactorID]["input"][$key]['product'] =  ___decrypt($request->product[$key]);
                        $val_cas[$request->reactorID]["input"][$key]['flowtype'] = ___decrypt($request->flowtype[$key]);
                        $val_cas[$request->reactorID]["input"][$key]['unit_id'] = json_encode(10);
                        $val_cas[$request->reactorID]["input"][$key]['unit_constant_id'] = ___decrypt($request->unit[$key]);
                        if (!empty($request->objassprd[$key])) {
                            $val_cas[$request->reactorID]["input"][$key]['mass_flow_rate'] = json_encode(array_sum($request->objassprd[$key]));
                        } else {
                            $val_cas[$request->reactorID]["input"][$key]['mass_flow_rate'] = 0;
                        }
                        foreach ($request->ass as $k => $v) {
                            if (isset($request->objassprd[$key][$k])) {
                                if ($v != 0) {
                                    $val_cas[$request->reactorID]["input"][$key]['product_compostion'][$k . "##" . ___decrypt($v)] = $request->objassprd[$key][$k];
                                } else {
                                    $val_cas[$request->reactorID]["input"][$key]['product_compostion'][$k . "##" . $v] = $request->objassprd[$key][$k];
                                }
                            }
                        }
                    }
                }
                if (!empty($md)) {
                    if ($flag == 0) {
                        $New_start_index = 1;
                        $val_cas = array_merge($md, $val_cas);
                        $val_cas = array_combine(
                            range($New_start_index, count($val_cas) + ($New_start_index - 1)),
                            array_values($val_cas)
                        );
                    }
                }
            }
            $setData = createProduct($request);
        }
        $simulationData->mass_basic_pc  = $val_cas;
        $process_id = $request->process_id;
        $simulation_type = ___decrypt($request->simulation_type);
        $simulationData->process_id = $request->process_id;
        if (isset($request->data_source_mass)) {
            $simulationData->data_source_mass = ___decrypt($request->data_source_mass);
        } else {
            if ($simulationData['data_source_mass'] == NULL) {
                $simulationData->data_source_mass = 0;
            } else {
                $simulationData->data_source_mass = $simulationData['data_source_mass'];
            }
        }
        if (isset($request->data_source_energy)) {
            $simulationData->data_source_energy = ___decrypt($request->data_source_energy);
        } else {
            if ($simulationData['data_source_energy'] == NULL) {
                $simulationData->data_source_energy = 0;
            } else {

                $simulationData->data_source_energy =  $simulationData['data_source_energy'];
            }
        }
        $simulationData->simulation_type = $simulation_type;
        /* code repect to create product */
        /* code end respect to create product */
        if ($simulationData->save()) {
            $simulationDataProfile = ProcessSimulation::find($process_id);
            $editId = $simulationDataProfile['sim_stage'];
            if (!empty($editId)) {
                array_push($editId, $simulation_type);
            } else {
                $editId = [$simulation_type];
            }
            $simulationDataProfile->sim_stage = array_unique($editId);;
            $simulationDataProfile->simulation_type = ___decrypt($request->simulation_type);
            $simulationDataProfile->updated_by = Auth::user()->id;
            $simulationDataProfile->updated_at = now();
            if ($simulationDataProfile->save()) {
                $success = true;
                $message = "Process Simulation Profile Successfully Updated";
                $response = [
                    'success' => $success,
                    'message' => $message
                ];
                return response()->json($response, 200);
            }
        }
    }

    public function processgetReactor(Request $request)
    {
        $reactData = ProcessProfile::select('id', 'mass_basic_pc')->where([['process_id', $request->id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        if ($reactData) {
            if ($reactData['mass_basic_pc'] != null) {
                $keyinfoArr = $reactData;
                if (!empty($keyinfoArr)) {
                    $reactArrrrDataPc = $keyinfoArr['mass_basic_pc'];
                    $data['pcArrData'] = $reactArrrrDataPc;
                } else {
                    $data['pcArrData'] = [];
                }
            }
        }
        if (!empty($data['pcArrData'])) {
            if (!empty($data['pcArrData']) && array_key_exists($request->react_id, $data['pcArrData'])) {
                $editData = $data['pcArrData'][$request->react_id];
            } else {
                $editData = [];
            }
        } else {
            $editData = [];
        }
        $renderDataPC = [];
        if (!empty($editData)) {
            if (!empty($editData['input'])) {
                foreach ($editData['input'] as $k => $v) {
                    $renderDataPC[$k]['product'] = ___encrypt($v['product']);
                    $renderDataPC[$k]['flowtype'] = ___encrypt($v['flowtype']);
                    $renderDataPC[$k]['unit'] = ___encrypt($v['unit_constant_id']);
                    if (!empty($v['product_compostion'])) {
                        $renderDataPC[$k]['pro'] = $v['product_compostion'];
                    } else {
                        $renderDataPC[$k]['pro'] = [];
                    }
                }
            }
        } else {
            $renderDataPC = [];
        }
        $renderDataPCAss = [];
        if (!empty($editData['input'])) {
            foreach ($editData['input'] as $k => $v) {
                $c = 0;
                if (!empty($v['product_compostion'])) {
                    foreach ($v['product_compostion'] as $pk => $pv) {
                        $prokey = explode('##', $pk);
                        if ($prokey[1] != 0) {
                            $sel = Chemical::select('id', 'chemical_name')->where('id', $prokey[1])->first();
                            $renderDataPCAss[$sel['id'] . "#" . $sel['chemical_name'] . "#@" . $c][] = $pv;
                        } else {
                            $renderDataPCAss[0 . "#select#@" . $c][] = 0;
                        }
                        $c++;
                    }
                }
            }
        }
        $data['setValue'] = $renderDataPC;
        $data['assoPro'] = $renderDataPCAss;
        if (!empty($editData['opr'])) {
            $data['opr'] = $editData['opr'];
        } else {
            $data['opr'] = [];
        }
        if (!empty($editData['catalyst_tab'])) {
            $data['catalyst_tab'] = $editData['catalyst_tab'];
        } else {
            $data['catalyst_tab'] = [];
        }
        $data['react_id'] = $request->react_id;
        $chemPro = getChemicalHelper($request->id);
        $buiFlowTypeInput = [];
        $buiFlowTypeOutput = [];
        $buiFlowTypeOther = [];
        $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
        $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
        $buiFlowTypeOther = SimulationFlowType::where('type', 3)->get();
        $fb = [];
        $pb = [];
        $bb = array_merge($buiFlowTypeInput->toArray(), $buiFlowTypeOutput->toArray(), $buiFlowTypeOther->toArray());
        foreach ($bb as $bk => $bv) {
            $fb[___encrypt($bv['id'])] = $bv['flow_type_name'];
        }
        $data['buiFlowtype'] = $fb;
        foreach ($chemPro as $pk => $pv) {
            $pb[___encrypt($pv['id'])] = $pv['chemical_name'];
        }
        $data['chemPro'] = $pb;
        $chemData = Chemical::select('id', 'chemical_name')->get();
        $data['chemData'] = $chemData->toArray();
        $masterUnit = getUnit(10);
        $pu = [];
        foreach ($masterUnit as $uk => $uv) {
            $pu[___encrypt($uk)] = $uv;
        }
        $getdefaultUnit = getdefaultUnit(10);
        $data['default_unit'] = $getdefaultUnit;
        $data['pcmassUnit'] = $pu;
        $masterUnitTemp = getUnit(12);
        $data['masterUnitTemp'] = $masterUnitTemp;
        $masterUnitTempdefault = getdefaultUnit(12);
        $data['masterUnitTempdefault'] = $masterUnitTempdefault;
        $masterUnitHeat = getUnit(15);
        $data['masterUnitHeat'] = $masterUnitHeat;
        $masterUnitHeatdefault = getdefaultUnit(15);
        $data['masterUnitHeatdefault'] = $masterUnitHeatdefault;
        $masterUnitpressure = getUnit(5);
        $data['masterUnitPressure'] = $masterUnitpressure;
        $masterUnitpressuredefault = getdefaultUnit(5);
        $data['masterUnitpressuredefault'] = $masterUnitpressuredefault;
        $masterUnitTime = getUnit(14);
        $data['masterUnitTime'] = $masterUnitTime;
        $masterUnitTimedefault = getdefaultUnit(14);
        $data['masterUnitTimedefault'] = $masterUnitTimedefault;
        $UnitWeightconcentration = getUnit(18);
        $data['UnitWeightconcentration'] = $UnitWeightconcentration;
        $UnitWeightconcentrationdefault = getdefaultUnit(18);
        $data['UnitWeightconcentrationdefault'] = $UnitWeightconcentrationdefault;
        $masterUnitCaTime = getUnit(20);
        $data['masterUnitCaTime'] = $masterUnitCaTime;
        $masterUnitCaTimedefault = getdefaultUnit(20);
        $data['masterUnitCaTimedefault'] = $masterUnitCaTimedefault;
        $simtypedecrypt = ___decrypt($request->simulation_type);
        if ($simtypedecrypt != 0) {
            if ($simtypedecrypt == 1 || $simtypedecrypt == 2 ||  $simtypedecrypt == 3) {
                $stage = "Early" . $simtypedecrypt;
            } elseif ($simtypedecrypt == 4) {
                $stage = "process_first";
            } elseif ($simtypedecrypt == 5) {
                $stage = "process_sim";
            } elseif ($simtypedecrypt == 6) {
                $stage = "plan_data";
            }
            $html = view('pages.console.mfg_process.' . $stage . '.reactor_form')->with(compact('data'))->render();
        } else {
            $html = "err";
        }
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function processProfileSave(Request $request)
    {
        $id = ProcessProfile::select('id')->where([['process_id', $request->process_id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        if ($id == NULL) {
            $simulationData = new ProcessProfile();
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->created_by = Auth::user()->id;
        } else {
            $simulationData = ProcessProfile::find($id['id']);
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->updated_at = now();
        }
        if ($request->qa == "qaas") {
            $simulationData->quality_assesment = $request->quality_assesment;
        }
        $cap_cost = [];
        if (isset($request->cap) && $request->cap == "capital") {
            if ($request->getAction == "add") {
                if (!empty($simulationData->equipment_capital_cost)) {
                    $capExit = $simulationData->equipment_capital_cost;
                    $cap_cost = $capExit['equipment_capital_cost'];
                    array_push($cap_cost, $request['capital_cost_eqp'][0]);
                } else {
                    if (!empty($request->capital_cost_eqp)) {
                        $cap_cost = $request->capital_cost_eqp;
                    } else {
                        $cap_cost = [];
                    }
                }
            } elseif ($request->getAction == "delete") {
                $capExit = $simulationData->equipment_capital_cost;
                $cap_cost = $capExit['equipment_capital_cost'];
                unset($cap_cost[$request->capId]);
                $cap_cost = array_merge($cap_cost);
            } elseif ($request->getAction == "isrecomended") {
                $capExit = $simulationData->equipment_capital_cost;
                $cap_cost = $capExit['equipment_capital_cost'];
                $isrecArr = [];
                foreach ($cap_cost as $ck => $cv) {
                    $isrecArr[$ck]['id'] = $cv['id'];
                    $isrecArr[$ck]['pps_unit'] = $cv['pps_unit'];
                    $isrecArr[$ck]['pps_unit_type'] = "10";
                    $isrecArr[$ck]['flowtype_id'] = $cv['flowtype_id'];
                    $isrecArr[$ck]['pps_reference'] = $cv['pps_reference'];
                    $isrecArr[$ck]['capex_estimate'] = $cv['capex_estimate'];
                    $isrecArr[$ck]['capex_reference'] = $cv['capex_reference'];
                    $isrecArr[$ck]['pps_refrence_id'] = $cv['pps_refrence_id'];
                    $isrecArr[$ck]['capex_price_unit_type'] = "19";
                    $isrecArr[$ck]['capex_price_unit'] = $cv['capex_price_unit'];
                    $isrecArr[$ck]['process_plant_size'] = $cv['process_plant_size'];
                    if ($ck == $request->capId) {
                        $isrecArr[$ck]['is_default'] = "1";
                    } else {
                        $isrecArr[$ck]['is_default'] = "0";
                    }
                }
                $cap_cost = $isrecArr;
            } else {
                $capExit = $simulationData->equipment_capital_cost;
                $cap_cost = $capExit['equipment_capital_cost'];
                $cap_cost[$request->capId] = $request['capital_cost_eqp'][0];
            }
            $cap_cost_arr['equipment_capital_cost'] = $cap_cost;
            $simulationData->equipment_capital_cost = $cap_cost_arr;
        }
        if ($request->keyinfo == "keyinfo") {
            $keyinfo = [];
            $newsliterature = $request->newsliterature;
            $regulatoryinformatio = $request->regulatoryinformatio;
            $keyinfo['newsliterature'] = $newsliterature;
            $keyinfo['regulatoryinformatio'] = $regulatoryinformatio;
            if ($request->file != "undefined") {
                $image = upload_file($request, 'file', 'image');
                $keyinfo['image'] = $image;
            } else {
                $keyinfo['image'] = "";
            }
            $simulationData->key_process_info = $keyinfo;
        }
        $process_id = $request->process_id;
        $simulation_type = ___decrypt($request->simulation_type);
        $data_source = $request->data_source;
        if ($data_source == "E1BUI" || $data_source == "E2BUI" || $data_source == "E3BUI" || $data_source == "PDBUI" || $data_source == "PFBUI" || $data_source == "PSBUI") {
            $simulationDataInput = [];
            if (!empty($request->input)) {
                foreach ($request->input as $key => $c_no) {
                    $val_en['input'][$key]['id'] = ($c_no['id']);
                    $val_en['input'][$key]['product_input'] = ___decrypt($c_no['product_input']);
                    $val_en['input'][$key]['unit_constant_id'] = ___decrypt($c_no['unit_constant_id']);
                    $val_en['input'][$key]['unit'] = $c_no['unit'];
                    $val_en['input'][$key]['flowtype'] = ___decrypt($c_no['flowtype']);
                    $val_en['input'][$key]['massflow'] = $c_no['massflow'];
                }
                $simulationDataInput  = $val_en;
            }
            $simulationDataoutput = [];
            if (!empty($request->output)) {
                foreach ($request->output as $key => $c_no) {
                    $val_en['output'][$key]['id'] = ($c_no['id']);
                    $val_en['output'][$key]['product_output'] = ___decrypt($c_no['product_output']);
                    $val_en['output'][$key]['unit_constant_id'] = ___decrypt($c_no['unit_constant_id']);
                    $val_en['output'][$key]['unit'] = $c_no['unit'];
                    $val_en['output'][$key]['flowtype'] = ___decrypt($c_no['flowtype']);
                    $val_en['output'][$key]['massflow'] = $c_no['massflow'];
                }
                $simulationDataoutput  = $val_en;
            }
            $mass_balance = array_merge($simulationDataInput, $simulationDataoutput);
            $simulationData->mass_basic_io = $mass_balance;
        }
        if ($data_source == "E3ENUBUI" || $data_source == "PSENUBUI" || $data_source == "PFENUBUI" || $data_source == "PDENUBUI") {
            $simulationDataInput = [];
            if (!empty($request->input)) {
                foreach ($request->input as $key => $c_no) {
                    // $val_en['input'][] = ___decrypt($c_no);
                    $val_en['input'][$key]['id'] = ($c_no['id']);
                    $val_en['input'][$key]['product_input'] = ___decrypt($c_no['product_input']);
                    $val_en['input'][$key]['unit_constant_id'] = ___decrypt($c_no['unit_constant_id']);
                    $val_en['input'][$key]['unit'] = $c_no['unit'];
                    $val_en['input'][$key]['flowtype'] = ___decrypt($c_no['flowtype']);
                    $val_en['input'][$key]['input_flow_rate'] = $c_no['input_flow_rate'];
                }
                $simulationDataInput  = $val_en;
            } else {
                $val_en['input'] = [];
                $simulationDataInput  = $val_en;
            }
            $simulationDataoutput = [];
            if (!empty($request->output)) {
                foreach ($request->output as $key => $c_no) {
                    // $val_en['output'][] = ___decrypt($c_no);
                    $val_en['output'][$key]['id'] = ($c_no['id']);
                    $val_en['output'][$key]['product_output'] = ___decrypt($c_no['product_output']);
                    $val_en['output'][$key]['unit_constant_id'] = ___decrypt($c_no['unit_constant_id']);
                    $val_en['output'][$key]['unit'] = $c_no['unit'];
                    $val_en['output'][$key]['flowtype'] = ___decrypt($c_no['flowtype']);
                    $val_en['output'][$key]['output_flow_rate'] = $c_no['output_flow_rate'];
                }
                $simulationDataoutput  = $val_en;
            } else {
                $val_en['output'] = [];
                $simulationDataoutput  = $val_en;
            }
            $energy_balance = array_merge($simulationDataInput, $simulationDataoutput);
            $simulationData->energy_basic_io = $energy_balance;
        }
        $simulationData->process_id = $request->process_id;
        $simulationData->simulation_type = $simulation_type;
        if (isset($request->data_source_mass)) {
            $simulationData->data_source_mass = ___decrypt($request->data_source_mass);
        } else {
            if ($simulationData['data_source_mass'] == NULL) {
                $simulationData->data_source_mass = 0;
            } else {
                $simulationData->data_source_mass = $simulationData['data_source_mass'];
            }
        }
        if (isset($request->data_source_energy)) {
            $simulationData->data_source_energy = ___decrypt($request->data_source_energy);
        } else {
            if ($simulationData['data_source_energy'] == NULL) {
                $simulationData->data_source_energy = 0;
            } else {
                $simulationData->data_source_energy = ($simulationData['data_source_energy']);
            }
        }
        if ($simulationData->save()) {
            $simulationDataProfile = ProcessSimulation::find($process_id);
            $editId = $simulationDataProfile['sim_stage'];
            if (!empty($editId)) {
                array_push($editId, $simulation_type);
            } else {
                $editId = [$simulation_type];
            }
            $simulationDataProfile->sim_stage = array_unique($editId);
            $simulationDataProfile->simulation_type = ___decrypt($request->simulation_type);
            $simulationDataProfile->updated_by = Auth::user()->id;
            $simulationDataProfile->updated_at = now();
            if ($simulationDataProfile->save()) {
                $success = true;
                $message = "Process Simulation profile successfully updated";
                $response = [
                    'success' => $success,
                    'message' => $message
                ];
                return response()->json($response, 200);
            }
        }
    }

    public function processgetSource(Request $request)
    {
        $reactData = ProcessProfile::select('id', 'mass_basic_pd')->where([['process_id', $request->id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        if ($reactData) {
            if ($reactData['mass_basic_pd'] != null) {
                $keyinfoArr = $reactData;
                if (!empty($keyinfoArr)) {
                    $reactArrrrDataPc = $keyinfoArr['mass_basic_pd'];
                    $data['pcArrData'] = $reactArrrrDataPc;
                } else {
                    $data['pcArrData'] = [];
                }
            }
        }
        if (!empty($data['pcArrData'])) {
            if (!empty($data['pcArrData']) && array_key_exists($request->source_id, $data['pcArrData'])) {
                $editData = $data['pcArrData'][$request->source_id];
            } else {
                $editData = [];
            }
        } else {
            $editData = [];
        }
        $renderDataPC = [];
        if (!empty($editData)) {
            if (!empty($editData['input'])) {
                foreach ($editData['input'] as $k => $v) {
                    $renderDataPC[$k]['product'] = ___encrypt($v['product']);
                    $renderDataPC[$k]['flowtype'] = ___encrypt($v['flowtype']);
                    $renderDataPC[$k]['unit'] = ___encrypt($v['unit_constant_id']);
                    if (!empty($v['product_compostion'])) {
                        $renderDataPC[$k]['pro'] = $v['product_compostion'];
                    } else {
                        $renderDataPC[$k]['pro'] = [];
                    }
                }
            }
        } else {
            $renderDataPC = [];
        }
        $renderDataPCAss = [];
        if (!empty($editData['input'])) {
            foreach ($editData['input'] as $k => $v) {
                $c = 0;
                if (!empty($v['product_compostion'])) {
                    foreach ($v['product_compostion'] as $pk => $pv) {
                        $prokey = explode('##', $pk);
                        if ($prokey[1] != 0) {
                            $sel = Chemical::select('id', 'chemical_name')->where('id', $prokey[1])->first();
                            $renderDataPCAss[$sel['id'] . "#" . $sel['chemical_name'] . "#@" . $c][] = $pv;
                        } else {
                            $renderDataPCAss[0 . "#select#@" . $c][] = 0;
                        }
                        $c++;
                    }
                }
            }
        }
        $data['setValue'] = $renderDataPC;
        $data['assoPro'] = $renderDataPCAss;
        if (!empty($editData['src_info'])) {
            $data['src_info'] = $editData['src_info'];
        } else {
            $data['src_info'] = [];
        }
        if (!empty($data['pcArrData']['sel'])) {
            $data['default'] = $data['pcArrData']['sel'];
        } else {
            $data['default'] = 1;
        }
        $data['source_id'] = $request->source_id;
        $chemPro = getChemicalHelper($request->id);
        $buiFlowTypeInput = [];
        $buiFlowTypeOutput = [];
        $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
        $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
        $fb = [];
        $pb = [];
        $bb = array_merge($buiFlowTypeInput->toArray(), $buiFlowTypeOutput->toArray());
        foreach ($bb as $bk => $bv) {
            $fb[___encrypt($bv['id'])] = $bv['flow_type_name'];
        }
        $data['buiFlowtype'] = $fb;
        foreach ($chemPro as $pk => $pv) {
            $pb[___encrypt($pv['id'])] = $pv['chemical_name'];
        }
        $data['chemPro'] = $pb;
        $masterUnit = getUnit(10);
        $pu = [];
        foreach ($masterUnit as $uk => $uv) {
            $pu[___encrypt($uk)] = $uv;
        }
        $getdefaultUnit = getdefaultUnit(10);
        $data['default_unit'] = $getdefaultUnit;
        $data['pcmassUnit'] = $pu;
        $masterUnitTemp = getUnit(12);
        $data['masterUnitTemp'] = $masterUnitTemp;
        $masterUnitHeat = getUnit(15);
        $data['masterUnitHeat'] = $masterUnitHeat;
        $masterUnitpressure = getUnit(5);
        $data['masterUnitPressure'] = $masterUnitpressure;
        $masterUnitTime = getUnit(14);
        $data['masterUnitTime'] = $masterUnitTime;
        $UnitWeightconcentration = getUnit(18);
        $data['UnitWeightconcentration'] = $UnitWeightconcentration;
        $masterUnitCaTime = getUnit(20);
        $data['masterUnitCaTime'] = $masterUnitCaTime;
        $simtypedecrypt = ___decrypt($request->simulation_type);
        if ($simtypedecrypt != 0) {
            if ($simtypedecrypt == 1 || $simtypedecrypt == 2 || $simtypedecrypt == 3) {
                $stage = "Early" . $simtypedecrypt;
            } elseif ($simtypedecrypt == 4) {
                $stage = "process_first";
            } elseif ($simtypedecrypt == 5) {
                $stage = "process_sim";
            } elseif ($simtypedecrypt == 6) {
                $stage = "plan_data";
            }
            $html = view('pages.console.mfg_process.' . $stage . '.source_form')->with(compact('data'))->render();
        } else {
            $html = "err";
        }
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function sourceProfileSave(Request $request)
    {
        $checkStag = [];
        for ($ch = 1; $ch <= $request->selstage; $ch++) {
            $checkStag[] = $ch;
        }
        $id = ProcessProfile::select('id')->where([['process_id', $request->process_id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        $md = [];
        if ($id == NULL) {
            $simulationData = new ProcessProfile();
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->created_by = Auth::user()->id;
        } else {
            $simulationData = ProcessProfile::find($id['id']);
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->updated_at = now();
            $sim = $simulationData->toArray();
            $md = $sim['mass_basic_pd'];
        }
        if (isset($request->src_info)) {
            if (!empty($md)) {
                $mdkey = array_keys($md);
                $result = array_diff($mdkey, $checkStag);
                foreach ($result as $rv) {
                    unset($md[$rv]);
                }
            }
            $md[$request->source_id]['src_info'] = ($request->src_info);
            $val_cas = $md;
        }
        if (isset($request->tab) && $request->tab == "input_output") {
            $flag = 0;
            if (!empty($md)) {
                $mdkey = array_keys($md);
                $result = array_diff($mdkey, $checkStag);
                if (!empty($result)) {
                    $flag = 1;
                    foreach ($result as $rv) {
                        unset($md[$rv]);
                    }
                }
            }
            if (!empty($md) && array_key_exists($request->source_id, $md)) {
                $val_cas1 = [];
                if (!empty($request->product)) {
                    foreach ($request->product as $key => $c_no) {
                        $val_cas1[$key]['id'] = json_encode($key);
                        $val_cas1[$key]['product'] =  ___decrypt($request->product[$key]);
                        $val_cas1[$key]['flowtype'] = ___decrypt($request->flowtype[$key]);
                        $val_cas1[$key]['unit_id'] = json_encode(10);
                        $val_cas1[$key]['unit_constant_id'] = ___decrypt($request->unit[$key]);
                        if (!empty($request->objassprd[$key])) {
                            $val_cas1[$key]['mass_flow_rate'] = json_encode(array_sum($request->objassprd[$key]));
                        } else {
                            $val_cas1[$key]['mass_flow_rate'] = 0;
                        }
                        foreach ($request->ass as $k => $v) {
                            if (isset($request->objassprd[$key][$k])) {
                                if ($v != "0")
                                    $val_cas1[$key]['product_compostion'][$k . "##" . ___decrypt($v)] = $request->objassprd[$key][$k];
                            } else {
                                $val_cas1[$key]['product_compostion'][$k . "##" . ___decrypt($v)] = 0;
                            }
                        }
                    }
                }
                $md[$request->source_id]["input"] = $val_cas1;
                $val_cas = $md;
            } else {
                $val_cas = [];
                if (!empty($request->product)) {
                    foreach ($request->product as $key => $c_no) {
                        $val_cas[$request->source_id]["input"][$key]['id'] = json_encode($key);
                        $val_cas[$request->source_id]["input"][$key]['product'] =  ___decrypt($request->product[$key]);
                        $val_cas[$request->source_id]["input"][$key]['flowtype'] = ___decrypt($request->flowtype[$key]);
                        $val_cas[$request->source_id]["input"][$key]['unit_id'] = json_encode(10);
                        $val_cas[$request->source_id]["input"][$key]['unit_constant_id'] = ___decrypt($request->unit[$key]);
                        if (!empty($request->objassprd[$key])) {
                            $val_cas[$request->source_id]["input"][$key]['mass_flow_rate'] = json_encode(array_sum($request->objassprd[$key]));
                        } else {
                            $val_cas[$request->source_id]["input"][$key]['mass_flow_rate'] = 0;
                        }
                        foreach ($request->ass as $k => $v) {

                            if (isset($request->objassprd[$key][$k])) {
                                if ($v != "0")
                                    $val_cas[$request->source_id]["input"][$key]['product_compostion'][$k . "##" . ___decrypt($v)] = $request->objassprd[$key][$k];
                            } else {
                                $val_cas[$request->source_id]["input"][$key]['product_compostion'][$k . "##" . ($v)] = 0;
                            }
                        }
                    }
                }
                if (!empty($md)) {
                    if ($flag == 1) {
                        $New_start_index = 1;
                        $val_cas = array_merge($md, $val_cas);
                        $val_cas = array_combine(
                            range($New_start_index, count($val_cas) + ($New_start_index - 1)),
                            array_values($val_cas)
                        );
                    }
                }
            }
        }
        $selected = 1;
        $default_source = $request->default_source;
        if ($default_source != 0) {
            $selected = $default_source;
        }
        $select_source['sel'] = $selected;
        $val_cas = ($val_cas + $select_source);
        $simulationData->mass_basic_pd  = $val_cas;
        $process_id = $request->process_id;
        $simulation_type = ___decrypt($request->simulation_type);
        $simulationData->process_id = $request->process_id;
        $simulationData->simulation_type = $simulation_type;
        if (isset($request->data_source_mass)) {
            $simulationData->data_source_mass = ___decrypt($request->data_source_mass);
        } else {
            if ($simulationData['data_source_mass'] == NULL) {
                $simulationData->data_source_mass = 0;
            } else {
                $simulationData->data_source_mass = $simulationData['data_source_mass'];
            }
        }
        if (isset($request->data_source_energy)) {
            $simulationData->data_source_energy = ___decrypt($request->data_source_energy);
        } else {
            if ($simulationData['data_source_energy'] == NULL) {
                $simulationData->data_source_energy = 0;
            } else {
                $simulationData->data_source_energy = ($simulationData['data_source_energy']);
            }
        }
        if (!isset($request->src_info)) {
            $setData = createProduct($request);
        }
        if ($simulationData->save()) {
            $simulationDataProfile = ProcessSimulation::find($process_id);
            $editId = $simulationDataProfile['sim_stage'];
            if (!empty($editId)) {
                array_push($editId, $simulation_type);
            } else {
                $editId = [$simulation_type];
            }
            $simulationDataProfile->sim_stage = array_unique($editId);;
            $simulationDataProfile->simulation_type = ___decrypt($request->simulation_type);
            $simulationDataProfile->updated_by = Auth::user()->id;
            $simulationDataProfile->updated_at = now();
            if ($simulationDataProfile->save()) {
                $success = true;
                $message = "Process Simulation profile successfully Updated";
                $response = [
                    'success' => $success,
                    'message' => $message
                ];
                return response()->json($response, 200);
            }
        }
    }

    public function processgetUtilitylevel(Request $request)
    {
        $reactData = ProcessProfile::select('id', 'energy_process_level')->where([['process_id', $request->id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        if ($reactData) {
            if ($reactData['energy_process_level'] != null) {
                $keyinfoArr = $reactData;
                if (!empty($keyinfoArr)) {
                    $reactArrrrDataPc = $keyinfoArr['energy_process_level'];
                    $data['pcArrData'] = $reactArrrrDataPc;
                } else {
                    $data['pcArrData'] = [];
                }
            }
        }
        if (!empty($data['pcArrData'])) {
            if (!empty($data['pcArrData']) && array_key_exists($request->source_id, $data['pcArrData'])) {
                $editData = $data['pcArrData'][$request->source_id];
            } else {
                $editData = [];
            }
        } else {
            $editData = [];
        }
        $renderDataPC = [];
        if (!empty($editData)) {
            if (!empty($editData['input'])) {
                foreach ($editData['input'] as $k => $v) {
                    $renderDataPC[$k]['energy'] = ___encrypt($v['energy']);
                    $renderDataPC[$k]['flowtype'] = ___encrypt($v['flowtype']);
                    $renderDataPC[$k]['unit_constant_id'] = ___encrypt($v['unit_constant_id']);
                    $renderDataPC[$k]['energy_value'] = $v['energy_value'];
                    $renderDataPC[$k]['utility_type'] = $v['utility_type'];
                }
            }
        } else {
            $renderDataPC = [];
        }
        $data['setValue'] = $renderDataPC;
        if (!empty($editData['src_info'])) {
            $data['src_info'] = $editData['src_info'];
        } else {
            $data['src_info'] = [];
        }
        if (!empty($data['pcArrData']['sel'])) {
            $data['default'] = $data['pcArrData']['sel'];
        } else {
            $data['default'] = 1;
        }
        $data['source_id'] = $request->source_id;
        $engPro = getEnergyHelper($request->id);
        $buiFlowTypeInput = [];
        $buiFlowTypeOutput = [];
        $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
        $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
        $fb = [];
        $pb = [];
        $bb = array_merge($buiFlowTypeInput->toArray(), $buiFlowTypeOutput->toArray());
        foreach ($bb as $bk => $bv) {
            $fb[___encrypt($bv['id'])] = $bv['flow_type_name'];
        }
        $data['buiFlowtype'] = $fb;
        foreach ($engPro as $pk => $pv) {
            $pb[___encrypt($pv['id'])] = $pv['energy_name'];
        }
        $data['engPro'] = $pb;
        $masterUnit = getUnitEnergybalance();
        $pu = [];
        foreach ($masterUnit as $uk => $uv) {
            $pu[___encrypt($uk)] = $uv;
        }
        $data['e3eu'] = $pu;
        $simtypedecrypt = ___decrypt($request->simulation_type);
        if ($simtypedecrypt != 0) {
            if ($simtypedecrypt == 1 || $simtypedecrypt == 2 || $simtypedecrypt == 3) {
                $stage = "Early" . $simtypedecrypt;
            } elseif ($simtypedecrypt == 4) {
                $stage = "process_first";
            } elseif ($simtypedecrypt == 5) {
                $stage = "process_sim";
            } elseif ($simtypedecrypt == 6) {
                $stage = "plan_data";
            }
            $html = view('pages.console.mfg_process.' . $stage . '.utility_leval_source_form')->with(compact('data'))->render();
        } else {
            $html = "err";
        }
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function utilitylevelSave(Request $request)
    {
        $checkStag = [];
        for ($ch = 1; $ch <= $request->selstage; $ch++) {
            $checkStag[] = $ch;
        }
        $id = ProcessProfile::select('id')->where([['process_id', $request->process_id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        $md = [];
        if ($id == NULL) {
            $simulationData = new ProcessProfile();
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->created_by = Auth::user()->id;
        } else {
            $simulationData = ProcessProfile::find($id['id']);
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->updated_at = now();
            $sim = $simulationData->toArray();
            $md = $sim['energy_process_level'];
        }
        if (isset($request->src_info)) {
            if (!empty($md)) {
                $mdkey = array_keys($md);
                $result = array_diff($mdkey, $checkStag);
                foreach ($result as $rv) {
                    unset($md[$rv]);
                }
            }
            $md[$request->source_id]['src_info'] = ($request->src_info);
            $val_cas = $md;
        }
        if (isset($request->tab) && $request->tab == "input_output") {
            $flag = 0;
            if (!empty($md)) {
                $mdkey = array_keys($md);
                $result = array_diff($mdkey, $checkStag);
                if (!empty($result)) {
                    $flag = 1;
                    foreach ($result as $rv) {
                        unset($md[$rv]);
                    }
                }
            }
            if (!empty($md) && array_key_exists($request->source_id, $md)) {
                $val_cas1 = [];
                if (!empty($request->energy)) {
                    foreach ($request->energy as $key => $c_no) {
                        $val_cas1[$key]['id'] = json_encode($key);
                        $val_cas1[$key]['energy_value'] = $request->energy_value[$key];
                        $val_cas1[$key]['energy'] =  ___decrypt($request->energy[$key]);
                        $val_cas1[$key]['flowtype'] = ___decrypt($request->flowtype[$key]);
                        $val_cas1[$key]['unit'] = ($request->unit[$key]);
                        $val_cas1[$key]['unit_constant_id'] = ___decrypt($request->unit_constant_id[$key]);
                        $val_cas1[$key]['utility_type'] = $request->utility_type[$key];
                    }
                }
                $md[$request->source_id]["input"] = $val_cas1;
                $val_cas = $md;
            } else {
                $val_cas = [];
                if (!empty($request->energy)) {
                    foreach ($request->energy as $key => $c_no) {
                        $val_cas[$request->source_id]["input"][$key]['id'] = json_encode($key);
                        $val_cas[$request->source_id]["input"][$key]['energy_value'] =  ($request->energy_value[$key]);
                        $val_cas[$request->source_id]["input"][$key]['energy'] =  ___decrypt($request->energy[$key]);
                        $val_cas[$request->source_id]["input"][$key]['flowtype'] = ___decrypt($request->flowtype[$key]);
                        $val_cas[$request->source_id]["input"][$key]['unit'] = ($request->unit[$key]);
                        $val_cas[$request->source_id]["input"][$key]['unit_constant_id'] = ___decrypt($request->unit_constant_id[$key]);
                        $val_cas[$request->source_id]["input"][$key]['utility_type'] = ($request->utility_type[$key]);
                    }
                }
                if (!empty($md)) {
                    if ($flag == 1) {
                        $New_start_index = 1;
                        $val_cas = array_merge($md, $val_cas);
                        $val_cas = array_combine(
                            range($New_start_index, count($val_cas) + ($New_start_index - 1)),
                            array_values($val_cas)
                        );
                    }
                }
            }
        }
        $selected = 1;
        $default_source = $request->default_source;
        if ($default_source != 0) {
            $selected = $default_source;
        }
        $select_source['sel'] = $selected;
        $val_cas = ($val_cas + $select_source);
        $simulationData->energy_process_level  = $val_cas;
        $process_id = $request->process_id;
        $simulation_type = ___decrypt($request->simulation_type);
        $simulationData->process_id = $request->process_id;
        $simulationData->simulation_type = $simulation_type;
        if (isset($request->data_source_mass)) {
            $simulationData->data_source_mass = ___decrypt($request->data_source_mass);
        } else {
            if ($simulationData['data_source_mass'] == NULL) {
                $simulationData->data_source_mass = 0;
            } else {
                $simulationData->data_source_mass = $simulationData['data_source_mass'];
            }
        }
        if (isset($request->data_source_energy)) {
            $simulationData->data_source_energy = ___decrypt($request->data_source_energy);
        } else {
            if ($simulationData['data_source_energy'] == NULL) {
                $simulationData->data_source_energy = 0;
            } else {
                $simulationData->data_source_energy = ___decrypt($simulationData['data_source_energy']);
            }
        }
        if ($simulationData->save()) {
            $simulationDataProfile = ProcessSimulation::find($process_id);
            $editId = $simulationDataProfile['sim_stage'];
            if (!empty($editId)) {
                array_push($editId, $simulation_type);
            } else {
                $editId = [$simulation_type];
            }
            $simulationDataProfile->sim_stage = array_unique($editId);;
            $simulationDataProfile->simulation_type = ___decrypt($request->simulation_type);
            $simulationDataProfile->updated_by = Auth::user()->id;
            $simulationDataProfile->updated_at = now();
            if ($simulationDataProfile->save()) {
                $success = true;
                $message = "Process Simulation profile successfully Updated";
                $response = [
                    'success' => $success,
                    'message' => $message
                ];
                return response()->json($response, 200);
            }
        }
    }

    public function processgetUtilitydetailedlevel(Request $request)
    {
        $reactData = ProcessProfile::select('id', 'energy_detailed_level')->where([['process_id', $request->id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        if ($reactData) {
            if ($reactData['energy_detailed_level'] != null) {
                $keyinfoArr = $reactData;
                if (!empty($keyinfoArr)) {
                    $reactArrrrDataPc = $keyinfoArr['energy_detailed_level'];
                    $data['pcArrData'] = $reactArrrrDataPc;
                } else {
                    $data['pcArrData'] = [];
                }
            }
        }
        if (!empty($data['pcArrData'])) {
            if (!empty($data['pcArrData']) && array_key_exists($request->source_id, $data['pcArrData'])) {
                $editData = $data['pcArrData'][$request->source_id];
            } else {
                $editData = [];
            }
        } else {
            $editData = [];
        }
        $renderDataPC = [];
        if (!empty($editData)) {
            if (!empty($editData['input'])) {
                foreach ($editData['input'] as $k => $v) {
                    $renderDataPC[$k]['energy'] = ___encrypt($v['energy']);
                    $renderDataPC[$k]['flowtype'] = ___encrypt($v['flowtype']);
                    $renderDataPC[$k]['unit_constant_id'] = ___encrypt($v['unit_constant_id']);
                    $renderDataPC[$k]['energy_value'] = $v['energy_value'];
                    $renderDataPC[$k]['utility_type'] = $v['utility_type'];
                    $renderDataPC[$k]['start_temperature'] = $v['start_temperature'];
                    $renderDataPC[$k]['end_temperature'] = $v['end_temperature'];
                }
            }
        } else {
            $renderDataPC = [];
        }
        $data['setValue'] = $renderDataPC;
        if (!empty($editData['src_info'])) {
            $data['src_info'] = $editData['src_info'];
        } else {
            $data['src_info'] = [];
        }
        if (!empty($data['pcArrData']['sel'])) {
            $data['default'] = $data['pcArrData']['sel'];
        } else {
            $data['default'] = 1;
        }
        $data['source_id'] = $request->source_id;
        $engPro = getEnergyHelper($request->id);
        $buiFlowTypeInput = [];
        $buiFlowTypeOutput = [];
        $buiFlowTypeInput = SimulationFlowType::where('type', 1)->get();
        $buiFlowTypeOutput = SimulationFlowType::where('type', 2)->get();
        $fb = [];
        $pb = [];
        $bb = array_merge($buiFlowTypeInput->toArray(), $buiFlowTypeOutput->toArray());
        foreach ($bb as $bk => $bv) {
            $fb[___encrypt($bv['id'])] = $bv['flow_type_name'];
        }
        $data['buiFlowtype'] = $fb;
        foreach ($engPro as $pk => $pv) {
            $pb[___encrypt($pv['id'])] = $pv['energy_name'];
        }
        $data['engPro'] = $pb;
        $masterUnit = getUnitEnergybalance();
        $pu = [];
        foreach ($masterUnit as $uk => $uv) {
            $pu[___encrypt($uk)] = $uv;
        }
        $data['e3eu'] = $pu;
        $simtypedecrypt = ___decrypt($request->simulation_type);
        if ($simtypedecrypt != 0) {
            if ($simtypedecrypt == 1 || $simtypedecrypt == 2 || $simtypedecrypt == 3) {
                $stage = "Early" . $simtypedecrypt;
            } elseif ($simtypedecrypt == 4) {
                $stage = "process_first";
            } elseif ($simtypedecrypt == 5) {
                $stage = "process_sim";
            } elseif ($simtypedecrypt == 6) {
                $stage = "plan_data";
            }
            $html = view('pages.console.mfg_process.' . $stage . '.utility_detailed_source_form')->with(compact('data'))->render();
        } else {
            $html = "err";
        }
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function utilityleveldetailedSave(Request $request)
    {
        $checkStag = [];
        for ($ch = 1; $ch <= $request->selstage; $ch++) {
            $checkStag[] = $ch;
        }
        $id = ProcessProfile::select('id')->where([['process_id', $request->process_id], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        $md = [];
        if ($id == NULL) {
            $simulationData = new ProcessProfile();
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->created_by = Auth::user()->id;
        } else {
            $simulationData = ProcessProfile::find($id['id']);
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->updated_at = now();
            $sim = $simulationData->toArray();
            $md = $sim['energy_detailed_level'];
        }
        if (isset($request->src_info)) {
            if (!empty($md)) {
                $mdkey = array_keys($md);
                $result = array_diff($mdkey, $checkStag);
                foreach ($result as $rv) {
                    unset($md[$rv]);
                }
            }
            $md[$request->source_id]['src_info'] = ($request->src_info);
            $val_cas = $md;
        }
        if (isset($request->tab) && $request->tab == "input_output") {
            $flag = 0;
            if (!empty($md)) {
                $mdkey = array_keys($md);
                $result = array_diff($mdkey, $checkStag);
                if (!empty($result)) {
                    $flag = 1;
                    foreach ($result as $rv) {
                        unset($md[$rv]);
                    }
                }
            }
            if (!empty($md) && array_key_exists($request->source_id, $md)) {
                $val_cas1 = [];
                if (!empty($request->energy)) {
                    foreach ($request->energy as $key => $c_no) {
                        $val_cas1[$key]['id'] = json_encode($key);
                        $val_cas1[$key]['energy_value'] = $request->energy_value[$key];
                        $val_cas1[$key]['start_temperature'] = $request->start_temperature[$key];
                        $val_cas1[$key]['end_temperature'] = $request->end_temperature[$key];
                        $val_cas1[$key]['energy'] =  ___decrypt($request->energy[$key]);
                        $val_cas1[$key]['flowtype'] = ___decrypt($request->flowtype[$key]);
                        $val_cas1[$key]['unit'] = ($request->unit[$key]);
                        $val_cas1[$key]['unit_constant_id'] = ___decrypt($request->unit_constant_id[$key]);
                        $val_cas1[$key]['utility_type'] = $request->utility_type[$key];
                    }
                }
                $md[$request->source_id]["input"] = $val_cas1;
                $val_cas = $md;
            } else {
                $val_cas = [];
                if (!empty($request->energy)) {
                    foreach ($request->energy as $key => $c_no) {
                        $val_cas[$request->source_id]["input"][$key]['id'] = json_encode($key);
                        $val_cas[$request->source_id]["input"][$key]['energy_value'] =  $request->energy_value[$key];
                        $val_cas[$request->source_id]["input"][$key]['start_temperature'] =  $request->start_temperature[$key];
                        $val_cas[$request->source_id]["input"][$key]['end_temperature'] =  $request->end_temperature[$key];
                        $val_cas[$request->source_id]["input"][$key]['energy'] =  ___decrypt($request->energy[$key]);
                        $val_cas[$request->source_id]["input"][$key]['flowtype'] = ___decrypt($request->flowtype[$key]);
                        $val_cas[$request->source_id]["input"][$key]['unit'] = ($request->unit[$key]);
                        $val_cas[$request->source_id]["input"][$key]['unit_constant_id'] = ___decrypt($request->unit_constant_id[$key]);
                        $val_cas[$request->source_id]["input"][$key]['utility_type'] = $request->utility_type[$key];
                    }
                }
                if (!empty($md)) {
                    if ($flag == 1) {
                        $New_start_index = 1;
                        $val_cas = array_merge($md, $val_cas);
                        $val_cas = array_combine(
                            range($New_start_index, count($val_cas) + ($New_start_index - 1)),
                            array_values($val_cas)
                        );
                    }
                }
            }
        }
        $selected = 1;
        $default_source = $request->default_source;
        if ($default_source != 0) {
            $selected = $default_source;
        }
        $select_source['sel'] = $selected;
        $val_cas = ($val_cas + $select_source);
        $simulationData->energy_detailed_level  = $val_cas;
        $process_id = $request->process_id;
        $simulation_type = ___decrypt($request->simulation_type);
        $simulationData->process_id = $request->process_id;
        $simulationData->simulation_type = $simulation_type;
        if (isset($request->data_source_mass)) {
            $simulationData->data_source_mass = ___decrypt($request->data_source_mass);
        } else {
            if ($simulationData['data_source_mass'] == NULL) {
                $simulationData->data_source_mass = 0;
            } else {
                $simulationData->data_source_mass = $simulationData['data_source_mass'];
            }
        }
        if (isset($request->data_source_energy)) {
            $simulationData->data_source_energy = ___decrypt($request->data_source_energy);
        } else {
            if ($simulationData['data_source_energy'] == NULL) {
                $simulationData->data_source_energy = 0;
            } else {
                $simulationData->data_source_energy = ___decrypt($simulationData['data_source_energy']);
            }
        }
        if ($simulationData->save()) {
            $simulationDataProfile = ProcessSimulation::find($process_id);
            $editId = $simulationDataProfile['sim_stage'];
            if (!empty($editId)) {
                array_push($editId, $simulation_type);
            } else {
                $editId = [$simulation_type];
            }
            $simulationDataProfile->sim_stage = array_unique($editId);;
            $simulationDataProfile->simulation_type = ___decrypt($request->simulation_type);
            $simulationDataProfile->updated_by = Auth::user()->id;
            $simulationDataProfile->updated_at = now();
            if ($simulationDataProfile->save()) {
                $success = true;
                $message = "Process Simulation profile successfully Updated";
                $response = [
                    'success' => $success,
                    'message' => $message
                ];
                return response()->json($response, 200);
            }
        }
    }

    public function getUtilityunit(Request $request)
    {
        $getunittype = EnergyUtility::select('id', 'base_unit_type')->where('id', ___decrypt($request->utilityid))->first();
        if ($getunittype['base_unit_type'] == 2) {
            $unitId = 4;
        } elseif ($getunittype['base_unit_type'] == 7) {
            $unitId = 10;
        } elseif ($getunittype['base_unit_type'] == 6) {
            $unitId = 36;
        }
        $masterUnit = getUnitEncrypt($unitId);
        $data["unit"] = $masterUnit;
        $data["unit_type"] = $unitId;
        return json_encode($data);
    }
}
