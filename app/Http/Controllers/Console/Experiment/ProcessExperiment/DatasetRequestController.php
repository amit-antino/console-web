<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use App\Models\Models\ModelDetail;
use Illuminate\Http\Request;
use App\Models\ProcessExperiment\DataRequestModel;
use App\Models\ProcessExperiment\DatasetModel;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\ProcessExperiment\Variation;

class DatasetRequestController extends Controller
{
    public function index()
    {
    }

    public function datareq_list(Request $request)
    {
        $data = [];
        $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
        $arr = [];

        if (!empty($variton->datamodel)) {
            $arr = $variton->datamodel;
        }
        $viewflag = $request->viewflag;
        $data = DataRequestModel::whereIn('id', $arr)->with('getCreatedBy')->orderBy('id', 'desc')->get();
        $html = view('pages.console.experiment.experiment.profile.data_request_list', compact('data', 'viewflag'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function upload_datareq_model(Request $request)
    {
        $data = [];
        $data = User::get();
        $models = ModelDetail::where(['operation_status' => 'active'])->get();
        $datasets = DatasetModel::where(['operation_status' => 'active'])->get();
        $html = view('pages.console.experiment.experiment.profile.upload_data_request', compact('data', 'datasets', 'models'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function create()
    {
    }

    public function delete_data_request(Request $request)
    {
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (DataRequestModel::where('id', ___decrypt($request->id))->update($update)) {
            DataRequestModel::destroy(___decrypt($request->id));
        }
        $response = [
            'success' => true,
            'message' => "delete"
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        try {
            $expData = new DataRequestModel();
            $expData->process_experiment_id = ___decrypt($request->process_experiment_id);
            $expData->model_id = $request->model_id;
            $expData->tenant_id = session()->get('tenant_id');
            $expData->simulation_input_id = $request->simulation_input_id;
            //$expData->description = $request->description;
            $expData->notes = $request->file_notes;
            $filespath = [];
            // if (!empty($request->data_req_file)) {
            //     $data_req_file = upload_file($request, 'data_req_file', 'data_req_file');
            //     $expData->filename = $data_req_file;
            //     $filespath[] = $data_req_file;
            // }
            //$expData->status = 'active';
            $expData->created_by = Auth::user()->id;
            $expData->updated_by = Auth::user()->id;
            if ($expData->save()) {
                $variation = Variation::find(___decrypt($request->vartion_id));

                $datamodelArr = [];
                if (!empty($variation)) {
                    if (!empty($variation->datamodel)) {
                        $datamodelArr = $variation->datamodel;
                    }
                }
                if (!in_array($expData->id, $datamodelArr)) {
                    array_push($datamodelArr, $expData->id);
                }
                $variation->datamodel = $datamodelArr;
                $variation->updated_by = Auth::user()->id;
                $variation->save();
            }
            $status = true;
            $message = "Data/Model Request Sent Successfully.";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        // try {
        //     $username = getUser($expData->created_by);
        //     $title = "New Data/Model request has been Created";
        //     Mail::send('email_templates.model_template', [
        //         'url' => '', 'title' => $title, 'id' => $expData->id, 'username' => $username['username']
        //     ], function ($message) use ($request, $filespath) {
        //         $message->to('abhijit.jagtap@simreka.com')->subject('New Data/Model request Created');
        //         if (!empty($filespath)) {
        //             foreach ($filespath as $file) {
        //                 $message->attach($file);
        //             }
        //         }
        //     });
        // } catch (\Throwable $th) {
        //     $status = false;
        //     $message = $th->getMessage();
        // }
        $response = [
            'success' => $status,
            'message' => $message
        ];
        return response()->json($response, 200);
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
    
    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->ids);
        $processIDS1 = explode(',', ($id_string));
        foreach ($processIDS1 as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (DataRequestModel::whereIn('id', $processIDS)->update($update)) {
            DataRequestModel::destroy($processIDS);
        }
        $response = [
            'success' => true,
            'message' => "delete"
        ];
        return response()->json($response, 200);
    }
}
