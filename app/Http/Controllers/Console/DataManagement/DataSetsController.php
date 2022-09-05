<?php

namespace App\Http\Controllers\Console\DataManagement;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Imports\DataSetExperimenttImport;
use App\Models\DataManagement\Dataset;
use Illuminate\Support\Facades\Session;
use App\Models\Tenant\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataSetsController extends Controller
{
    public function index()
    {
        $data['data_sets'] = Dataset::get();
        $data['projects'] = Project::where('status', 'active')->get();
        return view('pages.console.data_management.data_sets.index', $data);
    }

    public function create()
    {
        $data['data_sets'] = [];
        return view('pages.console.data_management.data_sets.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant_id = Session::get('tenant_id');
            $data_set =  new Dataset();
            $data_set['tenant_id'] = $tenant_id;
            $data_set['project_id'] = !empty($request->project_id) ? ___decrypt($request->project_id) : 0;
            $data_set['name'] = $request->name;
            $data_set['description'] = $request->description;
            $data_set['tags'] = $request->tags;
            $data_set['updated_by'] = Auth::user()->id;
            $data_set['created_by'] = Auth::user()->id;
            $data_set->save();
            if (!empty($request->experiment_files)) {
                \Excel::import(new DataSetExperimenttImport($data_set->id), request()->file('experiment_files'));
            }
            $exp = '';
            if (!empty($request->experiment_files)) {
                $exp = upload_file($request, 'experiment_files', 'dataset');
            }
            $new_dataset = Dataset::find($data_set->id);
            $new_dataset['experiment_file'] = $exp;
            $new_dataset->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('data_management/data_sets');
            $this->message = "DataSet Added Successfully.";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $data_sets = Dataset::where('id', ___decrypt($id))->first();
        $project = Project::where('id', $data_sets->project_id)->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.data_management.data_sets.edit', ['data_set' => $data_sets, 'project_name' => !empty($project->name) ? $project->name : ''])->render()
        ]);
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
            $update = Dataset::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (Dataset::where('id', ___decrypt($id))->update($update)) {
                Dataset::destroy(___decrypt($id));
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
        if (Dataset::whereIn('id', $processIDS)->update($update)) {
            Dataset::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function list_experiment(Request $request)
    {
        $data_sets = Dataset::where('id', ___decrypt($request->parameters))->first();
        $experiments = $data_sets->experiment_data;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.data_management.data_sets.experiment_list', ['experiments' => $experiments])->render()
        ]);
    }
}
