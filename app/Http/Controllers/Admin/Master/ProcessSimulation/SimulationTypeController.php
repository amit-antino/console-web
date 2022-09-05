<?php

namespace App\Http\Controllers\Admin\Master\ProcessSimulation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\ProcessSimulation\SimulationType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SimulationTypeController extends Controller
{
    public function index(Request $request)
    {
        $simulation_types = SimulationType::all();
        $simulation_stages = [];
        foreach ($simulation_types as $simulation_type) {
            if ($simulation_type['status'] == 'active') {
                $simulation_stages[] = [
                    'id' => $simulation_type['id'],
                    'name' => $simulation_type['simulation_name'],
                    'mass_balance' => $simulation_type['mass_balance'],
                    'energy_balance' => $simulation_type['enery_utilities']
                ];
            }
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $simulation_stages
            ]);
        }
        return view('pages.admin.master.process_simulation.simulation_type.index', compact('simulation_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'simulation_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $simulation_type = new SimulationType();
            $simulation_type->simulation_name = $request->simulation_name;
            $simulation_type->description = $request->description;
            if (!empty($request->mass_balance)) {
                $val = array();
                foreach ($request->mass_balance as $key_mass => $mass) {
                    if (!empty($mass['data_source'])) {
                        $val[$key_mass]['id'] = json_encode($key_mass + 1);
                        $val[$key_mass]['data_source'] = $mass['data_source'];
                    }
                }
                $simulation_type->mass_balance = $val;
            }
            if (!empty($request->enery_utilities)) {
                foreach ($request->enery_utilities as $key => $energy) {
                    if (!empty($energy['data_source'])) {
                        $enery_utilities[$key]['id'] = json_encode($key + 1);
                        $enery_utilities[$key]['data_source'] = $energy['data_source'];
                    }
                }
                $simulation_type->enery_utilities = $enery_utilities;
            }
            $simulation_type->created_by = Auth::user()->id;
            $simulation_type->updated_by = Auth::user()->id;
            $simulation_type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/process_simulation/simulation_type');
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
            $update = SimulationType::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (SimulationType::where('id', ___decrypt($id))->update($update)) {
                SimulationType::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/process_simulation/simulation_type');
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
        if (SimulationType::whereIn('id', $processIDS)->update($update)) {
            SimulationType::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/process_simulation/simulation_type');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $simulation = SimulationType::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.process_simulation.simulation_type.edit', ['simulation' => $simulation])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'simulation_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $simulation_type =  SimulationType::find(___decrypt($id));
            $simulation_type->simulation_name = $request->simulation_name;
            $simulation_type->description = $request->description;
            if (!empty($request->mass_balance)) {
                $val = array();
                foreach ($request->mass_balance as $key_mass => $mass) {
                    if (!empty($mass['data_source'])) {
                        $val[$key_mass]['id'] = json_encode($key_mass + 1);
                        $val[$key_mass]['data_source'] = $mass['data_source'];
                    }
                }
                $simulation_type->mass_balance = $val;
            }
            if (!empty($request->enery_utilities)) {
                foreach ($request->enery_utilities as $key => $energy) {
                    if (!empty($energy['data_source'])) {
                        $enery_utilities[$key]['id'] = json_encode($key + 1);
                        $enery_utilities[$key]['data_source'] = $energy['data_source'];
                    }
                }
                $simulation_type->enery_utilities = $enery_utilities;
            }
            $simulation_type->created_by = Auth::user()->id;
            $simulation_type->updated_by = Auth::user()->id;
            $simulation_type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/process_simulation/simulation_type');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
    public function addMore(Request $request, $type)
    {
        return response()->json([
            'status' => true,
            'html' => view("pages.admin.master.process_simulation.simulation_type.add-more", ['count' => $request->count, 'type' => $type])->render()
        ]);
    }
}
