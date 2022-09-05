<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\ProcessExperiment\AssociatedModel;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\Models\ModelDetail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\ProcessExperiment\Variation;

class AssociatedController extends Controller
{

    public function view_associate_model(Request $request)
    {
        $viewflag = $request->viewflag;
        $html = view('pages.console.experiment.experiment.profile.model', compact('viewflag'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function associate_model(Request $request)
    {
        $data = [];
        $variton = Variation::where('id', ___decrypt($request->vartion_id))->first();
        $arr = [];
        if (!empty($variton->models)) {
            $arr = $variton->models;
        }
        $viewflag = $request->viewflag;
        $data = ModelDetail::whereIn('id', $arr)->orderBy('id', 'desc')->get();
        $html = view('pages.console.experiment.experiment.profile.associate_model', compact('data', 'viewflag'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function upload_associate_model(Request $request)
    {
        $data = [];
        $expnameobj = ProcessExperiment::where('id', ___decrypt($request->process_experiment_id))->first();
        $expname = $expnameobj['process_experiment_name'];
        $html = view('pages.console.experiment.experiment.profile.upload_model', compact('data'), compact('expname'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function render_edit_models(Request $request)
    {

        $data = [];
        $data = ModelDetail::find(___decrypt($request->model_id));
        $name = '';
        $html = view('pages.console.experiment.experiment.profile.edit_associate_model', compact('data'), compact('name'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function get_models_file(Request $request)
    {
        $data = [];
        $data = ModelDetail::where('id', ___decrypt($request->id))->first();
        $name = $data->name;
        $html = view('pages.console.experiment.experiment.profile.edit_model_file', compact('data'), compact('name'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function getFileContent_models(Request $request)
    {
        $data = [];
        $data = ModelDetail::where('id', ($request->id))->first();
        $dataObj = $data->files;
        $file = $dataObj[$request->file_id];
        $furl = ($file['url']);
        $contentfile = file_get_contents($furl);
        $html = view('pages.console.experiment.experiment.profile.file_content', compact('contentfile'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function view_dataset(Request $request)
    {
        $viewflag = $request->viewflag;
        $html = view('pages.console.experiment.experiment.profile.dataset', compact('viewflag'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function view_datarequest(Request $request)
    {
        $viewflag = $request->viewflag;
        $html = view('pages.console.experiment.experiment.profile.datarequest', compact('viewflag'))->render();
        return response()->json(['success' => true,  'html' => $html]);
    }

    public function store(Request $request)
    {
        try {
            $model_detail = new ModelDetail();
            $model_detail->name = $request->model_name;
            $model_detail->process_experiment_id = ___decrypt($request->process_experiment_id);
            $model_detail->model_type = !empty($request->model_type) ? ($request->model_type) : 0;
            $model_detail->version  = $request->version;
            $fileArr = [];
            $filespath = [];
            if (!empty($request->associted_model_file)) {
                foreach ($request->associted_model_file as $key => $files) {
                    $folder_name = 'associted_model_file/';
                    $file       = $files;
                    $extension  = $file->getClientOriginalExtension();
                    $file_name  = $file->getClientOriginalName();
                    $newFileName = 'models_' . date('YmdHis') . rand(1000, 9999) . '.' . $extension;
                    $backupLoc =  'uploads/' . $folder_name;
                    if (!is_dir($backupLoc)) {
                        mkdir($backupLoc, 0755, true);
                    }

                    $file->move($backupLoc, $newFileName);
                    $url = $backupLoc . $newFileName;
                    $filespath[] = $url;
                    $fileArr[] = ['url' => $url, 'filename' => $newFileName];
                }
            }

            $model_detail->files = $fileArr;
            if (!empty($request->tags)) {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $model_detail->tags = $tags;
            if (!empty($request->assumptions)) {
                $assumptions = explode(",", $request->assumptions);
            } else {
                $assumptions = [];
            }
            $model_detail->assumptions  = $assumptions;
            if (!empty($request->recommendations)) {
                $recommendations = explode(",", $request->recommendations);
            } else {
                $recommendations = [];
            }
            $model_detail->recommendations  = $recommendations;
            if (!empty($request->list_of_models)) {
                $list_of_models = explode(",", $request->list_of_models);
            } else {
                $list_of_models = [];
            }
            $model_detail->list_of_models  = $list_of_models;
            if (!empty($request->association)) {
                $association = explode(",", $request->association);
            } else {
                $association = [];
            }
            $model_detail->association  = $association;
            //$model_detail->status = 'requested';
            $model_detail->created_by = Auth::user()->id;
            $model_detail->updated_by = Auth::user()->id;
            $model_detail->description = $request->description;
            if ($model_detail->save()) {
                $variation = Variation::find(___decrypt($request->vartion_id));

                $modelArr = [];
                if (!empty($variation)) {
                    if (!empty($variation->models)) {
                        $modelArr = $variation->models;
                    }
                }
                array_push($modelArr, $model_detail->id);
                $variation->models = $modelArr;
                $variation->updated_by = Auth::user()->id;
                $variation->save();
            }


            $status = true;
            $message = "Model Added Successfully.";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        try {
            $username = getUser($model_detail->created_by);
            $title = "New Model has been Uploaded";
            Mail::send('email_templates.model_template', [
                'url' => '', 'title' => $title, 'name' => $model_detail->name, 'id' => $model_detail->id, 'username' => $username['username']
            ], function ($message) use ($request, $filespath) {
                $message->to('abhijit.jagtap@simreka.com')->subject('Model Uploaded');
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

    public function update_associated_model(Request $request)
    {
        try {
            $model_detail = ModelDetail::find($request->id);
            $model_detail->name = $request->name;
            $fileArr = [];
            $folder_name = 'associted_model_file/';
            $backupLoc =  'uploads/' . $folder_name;
            $fileName = 'model_' . time() . '.py';
            File::put($backupLoc . '/' . $fileName, $request->file_content);
            $url = $backupLoc . $fileName;
            $arr = [];
            $cnt = count($model_detail['files']);
            $arr[$cnt]['url'] = $url;
            $arr[$cnt]['filename'] = $fileName;
            $arrObj = array_merge($model_detail['files'], $arr);
            $model_detail->files = $arrObj;
            $model_detail->status = 'active';
            $model_detail->updated_by = Auth::user()->id;
            $model_detail->save();
            $status = true;
            $message = "Model Updated Successfully.";
        } catch (\Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }
        try {
            $username = getUser($model_detail->created_by);
            $title = "Model has been Updated";
            Mail::send('email_templates.model_template', [
                'url' => '', 'title' => $title, 'name' => $model_detail->name, 'id' => $model_detail->id, 'username' => $username['username']
            ], function ($message) use ($request) {
                $message->to('abhijit.jagtap@simreka.com')->subject('Model Uploaded');
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

    public function delete_model(Request $request)
    {
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ModelDetail::where('id', ___decrypt($request->id))->update($update)) {
            ModelDetail::destroy(___decrypt($request->id));
        }
        $response = [
            'success' => true,
            'message' => "delete"
        ];
        return response()->json($response, 200);
    }

    public function update_status_model(Request $request)
    {
        $mid = ModelDetail::where(['process_experiment_id' => ___decrypt($request->pe_id), 'flag' => 1])->first();
        if (!empty($mid)) {
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update['flag'] = 0;
            ModelDetail::where('id', ($mid->id))->update($update);
        }
        $update_flag['updated_by'] = Auth::user()->id;
        $update_flag['updated_at'] = now();
        $update_flag['flag'] = 1;
        ModelDetail::where('id', ($request->model_id))->update($update_flag);
        $response = [
            'success' => true,
            'message' => "delete"
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
        if (ModelDetail::whereIn('id', $processIDS)->update($update)) {
            ModelDetail::destroy($processIDS);
        }
        $response = [
            'success' => true,
            'message' => "delete"
        ];
        return response()->json($response, 200);
    }
}
