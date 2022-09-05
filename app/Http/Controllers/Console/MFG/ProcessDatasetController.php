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
use App\Models\Master\MasterUnit;

class ProcessDatasetController extends Controller
{
    public function index($process_id,Request $request)
    {
        try {
            $process_datasets = ProcessProfile::where('process_id',___decrypt($process_id))->orderBy('id', 'desc')->get();
            $simulationtype = SimulationType::where('status','active')->get();
            $process_info = [
                "id" => $process_id,
                "process_datasets" => $process_datasets,
                "simulationtype" => $simulationtype,
                "viewflag" => $request->viewflag
            ];
        } catch (\Exception $e) {
            return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        } catch (ModelNotFoundException $exception) {
            return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
        } catch (RelationNotFoundException $r) {
            return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
        }
        $html = view('pages.console.mfg_process.dataset.index', compact('process_info'))->render();
        return response()->json(['success' => true,  'html' => $html]);
        // return view('pages.console.experiment.experiment.profile.configuration')->with('process_experiment_info', $process_experiment_info);
    }

    public function create()
    {
    }

    public function store(Request $request, $process_id)
    {
        if ($request->energy_data_source_input == 1) {
            $validator = Validator::make($request->all(), [
                'dataset_name' => 'required',
                'simulation_type' => 'required',
                'mass_data_source' => 'required',
                'energy_data_source' => 'required'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'dataset_name' => 'required',
                'simulation_type' => 'required',
                'mass_data_source' => 'required',
            ]);
        }
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $process = ProcessSimulation::find(___decrypt($request->process_id));
            $main_feedstock = explode('_', $process->main_feedstock);
            $mass_basic_io = [];
            $energy_basic_io = [];
            if ($main_feedstock[0] == "ch") {
                $mass_basic_io[] = [
                    "product" => ___decrypt($main_feedstock[1]),
                    "flow_type" => 1,
                    "mass_flow" => "",
                    "unit_type" => "",
                    "io" => 1
                ];
            } elseif ($main_feedstock[0] == "en") {
                $energy_basic_io[] = [
                    "energy" => $main_feedstock[1],
                    "flow_type" => 1,
                    "mass_flow" => "",
                    "unit_type" => "",
                    "io" => 1
                ];
            }
            $main_product = explode('_', $process->main_product);
            if ($main_product[0] == "ch") {
                $mass_basic_io[] = [
                    "product" => ___decrypt($main_product[1]),
                    "flow_type" => 3,
                    "mass_flow" => "",
                    "unit_type" => "",
                    "io" => 2
                ];
            } elseif ($main_product[0] == "en") {
                $energy_basic_io[] = [
                    "energy" => $main_product[1],
                    "flow_type" => 3,
                    "mass_flow" => "",
                    "unit_type" => "",
                    "io" => 1
                ];
            }
            if (!empty($request->energy_data_source)) {
                $energy_data_source = $request->energy_data_source;
            } else {
                $energy_data_source = '';
            }
            $data_source = [];
            $data_source['mass_balance'] = $request->mass_data_source;
            $data_source['energy_utilities'] = !empty($request->energy_data_source) ? $request->energy_data_source : '';
            $Data = new ProcessProfile();
            $Data['dataset_name'] = $request->dataset_name;
            $Data['simulation_type'] = ___decrypt($request->simulation_type);
            $Data['data_source'] = $data_source;
            $Data['process_id'] = ___decrypt($request->process_id);
            $Data['mass_basic_io'] = $mass_basic_io;
            $Data['energy_basic_io'] = $energy_basic_io;
            $Data['created_by'] = Auth::user()->id;
            $Data['updated_by'] = Auth::user()->id;
            $Data->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Dataset Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        //
    }

