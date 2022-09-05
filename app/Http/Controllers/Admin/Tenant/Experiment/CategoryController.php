<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Experiment\ExperimentCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['category'] = ExperimentCategory::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = $tenant_id;
        $catgeories = [];
        foreach ($data['category'] as $category) {
            if ($category['status'] == 'active') {
                $catgeories[] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                ];
            }
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $catgeories
            ]);
        }
        return view('pages.admin.master.experiment.category.index', $data);
    }

    public function create()
    {
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $category =  new ExperimentCategory();
            $category['name'] = $request->category_name;
            $category['tenant_id'] = ___decrypt($tenant_id);
            $category['description'] = $request->description;
            $category['created_by'] = Auth::user()->id;
            $category['updated_by'] = Auth::user()->id;
            $category->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($tenant_id, $id)
    {
    }

    public function edit($tenant_id, $id)
    {
        $cat = ExperimentCategory::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.experiment.category.edit', ['cat' => $cat, 'tenant_id' => $tenant_id])->render()
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $category = ExperimentCategory::find(___decrypt($id));
            $category['name'] = $request->category_name;
            $category['description'] = $request->description;
            $category['updated_by'] = Auth::user()->id;
            $category['updated_at'] = now();
            $category->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Updated Successfully!";
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
            $update = ExperimentCategory::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ExperimentCategory::where('id', ___decrypt($id))->update($update)) {
                ExperimentCategory::destroy(___decrypt($id));
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
            $processIDS[] = $idval;
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ExperimentCategory::whereIn('id', $processIDS)->update($update)) {
            ExperimentCategory::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
