<?php

namespace App\Http\Controllers\Admin\Master\ProcessSimulation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\ProcessSimulation\ProcessType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProcessTypeController extends Controller
{
    public function index(Request $request)
    {
        $process_types = ProcessType::all();
        $classifications = [];
        foreach ($process_types as $classification) {
            if ($classification['status'] == 'active') {
                $classifications[] = [
                    'id' => $classification['id'],
                    'name' => $classification['name'],
                ];
            }
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $classifications
            ]);
        }
        return view('pages.admin.master.process_simulation.type.index', compact('process_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $process_type =  new ProcessType();
            $process_type->name = $request->name;
            $process_type->description = $request->description;
            $process_type['created_by'] = Auth::user()->id;
            $process_type['updated_by'] = Auth::user()->id;
            $process_type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/process_simulation/type');
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
            $update = ProcessType::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ProcessType::where('id', ___decrypt($id))->update($update)) {
                ProcessType::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/process_simulation/type');
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
        if (ProcessType::whereIn('id', $processIDS)->update($update)) {
            ProcessType::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/process_simulation/type');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $process_type = ProcessType::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.process_simulation.type.edit', ['type' => $process_type])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $process_type =  ProcessType::find(___decrypt($id));
            $process_type->name = $request->name;
            $process_type->description = $request->description;
            $process_type['updated_by'] = Auth::user()->id;
            $process_type['updated_at'] = now();
            $process_type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/process_simulation/type');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
