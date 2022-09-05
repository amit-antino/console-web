<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\Report\ExperimentReport;
use Illuminate\Support\Facades\Auth;
use App\Models\Experiment\ProcessDiagram;
use GuzzleHttp\Client;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\ProcessExperiment\Variation;
use Illuminate\Support\Facades\File;
use App\Models\Experiment\JobsQueue;
use Illuminate\Support\Facades\Response;
Use Log;
class ExperimentsController extends Controller
{
    public function index(Request $request)
    {
        ini_set('memory_limit', '-1');
        if (Auth::user()->role == 'console') {
            $process_experiments = ProcessExperiment::where('created_by', Auth::user()->id)->where('tenant_id', '=', session()->get('tenant_id'))->where('status', "active")->get();
            $reports = ExperimentReport::where('created_by', Auth::user()->id)->where('tenant_id', '=', session()->get('tenant_id'))->with('get_experiment', 'getCreatedBy', 'getUpdatedBy', 'getdataset', 'getconfig')->orderBy('id', 'desc')->get();
        } else {
            $process_experiments = ProcessExperiment::where('tenant_id', '=', session()->get('tenant_id'))->where('status', "active")->get();
            $reports = ExperimentReport::where('tenant_id', '=', session()->get('tenant_id'))->with('get_experiment', 'getCreatedBy', 'getUpdatedBy', 'getdataset', 'getconfig')->orderBy('id', 'desc')->get();
        }
        $experiment_reports = [];
        foreach ($reports as $report) {
            $execution_time = 0.0;
            if ($report != null) {
                $output_data = json_decode($report, true);
                if (!empty($output_data['key_results'])) {
                    $execution_time = $output_data['key_results']['detailed']['simulation_statistics'];
                }
            } else {
                $execution_time = 0.0;
            }
            $fnm=isset($report->getCreatedBy['first_name'])?$report->getCreatedBy['first_name']:'';
            $lnm=isset($report->getCreatedBy['last_name'])?$report->getCreatedBy['last_name']:'';
            $arr[] = $fnm . " " . $lnm;
            if (is_object($report->getdataset_ignoredelete))
                $variation = Variation::Select('id', 'name', 'deleted_at')->where('id', $report->getdataset_ignoredelete->variation_id)->withTrashed()->first();
            else
                $variation = '';
            $experiment_reports[] = [
                "id" => $report->id,
                "report_name" => $report->name,
                "report_type" => $report->report_type,
                "experiment_deleted_at" => $report->get_ignoredeleteexperiment->deleted_at,
                "experiment_id" => $report->get_ignoredeleteexperiment->id,
                "experiment_name" => $report->get_ignoredeleteexperiment->process_experiment_name,
                "dataset"  => is_object($report->getdataset_ignoredelete) ? $report->getdataset_ignoredelete->name : '',
                "simulation_input_id"  => is_object($report->getdataset_ignoredelete) ? $report->getdataset_ignoredelete->id : '',
                "simulation_input_deleted_at"  => is_object($report->getdataset_ignoredelete) ? $report->getdataset_ignoredelete->deleted_at : '',
                "simulate_input_type"  => is_object($report->getdataset_ignoredelete) ? $report->getdataset_ignoredelete->simulate_input_type : '',
                "configuration_name"  => (!empty($variation->name) ? $variation->name : ''),
                "variation_id"  => (!empty($variation->id) ? $variation->id : ''),
                "variation_deleted_at"  => (!empty($variation->deleted_at) ? $variation->deleted_at : ''),
                "created_by" => $fnm.' '.$lnm,
                "created_at" => $report->created_at,
                "status" => $report->status,
                "execution_time" => $execution_time,
                "updated_by"  => (isset($report->getUpdatedBy['first_name'])?$report->getUpdatedBy['first_name']:'') . " " . (isset($report->getUpdatedBy['last_name'])?$report->getUpdatedBy['last_name']:''),
                "updated_at"  => $report->updated_at,
                "description"  => $report->messages
            ];
        }
        $process_experiment = [];
        foreach ($process_experiments as $k => $value) {
            $varcount = Variation::where('experiment_id', $value->id)->count();
            $simInputcount = SimulateInput::where('experiment_id', $value->id)->count();
            if ($varcount != 0 && $simInputcount != 0) {
                $process_experiment[$k]['id'] = $value['id'];
                $process_experiment[$k]['status'] = $value['status'];
                $process_experiment[$k]['process_experiment_name'] = $value['process_experiment_name'];
            }
        }
        $userarray = [];
        if (!empty($arr)) {
            $userarray = array_unique($arr);
        }
        if ($request->ajax()) {
            return response()->json([
                'status'    => true,
                'html'      => view('pages.console.report.experiment.list', compact('userarray', 'process_experiments', 'experiment_reports'))->render()
            ]);
        }
        return view('pages.console.report.experiment.index', compact('userarray', 'process_experiment', 'process_experiments', 'experiment_reports'));
    }

