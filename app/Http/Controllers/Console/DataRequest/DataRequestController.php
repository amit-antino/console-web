<?php

namespace App\Http\Controllers\Console\DataRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\DataRequest\DataRequest;

class DataRequestController extends Controller
{

    public function index()
    {
        $data_requests = DataRequest::where([['status', 'Published'], ['tenant_id', session()->get('tenant_id')]])->orderBy('id', 'desc')->get();
        return view('pages.console.data_request.index', ['data_requests' => $data_requests]);
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
    }

    public function downloadCSV(Request $request)
    {
        $data_request = DataRequest::find(___decrypt($request->id));
        $csv_filename = $data_request->name . '.csv';
        jsonToCSV($data_request->data_request, $csv_filename);
        $headers = [
            'Content-Type' => 'application/csv',
        ];
        return response()->download($csv_filename, $csv_filename, $headers);
    }

    public function datarequest_list(Request $request)
    {
        $tenant_id = authenticate_api($request->API_key, $request->ClientID, $request->SecretKey);
        try {
            $data_requests = DataRequest::where([['status', 'Published'], ['tenant_id', $tenant_id]])->orderBy('id', 'desc')->get();
            $list = [];
            foreach ($data_requests as $data_request) {
                $list[] = [
                    "key" => ___encrypt($data_request->id),
                    "name" => $data_request->name

                ];
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $list
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function datarequest_csv(Request $request)
    {
        $tenant_id = authenticate_api($request->API_key, $request->ClientID, $request->SecretKey);
        try {
            $data_request = DataRequest::find(___decrypt($request->data_key));
            $csv_filename = $data_request->name . '.csv';
            jsonToCSV($data_request->data_request, $csv_filename);
            $headers = [
                'Content-Type' => 'application/csv',
            ];
            return response()->download($csv_filename, $csv_filename, $headers);
            // return response()->json([
            //     'success' => true,
            //     'status_code' => 200,
            //     'status' => true,
            //     'data' => $list
            // ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }
}
