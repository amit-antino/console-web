<?php

namespace App\Http\Controllers\Console\Organization\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Organization\Vendor\VendorClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ClassificationController extends Controller
{
    public function index()
    {
        $vendor_classifications = VendorClassification::all();
        return view('pages.console.tenant.vendor.classification.index', compact('vendor_classifications'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classification_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor_classification = new VendorClassification();
            $vendor_classification->classification_name = $request->classification_name;
            $vendor_classification->description = $request->description;
            $vendor_classification['created_by'] = Auth::user()->id;
            $vendor_classification['updated_by'] = Auth::user()->id;
            $vendor_classification->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/vendor/classification');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $vendor_classification = VendorClassification::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.tenant.vendor.classification.edit', ['vendor_classification' => $vendor_classification])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'classification_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor_classification = VendorClassification::find(___decrypt($id));
            $vendor_classification->classification_name = $request->classification_name;
            $vendor_classification->description = $request->description;
            $vendor_classification['updated_by'] = Auth::user()->id;
            $vendor_classification['updated_at'] = now();
            $vendor_classification->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/vendor/classification');
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
            $update = VendorClassification::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (VendorClassification::where('id', ___decrypt($id))->update($update)) {
                VendorClassification::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('organization/vendor/classification');
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
        if (VendorClassification::whereIn('id', $processIDS)->update($update)) {
            VendorClassification::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('organization/vendor/classification');
        return $this->populateresponse();
    }
}
