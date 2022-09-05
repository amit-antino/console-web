<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessExperiment\ProcessExpEnergyFlow;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\ProcessSimulation\SimulationFlowType;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\OtherInput\EnergyUtility;

class ProcessEnergyFlowController extends Controller
{
    public function index(Request $request)
    {
        $processExpEnergyFlow = ProcessExpEnergyFlow::where('process_id', ___decrypt($request->process_experiment_id))->get();
        $process_experiment = ProcessExperiment::find(___decrypt($request->process_experiment_id));
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
        $process_experiment_info = [
            "process_experiment_id" => $request->process_experiment_id,
            "experiment_units" => $experiment_units,
            "expEnergyFlowArr" => $expEnergyFlowArr,
        ];
        $html = view('pages.console.experiment.experiment.profile.process_energyflow_list')->with('process_experiment_info', $process_experiment_info)->render();;
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $processEnergy = new ProcessExpEnergyFlow();
        $processEnergy->process_id = ___decrypt($request['process_experiment_id']);
        $processEnergy->stream_flowtype = ___decrypt($request['energy_flow_type']);
        $processEnergy->stream_name = $request['energy_stream_name'];
        $processEnergy->experiment_unit_id = ___decrypt($request['energy_experimentunit_id']);
        $processEnergy->energy_utility_id = ___decrypt($request['utility_id']);
        $processEnergy->input_output = $request->inputoutput;
        $processEnergy->status = 'active';
        $processEnergy->created_by = Auth::user()->id;
        $processEnergy->updated_by = Auth::user()->id;
        try {
            $processEnergy->save();
            $success = true;
            $message = "Energy Flow Save Successfully";
            $response = [
                'success' => $success,
                'message' => $message
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $data['id'] = ___decrypt($id);
        $processEnergy = ProcessExpEnergyFlow::find(___decrypt($id));
        $process_experiment = ProcessExperiment::find($processEnergy->process_id);
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
            $data['processEnergyFlow'] = $processEnergy->toArray();
        } else {
            $data['processEnergyFlow'] = [];
        }
        $flowTypeEnergy = SimulationFlowType::where('type', 4)->get();
        $flowTypeEnergyArr = [];
        if (!empty($flowTypeEnergy)) {
            $flowTypeEnergyArr = $flowTypeEnergy->toArray();
        }
        $selectUtilityArr = [];
        if (!empty($process_experiment->energy_id)) {
            $selectUtility = EnergyUtility::select('id', 'energy_name')->whereIn('id', $process_experiment->energy_id)->get();
            $selectUtilityArr = $selectUtility->toArray();
        }
        $data['experiment_units'] = $experiment_units;
        $data['flowTypeEnergy'] = $flowTypeEnergyArr;
        $data['selectUtilityArr'] = $selectUtilityArr;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.experiment.experiment.profile.edit_energy_flow', compact('data'))->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $processEnergy = ProcessExpEnergyFlow::find(___decrypt($id));
        $processEnergy->process_id = ___decrypt($request['process_experiment_id']);
        $processEnergy->stream_flowtype = ___decrypt($request['energy_flow_type']);
        $processEnergy->stream_name = $request['energy_stream_name'];
        $processEnergy->experiment_unit_id = ___decrypt($request['energy_experimentunit_id']);
        $processEnergy->energy_utility_id = ___decrypt($request['utility_id']);
        $processEnergy->input_output = $request->inputoutput;
        $processEnergy->updated_by = Auth::user()->id;
        $processEnergy->updated_at = now();
        try {
            $processEnergy->save();
            $success = true;
            $message = "Energy Flow Update Successfully";
            $response = [
                'success' => $success,
                'message' => $message
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        $processExpEnergyFlow = ProcessExpEnergyFlow::find(___decrypt($id));
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProcessExpEnergyFlow::where('id', ___decrypt($id))->update($update)) {
            ProcessExpEnergyFlow::destroy(___decrypt($id));
        }
        $this->status = true;
        $this->redirect = url('/experiment/experiment/' . ___encrypt($processExpEnergyFlow->process_id) . '/manage');
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $processIDS1 = explode(',', ($id_string));
        foreach ($processIDS1 as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        $peId = ProcessExpEnergyFlow::whereIn('id', $processIDS)->get();
        $commonId = array_unique(array_column($peId->toArray(), 'process_id'));
        if (ProcessExpEnergyFlow::whereIn('id', $processIDS)->update($update)) {
            ProcessExpEnergyFlow::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('/experiment/experiment/' . ___encrypt($commonId[0]) . '/manage');
        return $this->populateresponse();
    }
}
