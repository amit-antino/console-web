<?php

namespace App\Http\Controllers\Admin\Master\ProcessSimulation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\ProcessSimulation\SimulationFlowType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FlowTypeController extends Controller
{
    public function index(Request $request)
    {
        $process_types = SimulationFlowType::all();
        $typeList=$this->com->getFlowType();
        $flow_types = [];
        foreach ($process_types as $flow_type) {
            if ($flow_type['type'] == "1") {
                $type = "Mass Input";
            } else if ($flow_type['type'] == "2") {
                $type = "Mass Output";
            } else if ($flow_type['type'] == "3") {
                $type = "Others";
            }
            $flow_types[] = [
                'id' => $flow_type['id'],
                'name' => $flow_type['flow_type_name'],
                'flow_type' => [
                    'id' => $flow_type['type'],
                    'flow_type_name' => $type
                ],
            ];
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $flow_types
            ]);
        }
        return view('pages.admin.master.process_simulation.flow_type.index', compact('process_types','typeList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'flow_type_name' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $process_type = new SimulationFlowType();
            $process_type->flow_type_name = $request->flow_type_name;
            $process_type->type = $request->type;
            $process_type->description = $request->description;
            $process_type['created_by'] = Auth::user()->id;
            $process_type['updated_by'] = Auth::user()->id;
            $process_type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/process_simulation/flow_type');
            $this->message = "Added Successfully!";
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
            $update = SimulationFlowType::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (SimulationFlowType::where('id', ___decrypt($id))->update($update)) {
                SimulationFlowType::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/process_simulation/flow_type');
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (SimulationFlowType::whereIn('id', $processIDS)->update($update)) {
            SimulationFlowType::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/process_simulation/flow_type');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $process_type = SimulationFlowType::where('id', ___decrypt($id))->first();
        $typeList=$this->com->getFlowType();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.process_simulation.flow_type.edit', ['type' => $process_type,"typeList"=>$typeList])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'flow_type_name' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $process_type = SimulationFlowType::find(___decrypt($id));
            $process_type->flow_type_name = $request->flow_type_name;
            $process_type->type = $request->type;
            $process_type->description = $request->description;
            $process_type['updated_by'] = Auth::user()->id;
            $process_type['updated_at'] = now();
            $process_type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/process_simulation/flow_type');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