    public function edit($process_id, $id)
    {
        try {
            $process_dataset = ProcessProfile::find(___decrypt($id));
            $simulationtype = SimulationType::where('status','active')->get();
            $data = [
                "process_dataset" => $process_dataset,
                "simulationtype" => $simulationtype,
            ];
        } catch (\Exception $e) {
            return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        } catch (ModelNotFoundException $exception) {
            return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
        } catch (RelationNotFoundException $r) {
            return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
        }
        $html = view('pages.console.mfg_process.dataset.edit', compact('data'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function update(Request $request, $process_id, $id)
    {
        if ($request->energy_data_source_input == 1) {
            $validator = Validator::make($request->all(), [
                'dataset_name' => 'required',
                'simulation_type' => 'required',
                'mass_data_source' => 'required',
                'energy_data_source' => 'required'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'dataset_name' => 'required',
                'simulation_type' => 'required',
                'mass_data_source' => 'required',
            ]);
        }
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $data_source = [
                "mass_balance" => $request->mass_data_source,
                "energy_utilities" => $request->energy_data_source,
            ];
            $Data = ProcessProfile::find(___decrypt($id));
            $Data->dataset_name = $request->dataset_name;
            $Data->simulation_type = ___decrypt($request->simulation_type);
            $Data->data_source = $data_source;
            $Data->process_id = ___decrypt($process_id);
            $Data->updated_by = Auth::user()->id;
            $Data->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Dataset Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function status(Request $request)
    {
        $Data = ProcessProfile::find(___decrypt($request->dataset_id));
        if ($request->val == 'pending') {
            $status = "active";
        } elseif ($request->val == 'active') {
            $status = "pending";
        }
        $Data->status = $status;
        $Data->updated_by = Auth::user()->id;
        $Data->save();
    }

    public function DatasetConfig($id)
    {
        $parameters = request()->segment(4);
        try {
            $process_dataset = ProcessProfile::find(___decrypt($id));
            $data = [
                "process_dataset" => $process_dataset,
                "viewflag" => $parameters,
            ];
        } catch (\Exception $e) {
            return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        } catch (ModelNotFoundException $exception) {
            return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
        } catch (RelationNotFoundException $r) {
            return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
        }
        return view('pages.console.mfg_process.dataset.manage')->with('process_dataset', $process_dataset)->with('viewflag',$parameters);
        // $html = view('pages.console.mfg_process.dataset.manage', compact('data'))->render();
        // return response()->json(['success' => true,  'html' => $html]);
    }

    public function EditConfig(Request $request)
    {
        $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
        if ($request->tab == 'mass_balance') {
            if ($process_dataset->data_source['mass_balance'] == 'Basic User Input') {
                $process = ProcessSimulation::find($process_dataset->process_id);
                $process_products = array_column($process->product, 'product');
                $flow_type = SimulationFlowType::whereIn('type', ['1', '2'])->get();
                $unit_type = MasterUnit::find(10);
                $data = [
                    'process_dataset' => $process_dataset,
                    'products' => $process_products,
                    'flow_types' => $flow_type,
                    "unit_types" => $unit_type->unit_constant,
                    "viewflag" => $request->viewflag
                ];
                $html = view('pages.console.mfg_process.dataset.mass_balance.basic_user_input', compact('data'))->render();
            }
        }
        if ($request->tab == 'energy_utilities') {
            if ($process_dataset->data_source['energy_utilities'] == 'Basic User Input') {
                $process = ProcessSimulation::find($process_dataset->process_id);
                $process_energies = array_column($process->energy, 'energy');
                $flow_type = SimulationFlowType::whereIn('type', ['1', '2'])->get();
                $unit_type = MasterUnit::find(10);
                $data = [
                    'process_dataset' => $process_dataset,
                    'energies' => $process_energies,
                    'flow_types' => $flow_type,
                    "unit_types" => $unit_type->unit_constant,
                    "viewflag" => $request->viewflag
                ];
                $html = view('pages.console.mfg_process.dataset.energy_utilities.basic_user_input', compact('data'))->render();
            }
        }
        if ($request->tab == 'equipment_capital_cost') {
            $data = [];
            $viewflag = $request->viewflag;
            $myunit = [];
            $massflowrate = getUnit(10);
            foreach ($massflowrate as $m => $mv) {
                if ($m == 13)
                    $myunit[$m] = $mv;
            }
            $data['capitalcost_unit'] = $myunit;
            $flow_feed_product = SimulationFlowType::select('id', 'flow_type_name')->whereIn('id', [1, 3])->get();
            $feed_product = [];
            foreach ($flow_feed_product->toArray() as $fk => $fv) {
                $feed_product[$fv['id']] = $fv['flow_type_name'];
            }
            $data['capitalcost_flowtype'] = $feed_product;
            $html = view('pages.console.mfg_process.dataset.equipment_capital_cost.index', compact('process_dataset','viewflag','data'))->render();
        }
        if ($request->tab == 'key_process_info') {
            $viewflag = $request->viewflag;
            $html = view('pages.console.mfg_process.dataset.key_process_info', compact('process_dataset','viewflag'))->render();
        }
        if ($request->tab == 'qualitative_assesment') {
            $viewflag = $request->viewflag;
            $html = view('pages.console.mfg_process.dataset.qualitative_assesment', compact('process_dataset','viewflag'))->render();
        }
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function SaveBasicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'flow_type' => 'required',
            'mass_flow' => 'required',
            'unit_type' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
            if (!empty($process_dataset->mass_basic_io)) {
                $sort_arr = $process_dataset->mass_basic_io;
                usort($sort_arr, function ($a, $b) {
                    return $a['flow_type'] <=> $b['flow_type'];
                });
                foreach ($sort_arr as $key => $mass_basic_io) {
                    if ($mass_basic_io['flow_type'] == 1 && ___decrypt($request->flow_type) == 1  && $key != $request->io_id) {
                        $this->status = true;
                        $this->success = false;
                        $this->modal = true;
                        $this->redirect = url('/mfg_process/simulation');
                        $this->message = "Main feed product already exists";
                        return $this->populateresponse();
                    }
                    if ($mass_basic_io['flow_type'] == 3 && ___decrypt($request->flow_type) == 3 && $key != $request->io_id) {
                        $this->status = true;
                        $this->success = false;
                        $this->modal = true;
                        $this->redirect = url('/mfg_process/simulation');
                        $this->message = "Main product already exists";
                        return $this->populateresponse();
                    }
                    if ($mass_basic_io['product'] == ___decrypt($request->product) && $mass_basic_io['io'] == $request->io && $key != $request->io_id) {
                        $this->status = true;
                        $this->success = false;
                        $this->modal = true;
                        $this->redirect = url('/mfg_process/simulation');
                        $this->message = "Product already exists";
                        return $this->populateresponse();
                    }
                }
            }

            if ($request->io_id == '-1') {
                $data_arr = [];
                $data_arr = [
                    "product" => ___decrypt($request->product),
                    "flow_type" => ___decrypt($request->flow_type),
                    "mass_flow" => $request->mass_flow,
                    "unit_type" => ___decrypt($request->unit_type),
                    "io" => $request->io,
                    "phase" => $request->phase
                ];
                if (empty($process_dataset->mass_basic_io)) {
                    $arr = [];
                } else {
                    $arr = $process_dataset->mass_basic_io;
                }
                array_push($arr, $data_arr);
            } else {
                $arr = $process_dataset->mass_basic_io;
                usort($arr, function ($a, $b) {
                    return $a['flow_type'] <=> $b['flow_type'];
                });
                $data_arr = [];
                $data_arr = [
                    "product" => ___decrypt($request->product),
                    "flow_type" => ___decrypt($request->flow_type),
                    "mass_flow" => $request->mass_flow,
                    "unit_type" => ___decrypt($request->unit_type),
                    "io" => $request->io,
                    "phase" => $request->phase
                ];
                $arr[$request->io_id] = $data_arr;
            }
            $process_dataset->mass_basic_io = $arr;
            $process_dataset->save();
            $this->status = true;
            $this->success = true;
            $this->modal = true;
            $this->redirect = url('/mfg_process/simulation');
            $this->message = "Product Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function DeleteBasicio(Request $request)
    {
        $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
        $arr = $process_dataset->mass_basic_io;
        usort($arr, function ($a, $b) {
            return $a['flow_type'] <=> $b['flow_type'];
        });
        unset($arr[$request->id]);
        $process_dataset->mass_basic_io = $arr;
        $process_dataset->save();
        $this->status = true;
        $this->modal = true;
        $this->redirect = url('/mfg_process/simulation');
        $this->message = "Product deleted Successfully!";
        return $this->populateresponse();
    }

    public function GetUnitConstant($id)
    {
        $energy_details = get_energy_details(___decrypt($id));
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
        $unit_type = MasterUnit::find($master_unit_id);
        $unit_constant = $unit_type->unit_constant;
        $html = view('pages.console.mfg_process.dataset.unit_constant_list', compact('unit_constant'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function SaveEnergyBasicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'energy' => 'required',
            'flow_type' => 'required',
            'energy_flow' => 'required',
            'unit_type' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
            if (!empty($process_dataset->energy_basic_io)) {
                $sort_arr = $process_dataset->energy_basic_io;
                usort($sort_arr, function ($a, $b) {
                    return $a['flow_type'] <=> $b['flow_type'];
                });
                foreach ($sort_arr as $key => $energy_basic_io) {
                    if ($energy_basic_io['flow_type'] == 1 && ___decrypt($request->flow_type) == 1  && $key != $request->io_id) {
                        $this->status = true;
                        $this->success = false;
                        $this->modal = true;
                        $this->redirect = url('/mfg_process/simulation');
                        $this->message = "Main feed product already exists";
                        return $this->populateresponse();
                    }
                    if ($energy_basic_io['flow_type'] == 3 && ___decrypt($request->flow_type) == 3 && $key != $request->io_id) {
                        $this->status = true;
                        $this->success = false;
                        $this->modal = true;
                        $this->redirect = url('/mfg_process/simulation');
                        $this->message = "Main product already exists";
                        return $this->populateresponse();
                    }
                    if ($energy_basic_io['energy'] == ___decrypt($request->energy) && $energy_basic_io['io'] == $request->io && $key != $request->io_id) {
                        $this->status = true;
                        $this->success = false;
                        $this->modal = true;
                        $this->redirect = url('/mfg_process/simulation');
                        $this->message = "Product already exists";
                        return $this->populateresponse();
                    }
                }
            }

            if ($request->io_id == '-1') {
                $data_arr = [];
                $data_arr = [
                    "energy" => ___decrypt($request->energy),
                    "flow_type" => ___decrypt($request->flow_type),
                    "energy_flow" => $request->energy_flow,
                    "unit_type" => ___decrypt($request->unit_type),
                    "io" => $request->io
                ];
                if (empty($process_dataset->energy_basic_io)) {
                    $arr = [];
                } else {
                    $arr = $process_dataset->energy_basic_io;
                }
                array_push($arr, $data_arr);
            } else {
                $arr = $process_dataset->energy_basic_io;
                usort($arr, function ($a, $b) {
                    return $a['flow_type'] <=> $b['flow_type'];
                });
                $data_arr = [];
                $data_arr = [
                    "energy" => ___decrypt($request->energy),
                    "flow_type" => ___decrypt($request->flow_type),
                    "energy_flow" => $request->energy_flow,
                    "unit_type" => ___decrypt($request->unit_type),
                    "io" => $request->io
                ];
                $arr[$request->io_id] = $data_arr;
            }
            $process_dataset->energy_basic_io = $arr;
            $process_dataset->save();
            $this->status = true;
            $this->success = true;
            $this->modal = true;
            $this->redirect = url('/mfg_process/simulation');
            $this->message = "Product Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function DeleteEnergyBasicio(Request $request)
    {
        $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
        $arr = $process_dataset->energy_basic_io;
        usort($arr, function ($a, $b) {
            return $a['flow_type'] <=> $b['flow_type'];
        });
        unset($arr[$request->id]);
        $process_dataset->energy_basic_io = $arr;
        $process_dataset->save();
        $this->status = true;
        $this->modal = true;
        $this->redirect = url('/mfg_process/simulation');
        $this->message = "Energy deleted Successfully!";
        return $this->populateresponse();
    }

    public function KeyProcessInfo(Request $request)
    {
        $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
        $keyinfo = [];
        $newsliterature = $request->newsliterature;
        $regulatoryinformatio = $request->regulatoryinformatio;
        $keyinfo['newsliterature'] = $newsliterature;
        $keyinfo['regulatoryinformatio'] = $regulatoryinformatio;
        $image = [];
        if(!empty($process_dataset['key_process_info']['image'])){
            foreach($process_dataset['key_process_info']['image'] as $img){
                $image[] = $img;
            }  
        }
        if (!empty($request->file) && $request->file != "undefined") {
            foreach($request->file as $cnt=>$file){
                $extension  = $file->getClientOriginalExtension();
                $file_name  = $file->getClientOriginalName();
                $backupLoc =  'assets/uploads/key_process_info';
                if (!is_dir($backupLoc)) {
                    mkdir($backupLoc, 0755, true);
                }
                $file->move($backupLoc, $file_name);
                $image[] = $backupLoc . '/' . $file_name;
            }  
        }
        $keyinfo['image'] = $image;
        $process_dataset->key_process_info = $keyinfo;
        $process_dataset->updated_by = Auth::user()->id;
        $process_dataset->save();
        $this->status = true;
        $this->success = true;
        $this->modal = true;
        $this->message = "Key Process Info Updated Successfully!";
        return $this->populateresponse();
    }

    public function QualAssesment(Request $request)
    {
        $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
        $process_dataset->quality_assesment = $request->quality_assesment;
        $process_dataset->updated_by = Auth::user()->id;
        $process_dataset->save();
        $this->status = true;
        $this->success = true;
        $this->modal = true;
        $this->message = "Qualitative Assesment Updated Successfully!";
        return $this->populateresponse();
    }

    public function getcapitalCost(Request $request)
    {
        $massflowrate = getUnit(10);
        $data['massflowrate'] = $massflowrate;
        $data['utilityflowtype'] = SimulationFlowType::where('type', 4)->get();
        $myunit = [];
        foreach ($massflowrate as $m => $mv) {
            if ($m == 13)
                $myunit[$m] = $mv;
        }
        $data['capitalcost_unit'] = $myunit;
        $flow_feed_product = SimulationFlowType::select('id', 'flow_type_name')->whereIn('id', [1, 3])->get();
        $feed_product = [];
        foreach ($flow_feed_product->toArray() as $fk => $fv) {
            $feed_product[$fv['id']] = $fv['flow_type_name'];
        }
        $data['capitalcost_flowtype'] = $feed_product;
        return view('pages.console.mfg_process.dataset.equipment_capital_cost.capital_cost_model')->with(compact('data'))->render();
    }

    public function getcapitalCosteditModel(Request $request)
    {
        if (isset($request['capid'])) {
            $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
            $editData = $process_dataset->equipment_capital_cost['equipment_capital_cost'][$request['capid']];
            $data["editData"] = $editData;
            $data['editid'] = $request['capid'];
            $data['action'] = 'edit';
        }
        $massflowrate = getUnit(10);
        $data['massflowrate'] = $massflowrate;
        $data['utilityflowtype'] = SimulationFlowType::where('type', 4)->get();
        $myunit = [];
        foreach ($massflowrate as $m => $mv) {
            if ($m == 13)
                $myunit[$m] = $mv;
        }
        $data['capitalcost_unit'] = $myunit;
        $flow_feed_product = SimulationFlowType::select('id', 'flow_type_name')->whereIn('id', [1, 3])->get();
        $feed_product = [];
        foreach ($flow_feed_product->toArray() as $fk => $fv) {
            $feed_product[$fv['id']] = $fv['flow_type_name'];
        }
        $data['capitalcost_flowtype'] = $feed_product;
        return view('pages.console.mfg_process.dataset.equipment_capital_cost.capital_cost_model')->with(compact('data'))->render();
    }

    public function getpps(Request $request)
    {
        if ($request->flowtype == "1") {
            $column = "main_feedstock";
        } else {
            $column = "main_product";
        }
        $value = [];
        $name = ProcessSimulation::select($column)->where('id', ___decrypt($request->process_id))->first();
        if (!empty($name)) {
            $chem = explode('_', $name[$column]);
            if ($chem[0] == "ch") {
                $selectchem = Chemical::select('id', 'chemical_name')->where('id', ___decrypt($chem[1]))->first();
                $value['name'] = $selectchem['chemical_name'];
                $value['id'] = $selectchem['id'];
            } else {
                $selectchem = EnergyUtility::select('id', 'energy_name')->where('id', $chem[1])->first();
                $value['name'] = $selectchem['energy_name'];
                $value['id'] = $selectchem['id'];
            }
        }
        return json_encode($value);
    }

    public function capitalCostSave(Request $request)
    {
        $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
        if ($request->getAction == "add") {
            if (!empty($process_dataset->equipment_capital_cost)) {
                $capExit = $process_dataset->equipment_capital_cost;
                $cap_cost = $capExit['equipment_capital_cost'];
                array_push($cap_cost, $request['capital_cost_eqp'][0]);
            } else {
                if (!empty($request->capital_cost_eqp)) {
                    $cap_cost = $request->capital_cost_eqp;
                } else {
                    $cap_cost = [];
                }
            }
            $this->message = "Record Added Successfully!";
        } elseif ($request->getAction == "delete") {
            $capExit = $process_dataset->equipment_capital_cost;
            $cap_cost = $capExit['equipment_capital_cost'];
            unset($cap_cost[$request->capId]);
            $cap_cost = array_merge($cap_cost);
            $this->message = "Record Deleted Successfully!";
        } elseif ($request->getAction == "isrecomended") {
            $capExit = $process_dataset->equipment_capital_cost;
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
            //dd($isrecArr);
            $cap_cost = $isrecArr;
            $this->message = "Record Updated Successfully!";
        } else {
            $capExit = $process_dataset->equipment_capital_cost;
            $cap_cost = $capExit['equipment_capital_cost'];
            $cap_cost[$request->capId] = $request['capital_cost_eqp'][0];
            $this->message = "Record Updated Successfully!";
        }
        $cap_cost_arr['equipment_capital_cost'] = $cap_cost;
        $process_dataset->equipment_capital_cost = $cap_cost_arr;
        $process_dataset->updated_by = Auth::user()->id;
        $process_dataset->save();
        $this->status = true;
        $this->success = true;
        $this->modal = true;
        return $this->populateresponse();
    }
    
    public function destroy(Request $request, $id)
    {
        ProcessProfile::find(___decrypt($request->id))->delete();
        $this->status = true;
        $this->redirect = url('/mfg_process/simulation');
        return $this->populateresponse();
    }

    public function BulkDelete(Request $request)
    {
        $id_string = implode(',', $request->ids);
        $id = explode(',', ($id_string));
        foreach ($id as $idval) {
            $ids[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProcessProfile::whereIn('id', $ids)->update($update)) {
            ProcessProfile::destroy($ids);
        }
        $this->status = true;
        $this->redirect = url('/mfg_process/simulation');
        return $this->populateresponse();
    }

    public function deleteKeyProcessInfoImg(Request $request){
        $process_dataset = ProcessProfile::find(___decrypt($request->dataset_id));
        $keyinfo = $process_dataset['key_process_info'];
        unset($keyinfo['image'][$request->id]);
        $process_dataset->key_process_info = $keyinfo;
        $process_dataset->updated_by = Auth::user()->id;
        $process_dataset->save();
        $this->status = true;
        $this->success = true;
        $this->modal = true;
        $this->message = "Key Process Info Image Deleted Successfully!";
        return $this->populateresponse();
    }
}
