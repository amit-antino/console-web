<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Experiment\SimulateInputExcelTemplate;
use App\Models\ProcessExperiment\Variation;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\Experiment\ProcessDiagram;
use App\Models\Product\Chemical;
use App\Models\Master\MasterUnit;
use App\Models\ProcessExperiment\ProcessExpProfileMaster;
use App\Models\ProcessExperiment\ProcessExpProfile;
use App\Models\Experiment\ExperimentConditionMaster;
use App\Models\Experiment\ExperimentOutcomeMaster;
use App\Exports\SimTemplate;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\Experiment\CriteriaMaster;
use App\Models\Experiment\sim_inp_template_upload;
use DB;

class SimulationExcelConfigController extends Controller
{
    public function index(Request $request)
    {
        $variation_id = ___decrypt($request->id);
        $data = SimulateInputExcelTemplate::select('id', 'variation_id', 'template_name', 'status', 'simulate_id', 'raw_material', 'master_conditions', 'exp_unit_conditions', 'master_outcomes', 'exp_unit_outcomes', 'description', 'created_by', 'updated_by')
            ->where([['variation_id', $variation_id], ['simulate_id', '=', 0]])->with('forwardlog')->with('reverselog')
            ->orderBy('id', 'desc')->get();
        $variation = Variation::where('id', $variation_id)->first();
        return view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.index')->with(['data' => $data, 'variation' => $variation]);
    }

    public function create()
    {
    }

