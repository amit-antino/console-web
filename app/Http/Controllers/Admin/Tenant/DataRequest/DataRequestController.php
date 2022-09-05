<?php

namespace App\Http\Controllers\Admin\Tenant\DataRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\DataRequest\DataRequest;

class DataRequestController extends Controller
{
    public function index($id)
    {
        $tenant_id = ___decrypt($id);
        $data_requests = DataRequest::where('tenant_id', $tenant_id)->orderBy('id', 'desc')->get();
        return view('pages.admin.tenant.data_request.index', ['data_requests' => $data_requests, 'tenant_id' => $id]);
    }

    public function create($id)
    {
        return view('pages.admin.tenant.data_request.create', ['tenant_id' => $id]);
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'data_file' => 'required|mimes:csv,txt',
            ]
        );
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $data_request = new DataRequest();
            $data_request['name'] = $request->name;
            $data_request['description'] = $request->description;
            $data_request['tenant_id'] = ___decrypt($id);
            $file = upload_file($request, 'data_file', 'data_file');
            $data_request['file_name'] = $file;
            $json = csvToJson($file);
            $data_request['data_request'] = $json;
            $data_request['created_by'] = Auth::user()->id;
            $data_request['updated_by'] = Auth::user()->id;
            $data_request->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $id . '/data_request');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
    }

    public function edit($tenant_id, $id)
    {
        $data_request = DataRequest::where('id', ___decrypt($id))->first();
        return view('pages.admin.tenant.data_request.edit', ['data_request' => $data_request]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $data_request = DataRequest::find(___decrypt($id));
            $data_request->name = $request->name;
            $data_request->description = $request->description;
            if (!empty($request->data_file)) {
                $file = upload_file($request, 'data_file', 'data_file');
                $data_request->file_name = $file;
                $json = csvToJson($file);
                $data_request->data_request = $json;
            }
            $data_request->updated_by = Auth::user()->id;
            $data_request->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/data_request');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function downloadCSV(Request $request)
    {
        $data_request = DataRequest::find(___decrypt($request->id));
        $csv_filename = $data_request->name . '.csv';
        jsonToCSV($data_request->data_request, $csv_filename);
        $headers = [];
        return response()->download($csv_filename, $csv_filename, $headers);
    }

    public function destroy(Request $request, $tenant_id, $id)
    {
        if (!empty($request->status)) {
            $update = DataRequest::find(___decrypt($id));
            $update['status'] = $request->status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/data_request');
            $this->message = "Status Changed Successfully!";
        } else {
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (DataRequest::where('id', ___decrypt($id))->update($update)) {
                DataRequest::destroy(___decrypt($id));
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('admin/tenant/data_request');
                $this->message = "Data Request Deleted Successfully!";
            }
        }
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request)
    {
        $string = implode(',', $request->bulk);
        $dataRequestID = explode(',', ($string));
        foreach ($dataRequestID as $idval) {
            $dataRequestIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (DataRequest::whereIn('id', $dataRequestIDS)->update($update)) {
            DataRequest::destroy($dataRequestIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/data_request');
        return $this->populateresponse();
    }
}
