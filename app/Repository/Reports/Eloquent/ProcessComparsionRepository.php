<?php

namespace App\Repository\Reports\Eloquent;

use App\Models\Report\ProcessComaprison;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repository\Reports\Interfaces\ProcesComparsionReport;

class ProcessComparsionRepository implements ProcesComparsionReport
{
    public function getAll()
    {
        $process_simulation_reports = ProcessComaprison::get();
        return $process_simulation_reports;
    }

    public function createReport($request)
    {
        $simulationData = new ProcessComaprison();
        $simulationData->report_name = $request->report_name;
        $simulationData->report_type = $request->report_type;
        $simulationData->simulation_type =  ___decrypt($request->simulation_type);
        $simulationData->process_simulation_ids =  ($request->process_simulation);
        $simulationData->mass_balance =  ($request->mass_bal);
        $simulationData->energy_balance =  ($request->energy_bal);
        $specify_weights = [];
        $specify_weights = [
            "remaining_weight" => (!empty($request->remaining_weight) ? $request->remaining_weight : ""),
            "economic_constraint" => (!empty($request->economic_constraint) ? $request->economic_constraint : ""),
            "process_cost_enviroment_impacts" => (!empty($request->process_cost_enviroment_impacts) ? $request->process_cost_enviroment_impacts : ""),
            "enviroment_impact_raw_material" => (!empty($request->enviroment_impact_raw_material) ? $request->enviroment_impact_raw_material : ""),
            "ehs_hazards" => (!empty($request->ehs_hazards) ? $request->ehs_hazards : ""),
            "risk_aspect" => (!empty($request->risk_aspect) ? $request->risk_aspect : ""),
            "total_weights" => (!empty($request->total_weights) ? $request->total_weights : "")
        ];
        $simulationData->specify_weights =  $specify_weights;

        $simulationData->created_by = Auth::user()->id;
        $simulationData->updated_by = Auth::user()->id;
        $tags = [];
        if ($request->tags != "") {
            $tags = explode(",", $request->tags);
        } else {
            $tags = [];
        }
        $simulationData->tags = $tags;
        $simulationData->save();
        $status = true;
        return $status;
    }
    public function destroy($id)
    {
        $del = 0;
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProcessComaprison::where('id', ___decrypt($id))->update($update)) {
            $del = ProcessComaprison::destroy(___decrypt($id));
        }
        return $del;
    }
}
