<?php

namespace App\Http\Controllers\Console\Organization\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Vendor\Vendor;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Models\Organization\Vendor\VendorContactDetail;
use App\Models\Organization\Vendor\VendorLocation;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization\Vendor\VendorClassification;
use App\Models\Organization\Vendor\VendorCategory;

class VendorController extends Controller
{
    public function index()
    {
        $data['vendors'] = Vendor::where('tenant_id', session()->get('tenant_id'))
            ->with([
                'classification' => function ($q) {
                    $q->select('id', 'name');
                }, 'category' => function ($q) {
                    $q->select('id', 'name');
                }, 'location' => function ($q) {
                    $q->select('id', 'name');
                }
            ])
            ->get();
        return view('pages.console.tenant.vendor.index', $data);
    }

    public function create()
    {
        $data['categories'] = VendorCategory::where('status', 'active')->get();
        $data['classifications'] = VendorClassification::where('status', 'active')->get();
        return view('pages.console.tenant.vendor.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Please enter Vendor name',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor = new Vendor();
            $vendor->tenant_id = session()->get('tenant_id');
            $vendor->name = $request->name;
            $vendor->category_id = isset($request->category_id) ? ___decrypt($request->category_id) : 0;
            $vendor->classificaton_id = isset($request->classification_id) ? ___decrypt($request->classification_id) : 0;
            $vendor->start_date = $request->start_date;
            $vendor->address =  $request->address;
            $vendor->country_id = $request->country_id;
            $vendor->state = $request->state;
            $vendor->city = $request->city;
            $vendor->pincode =  $request->pincode;
            if (!empty($request->logo)) {
                $image = upload_file($request, 'logo', 'logo');
                $vendor->logo = $image;
            }
            $vendor->tags = $request->tags;
            $vendor->description = $request->description;
            $vendor->created_by = Auth::user()->id;
            $vendor->updated_by = Auth::user()->id;
            $vendor->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/vendor');
            $this->message = "Vendors Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $vendor = Vendor::find(___decrypt($id));
        return view('pages.console.tenant.vendor.views', compact('vendor'));
    }

    public function manage($id)
    {
        $vendor_id = $id;
        $vendor = Vendor::find(___decrypt($id));
        $vendor_contacts = VendorContactDetail::where('vendor_id', ___decrypt($id))->get();
        $vendor_locations = VendorLocation::where('vendor_id', ___decrypt($id))->get();
        return view('pages.console.tenant.vendor.manage', compact('vendor', 'vendor_id', 'vendor_contacts', 'vendor_locations'));
    }

    public function edit($id)
    {
        $vendor['vendor'] = Vendor::find(___decrypt($id));
        $vendor['VendorCategory'] = VendorCategory::where('status', 'active')->get();
        $vendor['VendorClassification'] = VendorClassification::where('status', 'active')->get();
        return view('pages.console.tenant.vendor.edit', $vendor);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Please enter Vendor name',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $vendor = Vendor::find(___decrypt($id));
            $vendor->tenant_id = session()->get('tenant_id');
            $vendor->name = $request->name;
            $vendor->category_id = isset($request->category_id) ? ___decrypt($request->category_id) : 0;
            $vendor->classificaton_id = isset($request->classification_id) ? ___decrypt($request->classification_id) : 0;
            $vendor->start_date = $request->start_date;
            $vendor->address =  $request->address;
            $vendor->country_id = $request->country_id;
            $vendor->state = $request->state;
            $vendor->city = $request->city;
            $vendor->pincode =  $request->pincode;
            if (!empty($request->logo)) {
                $image = upload_file($request, 'logo', 'logo');
                $vendor->logo = $image;
            }
            $vendor->tags = $request->tags;
            $vendor->description = $request->description;
            $vendor->updated_by = Auth::user()->id;
            $vendor->update_at = now();
            $vendor->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/vendor');
            $this->message = "Vendors Updated Successfully!";
        }
        return $this->populateresponse();
    }

    // public function importFile(Request $request)
    // {
    //     $validations = [
    //         'select_file' => ['required'],
    //     ];
    //     $validator = Validator::make($request->all(), $validations, []);
    //     if ($validator->fails()) {
    //         $this->message = $validator->errors();
    //     } else {
    //         $datetime = date('Ymd_his');
    //         $file = $request->file('select_file');
    //         $filename = $datetime . "_" . $file->getClientOriginalName();
    //         $savepath = public_path('/upload/');
    //         $file->move($savepath, $filename);
    //         $excel = Importer::make('Excel');
    //         $excel->load($savepath . $filename);
    //         $collection = $excel->getCollection();
    //         if ($collection->count() > 0) {
    //             foreach ($collection->toArray() as $key => $value) {
    //                 $insert_data = array(
    //                     'name'  => $value[0],
    //                     'vendors_type'   => $value[1],
    //                     'start_date'   => $value[2],
    //                     'country'   => $value[3],
    //                     'state'   => $value[4],
    //                     'vendor_classificatons' => $value[5]
    //                 );
    //                 Vendor::insertGetId($insert_data);
    //             }
    //         }
    //         $this->status = true;
    //         $this->alert = true;
    //         $this->modal = true;
    //         $this->redirect = url('organization/vendor');
    //         $this->message = "Vendor CSV uploaded Successfully!";
    //     }
    //     return $this->populateresponse();
    // }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = Vendor::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (Vendor::where('id', ___decrypt($id))->update($update)) {
                Vendor::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('/organization/vendor');
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
        if (Vendor::whereIn('id', $processIDS)->update($update)) {
            Vendor::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('/organization/vendor');
        return $this->populateresponse();
    }
}
