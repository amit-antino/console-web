<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Classes\ExperimentCommon;
use App\Classes\VariationCommon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Chemical;
use App\Models\Organization\Experiment\ExperimentCategory;
use App\Models\Organization\Experiment\ExperimentClassification;
use App\Models\ProcessExperiment\ExperimentUnit;
use App\Models\ProcessExperiment\ProcessExperiment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\ProcessSimulation\SimulationFlowType;
use App\Models\Experiment\ExperimentConditionMaster;
use App\Models\Master\MasterUnit;
use App\Models\Experiment\ExperimentOutcomeMaster;
use App\Models\OtherInput\Reaction;
use App\Models\ProcessExperiment\ProcessExpProfile;
use App\Models\ProcessExperiment\ProcessExpProfileMaster;
use App\Models\ProcessExperiment\SimulateDataset;
use App\Models\Product\ChemicalProperties;
use App\Models\Organization\Experiment\EquipmentUnit;
use App\Models\Experiment\ProcessDiagram;
use App\Models\OtherInput\EnergyUtility;
use App\Models\ProcessExperiment\ProcessExpEnergyFlow;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\ProcessExperiment\Variation;
use App\Models\Tenant\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Support\Facades\Redis;

class ProcessExperimentController extends Controller
{
    public function index($redis_update = '')
    {
        $expCommon = new ExperimentCommon();
        $process_exp_list = $expCommon->experiment_list($redis_update);
        return view('pages.console.experiment.experiment.index')->with('process_exp_list', $process_exp_list);
    }

    public function create()
    {
        if (Auth::user()->role == 'console') {
            $data['experiment_units'] = ExperimentUnit::where('created_by', Auth::user()->id)->where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
            $data['chemicals'] = Chemical::where('created_by', Auth::user()->id)->where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        } else {
            $data['experiment_units'] = ExperimentUnit::where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
            $data['chemicals'] = Chemical::where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        }
        $projects = Project::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $new_pro = [];
        if (Auth::user()->role == 'admin') {
            if (!empty($projects)) {
                foreach ($projects as $key => $project) {
                    $new_pro[$key]['id'] = $project['id'];
                    $new_pro[$key]['name'] = $project['name'];
                }
            }
        } else {
            if (!empty($projects)) {
                foreach ($projects as $key => $project) {
                    if (in_array(Auth::user()->id, $project['users'])) {
                        $new_pro[$key]['id'] = $project['id'];
                        $new_pro[$key]['name'] = $project['name'];
                    }
                }
            }
        }
        $data['projects'] = $new_pro;
        $data['energy'] = EnergyUtility::where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        $data['experiment_categories'] = ExperimentCategory::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $data['experiment_classifications'] = ExperimentClassification::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        return view('pages.console.experiment.experiment.create', $data);
    }

