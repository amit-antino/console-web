<?php

namespace App\Http\Controllers\Admin\Master\ProcessSimulation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\ProcessSimulation\ProcessStatus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProcessStatusController extends Controller
{
    public function index(Request $request)
    {
        $process_status = ProcessStatus::all();
        $statuses = [];
        foreach ($process_status as $status) {
            if ($status['status'] == 'active') {
                $statuses[] = [
                    'id' => $status['id'],
                    'name' => $status['name'],
                ];
            }
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $statuses
            ]);
        }
        return view('pages.admin.master.process_simulation.status.index', compact('process_status'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $process_status =  new ProcessStatus();
            $process_status->name = $request->name;
            $process_status->description = $request->description;
            $process_status['created_by'] = Auth::user()->id;
            $process_status['updated_by'] = Auth::user()->id;
            $process_status->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
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
            $update = ProcessStatus::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ProcessStatus::where('id', ___decrypt($id))->update($update)) { //echo ___decrypt($id);
                ProcessStatus::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/process_simulation/process_status');
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
        if (ProcessStatus::whereIn('id', $processIDS)->update($update)) {
            ProcessStatus::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $st = ProcessStatus::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.process_simulation.status.edit', ['st' => $st])->render()
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
            $process_status =  ProcessStatus::find(___decrypt($id));
            $process_status->name = $request->name;
            $process_status->description = $request->description;
            $process_status['updated_by'] = Auth::user()->id;
            $process_status['updated_at'] = now();
            $process_status->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
