<?php

namespace App\Http\Controllers\Admin\Master\Chemical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\ChemicalCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['category'] = ChemicalCategory::all();
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
        return view('pages.admin.master.chemical.category.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $type =  new ChemicalCategory();
            $type['name'] = $request->name;
            $type['description'] = $request->description;
            $type['created_by'] = Auth::user()->id;
            $type['updated_by'] = Auth::user()->id;
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/category');
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
            $update = ChemicalCategory::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ChemicalCategory::where('id', ___decrypt($id))->update($update)) {
                ChemicalCategory::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/category');
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
        if (ChemicalCategory::whereIn('id', $processIDS)->update($update)) {
            ChemicalCategory::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/category');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $cat = ChemicalCategory::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.chemical.category.edit', ['cat' => $cat])->render()
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
            $type =  ChemicalCategory::find(___decrypt($id));
            $type['name'] = $request->name;
            $type['description'] = $request->description;
            $type['updated_by'] = Auth::user()->id;
            $type['updated_at'] = now();
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/category');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
