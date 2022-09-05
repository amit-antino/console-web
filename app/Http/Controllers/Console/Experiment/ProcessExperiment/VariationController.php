<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Classes\ExperimentCommon;
use App\Classes\VariationCommon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\ProcessExperiment\Variation;
use App\Models\ProcessExperiment\ProcessExpProfileMaster;
use App\Models\Experiment\ProcessDiagram;
use App\Models\ProcessExperiment\ProcessExpProfile;
use App\Models\ProcessExperiment\ProcessExpEnergyFlow;
use App\Models\ProcessExperiment\ProcessExperiment;

class VariationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'variation_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $variation = new Variation();
            $variation->created_by = Auth::user()->id;
            $variation->name = $request->variation_name;
            $variation->experiment_id = ___decrypt($request->experiment_id);
            $unit_specification = [];
            $unit_specification["master_units"] = "";
            $unit_specification["experiment_units"] = [];
            $variation->unit_specification = $unit_specification;
            $variation->process_flow_table = [];
            $variation->models = [];
            $variation->dataset = [];
            $variation->datamodel = [];
            $variation->updated_by = Auth::user()->id;
            $variation->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = 'reload_fail';
            $this->triggertab = '#configuration_view_tab';
            $this->message = "Variation Created Successfully.";
            $expCommon = new ExperimentCommon();
            $process_exp_list = $expCommon->experiment_list('redis_update');
            //$res = array_merge($request->all(), ['process_experiment_id' => ___encrypt($request->experiment_id)]);
            $redis_variation = new VariationCommon();
            $redis_variation->variation_list($request, 'redis_update');
            $status = true;
            $message = "Variation Updated Successfully.";
        }
        // $response = [
        //     'success' => $status,
        //     'message' => $this->message
        // ];
        // return response()->json($response, 200);
        return $this->populateresponse();
    }

    public function editdata(Request $request)
    {
        $exp_id = $request->expid;
        $variation_id = $request->var_id;
        $id = $exp_id;
        $config_edit_data = Variation::find(___decrypt($variation_id));
        $process_experiment = ProcessExperiment::find(___decrypt($id));
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
            "id" => ($process_experiment->id),
            "name" => $process_experiment->process_experiment_name,
            "variation_id" => ($config_edit_data->id),
            "config_name" => !empty($config_edit_data->name) ? $config_edit_data->name : '',
            "config_description" => !empty($config_edit_data->description) ? $config_edit_data->description : '',
            "status" => $config_edit_data->status,
            "experiment_units" => $experiment_units,

        ];

        $html = view('pages.console.experiment.experiment.profile.config_edit', compact('process_experiment_info'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function edit(Request $request)
    {
        # code...
    }

    public function updateVarition(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'variation_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
            $status = false;
        } else {
            $variation =  Variation::find(___decrypt($request->var_id));
            $variation->name = $request->variation_name;
            $variation->description = $request->description;
            $variation->updated_by = Auth::user()->id;
            $variation->save();
            $expCommon = new ExperimentCommon();
            $process_exp_list = $expCommon->experiment_list('redis_update');
            $redis_variation = new VariationCommon();
            $redis_variation->variation_list($request, 'redis_update', $variation->experiment_id);
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->triggertab = '#configuration_view_tab';
            $this->message = "Variation Updated Successfully.";
        }
        return $this->populateresponse();
    }

    public function update(Request $request, $exp_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'config_name' => 'required',
        ]);
        $pe_profile = _arefy(ProcessExpProfile::where('process_exp_id', ___decrypt($request->experiment_id))->get());
        $process_diagram_profile = _arefy(ProcessDiagram::where('process_id', ___decrypt($request->experiment_id))->get());
        $validator->after(function ($validator) use ($pe_profile, $process_diagram_profile) {
            if (empty($pe_profile) && empty($process_diagram_profile)) {
                $validator->errors()->add('config_name', 'There cannot be a blank configuration.');
            }
        });
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $variation = new Variation();
            $variation->config_name = $request->config_name;
            $variation->process_exp_id = ___decrypt($request->experiment_id);
            $data = [];
            $master_data_profile = [];
            $experiment_unit_profile = [];
            $pe_profile_master_data = ProcessExpProfileMaster::where('process_exp_id', ___decrypt($request->experiment_id))->get();
            $pe_profile = ProcessExpProfile::where('process_exp_id', ___decrypt($request->experiment_id))->get();
            $process_diagram_profile = ProcessDiagram::where('process_id', ___decrypt($request->experiment_id))->get();
            $process_energyflow_profile = ProcessExpEnergyFlow::where('process_id', ___decrypt($request->experiment_id))->get();
            if (!empty($pe_profile_master_data)) {
                foreach ($pe_profile_master_data as $profile_master_data) {
                    $master_data_profile = [
                        "conditions" => $profile_master_data->condition,
                        "outcomes" => $profile_master_data->outcome,
                        "reactions" => $profile_master_data->reaction
                    ];
                }
            }
            if (!empty($pe_profile)) {
                foreach ($pe_profile as $profile_data) {
                    $experiment_unit_profile[] = [
                        "pe_experiment_unit_id" => json_encode($profile_data->experiment_unit),
                        "conditions" => $profile_data->condition,
                        "outcomes" => $profile_data->outcome,
                        "reactions" => $profile_data->reaction
                    ];
                }
            }
            $pdids = [];
            $pdid = [];
            if (!empty($process_diagram_profile)) {
                $arrIds = $process_diagram_profile->toArray();
                $pdids =  array_column($arrIds, 'id');
                if (!empty($pdids)) {
                    foreach ($pdids as $p) {
                        $pdid[] = json_encode($p);
                    }
                }
            }
            $peids = [];
            $peid = [];
            if (!empty($process_energyflow_profile)) {
                $arrenergyIds = $process_energyflow_profile->toArray();
                $peids =  array_column($arrenergyIds, 'id');
                if (!empty($peids)) {
                    foreach ($peids as $p) {
                        $peid[] = json_encode($p);
                    }
                }
            }
            $data = [
                "master_data_profile" => $master_data_profile,
                "experiment_unit_profile" => $experiment_unit_profile,
                "process_diagram_ids" => $pdid,
                "energy_flow_ids" => $peid
            ];
            $variation->configuration_data = $data;
            $variation->description = $request->description;
            $variation->status = 'active';
            $variation->created_by = Auth::user()->id;
            $variation->updated_by = Auth::user()->id;
            $variation->save();
            $expCommon = new ExperimentCommon();
            $process_exp_list = $expCommon->experiment_list('redis_update');
            $redis_variation = new VariationCommon();
            $redis_variation->variation_list($request, 'redis_update');
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "New Configuration is Created Successfully";
        }
        return $this->populateresponse();
    }

    public function deleteVartion(Request $request)
    {
        $id = $request->id;
        $urlId = Variation::select('experiment_id')->where('id', ___decrypt($id))->withTrashed()->first();
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (Variation::where('id', ___decrypt($id))->update($update)) {
            Variation::destroy(___decrypt($id));
        }
        $expCommon = new ExperimentCommon();
        $process_exp_list = $expCommon->experiment_list('redis_update');

        $redis_variation = new VariationCommon();
        $redis_variation->variation_list($request, 'redis_update', $urlId->experiment_id);

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
        $peId = Variation::whereIn('id', $processIDS)->get();
        $commonId = array_unique(array_column($peId->toArray(), 'experiment_id'));
        if (Variation::whereIn('id', $processIDS)->update($update)) {
            Variation::destroy($processIDS);
        }
        $expCommon = new ExperimentCommon();
        $process_exp_list = $expCommon->experiment_list('redis_update');
        foreach ($processIDS1 as $idval) {
            $process_id = ___decrypt($idval);
            $exp_var = Variation::where('id', $process_id)->withTrashed()->first();
            $redis_variation = new VariationCommon();
            $redis_variation->variation_list($request, 'redis_update', $exp_var->experiment_id);
        }
        $response = [
            'success' => true,
            'message' => "delete"
        ];
        return response()->json($response, 200);
    }

    public function update_status(Request $request)
    {
        if ($request->val == 'active') {
            $status = 'inactive';
        } else {
            $status = 'active';
        }
        $update = Variation::find(___decrypt($request->variation_id));
        $update['status'] = $status;
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        $update->save();
        $expCommon = new ExperimentCommon();
        $process_exp_list = $expCommon->experiment_list('redis_update');
        $redis_variation = new VariationCommon();
        $redis_variation->variation_list($request, 'redis_update', $update->experiment_id);
        $response = [
            'success' => true,
            'message' => "status update"
        ];
        return response()->json($response, 200);
    }
}
