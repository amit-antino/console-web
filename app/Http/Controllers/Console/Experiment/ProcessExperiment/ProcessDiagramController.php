<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Experiment\CriteriaMaster;
use Illuminate\Http\Request;
use App\Models\Experiment\ProcessDiagram;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\ProcessSimulation\SimulationFlowType;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\Product\Chemical;
use App\Models\Master\MasterUnit;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\ProcessExperiment\Variation;

class ProcessDiagramController extends Controller
{
    public function index(Request $request)
    {
        $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
        $arr = [];
        if (!empty($variton->process_flow_table)) {
            $arr = $variton->process_flow_table;
        }
        $processDiagram = ProcessDiagram::where('process_id', $variton->experiment_id)->whereIn('id', $arr)->get();

        $processDiagramArr = [];
        if (!empty($processDiagram)) {
            $processDiagramArr = $processDiagram->toArray();
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
        $process_experiment_info = [
            "process_experiment_id" => $request->process_experiment_id,
            "mass_flow_types" => $mass_flow_types,
            "processDiagramArr" => $processDiagramArr,
            "variation_id" => !empty($request->variation_id) ? $request->variation_id : '',
            "viewflag" => $request->viewflag
        ];
        $html = view('pages.console.experiment.experiment.profile.process_diagram_list')->with('process_experiment_info', $process_experiment_info)->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $processDiagram = new ProcessDiagram();
        $processDiagram->process_id = !empty($request['process_experiment_id']) ? ___decrypt($request['process_experiment_id']) : 0;
        $processDiagram->flowtype = !empty($request['mass_flow_type_id']) ? ___decrypt($request['mass_flow_type_id']) : 0;
        $processDiagram->name = !empty($request['process_stream_name']) ? $request['process_stream_name'] : '';
        $to_unit = [];
        if (!empty($request->experimentunit_input)) {
            $to_unit['experiment_unit_id'] = ___decrypt($request->experimentunit_input);
            $to_unit['experiment_unit_name'] = $request->experimentunit_input_text;
            $to_unit['input_stream'] = !empty($request->inputstreamtext) ? $request->inputstreamtext : '';
            $to_unit['input_stream_id'] = !empty($request->inputstreamvalue) ? $request->inputstreamvalue : '';
        }
        $from_unit = [];
        if (!empty($request->experimentunit_output)) {
            $from_unit['experiment_unit_id'] = ___decrypt($request->experimentunit_output);
            $from_unit['experiment_unit_name'] = $request->experimentunit_output_text;
            $from_unit['output_stream'] = $request->outputstreamtext;
            $from_unit['output_stream_id'] = $request->outputstreamvalue;
        }
        $products = [];
        if ($request->products) {
            foreach ($request->products as $product) {
                $products[] = ___decrypt($product);
            }
        }
        $processDiagram->from_unit = $from_unit;
        $processDiagram->to_unit = $to_unit;
        $processDiagram->openstream = $request->openstream;
        $processDiagram->products = $products;
        $processDiagram->status = 'active';
        $processDiagram->created_by = Auth::user()->id;
        $processDiagram->updated_by = Auth::user()->id;
        try {
            if ($processDiagram->save()) {
                $variation = Variation::find(___decrypt($request->vartion_id));
                $sreamArr = [];
                if (!empty($variation)) {
                    if (!empty($variation->process_flow_table)) {
                        $sreamArr = $variation->process_flow_table;
                    }
                }
                array_push($sreamArr, $processDiagram->id);
                $variation->process_flow_table = $sreamArr;
                $variation->updated_by = Auth::user()->id;
                $variation->save();
            }
            $success = true;
            $message = "Variation Saved Successfully";
            $response = [
                'success' => $success,
                'message' => $message
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function editData(Request $request)
    {
        $id = $request->id;
        $data['id'] = ___decrypt($id);
        $mass_flow_types = [];
        $processDiagram = ProcessDiagram::find(___decrypt($id));
        $process_experiment = ProcessExperiment::find($processDiagram->process_id);
        $experiment_units = [];
        if (!empty($process_experiment)) {
            if (!empty($process_experiment->experiment_unit)) {
                foreach ($process_experiment->experiment_unit as $experiment_unit) {
                    $experiment_units[] = [
                        "id" => $experiment_unit['id'],
                        "experiment_unit_name" => $experiment_unit['unit'],
                        "experiment_equipment_unit" => get_experiment_unit($experiment_unit['exp_unit']),
                    ];
                }
            }
            $data['processDiagram'] = $processDiagram->toArray();
        } else {
            $data['processDiagram'] = [];
        }
        $flow_types = SimulationFlowType::whereIn('type', [1, 2, 3])->get();
        if (!empty($flow_types)) {
            foreach ($flow_types as $flow_type) {
                $mass_flow_types[] = [
                    'id' => $flow_type['id'],
                    'name' => $flow_type['flow_type_name']
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
        $data['mass_flow_types'] = $mass_flow_types;
        $data['experiment_units'] = $experiment_units;
        $data['products'] = $products;
        $html = view('pages.console.experiment.experiment.profile.edit_modal', compact('data'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function getimgmodel(Request $request)
    {
        $data = $request->id;
        $html = view('pages.console.experiment.experiment.profile.diagramimage', compact('data'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function getDiagramImageView(Request $request)
    {
        $variation = Variation::find(___decrypt($request->vartion_id));
        $html = view('pages.console.experiment.experiment.profile.diagramimageview', compact('variation'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }
    //saveimgmodel getDiagramImageView
    public function saveimgmodel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'diagramimg_file' => 'nullable|image|mimes:jpeg,jpg,png,gif',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
            $response = [
                'success' => 0,
                'message' => $this->message
            ];
        } else {
            $variation = Variation::find(___decrypt($request->id));
            if (!empty($request->diagramimg_file)) {
                $image = upload_file($request, 'diagramimg_file', 'process_flow_img');
                $variation['process_flow_chart'] = $image;
            }
            $variation->updated_by = Auth::user()->id;
            $variation->save();
            $status = true;
            $message = "Added Successfully!";
            $response = [
                'success' => $status,
                'message' => $message
            ];
        }
        return response()->json($response, 200);
    }

    public function raw_material_edit_popup(Request $request, $pfd_stream_id)
    {
        $data['pfd_stream_id'] = ___decrypt($pfd_stream_id);
        $data['simulate_input_id'] = ___decrypt($request->simulate_input_id);
        $data['unit_constant_id'] = '';
        $data['unit_id'] = '';
        $mass_flow_types = [];
        $flow_types = SimulationFlowType::all();
        $processDiagram = ProcessDiagram::find(___decrypt($pfd_stream_id));
        $process_experiment = ProcessExperiment::find($processDiagram->process_id);
        $raw_material = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'raw_material')->where('id', $data['simulate_input_id'])->first();
        $pro = [];
        foreach ($raw_material->raw_material as $raw_mat) {
            if ($raw_mat['pfd_stream_id'] == $data['pfd_stream_id']) {
                if (!empty($raw_mat['product'])) {
                    foreach ($raw_mat['product'] as $key_count => $product) {
                        if (!empty($product['product_id'])) {
                            $associate_products = getAssociateValue(___encrypt($product['product_id']));
                            $pro[$key_count]['prod'] = $associate_products['prod']->chemical_name;
                            $pro[$key_count]['jsonArr'] = $associate_products['jsonArr'];
                            $pro[$key_count]['total'] = $product['value'];
                            $pro[$key_count][''] = !empty($product['value_flow_rate']) ? $product['value_flow_rate'] : 0;
                            $pro[$key_count]['product_id'] = $product['product_id'];
                            $data['unit_constant_id'] = $raw_mat['unit_constant_id'];
                            $data['unit_id'] = $raw_mat['unit_id'];
                            $data['value_flow_rate'] = $raw_mat['value_flow_rate'];
                            $master_unit = MasterUnit::where('id', $raw_mat['unit_id'])->first();
                        }
                    }
                }
            }
        }
        $products_ids = !empty($processDiagram->products) ? $processDiagram->products : [];
        $data['product'] = Chemical::Select('id', 'chemical_name')->WhereIn('id', $products_ids)->get();
        $prod = [];
        if (empty($pro)) {
            $prod['prod'] = [];
            $prod['jsonArr'] = [];
            $prod['total'] = 0;
            $prod['value_flow_rate'] = 0;
            $prod['product_id'] = 0;
            $prod['unit_constant_id'] = 0;
        }
        $data['product_arr'] = $pro;
        $data['master_unit'] = !empty($master_unit['unit_constant']) ? $master_unit['unit_constant'] : [];
        $data['request'] = $request;
        $data['experiment_id'] = $process_experiment->id;
        $data['processDiagram'] = !is_null($processDiagram) ? $processDiagram->toArray() : [];
        $data['count'] = !empty($request->count) ? $request->count : 0;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_output.raw_material.edit', compact('data', 'prod'))->render()
        ]);
    }

    public function product_raw_material_list(Request $request)
    {
        $prod = [];
        $experiment = ProcessExperiment::find(___decrypt($request->process_experiment_id));
        $data['product'] = Chemical::WhereIn('id', $experiment->chemical)->get();
        $master_units = MasterUnit::where('id', ___decrypt($request->parameters))->first();
        $data['master_unit'] = $master_units['unit_constant'];
        $data['default_unit'] = $master_units['default_unit'];
        $data['count'] = intval($request->count) + 1;
        $prod['total'] = 0;
        $prod['value_flow_rate'] = 0;
        $prod['unit_id'] = $request->parameters;
        $data['experiment_id'] = ___decrypt($request->process_experiment_id);
        $default_count = 0;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_output.raw_material.unit_type', compact('data', 'prod', 'default_count'))->render()
        ]);
    }

    public function raw_material_edit_popup_set_point(Request $request, $pfd_stream_id)
    {
        $data['pfd_stream_id'] = ___decrypt($pfd_stream_id);
        $data['simulate_input_id'] = ___decrypt($request->simulate_input_id);
        $data['unit_constant_id'] = '';
        $data['unit_id'] = '';
        $mass_flow_types = [];
        $flow_types = SimulationFlowType::all();
        $processDiagram = ProcessDiagram::find(___decrypt($pfd_stream_id));
        $process_experiment = ProcessExperiment::find($processDiagram->process_id);
        $raw_material = SimulateInput::Select('id', 'experiment_id', 'variation_id', 'raw_material')->where('id', $data['simulate_input_id'])->first();
        $pro = [];
        foreach ($raw_material->raw_material as $raw_mat) {
            if ($raw_mat['pfd_stream_id'] == $data['pfd_stream_id']) {
                if (!empty($raw_mat['product'])) {
                    foreach ($raw_mat['product'] as $key_count => $product) {
                        if (!empty($product['product_id'])) {
                            $associate_products = getAssociateValue(___encrypt($product['product_id']));
                            $pro[$key_count]['prod'] = $associate_products['prod']->chemical_name;
                            $pro[$key_count]['jsonArr'] = $associate_products['jsonArr'];
                            $pro[$key_count]['total'] = $product['value'];
                            $pro[$key_count]['max_value'] = !empty($product['max_value']) ? $product['max_value'] : 0;
                            $pro[$key_count]['criteria'] = !empty($product['criteria']) ? $product['criteria'] : 0;
                            $pro[$key_count][''] = !empty($product['value_flow_rate']) ? $product['value_flow_rate'] : 0;
                            $pro[$key_count]['product_id'] = $product['product_id'];
                            $data['unit_constant_id'] = $raw_mat['unit_constant_id'];
                            $data['unit_id'] = $raw_mat['unit_id'];
                            $data['value_flow_rate'] = $raw_mat['value_flow_rate'];
                            $master_unit = MasterUnit::where('id', $raw_mat['unit_id'])->first();
                        }
                    }
                }
            }
        }
        if (!empty($processDiagram->products)) {
            $data['product'] = Chemical::Select('id', 'chemical_name')->WhereIn('id', $processDiagram->products)->get();
        } else {
            $data['product'] = [];
        }

        $prod = [];
        if (empty($pro)) {
            $prod['prod'] = [];
            $prod['jsonArr'] = [];
            $prod['total'] = 0;
            $prod['value_flow_rate'] = 0;
            $prod['product_id'] = 0;
            $prod['unit_constant_id'] = 0;
        }
        $data['product_arr'] = $pro;
        $criteria = CriteriaMaster::where(['status' => 'active'])->get();;
        $data['master_unit'] = !empty($master_unit['unit_constant']) ? $master_unit['unit_constant'] : [];
        $data['request'] = $request;
        $data['experiment_id'] = $process_experiment->id;
        $data['processDiagram'] = $processDiagram->toArray();
        $data['count'] = !empty($request->count) ? $request->count : 0;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_set_point.raw_material.edit', compact('data', 'prod', 'criteria'))->render()
        ]);
    }

    public function product_raw_material_list_set_point(Request $request)
    {
        $prod = [];
        $experiment = ProcessExperiment::find(___decrypt($request->process_experiment_id));
        $data['product'] = Chemical::WhereIn('id', $experiment->chemical)->get();
        $master_units = MasterUnit::where('id', ___decrypt($request->parameters))->first();
        $data['master_unit'] = $master_units['unit_constant'];
        $data['count'] = intval($request->count) + 1;
        $prod['total'] = 0;
        $prod['value_flow_rate'] = 0;
        $prod['unit_id'] = $request->parameters;
        $data['experiment_id'] = ___decrypt($request->process_experiment_id);
        $default_count = 0;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulation_set_point.raw_material.unit_type', compact('data', 'prod', 'default_count'))->render()
        ]);
    }

    public function update(Request $request)
    {
        $processDiagram = ProcessDiagram::find($request->processDiagramId);
        $processDiagram->process_id = !empty($request['process_experiment_id']) ? ___decrypt($request['process_experiment_id']) : 0;
        $processDiagram->flowtype = !empty($request['mass_flow_type_id']) ? ___decrypt($request['mass_flow_type_id']) : 0;
        $processDiagram->name = $request['process_stream_name'];
        $to_unit = [];
        if (!empty($request->experimentunit_input)) {
            $to_unit['experiment_unit_id'] = ___decrypt($request->experimentunit_input);
            $to_unit['experiment_unit_name'] = $request->experimentunit_input_text;
            $to_unit['input_stream'] = !empty($request->inputstreamtext) ? $request->inputstreamtext : '';
            $to_unit['input_stream_id'] = !empty($request->inputstreamvalue) ? $request->inputstreamvalue : '';
        }
        $from_unit = [];
        if (!empty($request->experimentunit_output)) {
            $from_unit['experiment_unit_id'] = ___decrypt($request->experimentunit_output);
            $from_unit['experiment_unit_name'] = $request->experimentunit_output_text;
            $from_unit['output_stream'] = $request->outputstreamtext;
            $from_unit['output_stream_id'] = $request->outputstreamvalue;
        }
        $products = [];
        if ($request->products) {
            foreach ($request->products as $product) {
                $products[] = ___decrypt($product);
            }
        }
        $processDiagram->from_unit = $from_unit;
        $processDiagram->to_unit = $to_unit;
        $processDiagram->openstream = $request->openstream;
        $processDiagram->products = $products;
        $processDiagram->updated_by = Auth::user()->id;
        $processDiagram->updated_at = now();
        try {
            $processDiagram->save();
            $success = true;
            $message = "Variation Updated Successfully";
            $response = [
                'success' => $success,
                'message' => $message
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function deleteDiagram(Request $request)
    {
        $id = $request->id;
        $processDiagram = ProcessDiagram::find(___decrypt($id));
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProcessDiagram::where('id', ___decrypt($id))->update($update)) {
            ProcessDiagram::destroy(___decrypt($id));
        }
        $response = [
            'success' => true,
            'message' => "delete"
        ];
        return response()->json($response, 200);
    }

    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->ids);
        $processIDS1 = explode(',', ($id_string));
        foreach ($processIDS1 as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        $peId = ProcessDiagram::whereIn('id', $processIDS)->get();
        $commonId = array_unique(array_column($peId->toArray(), 'process_id'));
        if (ProcessDiagram::whereIn('id', $processIDS)->update($update)) {
            ProcessDiagram::destroy($processIDS);
        }
        $response = [
            'success' => true,
            'message' => "delete"
        ];
        return response()->json($response, 200);
    }
}