    function getConfiguration(Request $request)
    {
        $variation_list = [];
        try {
            $variations = Variation::where(['experiment_id' => ___decrypt($request->id), 'status' => "active"])->get();
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        if (!empty($variations)) {
            foreach ($variations as $variation) {
                $variation_list[] = [
                    "id" => ___encrypt($variation['id']),
                    "name" => $variation['name']
                ];
            }
        }
        $obj['configuration'] = $variation_list;
        return json_encode($obj);
    }

    function getDataset(Request $request)
    {
        $report_type = "forward";
        $variation_list = [];
        if ($request->report_type == 1) {
            $report_type = "forward";
        }
        if ($request->report_type == 2) {
            $report_type = "reverse";
        }

        try {
            $variations = SimulateInput::where([[
                'experiment_id', ___decrypt($request->process_id)
            ], [
                'variation_id', ___decrypt($request->variation_id)
            ], ['simulate_input_type', $report_type], ['status', "active"]])->get();
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        if (!empty($variations)) {
            foreach ($variations as $variation) {
                $variation_list[] = [
                    "id" => ___encrypt($variation['id']),
                    "name" => $variation['name']
                ];
            }
        }
        $obj['dataset'] = $variation_list;
        return json_encode($obj);
    }

    public function create()
    {
        return view('pages.console.report.experiment.create');
    }

    public function store(Request $request)
    {
        $sim = SimulateInput::find(___decrypt($request->simulation_input_id));
        $res = [];
        $pro_val = [];
        if (!empty($sim->raw_material)) {
            foreach ($sim->raw_material as $raw) {
                if (!empty($raw['product'])) {
                    foreach ($raw['product'] as $pro) {
                        $pro_val[] = $pro['product_id'];
                    }
                }
            }
        }
        if (empty($pro_val)) {
            $error = 'error_validation';
            $status = true;
            $res = [
                'error' => $error,
                'success' => $status,
                'message' => $error
            ];
            return response()->json($res, 200);
        }
        try {
            $count = ExperimentReport::where('status', 'pending')->count();
            if ($count >= 500) {
                $status = "pending";
                $message = "Report is in Process";
            } else {
                $tenant = getTenentCalURL(session()->get('tenant_id'));
                $simulationData = new ExperimentReport();
                $simulationData->tenant_id = session()->get('tenant_id');
                $simulationData->name = $request->report_name;
                $simulationData->experiment_id = ___decrypt($request->experiment_id);
                $simulationData->variation_id = ___decrypt($request->experiment_variation_id);
                $simulationData->simulation_input_id = ___decrypt($request->simulation_input_id);
                $simulationData->report_type = $request->report_type;
                $simulationData->status = "pending";
                $simulationData->created_by = Auth::user()->id;
                $simulationData->updated_by = Auth::user()->id;
                $simulationData->timestamps = false;
                $simulationData->created_at = now();
                if ($simulationData->save()) {
                    if ($simulationData->report_type == "1") {
                        $calc_url = !empty($tenant['calc_url']) ? $tenant['calc_url'] : env('GENERATE_REPORT');
                        //$calc_url = env('GENERATE_REPORT');
                        $url = $calc_url . '/api/v1/experiment/generate/forward_report';
                    } else {
                        $calc_url = !empty($tenant['calc_url']) ? $tenant['calc_url'] : env('GENERATE_REPORT');
                        $url = $calc_url . '/api/v1/experiment/generate/reverse_report';
                    }
                    // $jobdata = [
                    //     'report' => ExperimentReport::find($simulationData->id),
                    //     'simulate_input' => SimulateInput::find($simulationData->simulation_input_id),
                    //     'teneant' => session('tenant_id'),
                    //     'request_type' => env('REQUEST_TYPE'),
                    //     'user_id' => Auth::user()->id
                    // ];
                    // $data=array("teneant"=>session()->get('tenant_id'),"data"=>json_encode($jobdata));
                    // $job=new JobsQueue;
                    // $job->jobs="single_report_generation";
                    // $job->queue_data=json_encode($data);
                    // $job->status="0";
                    // $job->created_by=Auth::user()->id;
                    // $job->save();

                    $data = [
                        'report_id' => $simulationData->id,
                        'simulate_input_id' => $simulationData->simulation_input_id,
                        'tenant_id' => session('tenant_id'),
                        'request_type' => env('REQUEST_TYPE'),
                        'user_id' => Auth::user()->id
                    ];
                    $client = new Client();
                    $options = [
                        'form_params' => $data,
                        // 'http_errors' => false,
                        'timeout' => 3
                    ];
                    $promise = $client->request('POST', $url, $options);
                }
                $status = true;
                $message = "Added Successfully!";
            }
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $res = [
            'success' => $status,
            'message' => $message
        ];
        return response()->json($res, 200);
    }

    public function show(Request $request, $id)
    {
        $type = ___decrypt($request->report_type);
        $experiment_report = ExperimentReport::find(___decrypt($id));
        $experiment_info = ProcessExperiment::find($experiment_report->experiment_id);
        $classifications = [];
        foreach ($experiment_info->classification_id as $classification) {
            $classifications[] = experiment_classification($classification);
        }
        $product_list = [];
        if (!empty($experiment_info->chemical)) {
            $product_list = get_product_details_arr($experiment_info->chemical);
        }
        $main_product_inputs = [];
        if (!empty($experiment_info->main_product_input)) {
            $main_product_inputs = get_product_details_arr($experiment_info->main_product_input);
        }
        $main_product_outputs = [];
        if (!empty($$experiment_info->main_product_output)) {
            $main_product_outputs = get_product_details_arr($experiment_info->main_product_output);
        }
        $energy_list = [];
        $energy_infos = get_energy_details_arr($experiment_info->energy_id);
        if (!empty($energy_infos)) {
            foreach ($energy_infos as $energy_info_key => $energy_info) {
                $energy_list[] = [
                    "energy_name" => $energy_info['name']
                ];
            }
        }
        $experiment_units = [];
        if (!empty($experiment_info->experiment_unit)) {
            foreach ($experiment_info->experiment_unit as $experiment_unit) {
                $experiment_units[] = [
                    "id" => $experiment_unit['id'],
                    "experiment_unit_name" => $experiment_unit['unit'],
                    "experiment_equipment_unit" => get_experiment_unit($experiment_unit['exp_unit']),
                ];
            }
        }
        $experiment_details = [
            "experiment_name" => $experiment_info->process_experiment_name,
            "category_name" => $experiment_info->experiment_category->name,
            "classification_names" => $classifications,
            "data_source" => $experiment_info->data_source,
            "product_list" => $product_list,
            "main_product_inputs" => $main_product_inputs,
            "main_product_outputs" => $main_product_outputs,
            "energy_list" => $energy_list,
            "experiment_units" => $experiment_units,
            "description" => $experiment_info->description,
            "tags" => $experiment_info->tags,
        ];
        $response = $experiment_report->output_data;
        $response = json_decode($response, true);
        $folder = "forward";
        if ($type == 1) {

            $report_menus = [];
            foreach (array_keys($response) as $k) {
                if (!empty($response[$k]))
                    array_push($report_menus, $k);
            }
            foreach ($report_menus as $menu) {
                $report_menu[] = str_replace("_", " ", $menu);
            }

            unset($report_menu[3]);
            unset($report_menu[4]);
            $folder = "forward";
            if (!empty($response['key_results']['detailed']['simulation_statistics'])) {
                $execution_info = $response['key_results']['detailed']['simulation_statistics'];
            } else {
                $execution_info = "-";
            }
            $re_order_menu = array_slice($report_menu, 0, 9);
        } else {
            $folder = "backward";
            $report_menus = ["desired_outcomes", "predicted_input_key_results", "accuracy", "sensitivity", "list_of_models", "assumptions", "recommendations", "simulation_notes"];
            // $report_menu_list = array_diff(array_keys($response), array('process_diagram'));
            foreach ($report_menus as $menu) {
                $report_menu[] = str_replace("_", " ", $menu);
            }
            if (!empty($response['predicted_input_key_results']['detailed']['simulation_statistics'])) {
                $execution_info = $response['predicted_input_key_results']['detailed']['simulation_statistics'];
            } else {
                $execution_info = "-";
            }
            $re_order_menu = array_slice($report_menu, 0, 9);
        }
        // End Report Menu Order Preparation
        return view('pages.console.report.experiment.' . $folder . '.index', compact('experiment_details', 'experiment_report', 'response', 're_order_menu', 'execution_info', 'id'));
    }

    public function showData(Request $request)
    {
        $experiment_report = ExperimentReport::find(___decrypt($request->report_id));
        $generated_output = json_decode($experiment_report->output_data, true);
        $menu = "";
        if (strpos($request->value, ' ')) {
            $menu = str_replace(" ", "_", $request->value);
        } else {
            $menu = $request->value;
        }
        $report_type = ($request->report_type);
        $folder = "forward";
        if ($report_type == 1) {
            $folder = "forward";
            $accuracy = [];
            $unit_outcomes = [];
            $master_outcome = [];
            $master_exp_outcomes = [];
            $unit_outcomes_tab = [];
            $master_condition = [];
            $raw_matrial = [];
            $master_conditions = [];
            $experiment_unit_conditions = [];
            $raw_materials = [];
            $product_props = [];
            $data['execution_time'] = (float)$generated_output['key_results']['detailed']['simulation_statistics'];
            if ($menu == "inputs") {
                $experiment_dataset = SimulateInput::find($experiment_report->simulation_input_id);
                if (!empty($generated_output['inputs'])) {
                    foreach ($generated_output['inputs']['summary'] as $mk => $master_condition) {
                        $condition_info = getConditionInfoReport($master_condition['condition_id'], $master_condition['unit_constant_id']);
                        $master_conditions[] = [
                            "condition_name" => $condition_info['condition_name'],
                            "value" => (float)$master_condition['value'],
                            "unit_constant_name" => $condition_info['unit_constant_name']
                        ];
                    }
                }
                $unit_conditions = [];
                $process_exp_info = ProcessExperiment::find($experiment_report->experiment_id);
                if (!empty($generated_output['inputs']['detailed']['experiment_unit_condition'])) {
                    foreach ($generated_output['inputs']['detailed']['experiment_unit_condition'] as $uk => $unit_condition) {
                        foreach ($process_exp_info->experiment_unit as $exp_unit) {
                            if (!empty($unit_condition['exp_unit_id']) && $exp_unit['id'] == $unit_condition['exp_unit_id']) {
                                $expname = $exp_unit['unit'];
                                $unit_constant_name = get_unit_type($unit_condition['unit_id'], $unit_condition['unit_constant_id']);
                                $experiment_unit_conditions[$unit_condition['exp_unit_id']]['experiment_unit_name'] = $expname;
                                $experiment_unit_conditions[$unit_condition['exp_unit_id']]['experiment_equipment_unit'][] = [
                                    "condition_name" => getConditionName($unit_condition['condition_id']),
                                    "value" => (float)$unit_condition['value'],
                                    "unit_constant_name" => $unit_constant_name,
                                ];
                            }
                        }
                    }
                }
                $raw_materials = [];
                if (!empty($generated_output['inputs']['detailed']['raw_materials'])) {
                    foreach ($generated_output['inputs']['detailed']['raw_materials'] as $raw_material) {
                        $process_diagram_data = ProcessDiagram::find($raw_material['id']);
                        $unit_constant_name = get_unit_type($raw_material['unit_id'], $raw_material['unit_constant_id']);
                        $raw_materials[$raw_material['id']]['stream'] = $process_diagram_data['name'];
                        $raw_materials[$raw_material['id']]['flow_rate_value'] = $raw_material['flow_rate_value'];
                        $raw_materials[$raw_material['id']]['unit_constant_name'] = (!empty($unit_constant_name['unit_constant'])) ? $unit_constant_name['unit_constant']['unit_symbol'] : '-';
                        foreach ($raw_material['product_list'] as $product) {
                            $product_name = getsingleChemicalName($product['product_id']);
                            $raw_materials[$raw_material['id']]['detail'][] = [
                                "prd_id" => $product['product_id'],
                                "product_name" => $product_name,
                                "value" => (float)$product['value'],
                            ];
                        }
                    }
                }
                $property_details = [];
                $experiment_info = ProcessExperiment::find($experiment_report->experiment_id);
                $product_list = [];
                foreach ($experiment_info->chemical as $product) {
                    $product_list[] = $product;
                }
                $productproperty = [];
                if (!empty($raw_materials)) {
                }
                $data['inputs'] = [
                    "summary" => $master_conditions,
                    "detailed" => [
                        "experiment_unit_condition" => $experiment_unit_conditions,
                        "raw_material" => $raw_materials,
                        'productproperty' => $productproperty
                    ]
                ];
            }
            if ($menu == "key_results") {
                $key_graph_line = [];
                $arr = [];
                if (!empty($generated_output['key_results']['detailed']['graphs_data'])) {
                    foreach ($generated_output['key_results']['detailed']['graphs_data'] as $input_key => $input_value) {
                        $key_graph = json_decode($input_value, true);
                        $key_graph_line[] = $key_graph['data'];
                        $arr[] = $key_graph['layout'];
                    }
                }
                $streamdata = [];
                $key_master_outcome = [];
                if (!empty($generated_output['key_results']['summary'])) {
                    foreach ($generated_output['key_results']['summary'] as $ko => $kv) {
                        $unit_constant_name = get_unit_type($kv['unit_name'], $kv['unit_constants']);
                        $key_master_outcome[] = [
                            "outcome_name" => getOutcomeName($kv['outcome_name']),
                            "value" => (float)$kv['value'],
                            "unit_constant_name" => $unit_constant_name
                        ];
                    }
                }
                $process_exp_info = ProcessExperiment::find($experiment_report->experiment_id);
                $experiment_unit_outcomes = [];
                if (!empty($generated_output['key_results']['detailed']['experiment_units'])) {
                    foreach ($generated_output['key_results']['detailed']['experiment_units'] as $ek => $eu) {
                        foreach ($process_exp_info->experiment_unit as $exp_unit) {
                            if ($exp_unit['id'] == $eu['exp_unit_id']) {
                                $expname = $exp_unit['unit'];
                                $unit_constant_name = get_unit_type($eu['unit_id'], $eu['unit_constant_id']);
                                $experiment_unit_outcomes[$eu['exp_unit_id']]['experiment_unit_name'] = $expname;
                                $experiment_unit_outcomes[$eu['exp_unit_id']]['outcomes'][] = [
                                    "outcome_name" => getOutcomeName($eu['outcome_name']),
                                    "value" => (float)$eu['value'],
                                    "unit_constant_name" => (!empty($unit_constant_name['unit_constant'])) ? $unit_constant_name['unit_constant']['unit_symbol'] : ''
                                ];
                            }
                        }
                    }
                }
                if (!empty($generated_output['key_results']['detailed']['graphs_data'])) {
                    $graph_response = $generated_output['key_results']['detailed']['graphs_data'];
                } else {
                    $graph_response = [];
                }
                $simulation_statistics = $generated_output['key_results']['detailed']['simulation_statistics'];
                $data['keyresults'] = [
                    "summary" => $key_master_outcome,
                    "detailed" => $experiment_unit_outcomes,
                    "graphs" => $graph_response,
                    "simulation_statistics" => $simulation_statistics,
                    "key_graph_line" => $key_graph_line,
                    "layout" => $arr
                ];
            }
            if ($menu == "accuracy") {
                if (!empty($generated_output['accuracy']['summary'])) {
                    $master_accuracy_list = [];
                    foreach ($generated_output['accuracy']['summary']['master_outcomes'] as $outcome) {
                        $unit_constant_name = get_unit_type($outcome['unit_name'], $outcome['unit_constants']);
                        $master_accuracy_list[] = [
                            "outcome_name" => getOutcomeName($outcome['outcome_name']),
                            "value" => (float)$outcome['value'],
                            "unit_constant_name" => $unit_constant_name
                        ];
                    }
                }
                $data['accuracy'] = [
                    "summary" => [
                        "master_outcomes" => $master_accuracy_list
                    ],
                    "detailed" => [
                        "unit_comes" => $unit_outcomes
                    ]
                ];
            }
            if ($menu == "sensitivity") {
                if (!empty($generated_output['sensitivity'])) {
                    $data['sensitivity'] = [
                        "summary" => [
                            "master_outcomes" => $generated_output['sensitivity']['summary']['master_outcomes'],
                            "graphs" => $generated_output['sensitivity']['summary']['graphs_data']
                        ],
                        "detailed" => [
                            "unit_outcomes" => $generated_output['sensitivity']['detailed']['unit_outcomes'],
                            "graphs" => $generated_output['sensitivity']['detailed']['graphs_data']
                        ]
                    ];
                } else {
                    $data['sensitivity'] = [];
                }
            }
            if ($menu == "process_diagram") {
                $var_img = Variation::select('id', 'process_flow_chart')->where('id', $experiment_report->variation_id)->first();
                $streamdata = [];
                $stream_response = $generated_output['process_diagram']['stream_data'];
                $stream_value = [];
                $streams = [];
                if (!empty($stream_response)) {
                    $streams = array_column($stream_response, 'stream_id');
                    $streamids = array_column($streams, 'id');
                    $pd = [];
                    $pdids = array_column($stream_response, 'mass_flow_rate_info');
                    foreach ($pdids as $pk => $p) {
                        $pd[] = (array_column($p, 'product_id'));
                    }
                    foreach ($pd as $pkk => $pp) {
                        foreach ($pp  as $pii) {
                            $stream_value[] = $pii;
                        }
                    }
                }
                $streamvalue['prdid'] = array_unique($stream_value);
                $streamvalue['streams'] = $streams;
                $data['process_diagram'] = [
                    "stream" => $stream_response,
                    "streamvalue" => $streamvalue,
                    "var_img" => $var_img
                ];
            }
            if ($menu == "assumptions") {
                $data['assumptions'] = $generated_output['assumptions'];
            }
            if ($menu == "recommendations") {
                $data['recommendations'] = $generated_output['recommendations'];
            }
            if ($menu == "simulation_notes") {
                $data['simulation_notes'] = $generated_output['simulation_notes'];
            }
            if ($menu == "list_of_models") {
                $data['list_of_models'] = $generated_output['list_of_models'];
            }
        } else {
            $folder = "backward";
            $data['execution_time'] = (float)$generated_output['predicted_input_key_results']['detailed']['simulation_statistics'];
            if ($menu == "desired_outcomes") {
                $desired_outcome = [];
                if (!empty($generated_output['desired_outcomes']['summary'])) {
                    foreach ($generated_output['desired_outcomes']['summary'] as $ko => $kv) {
                        $unit_constant_name = get_unit_type($kv['unit_id'], $kv['unit_constant_id']);
                        $desired_outcome[] = [
                            "outcome_name" => getOutcomeName($kv['outcome_id']),
                            "value" => (float)$kv['value'],
                            "unit_constant_name" => $unit_constant_name
                        ];
                    }
                }
                if (!empty($generated_output['desired_outcomes']['detailed'])) {
                    foreach ($generated_output['desired_outcomes']['detailed']['master_conditions'] as $mk => $master_condition) {
                        $condition_info = getConditionInfoReport($master_condition['condition_id'], $master_condition['unit_constant_id']);
                        $master_conditions[] = [
                            "condition_name" => $condition_info['condition_name'],
                            "value" => (float)$master_condition['value'],
                            "unit_constant_name" => $condition_info['unit_constant_name']
                        ];
                    }
                    $raw_materials = [];
                    if (!empty($generated_output['desired_outcomes']['detailed']['raw_materials'])) {
                        foreach ($generated_output['desired_outcomes']['detailed']['raw_materials'] as $raw_material) {
                            $process_diagram_data = ProcessDiagram::find($raw_material['id']);
                            $unit_constant_name = get_unit_type($raw_material['unit_id'], $raw_material['unit_constant_id']);
                            $raw_materials[$raw_material['id']]['stream'] = $process_diagram_data['name'];
                            $raw_materials[$raw_material['id']]['flow_rate_value'] = $raw_material['flow_rate_value'];
                            $raw_materials[$raw_material['id']]['unit_constant_name'] = (!empty($unit_constant_name['unit_constant'])) ? $unit_constant_name['unit_constant']['unit_symbol'] : '-';
                            foreach ($raw_material['product_list'] as $product) {
                                $product_name = getsingleChemicalName($product['product_id']);
                                $raw_materials[$raw_material['id']]['detail'][] = [
                                    "prd_id" => $product['product_id'],
                                    "product_name" => $product_name,
                                    "value" => (float)$product['value'],
                                ];
                            }
                        }
                    }
                    $property_details = [];
                    $experiment_info = ProcessExperiment::find($experiment_report->experiment_id);
                    $product_list = [];
                    foreach ($experiment_info->chemical as $product) {
                        $product_list[] = $product;
                    }
                    $productproperty = [];
                    if (!empty($raw_materials)) {
                        // foreach ($raw_materials as $rakkey => $rawval) {
                        //     $productproperty[$rawval['prd_id']] = getsubprpertyValue($rawval['prd_id']);
                        // }
                    }
                }
                $data['desired_outcomes'] = [
                    "summary" => $desired_outcome,
                    "detailed" => [
                        "experiment_unit_condition" => $master_conditions,
                        "raw_material" => $raw_materials,
                        'productproperty' => ""
                    ]
                ];
            }
            if ($menu == "predicted_input_key_results") {
                $summary_conditions = [];
                if (!empty($generated_output['predicted_input_key_results']['summary'])) {
                    foreach ($generated_output['predicted_input_key_results']['summary'] as $mk => $summary_val) {
                        $unit_constant_name = get_unit_type($summary_val['unit_name'], $summary_val['unit_constants']);
                        $condition_info = getConditionInfoReport($summary_val['condition_name'], $summary_val['unit_constants']);
                        $summary_conditions[] = [
                            "condition_name" => $condition_info['condition_name'],
                            "value" => (float)$summary_val['value'],
                            "unit_constant_name" => $unit_constant_name
                        ];
                    }
                }
                $detailed_raw_materials = [];
                if (!empty($generated_output['predicted_input_key_results']['detailed']['stream'])) {
                    foreach ($generated_output['predicted_input_key_results']['detailed']['stream'] as $product) {
                        $product_name = getsingleChemicalName($product['product_id']);
                        $detailed_raw_materials[] = [
                            "prd_id" => $product['product_id'],
                            "product_name" => $product_name,
                            "value" => (float)$product['value'],
                        ];
                    }
                }
                $simulation_statistics = $generated_output['predicted_input_key_results']['detailed']['simulation_statistics'];
                $data['predicted_input_key_results'] = [
                    "summary" => $summary_conditions,
                    "detailed" => [
                        "stream" => $detailed_raw_materials,
                        "simulation_statistics" => $simulation_statistics
                    ],
                ];
            }
            if ($menu == "accuracy") {
                if (!empty($generated_output['accuracy']['summary'])) {
                    $master_accuracy_list = [];
                    foreach ($generated_output['accuracy']['summary'] as $outcome) {
                        $unit_constant_name = get_unit_type($outcome['unit_name'], $outcome['unit_constants']);
                        $master_accuracy_list[] = [
                            "outcome_name" => getOutcomeName($outcome['outcome_name']),
                            "value" => (float)$outcome['value'],
                            "unit_constant_name" => $unit_constant_name,
                            "setpoint_achieved" => $outcome['setpoint_achieved']
                        ];
                    }
                }
                $ittreation_cnt = 0;
                if (!empty($generated_output['accuracy']['detailed']['Number of iterations'])) {
                    $ittreation_cnt = $generated_output['accuracy']['detailed']['Number of iterations'];
                }
                $data['accuracy'] = [
                    "summary" => $master_accuracy_list,
                    "detailed" => $ittreation_cnt
                ];
            }
            if ($menu == "assumptions") {
                $data['assumptions'] = $generated_output['assumptions'];
            }
            if ($menu == "recommendations") {
                $data['recommendations'] = $generated_output['recommendations'];
            }
            if ($menu == "simulation_notes") {
                $data['simulation_notes'] = $generated_output['simulation_notes'];
            }
            if ($menu == "list_of_models") {
                $data['list_of_models'] = $generated_output['list_of_models'];
            }
            if ($menu == "sensitivity") {
                $data['sensitivity'] = [];
            }
        }
        $html = view('pages.console.report.experiment.' . $folder . '.' . $menu, compact('data'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function edit($id)
    {
        return view('pages.console.report.experiment.edit');
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ExperimentReport::where('id', ___decrypt($id))->update($update)) {
            ExperimentReport::destroy(___decrypt($id));
        }
        $this->status = true;
        $this->redirect = url('reports/experiment');
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
        if (ExperimentReport::whereIn('id', $processIDS)->update($update)) {
            ExperimentReport::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('reports/experiment');
        return $this->populateresponse();
    }

    public function process_output(Request $request)
    {
        try {
            $simulationData = ExperimentReport::find($request->report_id);
            $simulationData->output_data = !empty($request->output_data) ? $request->output_data : NULL;
            $simulationData->status = $request->status;
            $simulationData->messages = $request->messages;
            $simulationData->updated_at = now();
            $simulationData->save();
            
            $re= response()->json([
                'success' => "true",
                'status_code' => 200,
                'status' => "true",
                'data' => "Database Updated Successfully"
            ]);
            Log::info($re);
            return $re;
        } catch (\Exception $e) {
            return response()->json([
                'success' => "false",
                'status_code' => 500,
                'status' => "false",
                'data' => $e->getMessage()
            ]);
        }

    }

    public function downloadjson($id)
    {
        $experiment_report = ExperimentReport::find(___decrypt($id));
        $generated_output = json_decode($experiment_report->output_data, true);
        $data = [];
        $report_type = '';
        if ($experiment_report->report_type == 1) {
            $report_type = 'forward';
            $master_condition = [];
            $master_conditions = [];
            $experiment_unit_conditions = [];
            $raw_materials = [];
            if (!empty($generated_output)) {
                if (!empty($generated_output['inputs'])) {
                    if (!empty($generated_output['inputs']['summary'])) {
                        foreach ($generated_output['inputs']['summary'] as $mk => $master_condition) {
                            $condition_info = getConditionInfoReport($master_condition['condition_id'], $master_condition['unit_constant_id']);
                            $master_conditions['master_condition'][] = [
                                "condition_name" => $condition_info['condition_name'],
                                "value" => (float)$master_condition['value'],
                                "unit_constant_name" => $condition_info['unit_constant_name']
                            ];
                        }
                    }
                    $unit_conditions = [];
                    $process_exp_info = ProcessExperiment::find($experiment_report->experiment_id);
                    if (!empty($generated_output['inputs']['detailed']['experiment_units'])) {
                        foreach ($generated_output['inputs']['detailed']['experiment_units'] as $uk => $unit_condition) {
                            foreach ($process_exp_info->experiment_unit as $exp_unit) {
                                if ($exp_unit['id'] == $unit_condition['exp_unit_id']) {
                                    $expname = $exp_unit['unit'];
                                    $unit_constant_name = get_units_value($unit_condition['unit_id'], $unit_condition['unit_constant_id']);
                                    $experiment_unit_conditions[$unit_condition['exp_unit_id']]['experiment_unit_name'] = $expname;
                                    $experiment_unit_conditions[$unit_condition['exp_unit_id']]['experiment_equipment_unit'][] = [
                                        "condition_name" => getConditionName($unit_condition['condition_id']),
                                        "value" => (float)$unit_condition['value'],
                                        "unit_constant_name" => $unit_constant_name,
                                    ];
                                }
                            }
                        }
                    }
                    $raw_materials = [];
                    $prdid = [];
                    if (!empty($generated_output['inputs']['detailed']['raw_materials'])) {
                        foreach ($generated_output['inputs']['detailed']['raw_materials'] as $raw_material) {
                            $process_diagram_data = ProcessDiagram::find($raw_material['id']);
                            $unit_constant_name = get_unit_type($raw_material['unit_id'], $raw_material['unit_constant_id']);
                            $raw_materials[$raw_material['id']]['stream'] = $process_diagram_data['name'];
                            $raw_materials[$raw_material['id']]['flow_rate_value'] = $raw_material['flow_rate_value'];
                            $raw_materials[$raw_material['id']]['unit_constant_name'] = (!empty($unit_constant_name['unit_constant'])) ? $unit_constant_name['unit_constant']['unit_symbol'] : '-';
                            foreach ($raw_material['product_list'] as $product) {
                                $product_name = getsingleChemicalName($product['product_id']);
                                $raw_materials[$raw_material['id']]['detail'][] = [
                                    "prd_id" => $product['product_id'],
                                    "product_name" => $product_name,
                                    "value" => (float)$product['value'],
                                ];
                            }
                        }
                    }
                    $property_details = [];
                    $experiment_info = ProcessExperiment::find($experiment_report->experiment_id);
                    $product_list = [];
                    foreach ($experiment_info->chemical as $product) {
                        $product_list[] = $product;
                    }
                    $productproperty = [];
                    $data['inputs'] = [
                        "summary" => $master_conditions,
                        "detailed" => [
                            "experiment_unit_condition" => array_merge($experiment_unit_conditions),
                            "raw_material" => array_merge($raw_materials)
                        ]
                    ];
                }
                if (!empty($generated_output['key_results'])) {
                    $streamdata = [];
                    $key_master_outcome = [];
                    if (!empty($generated_output['key_results']['summary'])) {
                        foreach ($generated_output['key_results']['summary'] as $ko => $kv) {
                            $unit_constant_name = get_units_value($kv['unit_name'], $kv['unit_constants']);
                            $key_master_outcome['master_outcome'][] = [
                                "outcome_name" => getOutcomeName($kv['outcome_name']),
                                "value" => (float)$kv['value'],
                                "unit_constant_name" => $unit_constant_name
                            ];
                        }
                    }
                    $process_exp_info = ProcessExperiment::find($experiment_report->experiment_id);
                    $experiment_unit_outcomes = [];
                    if (!empty($generated_output['key_results']['detailed']['experiment_units'])) {
                        foreach ($generated_output['key_results']['detailed']['experiment_units'] as $ek => $eu) {
                            foreach ($process_exp_info->experiment_unit as $exp_unit) {
                                if ($exp_unit['id'] == $eu['exp_unit_id']) {
                                    $expname = $exp_unit['unit'];
                                    $unit_constant_name = get_units_value($eu['unit_id'], $eu['unit_constant_id']);
                                    $experiment_unit_outcomes[$eu['exp_unit_id']]['experiment_unit_name'] = $expname;
                                    $experiment_unit_outcomes[$eu['exp_unit_id']]['outcomes'][] = [
                                        "outcome_name" => $eu['outcome_name'],
                                        "value" => (float)$eu['value'],
                                        "unit_constant_name" => (!empty($unit_constant_name['unit_constant'])) ? $unit_constant_name['unit_constant']['unit_symbol'] : ''
                                    ];
                                }
                            }
                        }
                    }
                    $graph_response = [];
                    if (!empty($generated_output['key_results']['detailed']['graphs_data'])) {
                        $graph_response = $generated_output['key_results']['detailed']['graphs_data'];
                    }
                    $data['keyresults'] = [
                        "summary" => $key_master_outcome,
                        "detailed" => [
                            "experiment_unit_outcomes" => array_merge($experiment_unit_outcomes),
                            "graphs" => $graph_response
                        ]
                    ];
                    $stream_response = [];
                    if (!empty($generated_output['key_results']['detailed']['stream_data'])) {
                        $stream_response = $generated_output['key_results']['detailed']['stream_data'];
                    }
                    $stream_value = [];
                    if (!empty($stream_response)) {
                        foreach ($stream_response as $strk => $strv) {
                            $stream_value[$strk]['stream_name'] = $strv['stream_id']['stream_name'];
                            $massinfo = [];
                            if (!empty($strv['mass_flow_rate_info'])) {
                                foreach ($strv['mass_flow_rate_info'] as $massinfok => $massinfoval) {
                                    $massinfo[] = [
                                        "value" => $massinfoval['value'],
                                        "product" => getsingleChemicalName($massinfoval['product_id'])
                                    ];
                                }
                            }
                            $stream_value[$strk]['mass_flow_rate_info'] = $massinfo;
                        }
                    }
                    $data['process_diagram'] = [
                        "stream_details" => $stream_value,

                    ];
                    $simulation_statistics = !empty($generated_output['key_results']['detailed']['simulation_statistics']) ? $generated_output['key_results']['detailed']['simulation_statistics'] : '-';
                    $data['execution_time'] = ["simulation_statistics" => $simulation_statistics];
                }
                if (!empty($generated_output['assumptions'])) {
                    $data['assumptions'] =  $generated_output['assumptions'];
                }
                if (!empty($generated_output['recommendations'])) {
                    $data['recommendations'] = $generated_output['recommendations'];
                }
            }
        } else {
            $report_type = 'reverse';
            $desired_outcome = [];
            $master_conditions = [];
            $raw_materials = [];
            if (!empty($generated_output['desired_outcomes']['summary'])) {
                foreach ($generated_output['desired_outcomes']['summary'] as $ko => $kv) {
                    $unit_constant_name = get_units_value($kv['unit_id'], $kv['unit_constant_id']);
                    $desired_outcome[] = [
                        "outcome_name" => getOutcomeName($kv['outcome_id']),
                        "value" => (float)$kv['value'],
                        "unit_constant_name" => $unit_constant_name
                    ];
                }
            }
            if (!empty($generated_output['desired_outcomes']['detailed'])) {
                foreach ($generated_output['desired_outcomes']['detailed']['master_conditions'] as $mk => $master_condition) {
                    $condition_info = getConditionInfoReport($master_condition['condition_id'], $master_condition['unit_constant_id']);
                    $master_conditions[] = [
                        "condition_name" => $condition_info['condition_name'],
                        "value" => (float)$master_condition['value'],
                        "unit_constant_name" => $condition_info['unit_constant_name']
                    ];
                }
                $raw_materials = [];
                if (!empty($generated_output['desired_outcomes']['detailed']['raw_materials'])) {
                    foreach ($generated_output['desired_outcomes']['detailed']['raw_materials'] as $raw_material) {
                        $process_diagram_data = ProcessDiagram::find($raw_material['id']);
                        $unit_constant_name = get_units_value($raw_material['unit_id'], $raw_material['unit_constant_id']);
                        foreach ($raw_material['product_list'] as $product) {
                            $product_name = getsingleChemicalName($product['product_id']);
                            $raw_materials[] = [
                                "stream_name" => $process_diagram_data['name'],
                                "prd_id" => $product['product_id'],
                                "product_name" => $product_name,
                                "value" => (float)$product['value'],
                                "unit_constant_name" => (!empty($unit_constant_name['unit_constant'])) ? $unit_constant_name['unit_constant']['unit_symbol'] : ''
                            ];
                        }
                    }
                }
                $property_details = [];
                $experiment_info = ProcessExperiment::find($experiment_report->experiment_id);
                $product_list = [];
                foreach ($experiment_info->chemical as $product) {
                    $product_list[] = $product;
                }
                $productproperty = [];
                if (!empty($raw_materials)) {
                    foreach ($raw_materials as $rakkey => $rawval) {
                        $productproperty[$rawval['prd_id']] = getsubprpertyValue($rawval['prd_id']);
                    }
                }
            }
            $data['desired_outcomes'] = [
                "summary" => $desired_outcome,
                "detailed" => [
                    "experiment_unit_condition" => $master_conditions,
                    "raw_material" => $raw_materials,

                ]
            ];
            $summary_conditions = [];
            if (!empty($generated_output['predicted_input_key_results']['summary'])) {
                foreach ($generated_output['predicted_input_key_results']['summary'] as $mk => $summary_val) {
                    $unit_constant_name = get_units_value($summary_val['unit_name'], $summary_val['unit_constants']);
                    $condition_info = getConditionInfoReport($summary_val['condition_name'], $summary_val['unit_constants']);
                    $summary_conditions[] = [
                        "condition_name" => $condition_info['condition_name'],
                        "value" => (float)$summary_val['value'],
                        "unit_constant_name" => $unit_constant_name
                    ];
                }
            }
            $detailed_raw_materials = [];
            if (!empty($generated_output['predicted_input_key_results']['detailed']['stream'])) {
                foreach ($generated_output['predicted_input_key_results']['detailed']['stream'] as $product) {
                    $product_name = getsingleChemicalName($product['product_id']);
                    $detailed_raw_materials[] = [
                        "prd_id" => $product['product_id'],
                        "product_name" => $product_name,
                        "value" => (float)$product['value'],
                    ];
                }
            }
            $simulation_statistics = $generated_output['predicted_input_key_results']['detailed']['simulation_statistics'];
            $data['predicted_input_key_results'] = [
                "summary" => $summary_conditions,
                "detailed" => [
                    "stream" => $detailed_raw_materials,
                    "simulation_statistics" => $simulation_statistics
                ],
            ];
            $master_accuracy_list = [];
            if (!empty($generated_output['accuracy']['summary'])) {

                foreach ($generated_output['accuracy']['summary'] as $outcome) {
                    $unit_constant_name = get_units_value($outcome['unit_name'], $outcome['unit_constants']);
                    $master_accuracy_list[] = [
                        "outcome_name" => getOutcomeName($outcome['outcome_name']),
                        "value" => (float)$outcome['value'],
                        "unit_constant_name" => $unit_constant_name,
                        "setpoint_achieved" => $outcome['setpoint_achieved']
                    ];
                }
            }
            $ittreation_cnt = 0;
            if (!empty($generated_output['accuracy']['detailed']['Number of iterations'])) {
                $ittreation_cnt = $generated_output['accuracy']['detailed']['Number of iterations'];
            }
            $data['accuracy'] = [
                "summary" => $master_accuracy_list,
                "detailed" => $ittreation_cnt
            ];
            $data['assumptions'] = $generated_output['assumptions'];
            $data['recommendations'] = $generated_output['recommendations'];
            $data['simulation_notes'] = $generated_output['simulation_notes'];
            $data['list_of_models'] = $generated_output['list_of_models'];
            $data['sensitivity'] = [];
        }
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        $fileName = $report_type . time() . '.json';
        File::put(storage_path('json/' . $fileName), $newJsonString);
        return Response::download(storage_path('json/' . $fileName))->deleteFileAfterSend();
    }

    public function retry($id)
    {
        try {
            $report = ExperimentReport::find(___decrypt($id));
            $tenant = getTenentCalURL($report->tenant_id);
            if ($report->report_type == "1") {
                // $calc_url = env('RETRY_URL');
                $calc_url = !empty($tenant['calc_url']) ? $tenant['calc_url'] : env('RETRY_URL');
                $url = $calc_url . '/api/v1/experiment/generate/forward_report';
            } else {
                // $calc_url = env('RETRY_URL');
                $calc_url = !empty($tenant['calc_url']) ? $tenant['calc_url'] : env('RETRY_URL');

                $url = $calc_url . '/api/v1/experiment/generate/reverse_report';
            }
            $data = [
                'report_id' => $report->id,
                'simulate_input_id' => $report->simulation_input_id,
                'tenant_id' => session('tenant_id'),
                'request_type' => env('REQUEST_TYPE'),
                'user_id' => Auth::user()->id
            ];
            $report['status'] = "pending";
            $report['updated_by'] = Auth::user()->id;
            $report['updated_at'] = now();
            $report->save();
            $client = new Client();
            $options = [
                'form_params' => $data,
                // 'http_errors' => false,
                'timeout' => 3
            ];
            $promise = $client->request('POST', $url, $options);
            // $response = $promise->wait();
            $status = true;
            $message = "Success";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $this->status = true;
        $this->redirect = url('reports/experiment');
        return $this->populateresponse();
    }

    public function show_jobs()
    {
        // $queueName = 'default';
        // $redis = Redis::connection('tcp://localhost:6379')->llen();
        // $redis = new Predis\Client('tcp://localhost:6379');
        $redis = "";
        $data = "";
        if ($redis) {
            $data = "true";
        } else {
            $data = "false";
        }
        return view('pages.console.report.experiment.job_status', compact('data'));
    }

    public function editReportname(Request $request)
    {
        $process_experiment_report = ExperimentReport::find(___decrypt($request->var_id));
        $process_experiment_report = $process_experiment_report->toArray();
        $html = view('pages.console.report.experiment.edit', compact('process_experiment_report'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }
    public function updateName(Request $request)
    {
        $process_experiment_report = ExperimentReport::find(___decrypt($request->edit_report_id));
        $process_experiment_report->name = $request->edit_report_name;
        $process_experiment_report->updated_by = Auth::user()->id;
        $process_experiment_report->save();
        $status = true;
        $message = "Report Name Updated Successfully.";
        $response = [
            'success' => $status,
            'message' => $message
        ];
        return response()->json($response, 200);
    }
}
