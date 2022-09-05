<?php

namespace App\Http\Controllers\Console\Organization\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Organization\Vendor\VendorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $vendor_categories = VendorCategory::all();
        return view('pages.console.tenant.vendor.category.index', compact('vendor_categories'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor_category = new VendorCategory();
            $vendor_category->category_name = $request->category_name;
            $vendor_category->description = $request->description;
            $vendor_category['created_by'] = Auth::user()->id;
            $vendor_category['updated_by'] = Auth::user()->id;
            $vendor_category->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/vendor/category');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $vendor_category = VendorCategory::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.tenant.vendor.category.edit', ['vendor_category' => $vendor_category])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor_category = VendorCategory::find(___decrypt($id));
            $vendor_category->category_name = $request->category_name;
            $vendor_category->description = $request->description;
            $vendor_category['updated_by'] = Auth::user()->id;
            $vendor_category['updated_at'] = now();
            $vendor_category->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/vendor/category');
            $this->message = "Updated Successfully!";
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
            $update = VendorCategory::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (VendorCategory::where('id', ___decrypt($id))->update($update)) {
                VendorCategory::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('organization/vendor/category');
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
        if (VendorCategory::whereIn('id', $processIDS)->update($update)) {
            VendorCategory::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('organization/vendor/category');
        return $this->populateresponse();
    }
}
