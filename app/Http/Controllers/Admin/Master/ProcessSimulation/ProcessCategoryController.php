<?php

namespace App\Http\Controllers\Admin\Master\ProcessSimulation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\ProcessSimulation\ProcessCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProcessCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['category'] = ProcessCategory::all();
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
        return view('pages.admin.master.process_simulation.category.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $category = new ProcessCategory();
            $category->name = $request->name;
            $category->description = $request->description;
            $category['created_by'] = Auth::user()->id;
            $category['updated_by'] = Auth::user()->id;
            $category->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/process_simulation/category');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = ProcessCategory::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ProcessCategory::where('id', ___decrypt($id))->update($update)) {
                ProcessCategory::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/process_simulation/category');
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
        if (ProcessCategory::whereIn('id', $processIDS)->update($update)) {
            ProcessCategory::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/process_simulation/category');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $cat = ProcessCategory::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.process_simulation.category.edit', ['cat' => $cat])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $category = ProcessCategory::find(___decrypt($id));
            $category->name = $request->name;
            $category->description = $request->description;
            $category['updated_by'] = Auth::user()->id;
            $category['updated_at'] = now();
            $category->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/process_simulation/category');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