    public function exp_unit_add_more(Request $request)
    {
        if (Auth::user()->role == 'console') {
            $experiment_units = ExperimentUnit::where('created_by', Auth::user()->id)->where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        } else {
            $experiment_units = ExperimentUnit::where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        }
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.experiment_unit', [
                'count' => $request->count,
                'experiment_units' => $experiment_units,
            ])->render()
        ]);
    }

    public function store(Request $request)
    {
        Validator::extend('name_validation', function ($attr, $value) {
            return preg_match('/^[\s\w-]*$/', $value);
        });
        $validator = Validator::make(
            $request->all(),
            [
                'experiment_name' => 'required|name_validation',
                //'project' => 'required',
                'product' => 'required',
                'main_product_input' => 'required',
                'main_product_output' => 'required',
                'unit.*.unit' => 'required',
                'unit.*.exp_unit' => 'required'
            ],
            [
                'unit.*.unit.required' => 'Unit field is required',
                'unit.*.exp_unit.required' => ' Experiment Unit field is required',
                'experiment_name.name_validation' => 'The experiment name only contain letters and numbers'
            ]
        );
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            try {
                $expData = new ProcessExperiment();
                $expData->process_experiment_name = $request->experiment_name;
                $expData->tenant_id = session()->get('tenant_id');
                $expData->project_id = !empty($request->project) ? ___decrypt($request->project) : 0;
                $expData->category_id = !empty($request->category_id) ? ___decrypt($request->category_id) : 0;
                $chemicals = [];
                if (!empty($request->product)) {
                    foreach ($request->product as $chem) {
                        $chemicals[] = ___decrypt($chem);
                    }
                }
                $energy = [];
                if (!empty($request->energy)) {
                    foreach ($request->energy as $eng) {
                        $energy[] = ___decrypt($eng);
                    }
                }
                $main_product_outputs = [];
                if (!empty($request->main_product_output)) {
                    foreach ($request->main_product_output as $main_pro_outputs) {
                        $main_product_outputs[] = ___decrypt($main_pro_outputs);
                    }
                }
                $main_product_inputs = [];
                if (!empty($request->main_product_input)) {
                    foreach ($request->main_product_input as $main_pro_input) {
                        $main_product_inputs[] = ___decrypt($main_pro_input);
                    }
                }
                $classification_id = [];
                if (!empty($request->classification_id)) {
                    foreach ($request->classification_id as $classification) {
                        $classification_id[] = ___decrypt($classification);
                    }
                }
                $expData->energy_id = $energy;
                $expData->chemical = $chemicals;
                $expData->main_product_input = $main_product_inputs;
                $expData->main_product_output = $main_product_outputs;
                $val_en = [];
                if (!empty($request->unit)) {
                    foreach ($request->unit as $key => $expval) {
                        if (!empty($expval['unit'])) {
                            $val_en[$key]['id'] = json_encode($key + 1);
                            $val_en[$key]['exp_unit'] = !empty($expval['exp_unit']) ? ___decrypt($expval['exp_unit']) : '';
                            $val_en[$key]['unit'] = $expval['unit'];
                            $val_en[$key]['created_by'] = Auth::user()->id;
                        }
                    }
                    $expData->experiment_unit  = $val_en;
                }
                $expData->data_source = $request->data_source;
                $expData->classification_id = $classification_id;
                $expData->description = $request->description;
                if ($request->tags != "") {
                    $tags = explode(",", $request->tags);
                } else {
                    $tags = [];
                }
                $expData->tags = $tags;
                $expData->status = 'active';
                $expData->created_by = Auth::user()->id;
                $expData->updated_by = Auth::user()->id;
                $expData->save();
                $this->index('redis_update');
                $this->manage(___encrypt($expData->id), 'redis_update');
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('/experiment/experiment');
                $this->message = "New Experiment is Created Successfully";
            } catch (\Exception $e) {
                $this->redirect = url('/experiment/experiment');
                $this->status = true;
                $this->modal = true;
                $this->successimage = "error";
                $this->message = $e->getMessage();
            }
        }
        return $this->populateresponse();
    }

    // public function cloneExp(Request $request)
    // {
    //     try {
    //         $clone = ProcessExperiment::find(___decrypt($request->process_experiment_id));
    //         $expData = $clone->replicate();
    //         $expData = new ProcessExperiment();
    //         if (isset($request->name)) {
    //             if (!empty($request->name)) {
    //                 $expData->process_experiment_name = $request->name;
    //             } 
    //         } 
    //         $exp_name;
    //         $expData->updated_by = Auth::user()->id;
    //         if ($expData->save()) {
    //             $pid = ___decrypt($request->process_experiment_id);
    //             $newpeId = $expData->id;
    //             $varcln = [];
    //             $simInput = [];
    //             $variation = Variation::where('experiment_id', $pid)->get();
    //             if (!empty($variation)) {
    //                 foreach ($variation as $vd) {
    //                     $variationClone = Variation::find($vd->id);
    //                     $variationNew = new ProcessExperiment();
    //                     $variationNew = $variationClone->replicate();
    //                     $variationNew->experiment_id=$newpeId;
    //                     $variationNew->updated_by = Auth::user()->id;
    //                     if($variationNew->save())
    //                     {

    //                     }
    //                 }
    //             }
    //         }
    //         $this->index('redis_update');
    //         $this->manage(___encrypt($expData->id), 'redis_update');
    //         $status = true;
    //         $message = "Clone Successfully!";
    //     } catch (\Exception $e) {
    //         $status = false;
    //         $message = $e->getMessage();
    //     }
    //     $response = [
    //         'success' => $status,
    //         'message' => $message
    //     ];
    //     return response()->json($response, 200);
    // }

    public function cloneExp(Request $request)
    {
        try {
            $clone = ProcessExperiment::find(___decrypt($request->process_experiment_id));
            $expData = new ProcessExperiment();
            $expData->tenant_id = !empty($clone->tenant_id) ? ($clone->tenant_id) : 0;
            $exp_name = "";
            if (isset($request->name)) {
                if (!empty($request->name)) {
                    $exp_name = $request->name;
                } else {
                    $exp_name = $clone->process_experiment_name;
                }
            } else {
                $exp_name = $clone->process_experiment_name;
            }
            $expData->process_experiment_name = $exp_name;
            $expData->category_id = !empty($clone->category_id) ? ($clone->category_id) : 0;
            $expData->project_id = !empty($clone->project_id) ? ($clone->project_id) : 0;
            $chemicals = [];
            if (!empty($clone->chemical)) {
                $expData->chemical = $clone->chemical;
            }
            $energy = [];
            if (!empty($clone->energy_id)) {
                $expData->energy_id = $clone->energy_id;
            }
            $main_product_outputs = [];
            if (!empty($clone->main_product_output)) {
                $main_product_outputs = $clone->main_product_output;
            }
            $expData->main_product_output = $main_product_outputs;
            $main_product_inputs = [];
            if (!empty($clone->main_product_input)) {
                $main_product_inputs = $clone->main_product_input;
            }
            $expData->main_product_input = $main_product_inputs;
            $classification_id = [];
            if (!empty($clone->classification_id)) {
                $classification_id = $clone->classification_id;
            }
            if (!empty($clone->experiment_unit)) {
                $expData->experiment_unit  = $clone->experiment_unit;
            }
            $expData->data_source = $clone->data_source;
            $expData->classification_id = $classification_id;
            $expData->description = $clone->description;
            $expData->tags = $clone->tags;
            $expData->status = 'active';
            $expData->created_by = Auth::user()->id;
            $expData->updated_by = Auth::user()->id;
            if ($expData->save()) {
                $pid = ___decrypt($request->process_experiment_id);
                $newpeId = $expData->id;
                $varcln = [];
                $simInput = [];
                $variation = Variation::where('experiment_id', $pid)->get();
                if (!empty($variation)) {
                    foreach ($variation as $vd) {
                        $varcln[] = clonevVariation($vd, $newpeId, $pid);
                    }
                }
            }
            $this->index('redis_update');
            $this->manage(___encrypt($expData->id), 'redis_update');
            $status = true;
            $message = "Clone Successfully!";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $response = [
            'success' => $status,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function cloneVariation(Request $request)
    {
        try {
            $clone = Variation::find(___decrypt($request->variation_id));
            $expData = new Variation();
            $var_name = "";
            if (isset($request->name)) {
                if (!empty($request->name)) {
                    $var_name = $request->name;
                } else {
                    $var_name = $clone->name;
                }
            } else {
                $var_name = $clone->name;
            }
            $expData->name = $var_name;
            $expData->experiment_id =  $clone->experiment_id;
            $expData->process_flow_table =  $clone->process_flow_table;
            $expData->process_flow_chart =  $clone->process_flow_chart;
            $expData->unit_specification =  $clone->unit_specification;
            $expData->models =  $clone->models;
            $expData->dataset =  $clone->dataset;
            $expData->datamodel =  $clone->datamodel;
            $expData->notes =  $clone->notes;
            $expData->description =  $clone->description;
            $expData->note_urls =  $clone->note_urls;
            $expData->status =     $clone->status;
            $expData->created_by = Auth::user()->id;
            $expData->updated_by = Auth::user()->id;
            if ($expData->save()) {
                $clnprodiagrams = ProcessDiagram::whereIn('id', $clone->process_flow_table)->where('process_id', $clone->experiment_id)->get();
                $expdiagrams = [];
                if ($clnprodiagrams) {
                    foreach ($clnprodiagrams as $clnprodiagram) {
                        $expdiagrams[] = cloneprocessdiagram($clnprodiagram, $clone->experiment_id);
                    }
                }
                $MasterUnit = [];
                if (!empty($clone->unit_specification['master_units'])) {
                    $varMasterUnits = explode(',', $clone->unit_specification['master_units']);
                    foreach ($varMasterUnits as $varMasterUnit) {
                        $MasterUnit[] = $varMasterUnit;
                    }
                }
                $clnmasterprofiles = ProcessExpProfileMaster::whereIn('id', $MasterUnit)->where('process_exp_id', $clone->experiment_id)->get();
                $masterprofiles = [];
                if ($clnmasterprofiles) {
                    foreach ($clnmasterprofiles as $clnmasterprofile) {
                        $masterprofiles[] = cloneExpprofilemaster($clnmasterprofile, $clone->experiment_id);
                    }
                }
                $clnexpprofiles = ProcessExpProfile::where(['variation_id' => $clone->id])->get();
                if (!empty($clnexpprofiles)) {
                    foreach ($clnexpprofiles as $clnexpprofile) {
                        $expprofile[] = cloneExpprofile($clnexpprofile, $clone->experiment_id, $expData->id);
                    }
                    $expprofiles = ProcessExpProfile::select('id')->where(['variation_id' => $expData->id])->get();
                }
                $arr = [];
                $var_data = Variation::where('id', $expData->id)->first();
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
                $simulationInput = SimulateInput::where(['experiment_id' => $clone->experiment_id, 'variation_id' => $clone->id])->get();
                if (!empty($simulationInput)) {

                    foreach ($simulationInput as $sd) {
                        $simInput[] = clonevsimulationInput($sd, $clone->experiment_id, $expData->id);
                    }
                }
            }
            $redis_variation = new VariationCommon();
            $redis_variation->variation_list($request, 'redis_update', $clone->experiment_id);
            $status = true;
            $message = "Clone Successfully!";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $response = [
            'success' => $status,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function clonesimInput(Request $request)
    {
        try {
            $clone = SimulateInput::find(___decrypt($request->siminput_id));
            $expData = new SimulateInput();
            $name = "";
            if (isset($request->name)) {
                if (!empty($request->name)) {
                    $name = $request->name;
                } else {
                    $name = $clone->name;
                }
            } else {
                $name = $clone->name;
            }
            $expData->name = $name;
            $expData->experiment_id =  $clone->experiment_id;
            $expData->variation_id =  $clone->variation_id;
            $expData->simulate_input_type =  $clone->simulate_input_type;
            $expData->raw_material =  $clone->raw_material;
            $expData->master_condition =  $clone->master_condition;
            $expData->master_outcome =  $clone->master_outcome;
            $expData->unit_condition =  $clone->unit_condition;
            $expData->unit_outcome =  $clone->unit_outcome;
            $expData->simulation_type =  $clone->simulation_type;
            $expData->notes =  $clone->notes;
            $expData->note_urls =  $clone->note_urls;
            $expData->status =     $clone->status;
            $expData->created_by = Auth::user()->id;
            $expData->updated_by = Auth::user()->id;
            $expData->save();
            $status = true;
            $message = "Clone Successfully!";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $response = [
            'success' => $status,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function show($id)
    {
        //try {
        $process_experiment = ProcessExperiment::find(___decrypt($id));
        $classifications = [];
        if (!empty($process_experiment->classification_id)) {
            foreach ($process_experiment->classification_id as $classification) {
                $classifications[] = experiment_classification($classification);
            }
        }
        $product_list = [];
        if (!empty($process_experiment->chemical)) {
            foreach ($process_experiment->chemical as $product) {
                $product_list[] = get_product_details($product);
            }
        }
        $main_product_inputs = [];
        if (!empty($process_experiment->main_product_input)) {
            foreach ($process_experiment->main_product_input as $main_product_input) {
                $main_product_inputs[] = get_product_details($main_product_input);
            }
        }
        $main_product_outputs = [];
        if (!empty($process_experiment->main_product_outpu)) {
            foreach ($process_experiment->main_product_output as $main_product_output) {
                $main_product_outputs[] = get_product_details($main_product_output);
            }
        }
        $energy_list = [];
        if (!empty($process_experiment->energy_id)) {
            foreach ($process_experiment->energy_id as $energy) {
                $energy_info = get_energy_details($energy);
                $energy_list[] = [
                    "energy_name" => $energy_info['name']
                ];
            }
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
        $process_experiment_info = [
            "id" => $process_experiment->id,
            "name" => !empty($process_experiment->process_experiment_name) ? $process_experiment->process_experiment_name : '',
            "category" => !empty($process_experiment->experiment_category->name) ? $process_experiment->experiment_category->name : '',
            "classification" => $classifications,
            "data_source" => $process_experiment->data_source,
            "product_list" => $product_list,
            "main_product_inputs" => $main_product_inputs,
            "main_product_outputs" => $main_product_outputs,
            "energy_list" => $energy_list,
            "experiment_units" => $experiment_units,
            "description" => $process_experiment->description,
            "tags" => $process_experiment->tags,
            "status" => $process_experiment->status
        ];
        // } catch (\Exception $e) {
        //     return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        // } catch (ModelNotFoundException $exception) {
        //     return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
        // } catch (RelationNotFoundException $r) {
        //     return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
        // }
        return view('pages.console.experiment.experiment.view')->with('process_experiment_info', $process_experiment_info);
    }

    public function SimulationConfig(Request $request, $id)
    {
        $variation = Variation::find(___decrypt($id));
        $data['process_experiment'] = ProcessExperiment::find($variation->experiment_id);
        if (!empty($request->apply_config)) {
            $data['simulate_input'] = SimulateInput::find(___decrypt($request->apply_config));
            $data['apply_config'] = $request->apply_config;
            if (!empty($data['simulate_input']['raw_material'])) {
                foreach ($data['simulate_input']['raw_material'] as $r_key => $raw_material) {
                    $process_diagram_data = ProcessDiagram::find($raw_material['pfd_stream_id']);
                    if (!empty($process_diagram_data['to_unit'])) {
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
                                $product[$pro_key]['value'] = !empty($pro['value']) ? $pro['value'] : 0;
                                $product[$pro_key]['criteria'] = !empty($pro['criteria']) ? $pro['criteria'] : 0;
                                $product[$pro_key]['criteria_name'] = get_criteria_name(!empty($pro['criteria']) ? $pro['criteria'] : 0);
                                $product[$pro_key]['max_value'] = !empty($pro['max_value']) ? $pro['max_value'] : 0;
                            }
                        }
                        $raw_material_data[$r_key]['product'] = $product;
                    }
                }
            }
            $data['raw_material'] = !empty($raw_material_data) ? $raw_material_data : [];
            $data['simulation_type'] = !empty($data['simulate_input']['simulation_type']) ? $data['simulate_input']['simulation_type'] : [];
        } else {
            $data['simulate_input'] = SimulateInput::Select('id', 'name', 'experiment_id', 'variation_id', 'raw_material', 'simulation_type', 'simulate_input_type', 'status')->where(['experiment_id' => $variation->experiment_id, 'variation_id' => $variation->id, 'simulate_input_type' => 'forward'])->orderBy('id', 'desc')->first();
            $data['simulate_input_reverse'] = SimulateInput::Select('id', 'name', 'experiment_id', 'variation_id', 'raw_material', 'simulation_type', 'simulate_input_type', 'status')->where(['experiment_id' => $variation->experiment_id, 'variation_id' => $variation->id, 'simulate_input_type' => 'reverse'])->orderBy('id', 'desc')->first();
            if (empty($data['simulate_input'])) {
                //   $data['open_popup'] = 'yes';
                $data['simulate_type_forward'] = 'forward';
            }
            if (empty($data['simulate_input_reverse'])) {
                // $data['open_popup'] = 'yes';
                $data['simulate_type_reverse'] = 'reverse';
            }
        }
        if (Auth::user()->role == 'console') {
            $simulation_list = SimulateInput::where('created_by', Auth::user()->id)->where(['experiment_id' => $variation->experiment_id, 'variation_id' => $variation->id])->orderBy('id', 'desc')->get();
        } else {
            $simulation_list = SimulateInput::where(['experiment_id' => $variation->experiment_id, 'variation_id' => $variation->id])->orderBy('id', 'desc')->get();
        }
        $simdata = [];
        if (!empty($simulation_list)) {
            foreach ($simulation_list as $key => $simulate) {
                $simdata[$key]['id'] = $simulate->id;
                $simdata[$key]['experiment_id'] = $simulate->experiment_id;
                $simdata[$key]['variation_id'] = $simulate->variation_id;
                $simdata[$key]['name'] = $simulate->name;
                $simdata[$key]['variation_name'] = $variation->name;
                $simdata[$key]['simulate_input_type'] = $simulate->simulate_input_type;
                $simdata[$key]['created_by'] = get_user_name($simulate->created_by);
                $simdata[$key]['updated_by'] = get_user_name($simulate->updated_by);
                $simdata[$key]['created_at'] = $simulate->created_at;
                $simdata[$key]['updated_at'] = $simulate->updated_at;
                $simdata[$key]['status'] = $simulate->status;
            }
        }
        $data['simulate_input_list'] = $simdata;
        $data['variation'] = $variation;
        $data['time_unit'] = MasterUnit::where('id', 14)->first();
        $parameters = request()->segment(4);
        $data['viewflag'] = $parameters;
        return view('pages.console.experiment.experiment.configuration.simulation_config', $data);
    }

    public function showExpMaster(Request $request)
    {
        try {
            $tnt_id = session()->get('tenant_id');
            $master_conditions = ExperimentConditionMaster::where(['status' => 'active', 'tenant_id' => $tnt_id])->with('unit_types')->get();
            $master_condition_list = [];
            foreach ($master_conditions as $condition) {
                $master_condition_list[] = [
                    "id" => $condition->id,
                    "name" => $condition->name,
                    "unit_type" => [
                        "unit_id" => !empty($condition->unit_types->id) ? $condition->unit_types->id : '',
                        "unit_name" => !empty($condition->unit_types->unit_name) ? $condition->unit_types->unit_name : '',
                        "default_unit" => !empty($condition->unit_types->default_unit) ? $condition->unit_types->default_unit : '',
                        "unit_constants" => !empty($condition->unit_types->unit_constant) ? $condition->unit_types->unit_constant : '',
                    ]
                ];
            }
            // Master Outcomes
            $master_outcomes = ExperimentOutcomeMaster::where(['status' => 'active', 'tenant_id' => $tnt_id])->with('unit_types')->get();
            $master_outcome_list = [];
            if (!empty($master_outcomes)) {
                foreach ($master_outcomes as $outcome) {
                    $master_outcome_list[] = [
                        "id" => $outcome->id,
                        "name" => $outcome->name,
                        "unit_type" => [
                            "unit_id" => !empty($outcome->unit_types->id) ? $outcome->unit_types->id : '',
                            "unit_name" => !empty($outcome->unit_types->unit_name) ? $outcome->unit_types->unit_name : '',
                            "unit_constants" => !empty($outcome->unit_types->unit_constant) ? $outcome->unit_types->unit_constant : '',

                        ]
                    ];
                }
            }
            // Reactions
            $reactions = Reaction::select('id', 'reaction_name')->get();
            $reaction_list = [];
            if (!empty($reactions)) {
                foreach ($reactions as $reaction) {
                    $reaction_list[] = [
                        "id" => $reaction['id'],
                        "name" => $reaction['reaction_name']
                    ];
                }
            }
            $data = [];
            $condata = [];
            $outdata = [];
            $recdata = [];
            $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
            $masteridd = 0;
            if (!empty($variton->unit_specification) && !empty($variton->unit_specification['master_units'])) {
                $masteridd = $variton->unit_specification['master_units'];
            }
            $pe_profile_master_data = ProcessExpProfileMaster::where('id', ($masteridd))->first();
            if (!empty($pe_profile_master_data)) {
                if (!empty($pe_profile_master_data->condition)) {
                    $condata = $pe_profile_master_data->condition;
                }
                if (!empty($pe_profile_master_data->outcome)) {
                    $outdata = $pe_profile_master_data->outcome;
                }
                if (!empty($pe_profile_master_data->reaction)) {
                    $recdata = $pe_profile_master_data->reaction;
                }
                // Existing Data in Table
                $data['mastercondition'] = $condata;
                $data['masteroutcome'] = $outdata;
                $data['masterreaction'] = $recdata;
                // Data that are needed to be displayed in the frontend
            }

            if (!empty($master_condition_list)) {
                $data['master_condition_list'] = $master_condition_list;
            }
            if (!empty($master_outcome_list)) {
                $data['master_outcome_list'] = $master_outcome_list;
            }
            if (!empty($reaction_list)) {
                $data['reaction_list'] = $reaction_list;
            }
            $html = view('pages.console.experiment.experiment.profile.master_exp_data', compact('data'))->render();
        } catch (\Exception $e) {
            //return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
            $html = view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile())->render();;
        } catch (ModelNotFoundException $exception) {
            // return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
            $html = view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile())->render();;
        } catch (RelationNotFoundException $r) {
            // return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
            $html = view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile())->render();;
        }
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function showExp(Request $request)
    {
        try {
            $tnt_id = session()->get('tenant_id');
            $id = $request->experiment_unit_id;
            $unit_name = $request->unit_tab_id;
            $data['unit_name'] = $unit_name;
            $data['puid'] = $id;
            $data['unit_tab_id'] = $request->unit_tab_id;
            $process_experiment = ProcessExperiment::find(___decrypt($request->process_experiment_id));
            // Master Conditions 
            $master_conditions = ExperimentConditionMaster::where(['status' => 'active', 'tenant_id' => $tnt_id])->with('unit_types')->get();
            $master_condition_list = [];
            foreach ($master_conditions as $condition) {
                $master_condition_list[] = [
                    "id" => $condition->id,
                    "name" => $condition->name,
                    "unit_type" => [
                        "unit_id" => !empty($condition->unit_types->id) ? $condition->unit_types->id : '',
                        "unit_name" => !empty($condition->unit_types->unit_name) ? $condition->unit_types->unit_name : '',
                        "default_unit" => !empty($condition->unit_types->default_unit) ? $condition->unit_types->default_unit : '',
                        "unit_constants" => !empty($condition->unit_types->unit_constant) ? $condition->unit_types->unit_constant : '',
                    ]
                ];
            }
            // Master Outcomes
            $master_outcomes = ExperimentOutcomeMaster::where(['status' => 'active', 'tenant_id' => $tnt_id])->with('unit_types')->get();
            $master_outcome_list = [];
            foreach ($master_outcomes as $outcome) {
                $master_outcome_list[] = [
                    "id" => $outcome->id,
                    "name" => $outcome->name,
                    "unit_type" => [
                        "unit_id" => !empty($outcome->unit_types->id) ? $outcome->unit_types->id : '',
                        "unit_name" => !empty($outcome->unit_types->unit_name) ? $outcome->unit_types->unit_name : '',
                        "unit_constants" => !empty($outcome->unit_types->unit_constant) ? $outcome->unit_types->unit_constant : '',
                    ]
                ];
            }
            // Reactions
            $reactions = Reaction::select('id', 'reaction_name')->get();
            $reaction_list = [];
            if (!empty($reactions)) {
                foreach ($reactions as $reaction) {
                    $reaction_list[] = [
                        "id" => $reaction['id'],
                        "name" => $reaction['reaction_name']
                    ];
                }
            }
            $experiment_unit_list = [];
            $product_list = [];
            $mass_flow_types = [];
            $pe_experiment_units = [];
            $condition_list = [];
            $outcome_list = [];
            $reactions = [];
            $exp_unit_id = [];
            $experiment_unit_list = [];
            if (!empty($process_experiment)) {
                foreach ($process_experiment->experiment_unit as $experiment_unit) {
                    if ($experiment_unit['id'] == ___decrypt($request->unit_tab_id)) {
                        $pe_experiment_units = [
                            "id" => $experiment_unit['id'],
                            "experiment_unit_name" => $experiment_unit['unit'],
                            "experiment_equipment_unit" => get_experiment_unit($experiment_unit['exp_unit']),
                        ];
                        $exp_unit_id = $experiment_unit['exp_unit'];
                    }
                }
                $product_list = [];
                if (!empty($process_experiment->chemical)) {
                    $product_infos = get_product_details_arr($process_experiment->chemical);
                    foreach ($product_infos as $pk => $product_info) {
                        $product_list[] = [
                            "product_id" => $product_info['id'],
                            "product_name" => $product_info['name'],
                        ];
                    }
                }
                foreach ($process_experiment->experiment_unit as $key => $experiment_unit_data) {
                    $experiment_unit_list[$key] = [
                        "id" => $experiment_unit_data['id'],
                        "name" => $experiment_unit_data['unit'],
                        "experiment_units" => get_experiment_unit_name($experiment_unit_data['exp_unit']),
                    ];
                }
                $flow_types = SimulationFlowType::all();
                foreach ($flow_types as $flow_type) {
                    $mass_flow_types[] = [
                        'id' => $flow_type['id'],
                        'name' => $flow_type['flow_type_name']
                    ];
                }
            }
            $expunit_condition = [];
            $expunit_outcome = [];
            if (!empty($pe_experiment_units)) {
                if (!empty($pe_experiment_units['experiment_equipment_unit'])) {
                    $expunit_condition = array_column($pe_experiment_units['experiment_equipment_unit']['condition'], 'id');
                }
                if (!empty($pe_experiment_units['experiment_equipment_unit'])) {
                    $expunit_outcome = array_column($pe_experiment_units['experiment_equipment_unit']['outcome'], 'id');
                }
            }
            $condition_list = [];
            $outcome_list = [];
            $reactions = [];
            $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
            $experiment_unitsid = [];
            if (!empty($variton) && !empty($variton->unit_specification)) {
                $experiment_unitsid = $variton->unit_specification['experiment_units'];
            }
            $pe_profile_data = ProcessExpProfile::where([[
                'process_exp_id', ___decrypt($request->process_experiment_id)
            ], [
                'experiment_unit', ___decrypt($request->unit_tab_id)
            ], ['variation_id', ___decrypt($request->vartion_id)]])->first();
            if (!empty($pe_profile_data)) {
                $expprofileId = $pe_profile_data->id;
            }
            if (isset($expprofileId) && in_array($expprofileId, $experiment_unitsid)) {
                if (!empty($pe_profile_data)) {
                    if (!empty($pe_profile_data->condition)) {
                        $condition_list = $pe_profile_data->condition;
                    }
                    if (!empty($pe_profile_data->outcome)) {
                        $outcome_list = $pe_profile_data->outcome;
                    }
                    if (!empty($pe_profile_data->reaction)) {
                        $reactions = $pe_profile_data->reaction;
                    }
                }
            } else {
                $condition_list = [];
                $outcome_list = [];
                $reactions = [];
            }
            $data['condition_list'] = $condition_list;
            $data['outcome_list'] = $outcome_list;
            $data['reactions'] = $reactions;
            // Existing Data in Table
            $data['expunit_condition'] = $expunit_condition;
            $data['expunit_outcome'] = $expunit_outcome;
            // Data that are needed to be displayed in the frontend
            $data['experiment_unit_list'] = $experiment_unit_list;
            $data['mass_flow_types'] = $mass_flow_types;
            $data['mass_flow_rate_unit_constant'] = getUnit(10);
            $data['product_list'] = $product_list;
            $data['experiment_units'] = $pe_experiment_units;
            $data['master_condition_list'] = $master_condition_list;
            $data['master_outcome_list'] = $master_outcome_list;
            $data['reaction_list'] = $reaction_list;
            $html = view('pages.console.experiment.experiment.profile.process_exp_data', compact('data'))->render();
        } catch (\Exception $e) {
            $html = view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile())->render();;
        } catch (ModelNotFoundException $exception) {
            $html = view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile())->render();;
        } catch (RelationNotFoundException $r) {
            $html = view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile())->render();;
        }
        return response()->json(['success' => true,  'html' => $html]);
    }

    // getProductAssociate
    public function getProductAssociate(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'dynamic_prop_json')->where([[
                'chemical_id', ___decrypt($request->value)
            ], [
                'property_id', 2
            ], [
                'sub_property_id', 3
            ]])->get();
            $jsonArr = [];
            $sum = 0;
            if (!empty(_arefy($product_props))) {
                foreach ($product_props as $key => $value) {
                    $obj = $value['dynamic_prop_json'];
                    $arrayName = [];
                    foreach ($value['dynamic_prop_json'] as $objkey => $objval) {
                        if ($objval['unit_name'] == "chemical_list") {
                            $jsonArr[$key]['chem_id'] = $objval['field_value'];
                            $chemName = Chemical::select('id', 'chemical_name')->where('id', $objval['field_value'])->first();
                            $jsonArr[$key]['chemical_name'] = $chemName['chemical_name'];
                            $jsonArr[$key]['unit_value'] = $objval['unit_value'];
                            $sum = $sum + $objval['unit_value'];
                        }
                    }
                }
            } else {
                $jsonArr[0]['chem_id'] = ___decrypt($request->value);
                $chemName = Chemical::select('id', 'chemical_name')->where('id', ___decrypt($request->value))->first();
                $jsonArr[0]['chemical_name'] = $chemName['chemical_name'];
                $jsonArr[0]['unit_value'] = 0;
                $sum = $sum;
            }
            $jsonArr['sum'] = $sum;
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $jsonArr
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

    public function getProductAssociateSimulation(Request $request)
    {
        try {
            $jsonArr = [];
            $sum = 0;
            $count = intval($request->count);
            if (!empty($request->parameters)) {
                $data = getAssociateValue($request->parameters);
                $jsonArr = $data['jsonArr'];
                $sum = $data['sum'];
            }
            $master_unit = MasterUnit::where('id', 10)->first();
            return response()->json([
                'status' => true,
                'html' => view('pages.console.experiment.experiment.configuration.simulation_output.raw_material.associate_chemical', ['jsonArr' => $jsonArr, 'total' => $sum, 'master_unit' => $master_unit['unit_constant'], 'count' => $count])->render()
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

    // /get_vartion_view

    public function get_vartion_view(Request $request)
    {
        //dd('get_vartion_view');
        // try {
        $process_experiment = ProcessExperiment::find(___decrypt($request['process_experiment_id']));
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
        $products = [];
        if (!empty($process_experiment->chemical)) {
            foreach ($process_experiment->chemical as $chemical) {
                $products[] = [
                    'id' => $chemical,
                    'name' => getsingleChemicalName($chemical)
                ];
            }
        }

        $mass_flow_types = [];
        $flow_types = SimulationFlowType::whereIn('type', [1, 2, 3])->get();
        if (!empty($flow_types)) {
            foreach ($flow_types as $flow_type) {
                $mass_flow_types[] = [
                    'id' => $flow_type['id'],
                    'name' => $flow_type['flow_type_name']
                ];
            }
        }
        $varitioname = Variation::select('id', 'name', 'process_flow_chart', 'status', 'updated_at')->where('id', ___decrypt($request->id))->first();
        $process_experiment_info = [
            "vartion_id" => ($request->id),
            "id" => ($process_experiment->id),
            "experiment_name" => $process_experiment->process_experiment_name,
            "vartion_name" => ($varitioname->name),
            "name" => ($varitioname->name),
            "var_img" => ($varitioname->process_flow_chart),
            "experiment_units" => $experiment_units,
            "experiment_id" => $request->process_experiment_id,
            "viewflag" => $request->viewflag,
            "status" => $varitioname->status,
            "updated_at" => $varitioname->updated_at,
            "mass_flow_types" => $mass_flow_types,
            "products" => $products

        ];
        // } catch (\Exception $e) {
        //     return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        // } catch (ModelNotFoundException $exception) {
        //     return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
        // } catch (RelationNotFoundException $r) {
        //     return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
        // }
        $parameters = 'manage';
        return view('pages.console.experiment.experiment.profile.variation_manage', compact('process_experiment_info', 'parameters'));
        // $html = view('pages.console.experiment.experiment.profile.variationlist', compact('process_experiment_info'))->render();
        //return response()->json(['success' => true,  'html' => $html]);
        // return view('pages.console.experiment.experiment.profile.configuration')->with('process_experiment_info', $process_experiment_info);
    }

    public function get_configuration_view(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find(___decrypt($request['process_experiment_id']));
            $experiment_units = [];
            if (!empty($process_experiment->experiment_unit)) {
                foreach ($process_experiment->experiment_unit as $experiment_unit) {
                    $experiment_units[] = [
                        "id" => $experiment_unit['id'],
                        "experiment_unit_name" => $experiment_unit['unit'],
                        "experiment_equipment_unit" => get_experiment_unit($experiment_unit['exp_unit'])
                    ];
                }
            }
            $process_experiment_info = [
                "id" => $process_experiment->id,
                "experiment_units" => $experiment_units,
                "viewflag" => $request->viewflag
            ];
        } catch (\Exception $e) {
            return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        } catch (ModelNotFoundException $exception) {
            return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
        } catch (RelationNotFoundException $r) {
            return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
        }
        $html = view('pages.console.experiment.experiment.profile.configuration', compact('process_experiment_info'))->render();
        return response()->json(['success' => true,  'html' => $html]);
        // return view('pages.console.experiment.experiment.profile.configuration')->with('process_experiment_info', $process_experiment_info);
    }

    public function get_profile_view(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find(___decrypt($request['process_experiment_id']));
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
            $classifications = [];
            if (!empty($process_experiment->classification_id)) {
                foreach ($process_experiment->classification_id as $classification) {
                    $classifications[] = experiment_classification($classification);
                }
            }

            $product_list = [];
            if (!empty($process_experiment->chemical)) {
                $product_list = get_product_details_arr($process_experiment->chemical);
            }

            $main_product_inputs = [];
            if (!empty($process_experiment->main_product_input)) {
                $main_product_inputs = get_product_details_arr($process_experiment->main_product_input);
            }
            $main_product_outputs = [];
            if (!empty($process_experiment->main_product_output)) {
                $main_product_outputs = get_product_details_arr($process_experiment->main_product_output);
            }
            $energy_list = [];
            $energy_infos = [];
            if (!empty($process_experiment->energy_id)) {
                $energy_infos = get_energy_details_arr($process_experiment->energy_id);
            }
            if (!empty($energy_infos)) {
                foreach ($energy_infos as $energy_info_key => $energy_info) {
                    $energy_list[] = [
                        "energy_name" => $energy_info['name']
                    ];
                }
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
            $process_experiment_info = [
                "id" => $process_experiment->id,
                "name" => $process_experiment->process_experiment_name,
                "category" => (!empty($process_experiment->category_id)) ? $process_experiment->experiment_category->name : '-',
                "classification" => $classifications,
                "data_source" => $process_experiment->data_source,
                "product_list" => $product_list,
                "main_product_inputs" => $main_product_inputs,
                "main_product_outputs" => $main_product_outputs,
                "energy_list" => $energy_list,
                "experiment_units" => $experiment_units,
                "description" => $process_experiment->description,
                "tags" => $process_experiment->tags,
                "updated_at" => $process_experiment->updated_at,
                "status" => $process_experiment->status
            ];
        } catch (\Exception $e) {
            return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        } catch (ModelNotFoundException $exception) {
            return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
        } catch (RelationNotFoundException $r) {
            return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
        }
        $html = view('pages.console.experiment.experiment.profile.profie_view', compact('process_experiment_info'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function get_experiment_variation(Request $request)
    {
        $viewflag = $request->viewflag;
        try {
            $variation = new VariationCommon();
            $process_experiment_info = $variation->variation_list($request);
        } catch (\Exception $e) {
            return view('pages.error.cusome_error')->with('listerror', $e->getMessage())->with('line_number', $e->getLine())->with('filename', $e->getFile());
        } catch (ModelNotFoundException $exception) {
            return view('pages.error.cusome_error')->with('listerror', $exception->getMessage())->with('line_number', $exception->getLine())->with('filename', $exception->getFile());;
        } catch (RelationNotFoundException $r) {
            return view('pages.error.cusome_error')->with('listerror', $r->getMessage())->with('line_number', $r->getLine())->with('filename', $r->getFile());;
        }
        $html = view('pages.console.experiment.experiment.profile.experiment_data', compact('process_experiment_info', 'viewflag'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function manage($id, $redis_update = '')
    {
        $cachedExperimentInfo = Redis::get('process_experiment_info_' . $id);
        $data['parameters'] = request()->segment(4);
        if (empty($cachedExperimentInfo) || !empty($redis_update)) {
            $process_experiment = ProcessExperiment::find(___decrypt($id));
            $processExpEnergyFlow = ProcessExpEnergyFlow::where('process_id', ___decrypt($id))->get();
            $flowTypeEnergy = SimulationFlowType::where('type', 4)->get();
            $expEnergyFlowArr = [];
            if (!empty($processExpEnergyFlow)) {
                $processExpEnergyFlowArr = $processExpEnergyFlow->toArray();
                if (!empty($processExpEnergyFlowArr)) {
                    foreach ($processExpEnergyFlowArr as $enrgyflowkey => $energyflowval) {
                        $expEnergyFlowArr[$enrgyflowkey]['energy_flow_id'] = $energyflowval['id'];
                        $expEnergyFlowArr[$enrgyflowkey]['stream_name'] = $energyflowval['stream_name'];
                        $expEnergyFlowArr[$enrgyflowkey]['experiment_unit_name'] = $energyflowval['experiment_unit_id'];
                        $get_energy_details = get_energy_details($energyflowval['energy_utility_id']);
                        $expEnergyFlowArr[$enrgyflowkey]['energy_utility_name'] = $get_energy_details['name'];
                        $expEnergyFlowArr[$enrgyflowkey]['stream_flowtype'] = getsingleFlowtyeName($energyflowval['stream_flowtype']);
                        if ($energyflowval['input_output'] == 1) {
                            $expEnergyFlowArr[$enrgyflowkey]['inputoutput'] = "Output";
                        } else {
                            $expEnergyFlowArr[$enrgyflowkey]['inputoutput'] = "Input";
                        }
                    }
                }
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
            $mass_flow_types = [];
            $flow_types = SimulationFlowType::whereIn('type', [1, 2, 3])->get();
            if (!empty($flow_types)) {
                foreach ($flow_types as $flow_type) {
                    $mass_flow_types[] = [
                        'id' => $flow_type['id'],
                        'name' => $flow_type['flow_type_name']
                    ];
                }
            }
            $flowTypeEnergyArr = [];
            if (!empty($flowTypeEnergy)) {
                $flowTypeEnergyArr = $flowTypeEnergy->toArray();
            }
            $selectUtilityArr = [];
            if (!empty($process_experiment->energy_id)) {
                $selectUtility = EnergyUtility::select('id', 'energy_name')->whereIn('id', $process_experiment->energy_id)->get();
                $selectUtilityArr = $selectUtility->toArray();
            }
            $products = [];
            if (!empty($process_experiment->chemical)) {
                foreach ($process_experiment->chemical as $chemical) {
                    $products[] = [
                        'id' => $chemical,
                        'name' => getsingleChemicalName($chemical)
                    ];
                }
            }
            $parameters = request()->segment(4);
            $process_experiment_info = [
                "id" => $process_experiment->id,
                "name" => $process_experiment->process_experiment_name,
                "description" => $process_experiment->description,
                "tags" => $process_experiment->tags,
                "updated_at" => $process_experiment->updated_at,
                "mass_flow_types" => $mass_flow_types,
                "flowTypeEnergy" => $flowTypeEnergyArr,
                "selectUtilityArr" => $selectUtilityArr,
                "expEnergyFlowArr" => $expEnergyFlowArr,
                "experiment_units" => $experiment_units,
                "products" => $products,
                "status" => $process_experiment->status,
                "viewflag" => $parameters
            ];
            Redis::del('process_experiment_info_' . $id);
            Redis::set('process_experiment_info_' . $id, json_encode($process_experiment_info));
        } else {

            $process_experiment_info = json_decode($cachedExperimentInfo, TRUE);
        }
        return view('pages.console.experiment.experiment.profile.profile', $data)->with('process_experiment_info', $process_experiment_info);
    }

    public function getstreamdata(Request $request)
    {
        $flowtype = $request->tab;
        $process_experiment = ProcessExperiment::find((___decrypt($request->process_experiment_id)));
        $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
        $arr = [];
        if (!empty($variton->process_flow_table)) {
            $arr = $variton->process_flow_table;
        }
        $diagramArr = ProcessDiagram::whereIn('id', $arr)->get();
        // $diagramArr = ProcessDiagram::where('process_id', ___decrypt($request->process_experiment_id))->get();
        $fromStream = [];
        $toStream = [];
        if (!empty($diagramArr)) {
            $from_unit = array_column($diagramArr->toArray(), 'from_unit');
            $to_unit = array_column($diagramArr->toArray(), 'to_unit');
            if (!empty($from_unit)) {
                foreach ($from_unit as $fk => $fv) {
                    if (!empty($fv['output_stream_id'])) {
                        $fromStream[$fv['experiment_unit_id']][] = $fv['output_stream_id'];
                    }
                }
                if (!empty($fromStream[___decrypt($request->experiment_unit_id)])) {
                    $fromStream = $fromStream[___decrypt($request->experiment_unit_id)];
                }
            }
            if (!empty($to_unit)) {
                foreach ($to_unit as $fk => $fv) {
                    if (!empty($fv['input_stream_id'])) {
                        $toStream[$fv['experiment_unit_id']][] = $fv['input_stream_id'];
                    }
                }
                if (!empty($toStream[___decrypt($request->experiment_unit_id)])) {
                    $toStream = $toStream[___decrypt($request->experiment_unit_id)];
                }
            }
        }
        $expunitid = 0;
        if (!empty($process_experiment['experiment_unit'])) {
            foreach ($process_experiment['experiment_unit'] as $key => $val) {
                if ($val['id'] == ___decrypt($request->experiment_unit_id)) {
                    $expunitid = $val['exp_unit'];
                }
            }
        }
        if ($expunitid != 0) {
            $experiment_unit = ExperimentUnit::select('equipment_unit_id')->where('id', $expunitid)->first();
            $conditions = [];
            $equipmentdata = EquipmentUnit::select('stream_flow')->where('id', $experiment_unit->equipment_unit_id)->first();
        }
        $input = [];
        $output = [];
        if (!empty($equipmentdata['stream_flow'])) {
            $equipmentStream = $equipmentdata['stream_flow'];
            foreach ($equipmentStream as $keystream => $valstream) {
                if ($flowtype == "input") {
                    if ($valstream['flow_type'] == "input" && !in_array($valstream['id'], $toStream) && $request->experiment_unit_id != $request->expiito) {
                        $input[$keystream]['flow_type'] = $valstream['flow_type'];
                        $input[$keystream]['stream_name'] = $valstream['stream_name'];
                        $input[$keystream]['input_stream_id'] = $valstream['id'];
                    }
                    if ($valstream['flow_type'] == "input" && !in_array($valstream['id'], $toStream) && $request->experiment_unit_id == $request->expiito) {
                        $input[$keystream]['flow_type'] = $valstream['flow_type'];
                        $input[$keystream]['stream_name'] = $valstream['stream_name'];
                        $input[$keystream]['input_stream_id'] = $valstream['id'];
                    }
                }
                if ($flowtype == "output" && !in_array($valstream['id'], $fromStream)) {
                    if ($valstream['flow_type'] == "output") {
                        $output[$keystream]['flow_type'] = $valstream['flow_type'];
                        $output[$keystream]['stream_name'] = $valstream['stream_name'];
                        $output[$keystream]['output_stream_id'] = $valstream['id'];
                    }
                }
            }
        }
        if ($flowtype == "output") {
            if ($request->flag == "edit" && $request->experiment_unit_id == $request->expiifrom) {
                $oid = $request->outputstreamid;
                $osv = $request->outputstream;
                $output[($oid - 1)]['flow_type'] = "output";
                $output[($oid - 1)]['stream_name'] = $osv;
                $output[($oid - 1)]['output_stream_id'] = $oid;
            }

            $data['streams'] = $output;
            $data['flowtype'] = "output";
            return json_encode($data);
        }
        if ($flowtype == "input") {
            if ($request->flag == "edit" && $request->experiment_unit_id == $request->expiito) {
                $iid = $request->inputstreamid;
                $sv = $request->inputstream;
                $input[($iid - 1)]['flow_type'] = "input";
                $input[($iid - 1)]['stream_name'] = $sv;
                $input[($iid - 1)]['input_stream_id'] = $iid;
            }

            $data['streams'] = $input;
            $data['flowtype'] = "input";
            return json_encode($data);
        }
    }

    public function expUnitCondition(Request $request)
    {
        $id = $request->name;
        $process_experiment_id = $request->process_experiment_id;
        $condataArr = ExperimentConditionMaster::get();
        $profile_condition = [];
        $html = view('pages.console.experiment.experiment.configuration.exp_unit_condition')->with(compact('id', 'profile_condition', 'condataArr'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function expoutcomes(Request $request)
    {
        $id = $request->name;
        $process_experiment_id = $request->process_experiment_id;
        $experiment_units = ExperimentUnit::where('id', $id)->first();
        $outcomeataArr = ExperimentOutcomeMaster::get();
        $profile_outcomes = [];
        $html = view('pages.console.experiment.experiment.exp_unit_outcomes')->with(compact('id', 'profile_outcomes', 'outcomeataArr'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function setUnitcondition(Request $request)
    {
        $id = $request->name;
        $process_experiment_id = $request->process_experiment_id;
        $experiment_units = ExperimentUnit::where('id', $id)->first();
        $condataArr = ExperimentConditionMaster::get();
        $unit_condition = [];
        $html = view('pages.console.experiment.experiment.set_point_unit_condition')->with(compact('id', 'unit_condition', 'condataArr'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function expmessurData(Request $request)
    {
        $id = $request->name;
        $experiment_units = ExperimentUnit::where('id', $id)->first();
        $process_experiment_id = $request->process_experiment_id;
        $outcomeataArr = ExperimentOutcomeMaster::get();
        $profile_outcomes = [];
        $html = view('pages.console.experiment.experiment.configuration.exp_messure_data')->with(compact('id', 'profile_outcomes', 'outcomeataArr', 'experiment_units'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function edit($id)
    {
        $chemicls = Chemical::where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        $data['energy'] = EnergyUtility::where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        $data['chemicals'] = $chemicls->toArray();
        $projects = Project::where(['status' => 'active', 'tenant_id' => session()->get('tenant_id')])->get();
        $new_pro = [];
        if (Auth::user()->role == 'admin') {
            if (!empty($projects)) {
                foreach ($projects as $key => $project) {
                    $new_pro[$key]['id'] = $project['id'];
                    $new_pro[$key]['name'] = $project['name'];
                }
            }
        } else {
            if (!empty($projects)) {
                foreach ($projects as $key => $project) {
                    if (in_array(Auth::user()->id, $project['users'])) {
                        $new_pro[$key]['id'] = $project['id'];
                        $new_pro[$key]['name'] = $project['name'];
                    }
                }
            }
        }
        $data['projects'] = $new_pro;
        $data['experiment_units'] = ExperimentUnit::where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        $data['experiment_categories'] = ExperimentCategory::where('status', 'active')->get();
        $expcalss = ExperimentClassification::where('status', 'active')->get();
        $data['experiment_classifications'] = $expcalss->toArray();
        $data['process_experiment'] = ProcessExperiment::find(___decrypt($id));
        $data['product_lists'] = Chemical::whereIn('id', $data['process_experiment']['chemical'])->where('status', 'active')->get();
        $data['product_input_lists'] = Chemical::whereIn('id', $data['process_experiment']['main_product_input'])->where('status', 'active')->get();
        $data['product_output_lists'] = Chemical::whereIn('id', $data['process_experiment']['main_product_output'])->where('status', 'active')->get();

        return view('pages.console.experiment.experiment.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::extend('name_validation', function ($attr, $value) {
            return preg_match('/^[\s\w-]*$/', $value);
        });
        $requestData = $request->all();
        $count = count($requestData["unit"]);
        unset($requestData["unit"][$count]);
        $validator = Validator::make(
            $requestData,
            [
                'process_experiment_names' => 'required|name_validation',
                //'project' => 'required',
                'product' => 'required',
                'main_product_input' => 'required',
                'main_product_output' => 'required',
                'unit.*.unit' => 'required',
                'unit.*.exp_unit' => 'required'
            ],
            [
                'unit.*.unit.required' => 'Unit field is required',
                'unit.*.exp_unit.required' => ' Experiment Unit field is required',
                'process_experiment_names.name_validation' => 'The experiment name only contain letters and numbers'
            ]
        );
        if ($validator->fails()) {
            //return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
            $this->message = $validator->errors();
        } else {
            try {
                $expData = ProcessExperiment::find(___decrypt($id));
                $expData->process_experiment_name = $request->process_experiment_names;
                $expData->category_id = !empty($request->category_id) ? ___decrypt($request->category_id) : 0;
                $expData->project_id = !empty($request->project_id) ? ___decrypt($request->project_id) : 0;
                $chemicals = [];
                if (!empty($request->product)) {
                    foreach ($request->product as $chem) {
                        $chemicals[] = ___decrypt($chem);
                    }
                }
                $energy = [];
                if (!empty($request->energy)) {
                    foreach ($request->energy as $eng) {
                        $energy[] = ___decrypt($eng);
                    }
                }
                $main_product_outputs = [];
                if (!empty($request->main_product_output)) {
                    foreach ($request->main_product_output as $main_pro_outputs) {
                        $main_product_outputs[] = ___decrypt($main_pro_outputs);
                    }
                }
                $main_product_inputs = [];
                if (!empty($request->main_product_input)) {
                    foreach ($request->main_product_input as $main_pro_input) {
                        $main_product_inputs[] = ___decrypt($main_pro_input);
                    }
                }
                $classification_id = [];
                if (!empty($request->classification_id)) {
                    foreach ($request->classification_id as $classification) {
                        $classification_id[] = ___decrypt($classification);
                    }
                }
                $expData->energy_id = $energy;
                $expData->chemical = $chemicals;
                $expData->main_product_input = $main_product_inputs;
                $expData->main_product_output = $main_product_outputs;
                if (!empty($request->unit)) {
                    foreach ($request->unit as $key => $expval) {
                        if (!empty($expval['unit'])) {
                            $val_en[$key]['id'] = json_encode($key + 1);
                            $val_en[$key]['exp_unit'] = !empty($expval['exp_unit']) ? ___decrypt($expval['exp_unit']) : '';
                            $val_en[$key]['unit'] = $expval['unit'];
                            $val_en[$key]['created_by'] = !empty($expval['created_by']) ? ($expval['created_by']) : Auth::user()->id;
                        }
                    }
                    $expData->experiment_unit  = $val_en;
                }
                $expData->data_source = $request->data_source;
                $expData->classification_id = $classification_id;
                $expData->description = $request->description;
                if ($request->tags != "") {
                    $tags = explode(",", $request->tags);
                } else {
                    $tags = [];
                }
                $expData->tags = $tags;
                $expData->updated_by = Auth::user()->id;
                $expData->updated_at = now();
                $expData->save();
                $this->index('redis_update');
                $this->manage(___encrypt($expData->id), 'redis_update');
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('/experiment/experiment/' . ___encrypt($expData->id) . '/manage');
                $this->message = "Experiment is Updated Successfully";
            } catch (\Exception $e) {
                $this->redirect = url('/experiment/experiment');
                $this->status = true;
                $this->modal = true;
                $this->successimage = "error";
                $this->message = $e->getMessage();
            }
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
            $update = ProcessExperiment::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
            $this->manage($id, 'redis_update');
            $variations = Variation::where('experiment_id', ___decrypt($id))->get();
            if (!empty($variations)) {
                foreach ($variations as $variation) {
                    if ($status == 'inactive') {
                        $var_status = $status;
                        $prev_status = $variation->status;
                    } else {
                        $var_status = $variation->prev_status;
                        $prev_status = $variation->prev_status;
                    }
                    $variation->status = $var_status;
                    $variation->prev_status = $prev_status;
                    $variation->updated_by = Auth::user()->id;
                    $variation->updated_at = now();
                    if ($variation->save()) {
                        simulate_input_status_change($variation->id, $var_status);
                    }
                }
                $redis_variation = new VariationCommon();
                $redis_variation->variation_list($request, 'redis_update', ___decrypt($id));
            }
        } else {
            $message = "This Experiment is used in Report! You can not delete.Please Inactive status";
            $this->status = true;
            $this->message = $message;
            $this->redirect = true;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ProcessExperiment::where('id', ___decrypt($id))->update($update)) {
                ProcessExperiment::destroy(___decrypt($id));
            }
        }
        $this->index('redis_update');
        $this->status = true;
        $this->redirect = url('/experiment/experiment');
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
        if (ProcessExperiment::whereIn('id', $processIDS)->update($update)) {
            ProcessExperiment::destroy($processIDS);
        }
        $this->index('redis_update');
        $this->status = true;
        $this->redirect = url('/experiment/experiment');
        return $this->populateresponse();
    }

    public function checkStream(Request $request)
    {
        try {
            $pe_detail = ProcessExperiment::find(___decrypt($request['process_experiment_id']));
            if (!empty($pe_detail)) {
                foreach ($pe_detail->experiment_unit as $experiment_unit) {
                    if ($experiment_unit['id'] == ___decrypt($request['pe_experiment_unit_id'])) {
                        $experiment_unit_info = get_experiment_unit($experiment_unit['exp_unit']);
                        foreach ($experiment_unit_info['stream_flow'] as $stream) {
                            if ($stream['id'] == ___decrypt($request['stream_id'])) {
                                return response()->json([
                                    'success' => true,
                                    'status_code' => 200,
                                    'status' => true,
                                    'data' => $stream
                                ]);
                            }
                        }
                    }
                }
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

    public function get_process_experiment(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find($request->experiment_id);
            $classifications = [];
            foreach ($process_experiment->classification_id as $classification) {
                $classifications[] = experiment_classification($classification);
            }
            $product_list = [];
            foreach ($process_experiment->chemical as $product) {
                $product_list[] = get_product_details($product);
            }
            $main_product_inputs = [];
            foreach ($process_experiment->main_product_input as $main_product_input) {
                $main_product_inputs[] = get_product_details($main_product_input);
            }
            $main_product_outputs = [];
            foreach ($process_experiment->main_product_output as $main_product_output) {
                $main_product_outputs[] = get_product_details($main_product_output);
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
            $configuration_details = [];
            $process_experiment_info = [
                "id" => $process_experiment->id,
                "name" => $process_experiment->process_experiment_name,
                "category" => $process_experiment->experiment_category->name,
                "classification" => $classifications,
                "data_source" => $process_experiment->data_source,
                "product_list" => $product_list,
                "main_product_inputs" => $main_product_inputs,
                "main_product_outputs" => $main_product_outputs,
                "experiment_units" => $experiment_units,
                "description" => $process_experiment->description,
                "tags" => $process_experiment->tags,
                "updated_at" => $process_experiment->updated_at,
                "configuration_details" => $configuration_details
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $process_experiment_info
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

    public function get_pe_profile(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find($request->experiment_id);
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
            $configuration_details = [];
            $pe_profile = [
                "id" => $process_experiment->id,
                "name" => $process_experiment->process_experiment_name,
                "category" => $process_experiment->category_id,
                "classification" => $process_experiment->classification_id,
                "data_source" => $process_experiment->data_source,
                "product_list" => $process_experiment->chemical,
                "main_product_inputs" => $process_experiment->main_product_input,
                "main_product_outputs" => $process_experiment->main_product_output,
                "experiment_units" => $experiment_units,
                "configuration_details" => $configuration_details
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $pe_profile
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

    public function get_pe_profile_config(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find($request->experiment_id);
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
            $configuration_details = [];
            $pe_profile = [
                "id" => $process_experiment->id,
                "name" => $process_experiment->process_experiment_name,
                "category" => $process_experiment->category_id,
                "classification" => $process_experiment->classification_id,
                "data_source" => $process_experiment->data_source,
                "product_list" => $process_experiment->chemical,
                "main_product_inputs" => $process_experiment->main_product_input,
                "main_product_outputs" => $process_experiment->main_product_output,
                "experiment_units" => $experiment_units,
                "configuration_details" => $configuration_details
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $pe_profile
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

    public function get_pe_profile_config_datasets(Request $request)
    {
        try {
            $datasets = SimulateDataset::where([[
                'process_exp_id', $request->experiment_id
            ], [
                'variation_id', $request->variation_id
            ]])->get();
            $key = 0;
            $configuration = [];
            foreach ($datasets as  $master_data) {
                $raw_materials = $master_data->simulation_output['raw_material'];
                $master_conditions = $master_data->simulation_output['master_condition'];
                $master_outcomes = $master_data->simulation_output['master_outcome'];
                $exp_unit_outcomes = $master_data->simulation_output['exp_unit_outcome'];
                $exp_unit_conditions = $master_data->simulation_output['exp_unit_condition'];
                $simulation_types = $master_data->simulation_output['simulation_type'];
                $master_condition_set_point = $master_data->simulation_set_point['master_condition'];
                $master_outcome_set_point = $master_data->simulation_set_point['master_outcome'];
                $exp_unit_outcome_set_point = $master_data->simulation_set_point['exp_unit_outcome'];
                $exp_unit_condition_set_point = $master_data->simulation_set_point['exp_unit_condition'];
                $configuration[$key]['id'] = $master_data->id;
                if (!empty($raw_materials)) {
                    $i = 0;
                    foreach ($raw_materials as  $raw_material) {
                        $configuration[$key]['simulation_output']['raw_material'][$i]['pfd_stream_id'] = (int) $raw_material['pfd_stream_id'];
                        $configuration[$key]['simulation_output']['raw_material'][$i]['product_id'] = (int) $raw_material['product_id'];
                        $val = (float)$raw_material['value'];
                        $configuration[$key]['simulation_output']['raw_material'][$i]['value'] = number_format($val, 10, '.', '');
                        $configuration[$key]['simulation_output']['raw_material'][$i]['unit_constant_id'] = (int) $raw_material['unit_constant_id'];
                        $i++;
                    }
                }
                if (!empty($master_conditions)) {
                    $j = 0;
                    foreach ($master_conditions as  $master_data) {
                        $configuration[$key]['simulation_output']['master_condition'][$j]['master_condition_id'] = (int)$master_data['master_condition_id'];
                        $configuration[$key]['simulation_output']['master_condition'][$j]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration[$key]['simulation_output']['master_condition'][$j]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration[$key]['simulation_output']['master_condition'][$j]['value'] = number_format($val, 10, '.', '');
                        $configuration[$key]['simulation_output']['master_condition'][$j]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $j++;
                    }
                }
                if (!empty($master_outcomes)) {
                    $k = 0;
                    foreach ($master_outcomes as $master_data) {
                        $configuration[$key]['simulation_output']['master_outcome'][$k]['master_outcome_id'] = (int)$master_data['master_outcome_id'];
                        $configuration[$key]['simulation_output']['master_outcome'][$k]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration[$key]['simulation_output']['master_outcome'][$k]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration[$key]['simulation_output']['master_outcome'][$k]['value'] = number_format($val, 10, '.', '');
                        $configuration[$key]['simulation_output']['master_outcome'][$k]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $k++;
                    }
                }
                if (!empty($exp_unit_conditions)) {
                    $l = 0;
                    foreach ($exp_unit_conditions as $master_data) {
                        $configuration[$key]['simulation_output']['exp_unit_condition'][$l]['exp_condition_id'] = (int)$master_data['exp_condition_id'];
                        $configuration[$key]['simulation_output']['exp_unit_condition'][$l]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration[$key]['simulation_output']['exp_unit_condition'][$l]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration[$key]['simulation_output']['exp_unit_condition'][$l]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration[$key]['simulation_output']['exp_unit_condition'][$l]['value'] = number_format($val, 10, '.', '');
                        $configuration[$key]['simulation_output']['exp_unit_condition'][$l]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $l++;
                    }
                }
                if (!empty($exp_unit_outcomes)) {
                    $m = 0;
                    foreach ($exp_unit_outcomes as $master_data) {
                        $configuration[$key]['simulation_output']['exp_unit_outcome'][$m]['exp_outcome_id'] = (int)$master_data['exp_outcome_id'];
                        $configuration[$key]['simulation_output']['exp_unit_outcome'][$m]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration[$key]['simulation_output']['exp_unit_outcome'][$m]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration[$key]['simulation_output']['exp_unit_outcome'][$m]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration[$key]['simulation_output']['exp_unit_outcome'][$m]['value'] = number_format($val, 10, '.', '');
                        $configuration[$key]['simulation_output']['exp_unit_outcome'][$m]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $m++;
                    }
                }
                if (!empty($simulation_types)) {
                    $configuration[$key]['simulation_output']['simulation_type'] = $simulation_types;
                }
                if (!empty($master_condition_set_point)) {
                    $n = 0;
                    foreach ($master_condition_set_point as $master_data) {
                        $configuration[$key]['simulation_set_point']['master_condition'][$n]['master_condition_id'] = (int)$master_data['master_condition_id'];
                        $configuration[$key]['simulation_set_point']['master_condition'][$n]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration[$key]['simulation_set_point']['master_condition'][$n]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : 0;
                        $configuration[$key]['simulation_set_point']['master_condition'][$n]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration[$key]['simulation_set_point']['master_condition'][$n]['value'] = number_format($max_val, 10, '.', '');
                        $configuration[$key]['simulation_set_point']['master_condition'][$n]['max_value'] = number_format($val, 10, '.', '');
                        $configuration[$key]['simulation_set_point']['master_condition'][$n]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $n++;
                    }
                }
                if (!empty($master_outcome_set_point)) {
                    $o = 0;
                    foreach ($master_outcome_set_point as $master_data) {
                        $configuration[$key]['simulation_set_point']['master_outcome'][$o]['master_outcome_id'] = (int)$master_data['master_outcome_id'];
                        $configuration[$key]['simulation_set_point']['master_outcome'][$o]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration[$key]['simulation_set_point']['master_outcome'][$o]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : '';
                        $configuration[$key]['simulation_set_point']['master_outcome'][$o]['priority'] = (int)!empty($master_data['priority']) ? $master_data['priority'] : '';
                        $configuration[$key]['simulation_set_point']['master_outcome'][$o]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration[$key]['simulation_set_point']['master_outcome'][$o]['value'] = number_format($val, 10, '.', '');
                        $configuration[$key]['simulation_set_point']['master_outcome'][$o]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration[$key]['simulation_set_point']['master_outcome'][$o]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $o++;
                    }
                }
                if (!empty($exp_unit_condition_set_point)) {
                    $p = 0;
                    foreach ($exp_unit_condition_set_point as $master_data) {
                        $configuration[$key]['simulation_set_point']['exp_unit_condition'][$p]['exp_condition_id'] = (int)$master_data['exp_condition_id'];
                        $configuration[$key]['simulation_set_point']['exp_unit_condition'][$p]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration[$key]['simulation_set_point']['exp_unit_condition'][$p]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration[$key]['simulation_set_point']['exp_unit_condition'][$p]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : '';
                        $configuration[$key]['simulation_set_point']['exp_unit_condition'][$p]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration[$key]['simulation_set_point']['exp_unit_condition'][$p]['value'] = number_format($val, 10, '.', '');
                        $configuration[$key]['simulation_set_point']['exp_unit_condition'][$p]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration[$key]['simulation_set_point']['exp_unit_condition'][$p]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $p++;
                    }
                }
                if (!empty($exp_unit_outcome_set_point)) {
                    $q = 0;
                    foreach ($exp_unit_outcome_set_point as $master_data) {
                        $configuration[$key]['simulation_set_point']['exp_unit_outcome'][$q]['exp_outcome_id'] = (int)$master_data['exp_outcome_id'];
                        $configuration[$key]['simulation_set_point']['exp_unit_outcome'][$q]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration[$key]['simulation_set_point']['exp_unit_outcome'][$q]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration[$key]['simulation_set_point']['exp_unit_outcome'][$q]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : '';
                        $configuration[$key]['simulation_set_point']['exp_unit_outcome'][$q]['priority'] = (int)!empty($master_data['priority']) ? $master_data['priority'] : '';
                        $configuration[$key]['simulation_set_point']['exp_unit_outcome'][$q]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration[$key]['simulation_set_point']['exp_unit_outcome'][$q]['value'] = number_format($val, 10, '.', '');
                        $configuration[$key]['simulation_set_point']['exp_unit_outcome'][$q]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration[$key]['simulation_set_point']['exp_unit_outcome'][$q]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $q++;
                    }
                }
                $key++;
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $configuration,
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

    public function get_pe_profile_config_dataset(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find($request->experiment_id);
            $configuration_data = [];
            $dataset = SimulateDataset::find($request->simulation_input_id);
            $configuration = [];
            if (!empty($dataset)) {
                $raw_materials = $dataset->simulation_output['raw_material'];
                $master_conditions = $dataset->simulation_output['master_condition'];
                $master_outcomes = $dataset->simulation_output['master_outcome'];
                $exp_unit_outcomes = $dataset->simulation_output['exp_unit_outcome'];
                $exp_unit_conditions = $dataset->simulation_output['exp_unit_condition'];
                $simulation_types = $dataset->simulation_output['simulation_type'];
                $master_condition_set_point = $dataset->simulation_set_point['master_condition'];
                $master_outcome_set_point = $dataset->simulation_set_point['master_outcome'];
                $exp_unit_outcome_set_point = $dataset->simulation_set_point['exp_unit_outcome'];
                $exp_unit_condition_set_point = $dataset->simulation_set_point['exp_unit_condition'];
                $configuration['id'] = $dataset->id;
                $configuration['process_exp_id'] = $dataset->process_exp_id;
                $configuration['variation_id'] = $dataset->variation_id;
                if (!empty($raw_materials)) {
                    $i = 0;
                    foreach ($raw_materials as $raw_material) {
                        $configuration['simulation_output']['raw_material'][$i]['pfd_stream_id'] = (int) $raw_material['pfd_stream_id'];
                        $configuration['simulation_output']['raw_material'][$i]['product_id'] = (int) $raw_material['product_id'];
                        $val = (float)$raw_material['value'];
                        $configuration['simulation_output']['raw_material'][$i]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['raw_material'][$i]['unit_constant_id'] = (int) $raw_material['unit_constant_id'];
                        $i++;
                    }
                }
                if (!empty($master_conditions)) {
                    $j = 0;
                    foreach ($master_conditions as $master_data) {
                        $configuration['simulation_output']['master_condition'][$j]['master_condition_id'] = (int)$master_data['master_condition_id'];
                        $configuration['simulation_output']['master_condition'][$j]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration['simulation_output']['master_condition'][$j]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration['simulation_output']['master_condition'][$j]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['master_condition'][$j]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $j++;
                    }
                }
                if (!empty($master_outcomes)) {
                    $k = 0;
                    foreach ($master_outcomes as $master_data) {
                        $configuration['simulation_output']['master_outcome'][$k]['master_outcome_id'] = (int)$master_data['master_outcome_id'];
                        $configuration['simulation_output']['master_outcome'][$k]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration['simulation_output']['master_outcome'][$k]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration['simulation_output']['master_outcome'][$k]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['master_outcome'][$k]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $k++;
                    }
                }
                if (!empty($exp_unit_conditions)) {
                    $l = 0;
                    foreach ($exp_unit_conditions as $master_data) {
                        $configuration['simulation_output']['exp_unit_condition'][$l]['exp_condition_id'] = (int)$master_data['exp_condition_id'];
                        $configuration['simulation_output']['exp_unit_condition'][$l]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration['simulation_output']['exp_unit_condition'][$l]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration['simulation_output']['exp_unit_condition'][$l]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration['simulation_output']['exp_unit_condition'][$l]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['exp_unit_condition'][$l]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $l++;
                    }
                }
                if (!empty($exp_unit_outcomes)) {
                    $m = 0;
                    foreach ($exp_unit_outcomes as $master_data) {
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['exp_outcome_id'] = (int)$master_data['exp_outcome_id'];
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $m++;
                    }
                }
                if (!empty($simulation_types)) {
                    $configuration['simulation_output']['simulation_type'] = $simulation_types;
                }
                if (!empty($master_condition_set_point)) {
                    $n = 0;
                    foreach ($master_condition_set_point as $master_data) {
                        $configuration['simulation_set_point']['master_condition'][$n]['master_condition_id'] = (int)$master_data['master_condition_id'];
                        $configuration['simulation_set_point']['master_condition'][$n]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration['simulation_set_point']['master_condition'][$n]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : 0;
                        $configuration['simulation_set_point']['master_condition'][$n]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration['simulation_set_point']['master_condition'][$n]['value'] = number_format($max_val, 10, '.', '');
                        $configuration['simulation_set_point']['master_condition'][$n]['max_value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_set_point']['master_condition'][$n]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $n++;
                    }
                }
                if (!empty($master_outcome_set_point)) {
                    $o = 0;
                    foreach ($master_outcome_set_point as $master_data) {
                        $configuration['simulation_set_point']['master_outcome'][$o]['master_outcome_id'] = (int)$master_data['master_outcome_id'];
                        $configuration['simulation_set_point']['master_outcome'][$o]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration['simulation_set_point']['master_outcome'][$o]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : '';
                        $configuration['simulation_set_point']['master_outcome'][$o]['priority'] = (int)!empty($master_data['priority']) ? $master_data['priority'] : '';
                        $configuration['simulation_set_point']['master_outcome'][$o]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration['simulation_set_point']['master_outcome'][$o]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_set_point']['master_outcome'][$o]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration['simulation_set_point']['master_outcome'][$o]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $o++;
                    }
                }
                if (!empty($exp_unit_condition_set_point)) {
                    $p = 0;
                    foreach ($exp_unit_condition_set_point as $master_data) {
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['exp_condition_id'] = (int)$master_data['exp_condition_id'];
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : '';
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $p++;
                    }
                }
                if (!empty($exp_unit_outcome_set_point)) {
                    $q = 0;
                    foreach ($exp_unit_outcome_set_point as $master_data) {
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['exp_outcome_id'] = (int)$master_data['exp_outcome_id'];
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : '';
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['priority'] = (int)!empty($master_data['priority']) ? $master_data['priority'] : '';
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $q++;
                    }
                }
            }
            $resposne = [
                "process_experiment" => $process_experiment,
                "configuration_data" => $configuration_data,
                "dataset" => $configuration
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $resposne
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

    public function get_pe_profile_config_dataset_forward(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find($request->experiment_id);
            $configuration_data = [];
            $dataset = SimulateDataset::find($request->simulation_input_id);
            $configuration = [];
            if (!empty($dataset)) {
                $raw_materials = $dataset->simulation_output['raw_material'];
                $master_conditions = $dataset->simulation_output['master_condition'];
                $master_outcomes = $dataset->simulation_output['master_outcome'];
                $exp_unit_outcomes = $dataset->simulation_output['exp_unit_outcome'];
                $exp_unit_conditions = $dataset->simulation_output['exp_unit_condition'];
                $simulation_types = $dataset->simulation_output['simulation_type'];
                $configuration['id'] = $dataset->id;
                $configuration['process_exp_id'] = $dataset->process_exp_id;
                $configuration['variation_id'] = $dataset->variation_id;
                if (!empty($raw_materials)) {
                    $i = 0;
                    foreach ($raw_materials as $raw_material) {
                        $configuration['simulation_output']['raw_material'][$i]['pfd_stream_id'] = (int) $raw_material['pfd_stream_id'];
                        $configuration['simulation_output']['raw_material'][$i]['product_id'] = (int) $raw_material['product_id'];
                        $val = (float)$raw_material['value'];
                        $configuration['simulation_output']['raw_material'][$i]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['raw_material'][$i]['unit_constant_id'] = (int) $raw_material['unit_constant_id'];
                        $i++;
                    }
                }
                if (!empty($master_conditions)) {
                    $j = 0;
                    foreach ($master_conditions as $master_data) {
                        $configuration['simulation_output']['master_condition'][$j]['master_condition_id'] = (int)$master_data['master_condition_id'];
                        $configuration['simulation_output']['master_condition'][$j]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration['simulation_output']['master_condition'][$j]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration['simulation_output']['master_condition'][$j]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['master_condition'][$j]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $j++;
                    }
                }
                if (!empty($master_outcomes)) {
                    $k = 0;
                    foreach ($master_outcomes as $master_data) {
                        $configuration['simulation_output']['master_outcome'][$k]['master_outcome_id'] = (int)$master_data['master_outcome_id'];
                        $configuration['simulation_output']['master_outcome'][$k]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration['simulation_output']['master_outcome'][$k]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration['simulation_output']['master_outcome'][$k]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['master_outcome'][$k]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $k++;
                    }
                }
                if (!empty($exp_unit_conditions)) {
                    $l = 0;
                    foreach ($exp_unit_conditions as $master_data) {
                        $configuration['simulation_output']['exp_unit_condition'][$l]['exp_condition_id'] = (int)$master_data['exp_condition_id'];
                        $configuration['simulation_output']['exp_unit_condition'][$l]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration['simulation_output']['exp_unit_condition'][$l]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration['simulation_output']['exp_unit_condition'][$l]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration['simulation_output']['exp_unit_condition'][$l]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['exp_unit_condition'][$l]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $l++;
                    }
                }
                if (!empty($exp_unit_outcomes)) {
                    $m = 0;
                    foreach ($exp_unit_outcomes as $master_data) {
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['exp_outcome_id'] = (int)$master_data['exp_outcome_id'];
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_output']['exp_unit_outcome'][$m]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $m++;
                    }
                }
                if (!empty($simulation_types)) {
                    $configuration['simulation_output']['simulation_type'] = $simulation_types;
                }
            }
            $resposne = [
                "process_experiment" => $process_experiment,
                "configuration_data" => $configuration_data,
                "dataset" => $configuration
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $resposne
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

    public function get_pe_profile_config_dataset_backward(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find($request->experiment_id);
            $configuration_data = [];
            $dataset = SimulateDataset::find($request->simulation_input_id);
            $configuration = [];
            if (!empty($dataset)) {
                $master_condition_set_point = $dataset->simulation_set_point['master_condition'];
                $master_outcome_set_point = $dataset->simulation_set_point['master_outcome'];
                $exp_unit_outcome_set_point = $dataset->simulation_set_point['exp_unit_outcome'];
                $exp_unit_condition_set_point = $dataset->simulation_set_point['exp_unit_condition'];
                $configuration['id'] = $dataset->id;
                $configuration['process_exp_id'] = $dataset->process_exp_id;
                $configuration['variation_id'] = $dataset->variation_id;
                if (!empty($master_condition_set_point)) {
                    $n = 0;
                    foreach ($master_condition_set_point as $master_data) {
                        $configuration['simulation_set_point']['master_condition'][$n]['master_condition_id'] = (int)$master_data['master_condition_id'];
                        $configuration['simulation_set_point']['master_condition'][$n]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration['simulation_set_point']['master_condition'][$n]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : 0;
                        $configuration['simulation_set_point']['master_condition'][$n]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;
                        $configuration['simulation_set_point']['master_condition'][$n]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_set_point']['master_condition'][$n]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration['simulation_set_point']['master_condition'][$n]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $n++;
                    }
                }
                if (!empty($master_outcome_set_point)) {
                    $o = 0;
                    foreach ($master_outcome_set_point as $master_data) {
                        $configuration['simulation_set_point']['master_outcome'][$o]['master_outcome_id'] = (int)$master_data['master_outcome_id'];
                        $configuration['simulation_set_point']['master_outcome'][$o]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration['simulation_set_point']['master_outcome'][$o]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : '';
                        $configuration['simulation_set_point']['master_outcome'][$o]['priority'] = (int)!empty($master_data['priority']) ? $master_data['priority'] : '';
                        $configuration['simulation_set_point']['master_outcome'][$o]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration['simulation_set_point']['master_outcome'][$o]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_set_point']['master_outcome'][$o]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration['simulation_set_point']['master_outcome'][$o]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $o++;
                    }
                }
                if (!empty($exp_unit_condition_set_point)) {
                    $p = 0;
                    foreach ($exp_unit_condition_set_point as $master_data) {
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['exp_condition_id'] = (int)$master_data['exp_condition_id'];
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['condition_id'] = (int)$master_data['condition_id'];
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : '';
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration['simulation_set_point']['exp_unit_condition'][$p]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $p++;
                    }
                }
                if (!empty($exp_unit_outcome_set_point)) {
                    $q = 0;
                    foreach ($exp_unit_outcome_set_point as $master_data) {
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['exp_outcome_id'] = (int)$master_data['exp_outcome_id'];
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['exp_unit_id'] = (int)$master_data['exp_unit_id'];
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['outcome_id'] = (int)$master_data['outcome_id'];
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['criteria'] = (int)!empty($master_data['criteria']) ? $master_data['criteria'] : '';
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['priority'] = (int)!empty($master_data['priority']) ? $master_data['priority'] : '';
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['unit_id'] = (int)$master_data['unit_id'];
                        $val = (float)$master_data['value'];
                        $max_val = (float)!empty($master_data['max_value']) ? $master_data['max_value'] : 0;;
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['value'] = number_format($val, 10, '.', '');
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['max_value'] = number_format($max_val, 10, '.', '');
                        $configuration['simulation_set_point']['exp_unit_outcome'][$q]['unit_constant_id'] = (int)$master_data['unit_constant_id'];
                        $q++;
                    }
                }
            }
            $resposne = [
                "process_experiment" => $process_experiment,
                "configuration_data" => $configuration_data,
                "dataset" => $configuration
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $resposne
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

    public function get_experiment_product_list(Request $request)
    {
        try {
            $process_experiment = ProcessExperiment::find($request->experiment_id);

            $product_info = [];
            foreach ($process_experiment->chemical as $product_id) {
                $product = Chemical::select('id', 'chemical_name', 'ec_number', 'status')->where('id', $product_id)->get()->first();
                $product_info[] = [
                    "id" => $product->id,
                    "name" => $product->chemical_name
                ];
                // $product_list['id'] = get_product_details($product);
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $product_info
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

    public function get_pe_profile_diagram_old(Request $request)
    {
        try {
            $process_diagram = [];
            $dataset = SimulateDataset::find($request->simulation_input_id);
            if ($dataset != null) {
                if ($request->experiment_id == $dataset['process_exp_id'] && $dataset['variation_id'] == $request->variation_id) {
                    $configuration_data = ExperimentConfiguration::find($request->variation_id);
                    $configuration_data_pd = $configuration_data['configuration_data'];
                    $idsArr = [];
                    if (!empty($configuration_data_pd['process_diagram_ids'])) {
                        $idsArr = $configuration_data_pd['process_diagram_ids'];
                    }
                    if (isset($request->stream_id) && !empty($request->stream_id)) {
                        $id = 0;
                        if (in_array($request->stream_id, $idsArr)) {
                            $id = $request->stream_id;
                        }
                        if ($id != 0) {
                            $process_diagramobject = ProcessDiagram::where('process_id', $request->experiment_id)->Where('id', $id)->get();
                        } else {
                            return required_parameter("process_diagram_id not valid");
                        }
                    } else {
                        $process_diagramobject = ProcessDiagram::where('process_id', $request->experiment_id)->WhereIn('id', $idsArr)->get();
                    }
                    foreach ($process_diagramobject as $value) {
                        if (!empty($value['from_unit'])) {
                            $from_unit = [
                                "stream_id" => $value['from_unit']["output_stream"],
                                "experiment_unit_id" => json_decode($value['from_unit']["experiment_unit_id"])
                            ];
                        } else {
                            $from_unit = [];
                        }
                        if (!empty($value['to_unit'])) {
                            $to_unit = [
                                "stream_id" => $value['to_unit']["input_stream"],
                                "experiment_unit_id" => json_decode($value['to_unit']["experiment_unit_id"])
                            ];
                        } else {
                            $to_unit = [];
                        }
                        $process_diagram[] = [
                            "id" => $value['id'],
                            "name" => $value['name'],
                            "flow_type_id" => $value['flowtype'],
                            "from_unit" => $from_unit,
                            "to_unit" => $to_unit
                        ];
                    }
                }
            } else {
                return required_parameter("dataset id not valid");
            }
            $resposne = $process_diagram;
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $resposne
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

    public function get_pe_profile_diagram(Request $request)
    {
        try {
            $process_diagram = [];
            $dataset = SimulateInput::find($request->simulate_input_id);
            if ($dataset != null) {
                if ($request->experiment_id == $dataset['experiment_id'] && $dataset['variation_id'] == $request->variation_id) {
                    $configuration_data = Variation::find($request->variation_id);
                    $configuration_data_pd = $configuration_data['process_flow_table'];

                    $idsArr = [];
                    if (!empty($configuration_data_pd)) {
                        $idsArr = $configuration_data_pd;
                    }
                    if (isset($request->stream_id) && !empty($request->stream_id)) {
                        $id = 0;
                        if (in_array($request->stream_id, $idsArr)) {
                            $id = $request->stream_id;
                        }
                        if ($id != 0) {
                            $process_diagramobject = ProcessDiagram::where('process_id', $request->experiment_id)->Where('id', $id)->get();
                        } else {
                            return required_parameter("process_diagram_id not valid");
                        }
                    } else {
                        $process_diagramobject = ProcessDiagram::where('process_id', $request->experiment_id)->WhereIn('id', $idsArr)->get();
                    }
                    foreach ($process_diagramobject as $value) {
                        if (!empty($value['from_unit'])) {
                            $from_unit = [
                                "stream_id" => $value['from_unit']["output_stream"],
                                "experiment_unit_id" => json_decode($value['from_unit']["experiment_unit_id"])
                            ];
                        } else {
                            $from_unit = [];
                        }
                        if (!empty($value['to_unit'])) {
                            $to_unit = [
                                "stream_id" => $value['to_unit']["input_stream"],
                                "experiment_unit_id" => json_decode($value['to_unit']["experiment_unit_id"])
                            ];
                        } else {
                            $to_unit = [];
                        }
                        $process_diagram[] = [
                            "id" => $value['id'],
                            "name" => $value['name'],
                            "flow_type_id" => $value['flowtype'],
                            "from_unit" => $from_unit,
                            "to_unit" => $to_unit
                        ];
                    }
                }
            } else {
                return required_parameter("dataset id not valid");
            }
            $resposne = $process_diagram;
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $resposne
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
}
