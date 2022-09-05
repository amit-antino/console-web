<?php

namespace App\Http\Controllers\Console\MFG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Chemical;
use App\Models\OtherInput\EnergyUtility;
use App\Models\MFG\ProcessSimulation;
use App\Models\MFG\ProcessProfile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\ProcessSimulation\ProcessCategory;
use App\Models\Master\ProcessSimulation\ProcessStatus;
use App\Models\Master\ProcessSimulation\ProcessType;
use App\Models\Master\ProcessSimulation\SimulationType;
use App\Models\Master\ProcessSimulation\SimulationFlowType;
use App\Models\Product\ChemicalProperties;
use Carbon\Carbon;

class ProcessSimulationController extends Controller
{
    public function index()
    {
        $process_simulations = ProcessSimulation::where('tenant_id', session()->get('tenant_id'))->orderBy('id', 'DESC')->with('processCategory', 'processStatus')->get();
        $data = [];
        foreach ($process_simulations as $key => $value) {
            $data[$value->id]['id'] = $value->id;
            $data[$value->id]['status'] = $value->status;
            $data[$value->id]['process_name'] = $value->process_name;
            $data[$value->id]['created_at'] = $value->created_at;
            $data[$value->id]['updated_at'] = $value->updated_at;
            $data[$value->id]['dataset'] = ProcessProfile::where('process_id', $value->id)->count();
            $profileFeed = explode("_", $value->main_feedstock);
            if ($profileFeed[0] == "ch") {
                $selectchem = Chemical::select('chemical_name')->where('id', ___decrypt($profileFeed[1]))->first();
                $feed = !is_null($selectchem) ? $selectchem['chemical_name'] : '';
            } else {
                $selectchem = EnergyUtility::select('energy_name')->where('id', $profileFeed[1])->first();
                $feed = !is_null($selectchem) ? $selectchem['energy_name'] : '';
            }
            $data[$value->id]['main_feedstock'] = $feed;
            $profilemainproduct = explode("_", $value->main_product);
            if ($profilemainproduct[0] == "ch") {
                $selectproduct = Chemical::select('chemical_name')->where('id', ___decrypt($profilemainproduct[1]))->first();
                $main_product = !is_null($selectproduct) ? $selectproduct['chemical_name'] : '';
            } else {
                $main_product = EnergyUtility::select('energy_name')->where('id', $profilemainproduct[1])->first();
                $main_product = !is_null($main_product) ? $main_product['energy_name'] : '';
            };
            $data[$value->id]['main_product'] = $main_product;
            if ($value->processCategory) {
                $data[$value->id]['processCategory'] = $value->processCategory->name;
                $data[$value->id]['processCategorydescription'] = "";
            } else {
                $data[$value->id]['processCategory'] = "";
                $data[$value->id]['processCategorydescription'] = "";
            }
            if ($value->processStatus) {
                $data[$value->id]['processStatus'] = $value->processStatus->name;
                $data[$value->id]['processStatusdescription'] = "";
            } else {
                $data[$value->id]['processStatus'] = "";
                $data[$value->id]['processStatusdescription'] = "";
            }
        }
        return view('pages.console.mfg_process.index')->with(compact('data'));
    }

