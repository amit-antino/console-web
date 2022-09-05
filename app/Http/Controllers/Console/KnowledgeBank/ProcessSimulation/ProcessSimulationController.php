<?php

namespace App\Http\Controllers\Console\KnowledgeBank\ProcessSimulation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MFG\ProcessSimulation;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\ProcessSimulation\SimulationType;

class ProcessSimulationController extends Controller
{
    public function index()
    {
        $process_simulations = ProcessSimulation::where(["knowledge_bank" => 1, "status" => "active", "tenant_id" => session()->get('tenant_id')])->orderBy('id', 'DESC')->get();
        $data = [];
        foreach ($process_simulations as $key => $value) {
            $data[$value->id]['id'] = $value->id;
            $data[$value->id]['status'] = $value->status;
            $data[$value->id]['process_name'] = $value->process_name;
            $sname = SimulationType::select('simulation_name')->whereIn("id", $value->sim_stage)->get();;
            if (!empty($sname)) {
                $data[$value->id]['sim_stage'] = array_column($sname->toArray(), "simulation_name");
            } else {
                $data[$value->id]['sim_stage'] = [];
            }
            if ($value->processCategory) {
                $data[$value->id]['processCategory'] = $value->processCategory->name;
            } else {
                $data[$value->id]['processCategory'] = "";
            }
            if ($value->processStatus) {
                $data[$value->id]['processStatus'] = $value->processStatus->name;
            } else {
                $data[$value->id]['processStatus'] = "";
            }
        }
        return view('pages.console.knowledge_bank.process_simulation.index')->with(compact('data'));;
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        try {
            $simulationData = ProcessSimulation::find(___decrypt($id));
            $simulationData->updated_at = now();
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->knowledge_bank = 0;
            $simulationData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/knowledge_bank/process_simulation');
            $this->message = "Knowledge Bank Delete Successfully!";
        } catch (\Exception $e) {
            $this->status = false;
            $this->message = $e->getMessage();
        }
        return $this->populateresponse();
    }
    public function bulkDelete(Request $request)
    {
        $this->redirect = url('/knowledge_bank/process_simulation');
        return $this->populateresponse();
    }
}
