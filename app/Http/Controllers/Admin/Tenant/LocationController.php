<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Models\Tenant\Tenant;
use App\Models\Tenant\TenantConfig;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function index(Request $request, $id)
    {
        $config = TenantConfig::where('tenant_id', ___decrypt($id))->first();
        $data['location'] = $config->location;
        $data['tenant_info'] = Tenant::select('id', 'name')->where('id', ___decrypt($id))->first();
        return view('pages.admin.tenant.location.index', compact('data'));
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'location_name' => 'required',
            'country_id' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required|digits_between:6,10',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($listData->location)) {
                foreach ($listData->location as $desig) {
                    $id = $desig['id'];
                }
                $location[] = [
                    'id' => $id + 1,
                    'location_name' => $request->location_name,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country_id,
                    'pincode' => $request->pincode,
                    'address' => $request->address,
                    'status' => 'active',
                ];
                $listData->location = array_merge($listData->location, $location);
            } else {
                $location[] = [
                    'id' => 1,
                    'location_name' => $request->location_name,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country_id,
                    'pincode' => $request->pincode,
                    'address' => $request->address,
                    'status' => 'active',
                ];
                $listData->location = $location;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
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
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            $location = [];
            if (!empty($tenant->location)) {
                foreach ($tenant->location as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $location[$key]['id'] = $desig['id'];
                        $location[$key]['location_name'] = $desig['location_name'];
                        $location[$key]['address'] = $desig['address'];
                        $location[$key]['city'] = $desig['city'];
                        $location[$key]['state'] = $desig['state'];
                        $location[$key]['country_id'] = $desig['country_id'];
                        $location[$key]['status'] = $desig['status'];
                        $location[$key]['pincode'] = $desig['pincode'];
                    } else {
                        $location[$key]['id'] = $desig['id'];
                        $location[$key]['location_name'] = $desig['location_name'];
                        $location[$key]['address'] = $desig['address'];
                        $location[$key]['city'] = $desig['city'];
                        $location[$key]['state'] = $desig['state'];
                        $location[$key]['country_id'] = $desig['country_id'];
                        $location[$key]['pincode'] = $desig['pincode'];
                        $location[$key]['status'] = $status;
                    }
                }
                $listData->location = $location;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->location)) {
                foreach ($tenant->location as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $location[$key]['id'] = $desig['id'];
                        $location[$key]['location_name'] = $desig['location_name'];
                        $location[$key]['address'] = $desig['address'];
                        $location[$key]['city'] = $desig['city'];
                        $location[$key]['state'] = $desig['state'];
                        $location[$key]['country_id'] = $desig['country_id'];
                        $location[$key]['status'] = $desig['status'];
                        $location[$key]['pincode'] = $desig['pincode'];
                    }
                }
                $listData->location = $location;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/manage/' . $tenant_id);
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request, $tenant_id = null, $id = null)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $listData =  TenantConfig::find($tenant->id);
        $location = [];
        if (!empty($listData->location)) {
            foreach ($listData->location as $key => $loc) {
                if (!in_array(___encrypt($loc['id']), $processID)) {
                    $location[$key]['id'] = $loc['id'];
                    $location[$key]['location_name'] = $loc['location_name'];
                    $location[$key]['address'] = $loc['address'];
                    $location[$key]['city'] = $loc['city'];
                    $location[$key]['state'] = $loc['state'];
                    $location[$key]['country_id'] = $loc['country_id'];
                    $location[$key]['status'] = $loc['status'];
                    $location[$key]['pincode'] = $loc['pincode'];
                }
            }
            $listData->location = $location;
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function edit($tenant_id, $id)
    {
        $country = Country::get();
        $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $location = [];
        if (!empty($tenant->location)) {
            foreach ($tenant->location as $key => $desig) {
                if ($desig['id'] == ___decrypt($id)) {
                    $location['id'] = $desig['id'];
                    $location['location_name'] = $desig['location_name'];
                    $location['state'] = $desig['state'];
                    $location['city'] = $desig['city'];
                    $location['country_id'] = $desig['country_id'];
                    $location['address'] = !empty($desig['address']) ? $desig['address'] : '';
                    $location['status'] = $desig['status'];
                    $location['pincode'] = !empty($desig['pincode']) ? $desig['pincode'] : '';
                    $location['tenant_id'] = $tenant_id;
                }
            }
        }
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.tenant.location.edit', [
                'location' => $location,
                'country' => $country
            ])->render()
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'location_name' => 'required',
            'country_id' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required|digits_between:6,10',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
            $listData =  TenantConfig::find($tenant->id);
            if (!empty($tenant->location)) {
                foreach ($tenant->location as $key => $desig) {
                    if ($desig['id'] != ___decrypt($id)) {
                        $location[$key]['id'] = $desig['id'];
                        $location[$key]['location_name'] = $desig['location_name'];
                        $location[$key]['address'] = $desig['address'];
                        $location[$key]['city'] = $desig['city'];
                        $location[$key]['state'] = $desig['state'];
                        $location[$key]['country_id'] = $desig['country_id'];
                        $location[$key]['status'] = $desig['status'];
                        $location[$key]['pincode'] = $desig['pincode'];
                    } else {
                        $location[$key]['id'] = ___decrypt($id);
                        $location[$key]['location_name'] = $request->location_name;
                        $location[$key]['address'] = $request->address;
                        $location[$key]['city'] = $request->city;
                        $location[$key]['state'] = $request->state;
                        $location[$key]['country_id'] = $request->country_id;
                        $location[$key]['status'] = $request->status;
                        $location[$key]['pincode'] = $request->pincode;
                    }
                }

                $listData->location = $location;
            }
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