    public function create()
    {
        $data['chemicals'] = Chemical::where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        $data['EnergyUtility'] = EnergyUtility::where('status', 'active')->get();
        $data['ProcessCategory'] = ProcessCategory::where('status', 'active')->get();
        $data['ProcessStatus'] = ProcessStatus::where('status', 'active')->get();
        $data['ProcessType'] = ProcessType::where('status', 'active')->get();
        return view('pages.console.mfg_process.create', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'process_name' => 'required',
                'process_category' => 'required',
                'process_status' => 'required',
                'product' => 'required',
                'main_feedstock' => 'required',
                'main_product' => 'required',

            ]

        );
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            // try {
            $simulationData = new ProcessSimulation();
            $simulationData->tenant_id = session()->get('tenant_id');
            $simulationData->process_name = $request->process_name;
            $simulationData->process_type = ___decrypt($request->process_type);
            if (!empty($request->product)) {
                foreach ($request->product as $key => $c_no) {
                    $val_cas[$key]['id'] = $key + 1;
                    $chdata = explode('_', $c_no);
                    $val_cas[$key]['product'] = $chdata[0] . '_' . ___decrypt($chdata[1]);
                }
                $simulationData->product  = $val_cas;
            }
            if (!empty($request->energy)) {
                foreach ($request->energy as $key => $c_no) {
                    $val_en[$key]['id'] = $key + 1;
                    $endata = explode('_', $c_no);
                    $val_en[$key]['energy'] = $endata[0] . '_' . ___decrypt($endata[1]);
                }
                $simulationData->energy  = $val_en;
            } else {
                $simulationData->energy  = [];
            }
            $feed = explode('_', $request->main_feedstock);
            $pro = explode('_', $request->main_product);
            $simulationData->main_feedstock = $feed[0] . '_' . $feed[1];
            $simulationData->main_product = $pro[0] . '_' . $pro[1];
            $simulationData->process_category = ___decrypt($request->process_category);
            $simulationData->process_status = ___decrypt($request->process_status);
            $simulationData->description = $request->description;
            // $simulationData->simulation_type = ___decrypt($request->sim_stage);
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $simulationData->tags = $tags;
            $simulationData->created_by = Auth::user()->id;
            $simulationData->updated_by = Auth::user()->id;
            if ($simulationData->save()) {
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('/mfg_process/simulation');
                $this->message = "Process Added Successfully!";
            }

