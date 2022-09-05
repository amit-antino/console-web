<?php

namespace App\Http\Controllers\Admin\Tenant\Lists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Lists\CategoryList;
use App\Models\Organization\Lists\ClassificationList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index($tenant_id)
    {
        $data['category'] = CategoryList::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.master.list.category.index', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $category =  new CategoryList();
            $category['category_name'] = $request->name;
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

    public function destroy(Request $request, $tenant_id, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = CategoryList::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (CategoryList::where('id', ___decrypt($id))->update($update)) {
                CategoryList::destroy(___decrypt($id));
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
        if (CategoryList::whereIn('id', $processIDS)->update($update)) {
            CategoryList::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function edit($tenant_id, $id)
    {
        $cat = CategoryList::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.list.category.edit', ['cat' => $cat, 'tenant_id' => $tenant_id])->render()
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $category = CategoryList::find(___decrypt($id));
            $category['category_name'] = $request->name;
            $category['description'] = $request->description;
            $category['updated_by'] = Auth::user()->id;
            $category['updated_at'] = now();
            $category->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }
    
    public function lists_manage($tenant_id)
    {
        $data['category_count'] = CategoryList::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['classification_count'] = ClassificationList::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.master.list.manage', $data);
    }
}