    public function excelTemplateWithData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $Data = new SimulateInputExcelTemplate();
            $Data->variation_id = ___decrypt($request->variation_id);
            $Data->template_name = $request->template_name;
            $Data->description = $request->description;
            $Data->created_by = Auth::user()->id;
            $Data->save();
            $sinp = SimulateInput::find($request->simulate_id);
            $sinp->template_id = $Data->id;
            $sinp->save();
            $this->status = true;
            $this->modal = true;
            //$this->redirect = url('/experiment/experiment/' . $request->variation_id . '/sim_excel_config');
            $this->message = "Simulatation Input Excel Template Created Successfully!";
        }
        return $this->populateresponse();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $Data = new SimulateInputExcelTemplate();
            $Data->variation_id = ___decrypt($request->variation_id);
            $Data->template_name = $request->template_name;
            $Data->description = $request->description;
            $Data->created_by = Auth::user()->id;

            if ($request->has('simulate_id') && $request->simulate_id != "") {
                $Data->simulate_id = ___decrypt($request->simulate_id);
            }
            $Data->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/experiment/experiment/' . $request->variation_id . '/sim_excel_config');
            $this->message = "Simulatation Input Excel Template Created Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
    }

    public function edit($id, $template_id)
    {
        $excel_template = SimulateInputExcelTemplate::Select('id', 'variation_id', 'template_name', 'description')->where('id', ___decrypt($template_id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.edit_simulation_input_excel', ['excel_template' => $excel_template])->render()
        ]);
    }

    public function update(Request $request, $id, $template_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $template = SimulateInputExcelTemplate::find(___decrypt($template_id));
            $template['template_name'] = $request->name;
            $template['description'] = $request->description;
            $template['updated_by'] = Auth::user()->id;
            $template['updated_at'] = now();
            $template->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = " Simulation Inputs Excel Template Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function manage($id)
    {
        $template = SimulateInputExcelTemplate::where('id', ___decrypt($id))->first();
        $check_template_used = templateUsed(___decrypt($id));
        //SimulateInput::where('template_id', ___decrypt($id))->first();
        $variation = Variation::where('id', $template->variation_id)->first();
        $process_experiment = ProcessExperiment::find($variation->experiment_id);
        $processDiagram = ProcessDiagram::whereIn('id', $variation->process_flow_table)->where('openstream', '1')->get();
        // $product_list = Chemical::Select('id', 'chemical_name')->WhereIn('id', $variation['products'])->get();
        $master_unit_id = $variation['unit_specification']['master_units'];
        $conditions = ProcessExpProfileMaster::Select('id', 'condition')->where('id', $master_unit_id)->first();
        $mcount_conditions = !is_null($conditions)?ExperimentConditionMaster::WhereIn('id', $conditions->condition)->count():0;
        $outcomes = ProcessExpProfileMaster::Select('id', 'outcome')->where('id', $master_unit_id)->first();
        $mcount_outcomes = !is_null($outcomes)?ExperimentOutcomeMaster::WhereIn('id', $outcomes->outcome)->count():0;
        $ecount_conditions = 0;
        $ecount_outcome = 0;
        foreach ($variation['unit_specification']['experiment_units'] as $exp_unit_id) {
            $conditions = ProcessExpProfile::Select('id', 'condition', 'outcome', 'experiment_unit')->where([['id', $exp_unit_id], ['variation_id', $variation['id']]])->first();
            $count = ExperimentConditionMaster::WhereIn('id', $conditions->condition)->count();
            $ecount_conditions = (!is_null($count) ? $count : 0) + $ecount_conditions;
            $ocount = ExperimentOutcomeMaster::WhereIn('id', $conditions->outcome)->count();
            $ecount_outcome = (!is_null($ocount) ? $ocount : 0) + $ecount_outcome;
        }
        $data['master_condition'] = $mcount_conditions;
        $data['master_outcome'] = $mcount_outcomes;
        $data['exp_condition'] = $ecount_conditions;
        $data['exp_outcome'] = $ecount_outcome;
        $template_used = '';
        if (!empty($check_template_used)) {
            $template_used = 'yes';
        }
        return view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.manage')->with(['template' => $template, 'variation' => $variation, 'process_experiment' => $process_experiment, 'template_used' => $template_used, 'processdiagram' => $processDiagram, 'data' => $data]);
    }

    public function showStream(Request $request)
    {
        $tnt_id = session()->get('tenant_id');
        $id = $request->template_id;
        $template_name = $request->template_name;
        $data['template_name'] = $template_name;
        $data['type'] = $request->type;
        $data['puid'] = $id;
        $criteria = CriteriaMaster::where(['status' => 'active'])->get();
        $data['unit_tab_id'] = $request->unit_tab_id;
        $process_experiment = ProcessExperiment::find(___decrypt($request->experiment_id));
        $template = SimulateInputExcelTemplate::find(___decrypt($request->template_id));
        $variation = Variation::where('id', $template->variation_id)->first();
        if ($request->tab == 'raw_material') {
            $pfd = ProcessDiagram::find(___decrypt($request->stream_id));
            //$product_list = Chemical::Select('id', 'chemical_name')->WhereIn('id', $process_experiment->chemical)->get();

            $product_list = Chemical::Select('id', 'chemical_name')->WhereIn('id', $pfd->products)->get();
            $exp_product_list = [];
            if (!empty($product_list)) {
                foreach ($product_list as $product) {
                    $exp_product_list[] = [
                        'id' => $product->id,
                        'product_name' => $product->chemical_name
                    ];
                }
            }
            if (!empty($template['raw_material'])) {
                foreach (json_decode($template->raw_material) as $key => $rm) {
                    if ($key == $request->type) {
                        foreach ($rm as $k => $sd) {
                            if (!empty($sd)) {
                                if ($sd->stream_id == ___decrypt($request->stream_id)) {
                                    $data['stream_data'] = $sd;
                                    $master_units = MasterUnit::where('id', $data['stream_data']->unitid)->first();
                                    $data['master_unit'] = !empty($master_units['unit_constant']) ? $master_units['unit_constant'] : 0;
                                    $data['default_unit'] = !empty($master_units['default_unit']) ? $master_units['default_unit'] : 0;
                                    if ($request->type == 'reverse') {
                                        $data['criteria'] = !empty($sd->criteria) ? $sd->criteria : [];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $data['exp_product_list'] = $exp_product_list;
            $html = view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.excel_pfd_data', compact('data', 'criteria'))->render();
        }
        if ($request->tab == 'master_condition') {
            if (!empty($variation['unit_specification']['master_units'])) {
                $key = 0;
                $master_unit_id = $variation['unit_specification']['master_units'];
                $conditions = ProcessExpProfileMaster::Select('id', 'condition')->where('id', $master_unit_id)->first();
                $var_conditions = ExperimentConditionMaster::WhereIn('id', $conditions->condition)->get();
                $master_condition_output = [];
                if (!empty($template->master_conditions)) {
                    foreach (json_decode($template->master_conditions) as $key => $row) {
                        if ($key == $request->type) {
                            $selected_master_conditions = $row;
                        }
                    }
                }
                foreach ($var_conditions as $key => $condition) {
                    $master_condition_output[$key]['id'] = $condition['id'];
                    $master_condition_output[$key]['condition'] = $condition['name'];
                    if ($request->type == 'reverse') {
                        $master_condition_output[$key]['criteria'] = !empty($row[$key]->criteria) ? $row[$key]->criteria : 0;
                    }
                    $master_condition_output[$key]['unit_id'] = $condition['unittype'];
                    $unit_constant_data = MasterUnit::where('id', $condition['unittype'])->first();
                    $master_condition_output[$key]['unit_constants'] = $unit_constant_data['unit_constant'];
                    $master_condition_output[$key]['default_unit'] = $unit_constant_data['default_unit'];
                    $master_condition_output[$key]['selected_unit_constant'] = 0;
                    $master_condition_output[$key]['isdefault'] = 1;
                    if (!empty($selected_master_conditions)) {
                        foreach ($selected_master_conditions as $sc) {
                            if (___decrypt($sc->conditionid) == $condition['id']) {
                                $master_condition_output[$key]['selected_unit_constant'] = ___decrypt($sc->unit_constant);
                                $master_condition_output[$key]['isdefault'] = $sc->isdefault;
                            }
                        }
                    }
                }
                $data['condition_data'] = $master_condition_output;
            }
            $html = view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.excel_master_conditions', compact('data', 'criteria'))->render();
        }

        if ($request->tab == 'master_outcome') {
            if (!empty($variation['unit_specification']['master_units'])) {
                $key = 0;
                $master_unit_id = $variation['unit_specification']['master_units'];
                $outcomes = ProcessExpProfileMaster::Select('id', 'outcome')->where('id', $master_unit_id)->first();
                $var_outcomes = ExperimentOutcomeMaster::WhereIn('id', $outcomes->outcome)->get();
                $master_outcome_output = [];
                if (!empty($template->master_outcomes)) {
                    foreach (json_decode($template->master_outcomes) as $key => $row) {
                        if ($key == $request->type) {
                            $selected_master_outcomes = $row;
                            // foreach($row as $k=>$sd){
                            //     if($sd->stream_id==___decrypt($request->stream_id)){
                            //         $selected_master_outcomes =$sd->outcomes;
                            //     }        
                            // }
                        }
                    }
                }
                foreach ($var_outcomes as $key => $outcome) {
                    $master_outcome_output[$key]['id'] = $outcome['id'];
                    $master_outcome_output[$key]['outcome'] = $outcome['name'];
                    if ($request->type == 'reverse') {
                        $master_outcome_output[$key]['criteria'] = !empty($row[$key]->criteria) ? $row[$key]->criteria : 0;
                    }
                    $master_outcome_output[$key]['unit_id'] = $outcome['unittype'];
                    $unit_constant_data = MasterUnit::where('id', $outcome['unittype'])->first();
                    $master_outcome_output[$key]['unit_constants'] = $unit_constant_data['unit_constant'];
                    $master_outcome_output[$key]['default_unit'] = $unit_constant_data['default_unit'];
                    $master_outcome_output[$key]['selected_unit_constant'] = 0;
                    $master_outcome_output[$key]['isdefault'] = 1;
                    if (!empty($selected_master_outcomes)) {
                        foreach ($selected_master_outcomes as $sc) {
                            if (___decrypt($sc->outcomeid) == $outcome['id']) {
                                $master_outcome_output[$key]['selected_unit_constant'] = ___decrypt($sc->unit_constant);
                                $master_outcome_output[$key]['isdefault'] = $sc->isdefault;
                            }
                        }
                    }
                }
                $data['outcome_data'] = $master_outcome_output;
            }
            $html = view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.excel_master_outcomes', compact('data', 'criteria'))->render();
        }
        if ($request->tab == 'exp_condition') {
            if (!empty($variation['unit_specification']['experiment_units'])) {
                $key = 0;
                $exp_unit_conditions = [];
                foreach ($variation['unit_specification']['experiment_units'] as $exp_unit_id) {
                    $conditions = ProcessExpProfile::Select('id', 'condition', 'experiment_unit')->where([['id', $exp_unit_id], ['variation_id', $variation['id']]])->first();
                    if (!empty($conditions)) {
                        $experiment_unit = array_search($conditions->experiment_unit, array_column($process_experiment['experiment_unit'], 'id'));

                        $exp_unit = $process_experiment['experiment_unit'][$experiment_unit]['unit'];
                        $var_conditions = ExperimentConditionMaster::WhereIn('id', $conditions->condition)->get();
                        if (!empty($template->exp_unit_conditions)) {
                            foreach (json_decode($template->exp_unit_conditions) as $typekey => $row) {
                                if ($typekey == $request->type) {
                                    $selected_conditions = $row;
                                    // foreach($row as $k=>$sd){
                                    //     if($sd->stream_id==___decrypt($request->stream_id)){
                                    //         $selected_conditions =$sd->conditions;
                                    //     }        
                                    // }
                                }
                            }
                        }
                        foreach ($var_conditions as $ckey => $condition) {
                            $exp_condition_output[$key]['exp_unit_id'] = $conditions->experiment_unit;
                            $exp_condition_output[$key]['exp_unit'] = $exp_unit;
                            $exp_condition_output[$key]['id'] = $condition['id'];
                            $exp_condition_output[$key]['condition'] = $condition['name'];
                            if ($request->type == 'reverse') {
                                $exp_condition_output[$key]['criteria'] = !empty($condition['criteria']) ? $condition['criteria'] : 0;
                            }
                            $exp_condition_output[$key]['unit_id'] = $condition['unittype'];
                            $unit_constant_data = MasterUnit::where('id', $condition['unittype'])->first();
                            $exp_condition_output[$key]['unit_constants'] = $unit_constant_data['unit_constant'];
                            $exp_condition_output[$key]['default_unit'] = $unit_constant_data['default_unit'];
                            $exp_condition_output[$key]['selected_unit_constant'] = 0;
                            $exp_condition_output[$key]['isdefault'] = 1;
                            if (!empty($selected_conditions)) {
                                foreach ($selected_conditions as $sc) {
                                    if (___decrypt($sc->conditionid) == $condition['id'] && ___decrypt($sc->exp_unit_id) == $conditions->experiment_unit) {
                                        $exp_condition_output[$key]['selected_unit_constant'] = ___decrypt($sc->unit_constant);
                                        $exp_condition_output[$key]['isdefault'] = $sc->isdefault;
                                        if ($request->type == 'reverse') {
                                            $exp_condition_output[$key]['criteria'] = !empty($sc->criteria) ? $sc->criteria : 0;
                                        }
                                    }
                                }
                            }
                            $key++;
                        }
                    }
                }
                $data['condition_data'] = isset($exp_condition_output) ? $exp_condition_output : [];
            }
            $html = view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.excel_exp_conditions', compact('data', 'criteria'))->render();
        }
        if ($request->tab == 'exp_outcome') {
            if (!empty($variation['unit_specification']['experiment_units'])) {
                $key = 0;
                $exp_unit_outcomes = [];
                foreach ($variation['unit_specification']['experiment_units'] as $exp_unit_id) {
                    $outcomes = ProcessExpProfile::Select('id', 'outcome', 'experiment_unit')->where([['id', $exp_unit_id], ['variation_id', $variation['id']]])->first();
                    if (!empty($outcomes)) {
                        $experiment_unit = array_search($outcomes->experiment_unit, array_column($process_experiment['experiment_unit'], 'id'));
                        $exp_unit = $process_experiment['experiment_unit'][$experiment_unit]['unit'];
                        $var_outcomes = ExperimentOutcomeMaster::WhereIn('id', $outcomes->outcome)->get();
                        if (!empty($template->exp_unit_outcomes)) {
                            foreach (json_decode($template->exp_unit_outcomes) as $typekey => $row) {
                                if ($typekey == $request->type) {
                                    $selected_outcomes = $row;
                                    // foreach($row as $k=>$sd){
                                    //     if($sd->stream_id==___decrypt($request->stream_id)){
                                    //         $selected_outcomes =$sd->outcomes;
                                    //     }        
                                    // }
                                }
                            }
                        }
                        foreach ($var_outcomes as $okey => $outcome) {
                            $exp_outcome_output[$key]['exp_unit_id'] = $outcomes->experiment_unit;
                            $exp_outcome_output[$key]['exp_unit'] = $exp_unit;
                            $exp_outcome_output[$key]['id'] = $outcome['id'];
                            $exp_outcome_output[$key]['outcome'] = $outcome['name'];
                            $exp_outcome_output[$key]['unit_id'] = $outcome['unittype'];
                            if ($request->type == 'reverse') {
                                $exp_outcome_output[$key]['criteria'] = !empty($outcome['criteria']) ? $outcome['criteria'] : 0;
                            }
                            $unit_constant_data = MasterUnit::where('id', $outcome['unittype'])->first();
                            $exp_outcome_output[$key]['unit_constants'] = $unit_constant_data['unit_constant'];
                            $exp_outcome_output[$key]['default_unit'] = $unit_constant_data['default_unit'];
                            $exp_outcome_output[$key]['selected_unit_constant'] = 0;
                            $exp_outcome_output[$key]['isdefault'] = 1;
                            if (!empty($selected_outcomes)) {
                                foreach ($selected_outcomes as $sc) {
                                    if (___decrypt($sc->outcomeid) == $outcome['id'] && ___decrypt($sc->exp_unit_id) == $outcomes->experiment_unit) {
                                        $exp_outcome_output[$key]['selected_unit_constant'] = $sc->unit_constant != null ? ___decrypt($sc->unit_constant) : 0;
                                        $exp_outcome_output[$key]['isdefault'] = $sc->isdefault;
                                        if ($request->type == 'reverse') {
                                            $exp_outcome_output[$key]['criteria'] = !empty($sc->criteria) ? $sc->criteria : 0;
                                        }
                                    }
                                }
                            }
                            $key++;
                        }
                    }
                }
                $data['outcome_data'] = $exp_outcome_output;
            }
            $html = view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.excel_exp_outcomes', compact('data', 'criteria'))->render();
        }
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function master_units(Request $request)
    {
        $master_units = MasterUnit::where('id', ___decrypt($request->parameters))->first();
        $data['master_unit'] = $master_units['unit_constant'];
        $data['default_unit'] = $master_units['default_unit'];
        $data['count'] = intval($request->count) + 1;
        $prod['unit_id'] = $request->parameters;
        $default_count = 0;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.simulate_input_excel_template.master_unit', compact('data', 'prod', 'default_count'))->render()
        ]);
    }

    public function saveRawMaterial(Request $request)
    {
        $template = SimulateInputExcelTemplate::find(___decrypt($request->template_id));
        $stream_id = ___decrypt($request->stream_id);
        $type = $request->type;
        $raw_material = [];
        // $criteria = !empty($request->criteria) ? ___decrypt($request->criteria) : [];
        if (!empty($request->products)) {
            foreach ($request->products as $product) {
                if (!empty($product)) {
                    $selected_products[] = !empty($product) ? ___decrypt($product) : 0;
                }
            }
            $selected_products = $request->products;
        }
        if (!empty($request->criteria)) {
            foreach ($request->criteria as $crie) {
                $selected_criteria[] = !empty($crie) ? ___decrypt($crie) : 0;
            }
            $selected_criteria = $request->criteria;
        }
        $raw_material[$type][] = [
            "stream_id" => $stream_id,
            "criteria" => !empty($selected_criteria) ? $selected_criteria : [],
            "products" => !empty($selected_products) ? $selected_products : [],
            "unitid" => !empty($request->unitid) ? ___decrypt($request->unitid) : "0",
            "isdefault" => !empty($request->isdefault) ? $request->isdefault : "0",
            "unit_constant_id" => !empty($request->unit_constant_id) ? ___decrypt($request->unit_constant_id) : "0"
        ];
        if (!empty($template->raw_material)) {
            foreach (json_decode($template->raw_material) as $key => $rm) {
                if ($key != $type) {
                    $raw_material[$key] = $rm;
                } else {
                    foreach ($rm as $k => $sd) {
                        if ($sd->stream_id != $stream_id) {
                            $raw_material[$type][] = $sd;
                        }
                    }
                }
            }
        }
        $template['raw_material'] = $raw_material;
        $template['updated_by'] = Auth::user()->id;
        $template['updated_at'] = now();
        $template->save();
        $this->success = true;
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        $this->message = " Simulation Inputs Excel Template Updated Successfully!";
        return $this->populateresponse();
    }

    public function saveMasterCondition(Request $request)
    {
        $template = SimulateInputExcelTemplate::find(___decrypt($request->template_id));
        $stream_id = ___decrypt($request->stream_id);
        $type = $request->type;
        $master_condition = [];
        $master_condition[$type] = !empty($request->arr) ? $request->arr : "";
        if (!empty($template->master_conditions)) {
            foreach (json_decode($template->master_conditions) as $key => $row) {
                if ($key != $type) {
                    $master_condition[$key] = $row;
                } else {
                    // foreach($row as $k=>$sd){
                    //     if($sd->stream_id!=$stream_id){
                    //         $master_condition[$type][]=$sd;
                    //      }
                    // }
                }
            }
        }
        $template['master_conditions'] = $master_condition;
        $template['updated_by'] = Auth::user()->id;
        $template['updated_at'] = now();
        $template->save();
        $this->success = true;
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        $this->message = " Simulation Inputs Excel Template Updated Successfully!";
        return $this->populateresponse();
    }

    public function saveMasterOutcome(Request $request)
    {
        $template = SimulateInputExcelTemplate::find(___decrypt($request->template_id));
        $stream_id = ___decrypt($request->stream_id);
        $type = $request->type;
        $master_outcome = [];
        $master_outcome[$type] = !empty($request->arr) ? $request->arr : "";
        // $master_outcome[$type][]=[
        //     "stream_id"=>$stream_id,
        //     "outcomes"=>!empty($request->arr)?$request->arr:"",
        // ];
        if (!empty($template->master_outcomes)) {
            foreach (json_decode($template->master_outcomes) as $key => $row) {
                if ($key != $type) {
                    $master_outcome[$key] = $row;
                } else {
                    // foreach($row as $k=>$sd){
                    //     if($sd->stream_id!=$stream_id){
                    //         $master_outcome[$type][]=$sd;
                    //      }
                    // }
                }
            }
        }
        $template['master_outcomes'] = $master_outcome;
        $template['updated_by'] = Auth::user()->id;
        $template['updated_at'] = now();
        $template->save();
        $this->success = true;
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        $this->message = " Simulation Inputs Excel Template Updated Successfully!";
        return $this->populateresponse();
    }

    public function saveExpCondition(Request $request)
    {
        $template = SimulateInputExcelTemplate::find(___decrypt($request->template_id));
        $stream_id = ___decrypt($request->stream_id);
        $type = $request->type;
        $exp_condition = [];
        $exp_condition[$type] = !empty($request->arr) ? $request->arr : "";
        // $exp_condition[$type][]=[
        //     "stream_id"=>$stream_id,
        //     "conditions"=>!empty($request->arr)?$request->arr:"",
        // ];
        if (!empty($template->exp_unit_conditions)) {
            foreach (json_decode($template->exp_unit_conditions) as $key => $row) {
                if ($key != $type) {
                    $exp_condition[$key] = $row;
                } else {
                    // foreach($row as $k=>$sd){
                    //     if($sd->stream_id!=$stream_id){
                    //         $exp_condition[$type][]=$sd;
                    //      }
                    // }
                }
            }
        }
        $template['exp_unit_conditions'] = $exp_condition;
        $template['updated_by'] = Auth::user()->id;
        $template['updated_at'] = now();
        $template->save();
        $this->success = true;
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        $this->message = " Simulation Inputs Excel Template Updated Successfully!";
        return $this->populateresponse();
    }

    public function saveExpOutcome(Request $request)
    {
        $template = SimulateInputExcelTemplate::find(___decrypt($request->template_id));
        $stream_id = ___decrypt($request->stream_id);
        $type = $request->type;
        $exp_outcome = [];
        $exp_outcome[$type] = !empty($request->arr) ? $request->arr : "";
        if (!empty($template->exp_unit_outcomes)) {
            foreach (json_decode($template->exp_unit_outcomes) as $key => $row) {
                if ($key != $type) {
                    $exp_outcome[$key] = $row;
                } else {
                    // foreach($row as $k=>$sd){
                    //     if($sd->stream_id!=$stream_id){
                    //         $exp_outcome[$type][]=$sd;
                    //      }
                    // }
                }
            }
        }
        $template['exp_unit_outcomes'] = $exp_outcome;
        $template['updated_by'] = Auth::user()->id;
        $template['updated_at'] = now();
        $template->save();
        $this->success = true;
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        $this->message = " Simulation Inputs Excel Template Updated Successfully!";
        return $this->populateresponse();
    }

    public function DownloadTemplate($id, $type = 'forward')
    {
        $template = SimulateInputExcelTemplate::find(___decrypt($id));
        if (isset($template)) {

            $rm_cnt = 0;
            $raw_material_data = [];
            if (!empty($template->raw_material)) {
                foreach (json_decode($template->raw_material) as $key => $rm) {
                    if ($key == $type) {
                        $stream_count = count($rm);
                        foreach ($rm as $sd) {
                            $processDiagram = ProcessDiagram::find($sd->stream_id);
                            $master_units = MasterUnit::find($sd->unitid);
                            foreach ($master_units['unit_constant'] as $unit_constant) {
                                if ($unit_constant['id'] == $sd->unit_constant_id) {
                                    $unit_constant_name = $unit_constant['unit_name'];
                                }
                            }
                            $products = [];
                            $i = 0;
                            foreach ($sd->products as $ct => $pro_count) {
                                if (!empty($pro_count)) {
                                    $new_count[] = $pro_count;
                                    $i += $ct;
                                }
                            }
                            $rm_cnt =   count($new_count);
                            foreach ($sd->products as $y => $product_id) {
                                if (!empty($product_id)) {
                                    $product_list = Chemical::find(___decrypt($product_id));
                                    $products[] = [
                                        "product_id" => $product_id,
                                        "product_name" => $product_list->chemical_name,
                                        "criteria" => !empty($sd->criteria[$y]) ? get_criteria_data(___decrypt($sd->criteria[$y])) : '',
                                        "criteria_id" => !empty($sd->criteria[$y]) ? ___decrypt($sd->criteria[$y]) : '',
                                    ];
                                }
                            }
                            $raw_material_data[] = [
                                "stream_id_int" => $sd->stream_id,
                                "stream_id" => !empty($sd->stream_id) ? ___encrypt($sd->stream_id) : 0,
                                "stream_name" => $processDiagram['name'],
                                "unit_id" => !empty($sd->unitid) ? ___encrypt($sd->unitid) : 0,
                                "unit_name" => $master_units['unit_name'],
                                "unit_constant_id" => !empty($sd->unit_constant_id) ? ___encrypt($sd->unit_constant_id) : 0,
                                "unit_constant_name" => $unit_constant_name,
                                "products" => $products
                            ];
                        }
                    }
                }
            }
            usort($raw_material_data, function ($a, $b) {
                return $a['stream_id_int'] <=> $b['stream_id_int'];
            });
            $master_condition_data = [];
            if (!empty($template->master_conditions)) {
                foreach (json_decode($template->master_conditions) as $key => $row) {
                    if ($key == $type) {
                        foreach ($row as $master_condition) {
                            $var_conditions = ExperimentConditionMaster::find(!empty($master_condition->conditionid) ? ___decrypt($master_condition->conditionid) : 0);
                            $unit_constant_data = MasterUnit::find(!empty($master_condition->unitid) ? ___decrypt($master_condition->unitid) : 0);
                            $uni_c_id = !empty($master_condition->unit_constant) ? ___decrypt($master_condition->unit_constant) : 0;
                            $unit_constant = array_search($uni_c_id, array_column($unit_constant_data->unit_constant, 'id'));
                            $master_condition_data[] = [
                                "conditionid" => !empty($master_condition->conditionid) ? $master_condition->conditionid : '',
                                "condition" => !empty($var_conditions->name) ? $var_conditions->name : '',
                                "criteria" => get_criteria_data(!empty($master_condition->criteria) ? ___decrypt($master_condition->criteria) : 0),
                                "criteria_id" => !empty($master_condition->criteria) ? ___decrypt($master_condition->criteria) : 0,
                                "unitid" => !empty($master_condition->unitid) ? $master_condition->unitid : 0,
                                "unit_constant_id" => !empty($master_condition->unit_constant) ? $master_condition->unit_constant : 0,
                                "unit_constant" => !empty($unit_constant_data->unit_constant[$unit_constant]['unit_name']) ? $unit_constant_data->unit_constant[$unit_constant]['unit_name'] : ''
                            ];
                        }
                    }
                }
            }
            $master_outcome_data = [];
            if (!empty($template->master_outcomes)) {
                foreach (json_decode($template->master_outcomes) as $key => $row) {
                    if ($key == $type) {
                        foreach ($row as $master_outcome) {
                            $var_outcomes = ExperimentOutcomeMaster::find(___decrypt($master_outcome->outcomeid));
                            $unit_constant_data = MasterUnit::find(!empty($master_outcome->unitid) ? ___decrypt($master_outcome->unitid) : 0);
                            $unit_constant = array_search(!empty($master_outcome->unit_constant) ? ___decrypt($master_outcome->unit_constant) : 0, array_column($unit_constant_data->unit_constant, 'id'));
                            $master_outcome_data[] = [
                                "outcomeid" => !empty($master_outcome->outcomeid) ? $master_outcome->outcomeid : 0,
                                "outcome" => !empty($var_outcomes->name) ? $var_outcomes->name : '',
                                "criteria" => get_criteria_data(!empty($master_outcome->criteria) ? ___decrypt($master_outcome->criteria) : ''),
                                "criteria_id" => !empty($master_outcome->criteria) ? ___decrypt($master_outcome->criteria) : '',
                                "unitid" => !empty($master_outcome->unitid) ? $master_outcome->unitid : 0,
                                "unit_constant_id" => !empty($master_outcome->unit_constant) ? $master_outcome->unit_constant : 0,
                                "unit_constant" => !empty($unit_constant_data->unit_constant[$unit_constant]['unit_name']) ? $unit_constant_data->unit_constant[$unit_constant]['unit_name'] : ''
                            ];
                        }
                    }
                }
            }
            $exp_condition_data = [];
            $ec_cnt = 0;
            if (!empty($template->exp_unit_conditions)) {
                foreach (json_decode($template->exp_unit_conditions) as $key => $row) {
                    if ($key == $type) {
                        $ec_cnt = count($row);
                        foreach ($row as $exp_condition) {
                            if (!empty($exp_condition->unitid)) {
                                $unit_constant_data = MasterUnit::find(!empty($exp_condition->unitid) ? ___decrypt($exp_condition->unitid) : 0);
                                $unit_constant = array_search(___decrypt($exp_condition->unit_constant), array_column($unit_constant_data->unit_constant, 'id'));
                                $conditions[$exp_condition->exp_unit_id][] = [
                                    "unitid" => !empty($exp_condition->unitid) ? $exp_condition->unitid : '',
                                    "conditionid" => !empty($exp_condition->conditionid) ? $exp_condition->conditionid : '',
                                    "condition" => !empty($exp_condition->condition) ? $exp_condition->condition : '',
                                    "criteria_id" => !empty($exp_condition->criteria) ? ___decrypt($exp_condition->criteria) : '',
                                    "criteria" => get_criteria_data(!empty($exp_condition->criteria) ? ___decrypt($exp_condition->criteria) : ''),
                                    "unit_constant_id" => !empty($exp_condition->unit_constant) ? $exp_condition->unit_constant : 0,
                                    "unit_constant" => !empty($unit_constant_data->unit_constant[$unit_constant]['unit_name']) ? $unit_constant_data->unit_constant[$unit_constant]['unit_name'] : ''
                                ];
                                $exp_condition_data[$exp_condition->exp_unit_id] = [
                                    "exp_unit" => !empty($exp_condition->exp_unit) ? $exp_condition->exp_unit : '',
                                    "cnt" => !empty($conditions[$exp_condition->exp_unit_id]) ? count($conditions[$exp_condition->exp_unit_id]) : 0,
                                    "conditions" => !empty($conditions[$exp_condition->exp_unit_id]) ? $conditions[$exp_condition->exp_unit_id] : '',
                                ];
                            }
                        }
                    }
                }
            }
            $exp_outcome_data = [];
            $eo_cnt = 0;
            if (!empty($template->exp_unit_outcomes)) {
                foreach (json_decode($template->exp_unit_outcomes) as $key => $row) {
                    if ($key == $type) {
                        $eo_cnt = count($row);
                        foreach ($row as $exp_outcome) {
                            if (!empty($exp_outcome->unitid)) {
                                $unit_constant_data = MasterUnit::find(!empty($exp_outcome->unitid) ? ___decrypt($exp_outcome->unitid) : 0);
                                if (!is_null($exp_outcome->unit_constant))
                                    $unit_constant = !empty($unit_constant_data) ? array_search(___decrypt($exp_outcome->unit_constant), array_column($unit_constant_data->unit_constant, 'id')) : '';
                                $outcomes[$exp_outcome->exp_unit_id][] = [
                                    "unitid" => !empty($exp_outcome->unitid) ? $exp_outcome->unitid : '',
                                    "outcomeid" => !empty($exp_outcome->outcomeid) ? $exp_outcome->outcomeid : '',
                                    "criteria" => get_criteria_data(!empty($exp_outcome->criteria) ? ___decrypt($exp_outcome->criteria) : ''),
                                    "criteria_id" => !empty($exp_outcome->criteria) ? ___decrypt($exp_outcome->criteria) : '',
                                    "outcome" => !empty($exp_outcome->outcome) ? $exp_outcome->outcome : '',
                                    "unit_constant_id" => !empty($exp_outcome->unit_constant) ? $exp_outcome->unit_constant : '',
                                    "unit_constant" => !empty($unit_constant_data->unit_constant[$unit_constant]['unit_name']) ? $unit_constant_data->unit_constant[$unit_constant]['unit_name'] : ""
                                ];
                                $exp_outcome_data[$exp_outcome->exp_unit_id] = [
                                    "exp_unit" => !empty($exp_outcome->exp_unit) ? $exp_outcome->exp_unit : '',
                                    "cnt" => !empty($outcomes[$exp_outcome->exp_unit_id]) ? count($outcomes[$exp_outcome->exp_unit_id]) : 0,
                                    "outcomes" => !empty($outcomes[$exp_outcome->exp_unit_id]) ? $outcomes[$exp_outcome->exp_unit_id] : '',
                                ];
                            }
                        }
                    }
                }
            }
            $data['raw_material'] = $raw_material_data;
            $data['rm_cnt'] = $rm_cnt + $stream_count;
            $data['master_condition'] = $master_condition_data;
            $data['master_outcome'] = $master_outcome_data;
            $data['ec_cnt'] = $ec_cnt;
            $data['exp_unit_condition'] = $exp_condition_data;
            $data['eo_cnt'] = $eo_cnt;
            $data['exp_unit_outcome'] = $exp_outcome_data;
            $data['type'] = $type;
            $data['template_id'] = ___encrypt($template->id);
        }
        return \Excel::download(new SimTemplate($data), $template->template_name . '#' . ___encrypt($template->id) . '#' . $type . '.xlsx');
    }

    public function DownloadTemplateWithData($id = null)
    {
        $simulateData = SimulateInput::find(___decrypt($id));
        $lastId = SimulateInputExcelTemplate::latest()->first();
        $lastId = is_null($lastId) ? 1 : $lastId->id;
        $Data = new SimulateInputExcelTemplate();
        $Data->variation_id = $simulateData->variation_id;
        $Data->template_name = $simulateData->name . $simulateData->id . $lastId;
        $Data->created_by = Auth::user()->id;
        $Data->simulate_id = $simulateData->id;
        $Data->save();

        $template = SimulateInputExcelTemplate::find($Data->id);
        $experiment = ProcessExperiment::find($simulateData->experiment_id);
        if (isset($simulateData) && !is_null($simulateData)) {
            $rm_cnt = 0;
            $raw_material_data = [];
            if (!empty($simulateData->raw_material)) {
                foreach ($simulateData->raw_material as $key => $rm) {
                    $rm_cnt++;
                    //if ($key == $type) {
                    $stream_count = count($rm);
                    $sd = $rm;
                    //foreach ($rm as $sd) {
                    $processDiagram = ProcessDiagram::find($rm['pfd_stream_id']);
                    $master_units = MasterUnit::find($rm['unit_id']);
                    if ($master_units != null) {
                        foreach ($master_units['unit_constant'] as $unit_constant) {
                            if ($unit_constant['id'] == $rm['unit_constant_id']) {
                                $unit_constant_name = $unit_constant['unit_name'];
                            }
                        }
                    } else
                        $unit_constant_name = '';
                    $products = [];
                    $i = 0;
                    foreach ($rm['product'] as $ct => $pro_count) {
                        if (!empty($pro_count)) {
                            $new_count[] = $pro_count;
                            $i += $ct;
                        }
                    }
                    // $rm_cnt =   isset($new_count)?count($new_count):0;
                    foreach ($rm['product'] as $y => $product) {
                        if (!empty($product)) {
                            $rm_cnt++;
                            $product_list = Chemical::find($product['product_id']);
                            $products[] = [
                                "product_id" => ___encrypt($product['product_id']),
                                "product_name" => $product_list->chemical_name,
                                "value" => $product['value'],
                                "criteria" => !empty($product['criteria']) ? get_criteria_data($product['criteria']) : '',
                                "criteria_id" => !empty($product['criteria']) ? $product['criteria'] : '',
                                "max" => !empty($product['max_value']) ? $product['max_value'] : 0
                            ];
                        }
                    }
                    if ($rm_cnt == 1) {
                        $raw_material_data[] = [
                            "stream_id_int" => $rm['pfd_stream_id'],
                            "stream_id" => !empty($rm['pfd_stream_id']) ? ___encrypt($rm['pfd_stream_id']) : 0,
                            "stream_name" => $processDiagram['name'],
                            "unit_id" => !empty($rm['unit_id']) ? ___encrypt($rm['unit_id']) : 0,
                            "unit_name" => !is_null($master_units) ? $master_units['unit_name'] : '',
                            "unit_constant_id" => !empty($rm['unit_constant_id']) ? ___encrypt($rm['unit_constant_id']) : 0,
                            "unit_constant_name" => $unit_constant_name,
                            "flow_rate_value" => isset($rm['value_flow_rate']) ? $rm['value_flow_rate'] : '',
                            "products" => $products
                        ];
                    } else {
                        if (sizeof($products) > 0) {
                            $raw_material_data[] = [
                                "stream_id_int" => $rm['pfd_stream_id'],
                                "stream_id" => !empty($rm['pfd_stream_id']) ? ___encrypt($rm['pfd_stream_id']) : 0,
                                "stream_name" => $processDiagram['name'],
                                "unit_id" => !empty($rm['unit_id']) ? ___encrypt($rm['unit_id']) : 0,
                                "unit_name" => !is_null($master_units) ? $master_units['unit_name'] : '',
                                "unit_constant_id" => !empty($rm['unit_constant_id']) ? ___encrypt($rm['unit_constant_id']) : 0,
                                "unit_constant_name" => isset($unit_constant_name) ? $unit_constant_name : '',
                                "flow_rate_value" => isset($rm['value_flow_rate']) ? $rm['value_flow_rate'] : '',
                                "products" => $products
                            ];
                        } else
                            $rm_cnt--;
                    }
                    //}
                    //}
                }
            }
            usort($raw_material_data, function ($a, $b) {
                return $a['stream_id_int'] <=> $b['stream_id_int'];
            });
            $master_condition_data = [];
            if (!empty($simulateData->master_condition)) {
                foreach ($simulateData->master_condition as $key => $row) {
                    //if ($key == $type) {
                    //foreach ($row as $master_condition) {
                    $var_conditions = ExperimentConditionMaster::find(!empty($row['condition_id']) ? $row['condition_id'] : 0);
                    $unit_constant_data = MasterUnit::find(!empty($row['unit_id']) ? $row['unit_id'] : 0);
                    $uni_c_id = !empty($row['unit_constant_id']) ? $row['unit_constant_id'] : 0;
                    $unit_constant = !is_null($unit_constant_data) ? array_search($uni_c_id, array_column($unit_constant_data->unit_constant, 'id')) : '';
                    $master_condition_data[] = [
                        "conditionid" => !empty($row['condition_id']) ? ___encrypt($row['condition_id']) : '',
                        "condition" => !empty($var_conditions->name) ? $var_conditions->name : '',
                        "value" => $row['value'],
                        "max" => !empty($row['max_value']) ? $row['max_value'] : 0,
                        "criteria" => get_criteria_data(!empty($row['criteria']) ? $row['criteria'] : 0),
                        "criteria_id" => !empty($row['criteria']) ? $row['criteria'] : 0,
                        "unitid" => !empty($row['unit_id']) ? ___encrypt($row['unit_id']) : 0,
                        "unit_constant_id" => !empty($row['unit_constant_id']) ? ___encrypt($row['unit_constant_id']) : 0,
                        "unit_constant" => !empty($unit_constant_data->unit_constant[$unit_constant]['unit_name']) ? $unit_constant_data->unit_constant[$unit_constant]['unit_name'] : ''
                    ];
                    //}
                    //}
                }
            }
            $master_outcome_data = [];
            if (!empty($simulateData->master_outcome)) {
                foreach ($simulateData->master_outcome as $key => $row) {
                    // if ($key == $type) {
                    //     foreach ($row as $master_outcome) {
                    $var_outcomes = ExperimentOutcomeMaster::find($row['outcome_id']);
                    $unit_constant_data = MasterUnit::find(!empty($row['unit_id']) ? $row['unit_id'] : 0);

                    $unit_constant = !is_null($unit_constant_data) ? array_search(!empty($row['unit_constant_id']) ? $row['unit_constant_id'] : 0, array_column($unit_constant_data->unit_constant, 'id')) : '';
                    $master_outcome_data[] = [
                        "outcomeid" => !empty($row['outcome_id']) ? ___encrypt($row['outcome_id']) : 0,
                        "outcome" => !empty($var_outcomes->name) ? $var_outcomes->name : '',
                        "value" => $row['value'],
                        "max" => !empty($row['max_value']) ? $row['max_value'] : 0,
                        "criteria" => get_criteria_data(!empty($row['criteria']) ? $row['criteria'] : ''),
                        "criteria_id" => !empty($row['criteria']) ? $row['criteria'] : '',
                        "unitid" => !empty($row['unit_id']) ? ___encrypt($row['unit_id']) : 0,
                        "unit_constant_id" => !empty($row['unit_constant_id']) ? ___encrypt($row['unit_constant_id']) : 0,
                        "unit_constant" => !empty($unit_constant_data->unit_constant[$unit_constant]['unit_name']) ? $unit_constant_data->unit_constant[$unit_constant]['unit_name'] : ''
                    ];
                    //     }
                    // }
                }
            }
            $exp_condition_data = [];
            $ec_cnt = 0;
            if (!empty($simulateData->unit_condition)) {
                foreach ($simulateData->unit_condition as $key => $row) {
                    $ec_cnt++;
                    // if ($key == $type) {
                    //$ec_cnt = count($row);
                    // foreach ($row as $exp_condition) {
                    // if (!empty($row['unit_id'])) {
                    $unit_constant_data = MasterUnit::find(!empty($row['unit_id']) ? $row['unit_id'] : 0);
                    $unit_constant = !is_null($unit_constant_data) ? array_search($row['unit_constant_id'], array_column($unit_constant_data->unit_constant, 'id')) : 0;
                    $condition_data = getConditionInfo($row['condition_id']);
                    $conditions[$row['exp_unit_id']][] = [
                        "unitid" => !empty($row['unit_id']) ? ___encrypt($row['unit_id']) : 0,
                        "value" => $row['value'],
                        "max" => !empty($row['max_value']) ? $row['max_value'] : 0,
                        "conditionid" => !empty($row['condition_id']) ? ___encrypt($row['condition_id']) : '',
                        "condition" => !empty($row['condition_id']) ? $condition_data['condition_name'] : '',
                        "criteria_id" => !empty($row['criteria']) ? ___encrypt($row['criteria']) : '',
                        "criteria" => get_criteria_data(!empty($row['criteria']) ? $row['criteria'] : ''),
                        "unit_constant_id" => !empty($row['unit_constant_id']) ? ___encrypt($row['unit_constant_id']) : 0,
                        "unit_constant" => !empty($unit_constant_data->unit_constant[$unit_constant]['unit_name']) ? $unit_constant_data->unit_constant[$unit_constant]['unit_name'] : ''
                    ];

                    $exp_unit = get_experiment_unit_details($experiment->id, !empty($row['exp_unit_id']) ? $row['exp_unit_id'] : 0);

                    $exp_condition_data[___encrypt($row['exp_unit_id'])] = [
                        "exp_unit" => !empty($exp_unit['exp_unit_name']) ? $exp_unit['exp_unit_name'] : '',
                        "cnt" => !empty($conditions[$row['exp_unit_id']]) ? count($conditions[$row['exp_unit_id']]) : 0,
                        "conditions" => !empty($conditions[$row['exp_unit_id']]) ? $conditions[$row['exp_unit_id']] : '',
                    ];
                    //}
                    //     }
                    // }
                }
            }
            $exp_outcome_data = [];
            $eo_cnt = 0;
            if (!empty($simulateData->unit_outcome)) {
                foreach ($simulateData->unit_outcome as $key => $row) {
                    // if ($key == $type) {
                    $eo_cnt = count($row);
                    // foreach ($row as $exp_outcome) {
                    //if (!empty($row['unit_id'])) {
                    $unit_constant_data = MasterUnit::find(!empty($row['unit_id']) ? $row['unit_id'] : 0);
                    if (!is_null($row['unit_constant_id']))
                        $unit_constant = !empty($unit_constant_data) ? array_search($row['unit_constant_id'], array_column($unit_constant_data->unit_constant, 'id')) : '';
                    $outcome_data = getOutcomeInfo($row['outcome_id']);
                    $outcomes[$row['exp_unit_id']][] = [
                        "unitid" => !empty($row['unit_id']) ? ___encrypt($row['unit_id']) : '',
                        "value" => $row['value'],
                        "max" => !empty($row['max_value']) ? $row['max_value'] : 0,
                        "outcomeid" => !empty($row['outcome_id']) ? ___encrypt($row['outcome_id']) : '',
                        "criteria" => get_criteria_data(!empty($row['criteria']) ? $row['criteria'] : ''),
                        "criteria_id" => !empty($row['criteria']) ? ___encrypt($row['criteria']) : '',
                        "outcome" => !empty($row['outcome_id']) ? $outcome_data['outcome_name'] : '',
                        "unit_constant_id" => !empty($row['unit_constant_id']) ? ___encrypt($row['unit_constant_id']) : '',
                        "unit_constant" => !empty($unit_constant_data->unit_constant[$unit_constant]['unit_name']) ? $unit_constant_data->unit_constant[$unit_constant]['unit_name'] : ""
                    ];
                    $exp_unit = get_experiment_unit_details($experiment->id, !empty($row['exp_unit_id']) ? $row['exp_unit_id'] : 0);
                    $exp_outcome_data[___encrypt($row['exp_unit_id'])] = [
                        "exp_unit" => !empty($exp_unit['exp_unit_name']) ? $exp_unit['exp_unit_name'] : '',
                        "cnt" => !empty($outcomes[$row['exp_unit_id']]) ? count($outcomes[$row['exp_unit_id']]) : 0,
                        "outcomes" => !empty($outcomes[$row['exp_unit_id']]) ? $outcomes[$row['exp_unit_id']] : '',
                    ];
                    //}
                    //     }
                    // }
                }
            }
            $data['raw_material'] = $raw_material_data;
            $data['rm_cnt'] = $rm_cnt;
            $data['master_condition'] = $master_condition_data;
            $data['master_outcome'] = $master_outcome_data;
            $data['ec_cnt'] = $ec_cnt;
            $data['exp_unit_condition'] = $exp_condition_data;
            $data['eo_cnt'] = $eo_cnt;
            $data['simulate_input_name'] = $simulateData['name'];
            $data['exp_unit_outcome'] = $exp_outcome_data;
            $data['type'] = $simulateData['simulate_input_type'];
            $data['template_id'] = ___encrypt($template->id);
        }
        return \Excel::download(new SimTemplate($data), $template->template_name . '#' . ___encrypt($template->id) . '#' . $simulateData['simulate_input_type'] . '.xlsx');
    }

    public function importModal()
    {
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.configuration.import_sim_input')->render()
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            SimulateInputExcelTemplate::where('id', ___decrypt($id))->update(['status' => $status]);
        } else {
            SimulateInputExcelTemplate::find(___decrypt($id))->delete();
        }

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
        if (SimulateInputExcelTemplate::whereIn('id', $IDS)->update($update)) {
            SimulateInputExcelTemplate::destroy($IDS);
        }
        $this->status = true;
        $this->redirect = url('/experiment/experiment');
        return $this->populateresponse();
    }
}