            // } catch (\Exception $e) {
            //     $this->status = false;
            //     $this->message = $e->getMessage();
            // }
        }
        return $this->populateresponse();
    }

    public function manage($id)
    {
        $parameters = request()->segment(4);
        $data['edit'] = ProcessSimulation::find(___decrypt($id));
        $data['pfid'] = 1;
        $profileFeed = explode("_", $data['edit']['main_feedstock']);
        if ($profileFeed[0] == "ch") {
            $selectchem = Chemical::select('chemical_name')->where('id', ___decrypt($profileFeed[1]))->first();
            $value = $selectchem['chemical_name'];
        } else {
            $selectchem = EnergyUtility::select('energy_name')->where('id', $profileFeed[1])->first();
            $value = $selectchem['energy_name'];
        }
        $data['feed'] = $value;
        $profilemainproduct = explode("_", $data['edit']['main_product']);
        if ($profilemainproduct[0] == "ch") {
            $selectproduct = Chemical::select('chemical_name')->where('id', ___decrypt($profilemainproduct[1]))->first();
            $main_product = $selectproduct['chemical_name'];
        } else {
            $main_product = EnergyUtility::select('energy_name')->where('id', $profilemainproduct[1])->first();
            $main_product = $main_product['energy_name'];
        }
        $data['main_product'] = $main_product;
        $productName = [];
        if (!empty($data['edit']['product'])) {
            foreach ($data['edit']['product'] as $k => $v) {
                $chemexplode = explode("_", $v['product']);
                $pnames[] = $chemexplode[1];
            }
            $pds = Chemical::select('chemical_name')->whereIn('id', $pnames)->get();
            if (!empty($pds)) {
                foreach ($pds as $pnk => $pname) {
                    $productName[] = $pname['chemical_name'];
                }
            }
        }
        $utilityName = [];
        if (!empty($data['edit']['energy'])) {
            foreach ($data['edit']['energy'] as $ek => $ev) {
                $enxplode = explode("_", $ev['energy']);
                $enames[] = $enxplode[1];
            }
            $eds = EnergyUtility::select('energy_name')->whereIn('id', $enames)->get();
            if (!empty($eds)) {
                foreach ($eds as $pnk => $ename) {

                    $utilityName[] = $ename['energy_name'];
                }
            }
        }
        $data['utilityName'] = $utilityName;
        $data['productName'] = $productName;
        $data['processtype'] = $data['edit']->processType->name;
        $data['processCategory'] = $data['edit']->processCategory->name;
        $data['viewflag'] = $parameters;
        return view('pages.console.mfg_process.profile', compact('data'));
    }

    public function get_configuration_view(Request $request)
    {
        try {
            $process_datasets = ProcessProfile::where('process_id', ___decrypt($request['process_id']))->get();
            $process_info = [
                "id" => $request['process_id'],
                "process_datasets" => $process_datasets,
                //"viewflag" => $request->viewflag
            ];
        } catch (\Exception $e) {
            return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        }
        $html = view('pages.console.mfg_process.dataset.index', compact('process_info'))->render();
        return response()->json(['success' => true,  'html' => $html]);
        // return view('pages.console.experiment.experiment.profile.configuration')->with('process_experiment_info', $process_experiment_info);
    }

    public function show($id)
    {
        $data['edit'] = ProcessSimulation::find(___decrypt($id));
        $profileId = ProcessProfile::where([['process_id', $data['edit']['id']], ['simulation_type', $data['edit']['simulation_type']]])->first();
        $data['pfid'] = 1;
        $profileFeed = explode("_", $data['edit']['main_feedstock']);
        if ($profileFeed[0] == "ch") {
            $selectchem = Chemical::select('chemical_name')->where('id', $profileFeed[1])->first();
            $value = $selectchem['chemical_name'];
        } else {
            $selectchem = EnergyUtility::select('energy_name')->where('id', $profileFeed[1])->first();
            $value = $selectchem['energy_name'];
        }
        $data['feed'] = $value;
        $profilemainproduct = explode("_", $data['edit']['main_product']);
        if ($profilemainproduct[0] == "ch") {
            $selectproduct = Chemical::select('chemical_name')->where('id', $profilemainproduct[1])->first();
            $main_product = $selectproduct['chemical_name'];
        } else {
            $main_product = EnergyUtility::select('energy_name')->where('id', $profilemainproduct[1])->first();
            $main_product = $main_product['energy_name'];
        }
        $data['main_product'] = $main_product;
        $productName = [];
        foreach ($data['edit']['product'] as $k => $v) {
            $chemexplode = explode("_", $v['product']);
            $pname = Chemical::select('chemical_name')->where('id', $chemexplode[1])->first();
            $productName[$k] = $pname['chemical_name'];
        }
        $utilityName = [];
        foreach ($data['edit']['energy'] as $ek => $ev) {
            $enxplode = explode("_", $ev['energy']);

            $ename = EnergyUtility::select('energy_name')->where('id', $enxplode[1])->first();
            $utilityName[$ek] = $ename['energy_name'];
        }
        $data['utilityName'] = $utilityName;
        $data['productName'] = $productName;
        $data['processStatus'] = $data['edit']->processStatus->name;
        $data['processtype'] = $data['edit']->processType->name;
        $data['processCategory'] = $data['edit']->processCategory->name;
        return view('pages.console.mfg_process.view', compact('data'));
    }

    public function edit($id)
    {
        $data['chemicals'] = Chemical::where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        $data['EnergyUtility'] = EnergyUtility::where('status', 'active')->get();
        $data['ProcessCategory'] = ProcessCategory::where('status', 'active')->get();
        $data['ProcessStatus'] = ProcessStatus::where('status', 'active')->get();
        $data['ProcessType'] = ProcessType::where('status', 'active')->get();
        $data['edit'] = ProcessSimulation::find(___decrypt($id));
        $pr_id = $data['edit']['product'];
        $en_id = $data['edit']['energy'];
        $id_col = array_column($pr_id, 'product');
        $id_colen = array_column($en_id, 'energy');
        $nearr = [];
        $nearr1 = [];
        foreach ($id_col as $val) {
            $exp = explode('ch_', $val);
            array_push($nearr, $exp[1]);
        }
        foreach ($id_colen as $val) {
            $exp = explode('en_', $val);
            array_push($nearr1, $exp[1]);
        }
        $selectProdct = Chemical::select(['id', 'chemical_name'])->find($nearr);
        $selectEnergy = EnergyUtility::select(['id', 'energy_name'])->find($nearr1);
        $resultchem = [];
        foreach ($selectProdct->toArray() as $key => $value) {
            $resultchem[$key]['id'] = 'ch_' . ___encrypt($value['id']);
            $resultchem[$key]['chem'] = $value['chemical_name'];
        }
        $resulteng = [];
        foreach ($selectEnergy->toArray() as $key => $value) {
            $resulteng[$key]['id'] = 'en_' . ___encrypt($value['id']);
            $resulteng[$key]['chem'] = $value['energy_name'];
        }
        $merge = array_merge($resultchem, $resulteng);
        $ch_en = array_column($merge, 'chem', 'id');
        $data['ch_en'] = $ch_en;
        return view('pages.console.mfg_process.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'process_name' => 'required',
                'product' => 'required',
                'main_feedstock' => 'required',
                'main_product' => 'required',
                'process_category' => 'required',
                'process_status' => 'required'
            ],
            [
                'process_name.required' => 'process_name',
                'product.required' => 'product',
                'energy.required' => 'energy',
                'main_feedstock.required' => 'main_feedstock',
                'main_product.required' => 'main_product',
                'process_category.required' => 'process_category',
                'sim_stage.required' => 'sim_stage',
                'process_status.required' => 'process_status'
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            $simulationData = ProcessSimulation::find(___decrypt($id));
            // $editIdSim = $simulationData['sim_stage'];
            // $editId = $simulationData['sim_stage'];
            // if (!empty($editId)) {
            //     array_push($editId, ___decrypt($request->sim_stage));
            // } else {
            //     $editId = [___decrypt($request->sim_stage)];
            // }
            $simulationData->tenant_id = session()->get('tenant_id');
            $simulationData->process_name = $request->process_name;
            $simulationData->process_type =  ___decrypt($request->process_type);
            if (!empty($request->product)) {
                foreach ($request->product as $key => $c_no) {
                    $val_cas[$key]['id'] = json_encode($key);
                    $chdata = explode('_', $c_no);
                    $val_cas[$key]['product'] = $chdata[0] . '_' . ___decrypt($chdata[1]);
                }
                $simulationData->product  = $val_cas;
            }
            if (!empty($request->energy)) {
                foreach ($request->energy as $key => $c_no) {
                    $val_en[$key]['id'] = json_encode($key);
                    $endata = explode('_', $c_no);
                    $val_en[$key]['energy'] = $endata[0] . '_' . ___decrypt($endata[1]);
                }
                $simulationData->energy  = $val_en;
            } else {
                $simulationData->energy  = [];
            }
            $feed = explode('_', $request->main_feedstock);
            $pro = explode('_', $request->main_product);
            $simulationData->main_feedstock = $feed[0] . '_' . ($feed[1]);
            $simulationData->main_product = $pro[0] . '_' . ($pro[1]);
            $simulationData->process_category = ___decrypt($request->process_category);
            $simulationData->process_status = ___decrypt($request->process_status);
            //$simulationData->simulation_type = ___decrypt($request->sim_stage);
            $simulationData->description = $request->description;
            //$simulationData->sim_stage = array_unique($editId);
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $simulationData->tags = $tags;
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->updated_at = now();
            if ($simulationData->save()) {
            }
            $success = true;
            $message = "Process Simulation Successfully Updated";
            $response = [
                'success' => $success,
                'message' => $message
            ];
            return response()->json($response, 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = ProcessSimulation::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ProcessSimulation::where('id', ___decrypt($id))->update($update)) {
                ProcessSimulation::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('/mfg_process/simulation');
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
        if (ProcessSimulation::whereIn('id', $processIDS)->update($update)) {
            ProcessSimulation::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('/mfg_process/simulation');
        return $this->populateresponse();
    }

    public function get_process_simulation_info(Request $request)
    {
        try {
            $process_simulation = ProcessSimulation::find($request->process_simulation_id);
            $simulation_stages = [];
            // foreach ($process_simulation->sim_stage as $stage) {
            //     $simulation_stages = json_decode($stage, true);
            // }
            $product_list = [];
            foreach ($process_simulation->product as $product) {
                $product_id = explode("_", $product['product']);
                $product_list[] = $product_id[1];
            }
            $energy_utility_list = [];
            foreach ($process_simulation->energy as $energy) {
                $energy_utility_id = explode("_", $energy['energy']);
                $energy_utility_list[] = $energy_utility_id[1];
            }
            $main_feedstock = explode("_", $process_simulation->main_feedstock);
            $main_feedstock_info = [];
            if ($main_feedstock[0] == 'ch') {
                $main_feedstock_info = ___decrypt($main_feedstock[1]);
            } elseif ($main_feedstock[0] == 'en') {
                $main_feedstock_info = $main_feedstock[1];
            }
            $main_product = explode("_", $process_simulation->main_product);
            $main_product_info = [];
            if ($main_product[0] == 'ch') {
                $main_product_info = ___decrypt($main_product[1]);
            } elseif ($main_product[0] == 'en') {
                $main_product_info = $main_product[1];
            }
            $ps_info = [
                "id" => $process_simulation->id,
                "name" => $process_simulation->process_name,
                "process_type" => $process_simulation->processType->id,
                "process_status" => $process_simulation->processStatus->id,
                "process_category" => $process_simulation->processCategory->id,
                "simulation_stages" => $simulation_stages,
                "product_list" => $product_list,
                "energy_utilities" => $energy_utility_list,
                "main_feedstock" => $main_feedstock_info,
                "main_product" => $main_product_info,
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $ps_info
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

    public function get_ps_profile(Request $request)
    {
        try {
            $process_simulation_profile = ProcessProfile::where('process_id', $request->process_simulation_id)->get();
            $process_simulation_info = [];
            $ps_profile_details = [];
            if (!empty($process_simulation_profile)) {
                foreach ($process_simulation_profile as $ps_profile) {
                    if ($ps_profile->process_id == $request->process_simulation_id) {
                        $ps_profile_details[] = [
                            "simulation_stage" => [
                                "id" => $ps_profile->SimulationType->id,
                                "name" => $ps_profile->SimulationType->simulation_name,
                                "mass_basic_io" => get_mass_basic_io($request->process_simulation_id, $ps_profile->simulation_type),
                                "mass_process_chemistry" => get_mass_process_chemistry($request->process_simulation_id, $ps_profile->simulation_type),
                                "mass_process_detailed" => get_mass_process_detailed($request->process_simulation_id, $ps_profile->simulation_type),
                                "energy_basic_io" => get_energy_basic_io($request->process_simulation_id, $ps_profile->simulation_type),
                                "energy_process_level" => get_energy_process_level($request->process_simulation_id, $ps_profile->simulation_type),
                                "energy_detailed_level" => get_energy_detailed_level($request->process_simulation_id, $ps_profile->simulation_type),
                                "equipment_capital_cost" => get_equipment_capital_cost($request->process_simulation_id, $ps_profile->simulation_type),
                                "key_process_info" => $ps_profile->key_process_info,
                                "quality_assesment" => $ps_profile->quality_assesment
                            ]
                        ];
                        $process_simulation_info = [
                            "id" => $ps_profile->process_id,
                            "name" => $ps_profile->processSimulation->process_name,
                            "profile" => $ps_profile_details
                        ];
                    }
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $process_simulation_info
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

    public function get_ps_profile_stage_old(Request $request)
    {
        try {
            $process_simulation_profile = ProcessProfile::where('process_id', $request->process_simulation_id)->where('simulation_type', $request->simulation_stage_id)->first();
            $process_simulation_info = [];
            $ps_profile_details = [];
            $data_sources = get_simulation_stage($request->simulation_stage_id);
            $mass_data_source = [];
            $energy_data_source = [];
            if (!empty($request->data_source)) {
                foreach ($data_sources['mass_balance'] as $datasource) {
                    if (isset($request->data_source[0]['type']) && $request->data_source[0]['type'] == 1) {
                        if ($datasource['id'] == 1 && $request->data_source[0]['id'] == 1) {
                            $mass_basic_io = get_mass_basic_io($request->process_simulation_id, $request->simulation_stage_id);
                            $mass_data_source = [
                                "data_source_id" => json_decode($datasource['id'], true),
                                "overall_mass_balance" => !empty($mass_basic_io) ? $mass_basic_io : [],
                                "reaction_detail" => []
                            ];
                        }
                        if ($datasource['id'] == 2 && $request->data_source[0]['id'] == 2) {
                            $mass_process_chemistry = getMassBalanceofPC($request->process_simulation_id, $request->simulation_stage_id);
                            $reaction_detail = get_mass_process_chemistry($request->process_simulation_id, $request->simulation_stage_id, 1);
                            $mass_data_source = [
                                "data_source_id" => json_decode($datasource['id'], true),
                                "overall_mass_balance" => !empty($mass_process_chemistry) ? $mass_process_chemistry : [],
                                "reaction_detail" => !empty($reaction_detail) ? $reaction_detail['reaction_detail'] : []
                            ];
                        }
                        if ($datasource['id'] == 3 && $request->data_source[0]['id'] == 3) {
                            $mass_process_detailed = getMassBalanceofPD($request->process_simulation_id, $request->simulation_stage_id);
                            $reaction_detail = get_mass_process_detailed($request->process_simulation_id, $request->simulation_stage_id, 1);
                            $mass_data_source = [
                                "data_source_id" => json_decode($datasource['id'], true),
                                "overall_mass_balance" => !empty($mass_process_detailed) ? $mass_process_detailed : [],
                                "reaction_detail" => !empty($reaction_detail) ? $reaction_detail['reaction_detail'] : []
                            ];
                        }
                    }
                }
                foreach ($data_sources['enery_utilities'] as $datasource) {
                    if (isset($request->data_source[1]['type']) &&  $request->data_source[1]['type'] == 2) {
                        if ($datasource['id'] == 1 && $request->data_source[1]['id'] == 1) {
                            $energy_basic_io = get_energy_basic_io($request->process_simulation_id, $request->simulation_stage_id);
                            $energy_data_source = [
                                "data_source_id" => json_decode($datasource['id'], true),
                                "overall_energy_balance" => !empty($energy_basic_io) ? $energy_basic_io : []
                            ];
                        }
                        if ($datasource['id'] == 2 && $request->data_source[1]['id'] == 2) {
                            $energy_process_level = getMassBalanceofEnergyLevel($request->process_simulation_id, $request->simulation_stage_id);
                            $source_detail = get_energy_process_level($request->process_simulation_id, $request->simulation_stage_id, 1);
                            $energy_data_source = [
                                "data_source_id" => json_decode($datasource['id'], true),
                                "overall_energy_balance" => !empty($energy_process_level) ? $energy_process_level : [],
                                "source_detail" => !empty($source_detail) ? $source_detail['source_details'] : []
                            ];
                        }
                        if ($datasource['id'] == 3 && $request->data_source[1]['id'] == 3) {
                            $energy_detailed_level = get_energy_detailed_level($request->process_simulation_id, $request->simulation_stage_id);
                            $source_detail = get_energy_detailed_level($request->process_simulation_id, $request->simulation_stage_id, 1);
                            $energy_data_source = [
                                "data_source_id" => json_decode($datasource['id'], true),
                                "overall_energy_balance" => !empty($energy_detailed_level) ? $energy_detailed_level : [],
                                "source_detail" => !empty($source_detail) ? $source_detail['source_details'] : []
                            ];
                        }
                    }
                }
            } else {
                return required_parameter("data_source");
            }
            if (!empty($process_simulation_profile)) {
                $ps_profile_details = [
                    "simulation_stage" => [
                        "id" => $process_simulation_profile->SimulationType->id,
                        "name" => $process_simulation_profile->SimulationType->simulation_name,
                        "mass_data_source_type" => 1,
                        "mass_data_source_info" => $mass_data_source,
                        "energy_data_source_type" => 2,
                        "energy_data_source_info" => $energy_data_source,
                        "equipment_capital_cost" => get_equipment_capital_cost($request->process_simulation_id, $request->simulation_stage_id),
                        "key_process_info" => $process_simulation_profile->key_process_info,
                        "quality_assesment" => $process_simulation_profile->quality_assesment
                    ]
                ];
                $process_simulation_info = [
                    "id" => $process_simulation_profile->process_id,
                    "name" => $process_simulation_profile->processSimulation->process_name,
                    "profile" => $ps_profile_details
                ];
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'status' => true,
                    'data' => $process_simulation_info
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'status' => true,
                    'data' => "No Records Found"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_ps_profile_stage(Request $request)
    {
        try {
            $process_simulation_info = get_ps_profile_stage_info($request->dataset_id);
            if(!empty($process_simulation_info)){
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'status' => true,
                    'data' => $process_simulation_info
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'status' => true,
                    'data' => "No Records Found"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_ps_details(Request $request)
    {
        try {
            // $ps_details = get_ps_product_ced($request->process_simulation_id, $request->simulation_type);
            // return response()->json([
            //     'success' => true,
            //     'status_code' => 200,
            //     'status' => true,
            //     'data' => $ps_details
            // ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_ps_capex_estimate(Request $request)
    {
        try {
            $ps_details = get_equipment_capital_cost($request->process_simulation_id, $request->simulation_stage_id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $ps_details
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

    public function get_mass_input(Request $request)
    {

        try {
            if (!empty($request->process_simulation_id) && !empty($request->simulation_stage_id) && !empty($request->data_source_type)) {
                $ps_details = get_mass_detail($request, "input");
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'status' => true,
                    'data' => $ps_details
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'status_code' => 400,
                    'status' => true,
                    'data' => "The request is missing a required parameter"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_mass_output(Request $request)
    {
        try {
            if (!empty($request->process_simulation_id) && !empty($request->simulation_stage_id) && !empty($request->data_source_type)) {
                $ps_details = get_mass_detail($request, "output");
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'status' => true,
                    'data' => $ps_details
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'status_code' => 400,
                    'status' => true,
                    'data' => "The request is missing a required parameter"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_process_type(Request $request)
    {
        try {
            if (!empty($request->process_simulation_id)) {
                $ps_details = get_process_type($request);
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'status' => true,
                    'data' => $ps_details
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'status_code' => 400,
                    'status' => true,
                    'data' => "The request is missing a required parameter"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function processValidtion(Request $request)
    {
        $flag = 0;
        $stream = 1;
        $string = "";
        $profileId = ProcessProfile::select('id', 'mass_basic_pc', 'mass_basic_pd')->where([['process_id', $request['process_id']], ['simulation_type', ___decrypt($request->simulation_type)]])->first();
        if (!empty($profileId['mass_basic_pc']) && $request->data_source == 2) {
            foreach ($profileId['mass_basic_pc'] as $key => $value) {
                foreach ($value['input'] as $k => $v) {
                    if (___decrypt($request->id) == 1 && $v['flowtype'] == ___decrypt($request->id)) {
                        $flag = 1;
                        $stream = "Reactor " . $key;
                        $string = "Main Feed";
                        break;
                    }
                    if (___decrypt($request->id) == 3 && $v['flowtype'] == ___decrypt($request->id)) {
                        $flag = 2;
                        $stream = "Reactor" . $key;
                        $string = "Main Product";
                        break;
                    }
                }
            }
        }
        if (!empty($profileId['mass_basic_pd']) && $request->data_source == 3) {
            foreach ($profileId['mass_basic_pd'] as $key => $value) {
                if ($key != "sel") {
                    if (!empty($value['input'])) {
                        foreach ($value['input'] as $k => $v) {
                            if (___decrypt($request->id) == 1 && $v['flowtype'] == ___decrypt($request->id)) {
                                $flag = 1;
                                $stream = "Source" . $key;
                                $string = "Main Feed";
                                break;
                            }
                            if (___decrypt($request->id) == 3 && $v['flowtype'] == ___decrypt($request->id)) {
                                $flag = 2;
                                $stream = "Source" . $key;
                                $string = "Main Product";
                                break;
                            }
                        }
                    }
                }
            }
        }
        $message = $string . " Is Already Selected In  " . $stream;
        $response = [
            'flag' => $flag,
            "message" => $message

        ];
        return response()->json($response, 200);
    }

    public function replicatePopup($id)
    {
        $simulation = ProcessSimulation::find(___decrypt($id));
        return response()->json([
            'status' => true,
            'html' => view('pages.console.mfg_process.replicate', ['simulation' => $simulation])->render()
        ]);
    }

    public function replicateSimuation(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $simulation = ProcessSimulation::find(___decrypt($request->id));
            $newSimulation = $simulation->replicate();
            $newSimulation->process_name = $request->name;
            $newSimulation->created_at = Carbon::now();
            $newSimulation->save();
            $profiles = ProcessProfile::where('process_id', ___decrypt($request->id))->get();
            if (!empty($profiles)) {
                foreach ($profiles as $profile) {
                    $pro = ProcessProfile::find($profile->id);
                    $newPro = $pro->replicate();
                    $newPro->process_id = $newSimulation->id;
                    $newPro->created_at = Carbon::now();
                    $newPro->save();
                }
            }
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Process Simulation Replicated Successfully!";
        }
        return $this->populateresponse();
    }
}
