<?php

namespace App\Http\Controllers\Console\Organization\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Organization\Vendor\VendorLocation;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location_name' => 'required',
            'country_id' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor_location = new VendorLocation();
            $vendor_location->location_name = $request->location_name;
            $vendor_location->address = $request->address;
            $vendor_location->country_id = ___decrypt($request->country_id);
            $vendor_location->state = ___decrypt($request->state);
            $vendor_location->city = ___decrypt($request->city);
            $vendor_location->pincode = $request->pincode;
            $vendor_location->vendor_id = ___decrypt($request->vendor_id);
            $vendor_location->created_by = Auth::user()->id;
            $vendor_location->updated_by = Auth::user()->id;
            $vendor_location->save();
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
            'location_name' => 'required',
            'country_id' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor_location = VendorLocation::find($id);
            $vendor_location->location_name = $request->location_name;
            $vendor_location->address = $request->address;
            $vendor_location->country_id = ___decrypt($request->country_id);
            $vendor_location->state = ___decrypt($request->state);
            $vendor_location->city = ___decrypt($request->city);
            $vendor_location->pincode = $request->pincode;
            //$vendor_location->vendor_id = ___decrypt($request->vendor_id);
            $vendor_location->updated_by = Auth::user()->id;
            $vendor_location->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Vendor Contact Details Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function edit(Request $request, $id)
    {
        $location = VendorLocation::where('id', ___decrypt($id))->first();
        $country = Country::get();

        if ($request->type == 'contact') {
            $vendor_location = VendorLocation::get();
            return response()->json([
                'status' => true,
                'html' => view('pages.console.tenant.vendor.contact_add', ['locations' => $location, 'vendor_locations' => $vendor_location])->render()
            ]);
        } else {
            return response()->json([
                'status' => true,
                'html' => view('pages.console.tenant.vendor.edit-location', ['location' => $location, 'country' => $country, 'city' => '', 'state' => ''])->render()
            ]);
        }
    }
    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = VendorLocation::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {

            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (VendorLocation::where('id', ___decrypt($id))->update($update)) {
                VendorLocation::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
}
