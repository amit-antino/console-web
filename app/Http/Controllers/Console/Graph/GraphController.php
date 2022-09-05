<?php

namespace App\Http\Controllers\Console\Graph;

use App\Http\Controllers\Controller;
use App\Models\Graph\ToleranceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class GraphController extends Controller
{
    public function index(Request $request)
    {
        $data['tolerances'] = ToleranceReport::orderBy('id', 'desc')->get();
        if ($request->ajax()) {
            return response()->json([
                'status'    => true,
                'html'      => view('pages.console.graph_in.list', [
                    'tolerances' => $data['tolerances'],
                ])->render()
            ]);
        }
        return view('pages.console.graph_in.index', $data);
    }

    public function create()
    {
        return view('pages.console.graph_in.create');
    }

    public function show($id)
    {
        $torance_val = ToleranceReport::where('id', ___decrypt($id))->first();
        $tolerance_data = json_decode($torance_val->output_data);
        $data['graph_data'] = $tolerance_data->key_results->summary;
        $data['value'] = $torance_val->tolerance_value;
        return view('pages.console.graph_in.view', $data);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tolerance_value' => 'required',
            ]);
            if ($validator->fails()) {
                $this->message = $validator->errors();
            } else {
                $simulationData = new ToleranceReport();
                $simulationData->name = 'Tolerance';
                $simulationData->tolerance_value = $request->tolerance_value;
                $simulationData->status = "pending";
                $simulationData->created_by = Auth::user()->id;
                $simulationData->updated_by = Auth::user()->id;
                $simulationData->created_at = now();
                if ($simulationData->save()) {
                    $calc_url = env('TOLERANCE_URL');
                    $url = $calc_url . '/api/v1/experiment/generate/tolerance';
                    $data = [
                        'report_id' => $simulationData->id,
                        'tolerance_value' => $simulationData->tolerance_value,
                        // 'tenant_id' => session('tenant_id'),
                        // 'user_id' => Auth::user()->id
                    ];
                    $client = new Client();
                    $options = [
                        'form_params' => $data,
                        // 'http_errors' => false,
                        'timeout' => 3
                    ];
                    $promise = $client->request('POST', $url, $options);
                    // $response = $promise->wait();
                }
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('graph-in');
                $this->message = "Added Successfully!";
            }
        } catch (\Exception $e) {
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('graph-in');
            $this->message = 'Added Successfully!"';
        }
        return $this->populateresponse();
    }

    public function process_output(Request $request)
    {
        try {
            $tolerance = ToleranceReport::find($request->report_id);
            $tolerance->output_data = !empty($request->output_data) ? $request->output_data : NULL;
            $tolerance->status = $request->status;
            $tolerance->messages = $request->messages;
            $tolerance->updated_at = now();
            $tolerance->save();
            return response()->json([
                'success' => "true",
                'status_code' => 200,
                'status' => "true",
                'data' => "Database Updated Successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => "false",
                'status_code' => 500,
                'status' => "false",
                'data' => $e->getMessage()
            ]);
        }
    }
    public function destroy($id)
    {
        ToleranceReport::find(___decrypt($id))->delete();
        $this->status = true;
        $this->redirect = url('/graph-in');
        return $this->populateresponse();
    }

    public function retry(Request $request, $id)
    {
        $simulationData =  ToleranceReport::find(___decrypt($id));
        $simulationData->status = "pending";
        $simulationData->updated_by = Auth::user()->id;
        $simulationData->updated_at = now();
        if ($simulationData->save()) {
            $calc_url = env('TOLERANCE_URL');
            $url = $calc_url . '/api/v1/experiment/generate/tolerance';
            $data = [
                'report_id' => $simulationData->id,
                'tolerance_value' => $simulationData->tolerance_value
            ];
            $client = new Client();
            $options = [
                'form_params' => $data,
                'timeout' => 3
            ];
            $promise = $client->request('POST', $url, $options);
            // $response = $promise->wait();
            $status = true;
            $message = "Success";
        }
        $this->status = true;
        $this->redirect = url('/graph-in');
        return $this->populateresponse();
    }
}
