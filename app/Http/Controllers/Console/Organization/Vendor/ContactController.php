<?php

namespace App\Http\Controllers\Console\Organization\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Organization\Vendor\VendorContactDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization\Vendor\VendorLocation;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'designation' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor_contact = new VendorContactDetail();
            $vendor_contact->name = $request->name;
            $vendor_contact->location_id = ___decrypt($request->location_id);
            $vendor_contact->designation = ___decrypt($request->designation);
            $vendor_contact->email = $request->email;
            $vendor_contact->phone_no = $request->phone_no;
            $vendor_contact->vendor_id = ___decrypt($request->vendor_id);
            $vendor_contact->created_by = Auth::user()->id;
            $vendor_contact->updated_by = Auth::user()->id;
            $vendor_contact->status = 'inactive';
            $vendor_contact->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Vendor Contact Details Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function update(Request $request, $id)
    {
        $id = ___decrypt($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'designation' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor_contact = VendorContactDetail::find($id);
            $vendor_contact->name = $request->name;
            $vendor_contact->location_id = ___decrypt($request->location_id);
            $vendor_contact->designation = ___decrypt($request->designation);
            $vendor_contact->email = $request->email;
            $vendor_contact->phone_no = $request->phone_no;
            // $vendor_contact->vendor_id = ___decrypt($request->vendor_id);
            $vendor_contact->updated_by = Auth::user()->id;
            $vendor_contact->status = 'inactive';
            $vendor_contact->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Vendor Contact Details Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $contact = VendorContactDetail::where('id', ___decrypt($id))->first();
        $vendor_locations = VendorLocation::get();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.tenant.vendor.edit-contact_form', ['contact' => $contact, 'vendor_locations' => $vendor_locations])->render()
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = VendorContactDetail::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (VendorContactDetail::where('id', ___decrypt($id))->update($update)) {
                VendorContactDetail::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
