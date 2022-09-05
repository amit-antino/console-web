<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Models\ModelDetail;
use App\Models\Models\ModelFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ModelsController extends Controller
{
    public function index($tenant_id)
    {
        $data['models'] = ModelDetail::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.master.experiment.model.index', $data);
    }

    public function create($tenant_id)
    {
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.master.experiment.model.create', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $model =  new ModelDetail();
            $model['name'] = $request->name;
            $model['tenant_id'] = ___decrypt($tenant_id);
            $model['version'] = $request->version;
            $model['association'] = $request->association;
            $model['recommendations'] = $request->recommendations;
            $model['list_of_models'] = $request->list_of_models;
            $model['assumptions'] = $request->assumptions;
            $model['description'] = $request->description;
            $model['created_by'] = Auth::user()->id;
            $model['updated_by'] = Auth::user()->id;
            $model->save();
            if ($model->id) {
                if (!empty($request->file)) {
                    foreach ($request->file as $key => $files) {
                        $folder_name = 'uploads\models\files';
                        if (!is_dir($folder_name)) {
                            mkdir($folder_name, 0777, true);
                        }
                        $file       = $files;
                        $extension  = $file->getClientOriginalExtension();
                        $file_name  = $file->getClientOriginalName();
                        $newFileName = 'models_' . date('YmdHis') . rand(1000, 9999) . '.' . $extension;
                        $file->move($folder_name, $newFileName);
                        $url = $folder_name . '/' . $newFileName;
                        $modelFile = new ModelFile();
                        $modelFile->model_id = $model->id;
                        $modelFile->file_name = $file_name;
                        $modelFile->file_url = $url;
                        $modelFile->created_by = Auth::user()->id;
                        $modelFile->updated_by = Auth::user()->id;
                        $modelFile->save();
                    }
                }
            }
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/models');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($tenant_id, $id)
    {
        return view('pages.admin.master.experiment.model.view');
    }

    public function edit($tenant_id, $id)
    {
        $id = ___decrypt($id);
        $data['tenant_id'] = $tenant_id;
        $data['models'] = ModelDetail::Select('*')
            ->with([
                'model_files' => function ($q) {
                    $q->select('*');
                }
            ])
            ->where('id', $id)->first();
        return view('pages.admin.master.experiment.model.edit', $data);
    }

    public function getFileContent($tenant_id, $file_id)
    {
        $file = ModelFile::where('id', ___decrypt($file_id))->first();
        $content = file_get_contents($file->file_url);
        return response()->json([
            'status' => true,
            'content' => $content,
            'file_url' => $file->file_url,
            'file_name' => $file->file_name,
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => "required_if:new_file,==,on"
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $id = ___decrypt($id);
            if (!empty($request->new_file)) {
                $extension = pathinfo($request->file_url, PATHINFO_EXTENSION);
                $content = $request->file_details;
                $file = 'models_' . date('YmdHis') . rand(1000, 9999) . '_file.' . $extension;
                $destinationPath = public_path() . "/uploads/models/files/" . $file;
                \File::put($destinationPath, $content);
                $modelFile = new ModelFile();
                $modelFile->model_id = $id;
                $modelFile->file_name = $request->file_name;
                $modelFile->file_url = $destinationPath;
                $modelFile->updated_by = Auth::user()->id;
                $modelFile->updated_at = now();
                $modelFile->save();
            } else {
                $file = $request->file_url;
                $content = $request->file_details;
                \File::put($file, $content);
            }
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/models');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $tenant_id, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = ModelDetail::find(___decrypt($id));
            $update['operation_status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['operation_status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ModelDetail::where('id', ___decrypt($id))->update($update)) {
                ModelDetail::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request, $tenant_id)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ModelDetail::whereIn('id', $processIDS)->update($update)) {
            ModelDetail::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
