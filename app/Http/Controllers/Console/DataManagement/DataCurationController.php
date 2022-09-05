<?php

namespace App\Http\Controllers\Console\DataManagement;

use App\Http\Controllers\Controller;
use App\Models\DataManagement\CurationRule;
use App\Models\DataManagement\DataCuration;
use App\Models\DataManagement\Dataset;
use App\Models\Tenant\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class DataCurationController extends Controller
{
    public function index(Request $request)
    {
        $data['data_curation'] = DataCuration::where(['tenant_id' => 1])->orderBy('id', 'desc')->get();
        $data['curation_rule'] = CurationRule::where(['tenant_id' => 1, 'status' => 'active'])->get();
        $data['datasets'] = Dataset::where('status', 'active')->get();
        if ($request->ajax()) {
            return response()->json([
                'status'    => true,
                'html'      => view('pages.console.data_management.data_curation.list', [
                    'data_curation' => $data['data_curation'],
                    //'curation_rule' => $data['data_curation'],
                ])->render()
            ]);
        }
        return view('pages.console.data_management.data_curation.index', $data);
    }


    public function create()
    {
        $data['data_curation'] = [];
        return view('pages.console.data_management.data_curation.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'simulation_input_id' => 'required',
                'experiment' => 'required',
                'variation_coeficient' => 'required',
                'smoothness_factor' => 'required',
            ]);
            if ($validator->fails()) {
                $this->message = $validator->errors();
            } else {
                $tenant_id = Session::get('tenant_id');
                $data_curation =  new DataCuration();
                $data_curation['tenant_id'] = $tenant_id;
                $data_curation['data_set_id'] = !empty($request->simulation_input_id) ? ___decrypt($request->simulation_input_id) : 0;
                $data_curation['curation_rule_id'] = !empty($request->curation_rule_id) ? ___decrypt($request->curation_rule_id) : 0;
                $data_curation['data_set_experiment_id'] = !empty($request->experiment) ? $request->experiment : 0;
                $data_curation['variation_coeficient'] = !empty($request->variation_coeficient) ? $request->variation_coeficient : 0;
                $data_curation['smoothness_factor'] = !empty($request->smoothness_factor) ? $request->smoothness_factor : 0;
                $data_curation['updated_by'] = Auth::user()->id;
                $data_curation['created_by'] = Auth::user()->id;
                $data_curation->save();
                if ($data_curation->save()) {
                    $calc_url = env('GENERATE_REPORT', 'http://localhost:5000');
                    $url = $calc_url . '/api/v1/experiment/generate/data_curation';
                    $data = [
                        'report_id' => $data_curation->id,
                        "experiment_name" =>  $request->experiment,
                        "cov_user_defined" => $data_curation->variation_coeficient,
                        "smoothness_factor" => $data_curation->smoothness_factor
                    ];
                    $client = new Client();
                    $options = [
                        'form_params' => $data,
                        // 'http_errors' => false,
                        'timeout' => 1
                    ];
                    $promise = $client->request('POST', $url, $options);
                    // $response = $promise->wait();
                    $status = true;
                    $message = "Success";
                }
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('data_management/data_curation');
                $this->message = "Data Curation Added Successfully.";
            }
        } catch (\Exception $e) {
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('data_management/data_curation');
            $this->message = 'Data Curation Added Successfully.';
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $data_sets = DataCuration::where('id', ___decrypt($id))->first();
        $data['data_set'] = Dataset::where('id', $data_sets->data_set_id)->first();
        $curatin_data = json_decode($data_sets->output, true);
        $data['graph_data'] = json_encode($curatin_data['graph_outcome']);
        $data['data_curation'] = $data_sets;
        return view('pages.console.data_management.data_curation.view', $data);
    }

    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
    }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = DataCuration::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (DataCuration::where('id', ___decrypt($id))->update($update)) {
                DataCuration::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = true;
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
        if (DataCuration::whereIn('id', $processIDS)->update($update)) {
            DataCuration::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function retry(Request $request, $id)
    {
        try {
            $data_curation =  DataCuration::find(___decrypt($id));
            $data_curation->status = "pending";
            $data_curation->updated_by = Auth::user()->id;
            $data_curation->updated_at = now();
            if ($data_curation->save()) {
                $calc_url = env('GENERATE_REPORT', 'http://localhost:5000');
                $url = $calc_url . '/api/v1/experiment/generate/data_curation';
                $data = [
                    'report_id' => $data_curation->id,
                    "experiment_name" =>  $data_curation->data_set_experiment_id,
                    "cov_user_defined" => $data_curation->variation_coeficient,
                    "smoothness_factor" => $data_curation->smoothness_factor
                ];
                $client = new Client();
                $options = [
                    'form_params' => $data,
                    'timeout' => 1
                ];
                $promise = $client->request('POST', $url, $options);
                // $response = $promise->wait();
                $status = true;
                $message = "Success";
            }
            $this->status = true;
            $this->redirect = url('/data_management/data_curation');
        } catch (\Exception $e) {
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('data_management/data_curation');
            $this->message = 'Data Curation Added Successfully.';
        }
        return $this->populateresponse();
    }

    public function data_curation_output(Request $request)
    {
        try {
            $curation = DataCuration::find($request->report_id);
            $curation->output = !empty($request->output_data) ? $request->output_data : [];
            $curation->status = $request->status;
            $curation->message = $request->messages;
            $curation->updated_at = now();
            $curation->save();
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
}
