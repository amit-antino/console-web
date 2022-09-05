<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessExperiment\DatasetModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Models\ModelDetail;
use Illuminate\Support\Facades\Mail;
use App\Models\ProcessExperiment\Variation;

class DatasetModelController extends Controller
{

    public function dataset_list(Request $request)
    {
        $data = [];
        $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
        $arr = [];
        if (!empty($variton->dataset)) {
            $arr = $variton->dataset;
        }
        $viewflag = $request->viewflag;
        $data = DatasetModel::whereIn('id', $arr)->orderBy('id', 'desc')->get();
        $html = view('pages.console.experiment.experiment.profile.dataset_list', compact('data', 'viewflag'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function upload_dataset_model(Request $request)
    {
        $data = [];
        $html = view('pages.console.experiment.experiment.profile.upload_dataset_model', compact('data'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function updated_dataset_model(Request $request)
    {
        $dataset = [];
        $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
        $dataset = DatasetModel::where('id', ___decrypt($request->id))->first();
        $arr = [];
        if (!empty($variton->models)) {
            $arr = $variton->models;
        }
        $datamodel = ModelDetail::whereIn('id', $arr)->orderBy('id', 'desc')->get();
        $html = view('pages.console.experiment.experiment.profile.update_dataset', compact('dataset'), compact('datamodel'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            $expData = new DatasetModel();
            $expData->process_experiment_id = ___decrypt($request->process_experiment_id);
            $expData->name = $request->dataset_name;
            $expData->tenant_id = session()->get('tenant_id');
            $expData->type = !empty($request->dataset_type) ? ($request->dataset_type) : 0;
            $filespath = [];
            if (!empty($request->dataset_model_file)) {
                $dataset_model_file = upload_file($request, 'dataset_model_file', 'dataset_model_file');
                $expData->filename = $dataset_model_file;
                $filespath[] = $dataset_model_file;
            }
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $expData->description = $request->description;
            $expData->tags = $tags;
            //$expData->status = 'pending';
            $expData->created_by = Auth::user()->id;
            $expData->updated_by = Auth::user()->id;
            if ($expData->save()) {
                $variation = Variation::find(___decrypt($request->vartion_id));
                $datasetArr = [];
                if (!empty($variation)) {
                    if (!empty($variation->dataset)) {
                        $datasetArr = $variation->dataset;
                    }
                }
                if (!in_array($expData->id, $datasetArr)) {
                    array_push($datasetArr, $expData->id);
                }

                $variation->dataset = $datasetArr;
                $variation->updated_by = Auth::user()->id;
                $variation->save();
            }
            $status = true;
            $message = "Dataset Added Successfully.";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        try {
            $username = getUser($expData->created_by);
            $title = "New Dataset has been Uploaded";
            Mail::send('email_templates.model_template', [
                'url' => '', 'title' => $title, 'name' => $expData->name, 'id' => $expData->id, 'username' => $username['username']
            ], function ($message) use ($request, $filespath) {
                $message->to('app@simreka.com')->subject('New Dataset Uploaded');
                if (!empty($filespath)) {
                    foreach ($filespath as $file) {
                        $message->attach($file);
                    }
                }
            });
        } catch (\Throwable $th) {
            $status = false;
            $message = $th->getMessage();
        }
        $response = [
            'success' => $status,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function exp_dataset_update(Request $request)
    {
        try {
            $expData = DatasetModel::find(___decrypt($request->simulation_input_id));
            $expData->name = ($request->dataset_name);
            $expData->model_id = ($request->model_type);
            $expData->update_notes = $request->update_notes;
            $expData->update_parameter = $request->udate_parameter;
            $expData->updated_by = Auth::user()->id;
            $expData->save();
            $status = true;
            $message = "Dataset  Updated Successfully.";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $response = [
            'success' => $status,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function delete_dataset(Request $request)
    {
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (DatasetModel::where('id', ___decrypt($request->id))->update($update)) {
            DatasetModel::destroy(___decrypt($request->id));
        }
        $response = [
            'success' => true,
            'message' => "delete"
        ];
        return response()->json($response, 200);
    }

    public function update_status_dataset(Request $request)
    {
        $mid = DatasetModel::where(['process_experiment_id' => ___decrypt($request->pe_id), 'flag' => 1])->first();
        if (!empty($mid)) {
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update['flag'] = 0;
            DatasetModel::where('id', ($mid->id))->update($update);
        }
        $update_flag['updated_by'] = Auth::user()->id;
        $update_flag['updated_at'] = now();
        $update_flag['flag'] = 1;
        DatasetModel::where('id', ($request->simulation_input_id))->update($update_flag);
        $response = [
            'success' => true,
            'message' => "updated"
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
        if (DatasetModel::whereIn('id', $processIDS)->update($update)) {
            DatasetModel::destroy($processIDS);
        }
        $response = [
            'success' => true,
            'message' => "delete"
        ];
        return response()->json($response, 200);
    }
}
