<?php

namespace App\Http\Controllers\Console\ProductSystem\ProductSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\ProcessSimulation\SimulationType;
use App\Models\MFG\ProcessSimulation;
use App\Models\ProductSystem\ProductSystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\MFG\ProcessProfile;
use App\Models\ProductSystem\ProductSystemProfile;
use App\Models\Product\Chemical;
use App\Models\OtherInput\EnergyUtility;
use Illuminate\Support\Facades\Redis;

class ProductSystemController extends Controller
{
    public function index()
    {
        $proccess_simulation_count = ProcessSimulation::where('status', 'active')->count();
        $product_systems = ProductSystem::where('tenant_id', session()->get('tenant_id'))->orderBy('id', 'DESC')->get();
        $data = [];
        if (!empty($product_systems)) {
            foreach ($product_systems as $key => $val) {
                $data[$key]['id'] = $val['id'];
                $data[$key]['name'] = $val['name'];
                $data[$key]['description'] = $val['description'];
                $data[$key]['status'] = $val['status'];
                $prd = $val['process'];
                if (!empty($prd)) {
                    $sinIds = array_column($prd, 'process_sim');
                    $processIds = ProcessSimulation::select(['id', 'process_name'])->find($sinIds);

                    $data[$key]['count'] = count($processIds->toArray());
                } else {
                    $data[$key]['count'] = 0;
                }
            }
        }
        return view('pages.console.product_system.product_system.index', compact('data', 'proccess_simulation_count'));
    }

    public function create()
    {
        $data['process_simulation'] = ProcessSimulation::where('status', 'active')->get();
        if ($productSystem = Redis::get('productSystemSimulation' . Auth::user()->id))
            Redis::del(Redis::keys('productSystemSimulation' . Auth::user()->id));
        return view('pages.console.product_system.product_system.create', $data);
    }

    public function processList(Request $request, $simulation = '')
    {
        if (empty($simulation)) {
            $simulation = $request->parameters;
        }

        $process_simulations = ProcessProfile::where([['simulation_type', ___decrypt($simulation)]])->get();
        $data = [];
        foreach ($process_simulations as $key => $value) {
            if ($value->processSimulation) {
                $data[$value->id]['process_name'] = $value->processSimulation->process_name;
                $data[$value->id]['id'] = $value->processSimulation->id;
            }
        }
        return response()->json([
            'status' => true,
            'html' => view("pages.console.product_system.product_system.process-simulation", ['count' => $request->count, 'data' => $data])->render()
        ]);
    }

    public function productSimulationTypelist(Request $request, $process_id = '')
    {
        if (empty($process_id)) {
            $process_id = $request->parameters;
        }
        $proccess_simulation = ProcessSimulation::where('id', ___decrypt($process_id))->first();
        if (Redis::get('ProcessSimulation_id' . ___decrypt($process_id)))
            Redis::del(Redis::keys('ProcessSimulation_id' . ___decrypt($process_id)));
        Redis::set('ProcessSimulation_id' . ___decrypt($process_id), json_encode($proccess_simulation));
        
        if(!empty($request->report)){
            $process_dataset = ProcessProfile::select('simulation_type')->groupBy('simulation_type')->where([['process_id', ___decrypt($process_id)],['status','active']])->with('SimulationType')->get();
            if(count($process_dataset)>0){
                return response()->json([
                    'status' => true,
                    'html' => view("pages.console.product_system.product_system.simulation_type_select", compact('process_dataset'))->render()
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'html' => view("pages.console.product_system.product_system.simulation_type_select", compact('process_dataset'))->render()
                ]);
            } 
        }
        $process_dataset = ProcessProfile::select('simulation_type')->groupBy('simulation_type')->where([['process_id', ___decrypt($process_id)]])->with('SimulationType')->get();
        return response()->json([
            'status' => true,
            'html' => view("pages.console.product_system.product_system.simulation_type_select", compact('process_dataset'))->render()
        ]);
    }

