<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessExperiment\ProcessExpProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\ProcessExperiment\ProcessExpProfileMaster;
use App\Models\ProcessExperiment\Variation;

class ProcessExperimentProfileController extends Controller
{
    public function saveprofile(Request $request)
    {
        $process_exp_id = ___decrypt($request['process_experiment_id']);
        $experiment_unit = ___decrypt($request['experiment_unit_id']);
        $id = ProcessExpProfile::select('id')->where([['variation_id', ___decrypt($request->vartion_id)], ['process_exp_id',  $process_exp_id], ['experiment_unit', $experiment_unit]])->first();
        if ($id == null) {
            $simulationData = new ProcessExpProfile();
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->created_by = Auth::user()->id;
        } else {
            $simulationData = ProcessExpProfile::find($id['id']);
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->updated_at = now();
        }
        if (isset($request->tab) && $request->tab == "condition") {
            $conditionArr = [];
            $outcomes = [];
            $reactiondata = [];
            if (!empty($request['conditions'])) {
                foreach ($request['conditions'] as $condi) {
                    $conditionArr[] = ___decrypt($condi);
                }
            }
            if (!empty($request['reaction'])) {
                foreach ($request['reaction'] as $reaction) {
                    $reactiondata[] = ___decrypt($reaction);
                }
            }
            if (!empty($request['outcome'])) {
                foreach ($request['outcome'] as $outcome) {
                    $outcomes[] = ___decrypt($outcome);
                }
            }
            $simulationData->reaction  = $reactiondata;
            $simulationData->outcome = $outcomes;
            $simulationData->condition = $conditionArr;
            $simulationData->process_exp_id = $process_exp_id;
            $simulationData->experiment_unit = $experiment_unit;
            $simulationData->variation_id = ___decrypt($request->vartion_id);
        }
        if ($simulationData->save()) {
            $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
            $experiment_unitsid = [];
            $arr = [];
            $varArr = $variton->unit_specification;
            if (!empty($variton) && !empty($variton->unit_specification)) {
                if (!empty($variton->unit_specification['experiment_units'])) {
                    $arr = $variton->unit_specification['experiment_units'];
                }
            }
            if (!in_array($simulationData->id, $arr)) {
                array_push($arr, $simulationData->id);
            }
            $varArr['experiment_units'] = $arr;
            $variton->unit_specification = $varArr;
            $variton->updated_by = Auth::user()->id;
            $variton->save();
            $success = true;
            $message = "Unit Specifications Successfully Updated";
            $response = [
                'success' => $success,
                'message' => $message
            ];
        }
        return response()->json($response, 200);
    }

    public function destroy($id, $pid, $uid)
    {
    }

    public function saveprofilemaster(Request $request)
    {
        $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
        $masteridd = [];
        if (!empty($variton->unit_specification)) {
            $masteridd = $variton->unit_specification['master_units'];
        }
        $id = ProcessExpProfileMaster::select('id')->where('id', ($masteridd))->first();
        // $id = ProcessExpProfileMaster::select('id')->where([['process_exp_id',  ___decrypt($request['process_experiment_id'])]])->first();
        if ($id == null) {
            $simulationData = new ProcessExpProfileMaster();
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->created_by = Auth::user()->id;
        } else {
            $simulationData = ProcessExpProfileMaster::find($id['id']);
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->updated_at = now();
        }
        if (isset($request->tab) && $request->tab == "condition") {
            $master_condition = [];
            $master_outcome = [];
            $reactiondata = [];
            if (!empty($request['master_conditions'])) {
                foreach ($request['master_conditions'] as $condi) {
                    $master_condition[] = ___decrypt($condi);
                }
            }
            if (!empty($request['master_reaction'])) {
                foreach ($request['master_reaction'] as $reaction) {
                    $reactiondata[] = ___decrypt($reaction);
                }
            }
            if (!empty($request['master_outcomes'])) {
                foreach ($request['master_outcomes'] as $outcome) {
                    $master_outcome[] = ___decrypt($outcome);
                }
            }
            $simulationData->reaction  = $reactiondata;
            $simulationData->outcome = $master_outcome;
            $simulationData->condition = $master_condition;
            $simulationData->process_exp_id = ___decrypt($request['process_experiment_id']);
        }
        if (isset($request->tab) && $request->tab == "outcome") {
            $master_outcome = [];
            if (!empty($request['master_outcomes'])) {
                foreach ($request['master_outcomes'] as $key_outcome => $outcome) {
                    $master_outcome[] = [
                        "id" => json_encode($key_outcome),
                        "outcome_id" => ___decrypt($outcome['outcome_id']),
                        "unit_id" => ___decrypt($outcome['unit_id']),
                        "value" => $outcome['value'],
                        "unit_constant_id" => ___decrypt($outcome['unit_constant_id']),
                    ];
                    $master_outcome_id[$key_outcome] = ___decrypt($outcome['outcome_id']);
                }
            }
            $simulationData->outcome = $master_outcome;
            $simulationData->process_exp_id = ___decrypt($request['process_experiment_id']);
        }
        if (isset($request->tab) && $request->tab == "reaction") {
            $reaction_datamaster = $request['reaction_datamaster'];
            $reactiondata = [];
            foreach ($reaction_datamaster as $key => $c_no) {
                $reactiondata[$key]['id'] = json_encode($key);
                $reactiondata[$key]['reaction'] =  ___decrypt($c_no);
            }
            $simulationData->reaction  = $reactiondata;
            $simulationData->process_exp_id  = ___decrypt($request['process_experiment_id']);
        }
        if ($simulationData->save()) {
            $varitonArr = Variation::find(___decrypt($request->vartion_id));
            $varArr = $varitonArr->unit_specification;
            $varArr['master_units'] = $simulationData->id;
            $varitonArr->unit_specification = $varArr;
            $varitonArr->updated_by = Auth::user()->id;
            $varitonArr->save();
            $success = true;
            $message = "Unit Specifications Successfully Updated";
            $response = [
                'success' => $success,
                'message' => $message
            ];
        }
        return response()->json($response, 200);
    }
}