    public function processSimulationDatasetList(Request $request, $simulation_type = '', $extra = '')
    {
        if (empty($simulation_type)) {
            $simulation_type = $request->parameters;
        }
       
        $SimulationType = SimulationType::where(['id' => ___decrypt($simulation_type)])->first();
        if (Redis::get('SimulationType_id' . ___decrypt($simulation_type)))
            Redis::del(Redis::keys('SimulationType_id' . ___decrypt($simulation_type)));
        Redis::set('SimulationType_id' . ___decrypt($simulation_type), json_encode($SimulationType));
        $process_dataset = ProcessProfile::select('id', 'dataset_name')->where([['simulation_type', ___decrypt($simulation_type)], ['process_id', ___decrypt($request->extra)]])->get();
      
        return response()->json([
            'status' => true,
            'html' => view("pages.console.product_system.product_system.process-dataset-select", compact('process_dataset'))->render()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $prdData = new ProductSystem();
            $prdData->tenant_id = session()->get('tenant_id');
            $prdData->name  = $request->name;
            $data = array();
            if ($productSystem = Redis::get('productSystemSimulation' . Auth::user()->id)) {
                $i = 0;
                foreach (json_decode($productSystem) as $key => $pro) {
                    $row = array(
                        "id" => $key,
                        "process_sim" => ___decrypt($pro->process_simulation),
                        "simulation" => ___decrypt($pro->simulation_type),
                        "dataset" => ___decrypt($pro->dataset),
                    );
                    $data[$i] = $row;
                    $i++;
                }
                Redis::del(Redis::keys('productSystemSimulation' . Auth::user()->id));
                Redis::set('productSystemSimulation' . Auth::user()->id, json_encode($data), 'EX', 1800);
            }
            // if (!empty($request->simulation)) {
            //     foreach ($request->simulation as $key => $expval) {
            //         foreach ($request->process_sim as $keyexp => $exp) { {
            //                 $val_en[$key]['id'] = json_encode($key);
            //                 $val_en[$key]['simulation'] = ___decrypt($expval);
            //                 $val_en[$keyexp]['process_sim'] = ___decrypt($exp);
            //             }
            //         }
            //         $prdData->process  = $val_en;
            //     }
            // }
            $prdData->process  = $data;
            $prdData->description = $request->description;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $prdData['tags'] = $tags;
            $prdData->created_by = Auth::user()->id;
            $prdData->updated_by = Auth::user()->id;
            if (sizeof($data) > 0) {
                $prdData->save();
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('/product_system/product');
                $this->message = "Process System  Added Successfully!";
            } else {
                $this->status = true;
                $this->modal = true;
                $this->redirect = 'reload_fail';
                $this->message = "Atleast one simulation process data is required";
            }
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $dataEdit = ProductSystem::find(___decrypt($id));
        $profilelist = ProductSystemProfile::where([['product_system_id', ___decrypt($id)]])->get();
        $pdata = [];
        if (!empty($profilelist)) {
            foreach ($profilelist as $pk => $pv) {
                $pdata[$pk]['profile_id'] = $pv['id'];
                $pdata[$pk]['product_system_id'] = $pv['product_system_id'];
                $processIds = ProcessSimulation::select(['id', 'process_name'])->where('id', $pv['process_id'])->first();
                $pdata[$pk]['process'] = $processIds['process_name'];
                if (!empty($pv['product_input'])) {
                    foreach ($pv['product_input'] as $ik => $iv) {
                        $expld = explode('_', $iv);
                        if ($expld[0] == "ch") {
                            $selectchem = Chemical::select('id', 'chemical_name')->where('id', $expld[1])->first();
                            $value = $selectchem['chemical_name'];
                        } else {
                            $selectchem = EnergyUtility::select('id', 'energy_name')->where('id', $expld[1])->first();
                            $value = $selectchem['energy_name'];
                        }
                        $pdata[$pk]['prd_input'][] = $value;
                    }
                }
                if (!empty($pv['product_output'])) {
                    foreach ($pv['product_output'] as $ok => $ov) {
                        $expld = explode('_', $ov);
                        if ($expld[0] == "ch") {
                            $selectchem = Chemical::select('id', 'chemical_name')->where('id', $expld[1])->first();
                            $value = $selectchem['chemical_name'];
                        } else {
                            $selectchem = EnergyUtility::select('id', 'energy_name')->where('id', $expld[1])->first();
                            $value = $selectchem['energy_name'];
                        }
                        $pdata[$pk]['prd_output'][] = $value;
                    }
                }
            }
        }
        $data['profilelist'] =  $pdata;
        $data['id'] = $dataEdit['id'];
        $data['name'] = $dataEdit['name'];
        $prd = $dataEdit['process'];
        $sinIds = array_column($prd, 'process_sim');
        $processIds = ProcessSimulation::select(['id', 'process_name'])->find($sinIds);
        $data['process'] = $processIds->toArray();
        $data['count'] = count($processIds->toArray());
        $data['description'] = $dataEdit['description'];
        $data['updated_at'] = $dataEdit['updated_at'];
        return view('pages.console.product_system.product_system.view', compact('data'));
    }

    public function simulationproduct(Request $request)
    {
        $process_simulations = ProductSystemProfile::where([['product_system_id', $request->prd_id], ['process_id', $request->id]])->get();
        $pscnt = 0;
        $pscnt = count($process_simulations);
        if ($pscnt == 0) {
            $processdata = ProcessSimulation::select(['id', 'product', 'energy'])->find($request->id);
            $eng = getEnergyHelper($request->id);
            $chem = getChemicalHelper($request->id);
            $chemdata = [];
            foreach ($chem as $chemKey => $chemVal) {
                $chemdata[$chemKey]['id'] = "ch_" . $chemVal['id'];
                $chemdata[$chemKey]['product'] = $chemVal['chemical_name'];
            }
            $engdata = [];
            foreach ($eng as $engKey => $engVal) {
                $engdata[$engKey]['id'] = "en_" . $engVal['id'];
                $engdata[$engKey]['product'] = $engVal['energy_name'];
            }
            $productEng = array_merge($chemdata, $engdata);
            return json_encode($productEng);
        } else {
            $html = ["err" => "Process Already Selected"];
            return json_encode($html);
        }
    }

    public function showSimulationConfig($id)
    {
        return redirect()->to('/mfg_process/simulation/' . $id);
    }

    public function edit($id)
    {
        $data['process_simulation'] = ProcessSimulation::where('status', 'active')->get();
        $data['simulation_types'] = SimulationType::get();
        $dataEdit = ProductSystem::find(___decrypt($id));
        $editData = [];
        $editData['id'] = $dataEdit['id'];
        $editData['name'] = $dataEdit['name'];
        $prd = $dataEdit['process'];
        $dataSim = [];
        if (!empty($prd)) {
            foreach ($prd  as $jk => $jv) {
                $simName = SimulationType::where('id', $jv['simulation'])->first();
                $dataSim[$jk]['simulation_type'] = ___encrypt($jv['simulation']);
                $dataSim[$jk]['simulation_type_name'] = $simName['simulation_name'];
                $processName = ProcessSimulation::where('id', $jv['process_sim'])->first();
                $dataSim[$jk]['process_simulation'] = ___encrypt($jv['process_sim']);
                $dataSim[$jk]['process_simulation_name'] = $processName['process_name'];
                $dataset = ProcessProfile::where('id', $jv['dataset'])->first();
                $dataSim[$jk]['dataset'] = ___encrypt($jv['dataset']);
                $dataSim[$jk]['dataset_name'] = $dataset['dataset_name'];
            }
        }
        if ($productSystem = Redis::get('productSystemSimulation' . Auth::user()->id)) {
            Redis::del(Redis::keys('productSystemSimulation' . Auth::user()->id));
            Redis::set('productSystemSimulation' . Auth::user()->id, json_encode($dataSim), 'EX', 1800);
        }
        // if (!empty($prd)) {
        //     foreach ($prd  as $jk => $jv) {
        //         $simName = SimulationType::where('id', $jv['simulation'])->first();
        //         $dataSim[$jk]['simtype_id'] = $simName['id'];
        //         $dataSim[$jk]['simulation_name'] = $simName['simulation_name'];
        //         $processName = ProcessSimulation::where('id', $jv['process_sim'])->first();
        //         $dataSim[$jk]['process_id'] = $processName['id'];
        //         $dataSim[$jk]['process_name'] = $processName['process_name'];
        //     }
        // }
        $editData['process'] = $dataSim;
        $editData['tags'] = $dataEdit['tags'];
        $editData['description'] = $dataEdit['description'];
        $data['edit'] = $editData;
        return view('pages.console.product_system.product_system.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $prdData =   ProductSystem::find(___decrypt($id));
            $prdData->tenant_id = session()->get('tenant_id');
            $prdData->name  = $request->name;
            $data = array();
            if ($productSystem = Redis::get('productSystemSimulation' . Auth::user()->id)) {
                $i = 0;
                foreach (json_decode($productSystem) as $key => $pro) {
                    $row = array(
                        "id" => $key,
                        "process_sim" => ___decrypt($pro->process_simulation),
                        "simulation" => ___decrypt($pro->simulation_type),
                        "dataset" => ___decrypt($pro->dataset),
                    );
                    $data[$i] = $row;
                    $i++;
                }
                Redis::del(Redis::keys('productSystemSimulation' . Auth::user()->id));
                Redis::set('productSystemSimulation' . Auth::user()->id, json_encode($data), 'EX', 1800);
            }
            // if (!empty($request->simulation)) {
            //     foreach ($request->simulation as $key => $expval) {
            //         foreach ($request->process_sim as $keyexp => $exp) { {
            //                 $val_en[$key]['id'] = json_encode($key);
            //                 $val_en[$key]['simulation'] = ___decrypt($expval);
            //                 $val_en[$keyexp]['process_sim'] = ___decrypt($exp);
            //             }
            //         }
            //         $prdData->process  = $val_en;
            //     }
            // }
            $prdData->process  = $data;
            $prdData->description = $request->description;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $prdData['tags'] = $tags;
            $prdData->updated_at = now();
            $prdData->updated_by = Auth::user()->id;
            $prdData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/product_system/product');
            $this->message = "Product System  Updated Successfully!";
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
            $update = ProductSystem::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ProductSystem::where('id', ___decrypt($id))->update($update)) {
                ProductSystem::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('/product_system/product');
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
        if (ProductSystem::whereIn('id', $processIDS)->update($update)) {
            ProductSystem::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('/product_system/product');
        return $this->populateresponse();
    }

    public function addMore(Request $request)
    {
        if ($request->has('remove')) {
            $rkey = $request->remove;
            $data = array();
        } else {
          
            $data[0] = array(
                "process_simulation" => $request->process_simulation,
                "process_simulation_name" => json_decode(Redis::get('ProcessSimulation_id' . ___decrypt($request->process_simulation)))->process_name,
                "simulation_type_name" => json_decode(Redis::get('SimulationType_id' . ___decrypt($request->simulation_type)))->simulation_name,
                "simulation_type" => $request->simulation_type,
                "dataset" => $request->dataset,
                "dataset_name" => json_decode(Redis::get('ProcessProfile_id' . ___decrypt($request->dataset)))->dataset_name
            );
        }
        $tbl = "";
        if ($productSystem = Redis::get('productSystemSimulation' . Auth::user()->id)) {
            $i = isset($rkey) ? 0 : 1;
            foreach (json_decode($productSystem) as $key => $pro) {
                if (isset($rkey)) {
                    if ($rkey == $key)
                        continue;
                }
                $row = array(
                    "process_simulation" => $pro->process_simulation,
                    "process_simulation_name" => json_decode(Redis::get('ProcessSimulation_id' . ___decrypt($pro->process_simulation)))->process_name,
                    "simulation_type_name" => json_decode(Redis::get('SimulationType_id' . ___decrypt($pro->simulation_type)))->simulation_name,
                    "simulation_type" => $pro->simulation_type,
                    "dataset" => $pro->dataset,
                    "dataset_name" => json_decode(Redis::get('ProcessProfile_id' . ___decrypt($pro->dataset)))->dataset_name
                );
                $data[$i] = $row;
                $i++;
            }
            Redis::del(Redis::keys('productSystemSimulation' . Auth::user()->id));
            Redis::set('productSystemSimulation' . Auth::user()->id, json_encode($data), 'EX', 1800);
        } else {
            Redis::set('productSystemSimulation' . Auth::user()->id, json_encode($data), 'EX', 1800);
        }
        return response()->json([
            'status' => true,
            'html' => view("pages.console.product_system.product_system.simulation-process", ['simulation_data' => $data])->render()
        ]);
    }
    public function deleteAddedSimulationproccess($id)
    {
        $tbl = "";
        $data = array();
        if ($productSystem = Redis::get('productSystemSimulation' . Auth::user()->id)) {
            $i = 1;
            foreach (json_decode($productSystem) as $key => $pro) {
                if ($key == $id)
                    continue;
                $row = array(
                    "process_simulation" => $pro->process_simulation,
                    "process_simulation_name" => json_decode(Redis::get('ProcessSimulation_id' . ___decrypt($pro->process_simulation)))->process_name,
                    "simulation_type_name" => json_decode(Redis::get('SimulationType_id' . ___decrypt($pro->simulation_type)))->simulation_name,
                    "simulation_type" => $pro->simulation_type,
                    "dataset" => $pro->dataset,
                    "dataset_name" => json_decode(Redis::get('ProcessProfile_id' . ___decrypt($pro->dataset)))->dataset_name
                );
                // $tbl.="
                // <tr>
                //     <td>". json_decode(Redis::get('ProcessSimulation_id'.___decrypt($pro->process_simulation)))->process_name. "</td>
                //     <td>". json_decode(Redis::get('SimulationType_id'.___decrypt($pro->simulation_type)))->simulation_name. "</td>
                //     <td>". json_decode(Redis::get('ProcessProfile_id'.___decrypt($pro->dataset)))->dataset_name. "</td>
                // </tr>
                // ";
                $data[$i] = $row;
                $i++;
            }
            Redis::del(Redis::keys('productSystemSimulation' . Auth::user()->id));
            Redis::set('productSystemSimulation' . Auth::user()->id, json_encode($data), 'EX', 1800);
        }
        return response()->json([
            'status' => true,
            'redirect' => 'reload_fail',
            'html' => view("pages.console.product_system.product_system.simulation-process", ['simulation_data' => $data])->render()
        ]);
    }

    /*public function addMore(Request $request)
    {
    
        if (!empty($request->simulation)) {
            $simtypeArr = explode(",", $request->simulation);
        }
        if (!empty($request->process_sim)) {
            $processSimArr = explode(",", $request->process_sim);
        }
        $simul_type = !empty($request->simulation_type) ? ___decrypt($request->simulation_type) : '';
        $pro_sim = !empty($request->process_simulation) ? ___decrypt($request->process_simulation) : '';
        $flag = 0;
        if (!empty($simtypeArr)) {
            foreach ($simtypeArr as $typek => $typeval) {
                if (___decrypt($typeval) ==  $simul_type && ___decrypt($processSimArr[$typek]) ==  $pro_sim) {
                    $flag = 1;
                }
            }
        }
        if ($request->process_simulation == NULL || $request->simulation_type == NULL) {
            exit;
        }
        if ($flag == 1) {
            return response()->json([
                'status' => false,
                'msg' => "Simulation Type And Process Already exits"
            ]);
            exit;
        }
        if (!empty($request->process_simulation)) {
            $process_simulations = ProcessSimulation::where(['id' => ___decrypt($request->process_simulation)])->first();
            $data['process_name'] = $process_simulations['process_name'];
            $data['process_id'] = $process_simulations['id'];
        } else {
            $data['process_name'] = "";
            $data['process_id'] = "";
        }
        if (!empty($request->simulation_type)) {
            $SimulationType = SimulationType::where(['id' => ___decrypt($request->simulation_type), 'status' => 'active'])->first();
            $data['simulation_name'] = $SimulationType->simulation_name;
            $data['simulation_id'] = $SimulationType->id;
        } else {
            $data['simulation_name'] = '';
            $data['simulation_id'] = '';
        }
        return response()->json([
            'status' => true,
            'html' => view("pages.console.product_system.product_system.simulation-process", ['count' => $request->count, 'simulation_data' => $data])->render()
        ]);
    }*/

    public function get_product_system_info(Request $request){
        try {
            $product_system_info = [];
            $profile = [];
            $product_system = ProductSystem :: find($request->product_system_id);
            if(!empty($product_system)){
                $product_system_profile = ProductSystemProfile :: where('product_system_id',$request->product_system_id)->get();
                if(!empty($product_system_profile)){
                    foreach($product_system_profile as $cnt=>$ps_profile){
                        $product_input = [];
                        $product_output = [];
                        if(!empty($ps_profile['product_input'])){
                            foreach($ps_profile['product_input'] as $pro_input){
                                $input = explode("_", $pro_input);
                                if ($input[0] == "ch") {
                                    $property = get_product_properties_helper($input[1]);
                                    $selectchem = Chemical::select('chemical_name')->where('id', $input[1])->first();
                                    $name = !is_null($selectchem) ? $selectchem['chemical_name'] : '';
                                } else {
                                }
                                $product_input[] = [
                                    "id" => $input[1],
                                    "name" => $name,
                                    "property" => $property
                                ];
                            }
                        }
                        if(!empty($ps_profile['product_output'])){
                            foreach($ps_profile['product_output'] as $pro_output){
                                $output = explode("_", $pro_output);
                                if ($output[0] == "ch") {
                                    $property = get_product_properties_helper($output[1]);
                                    $selectchem = Chemical::select('chemical_name')->where('id', $output[1])->first();
                                    $name = !is_null($selectchem) ? $selectchem['chemical_name'] : '';
                                } else {
                                }
                                $product_output[] = [
                                    "id" => $output[1],
                                    "name" => $name,
                                    "property" => $property
                                ];
                            }
                        }
                        if(!empty($product_system['process'])){
                            foreach($product_system['process'] as $process){
                                if($process['process_sim']==$ps_profile['process_id']){
                                    $process_sim_info = get_ps_profile_stage_info($process['dataset']);
                                }
                            }
                        }
                        $profile[]=[
                            "profile_id" => $ps_profile['id'],
                            "process_number" => $cnt+1,
                            "process_info" => $process_sim_info,
                            "product_input" => $product_input,
                            "product_output" => $product_output
                        ];
                        // get_ps_profile_stage_info
                    }
                }
                $product_system_info = [
                    "product_system_name"=>$product_system['name'],
                    "profile" => $profile
                ];
            }
            if(!empty($product_system_info)){
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'status' => true,
                    'data' => $product_system_info
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
}
