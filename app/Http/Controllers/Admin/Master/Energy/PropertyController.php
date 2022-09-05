<?php

namespace App\Http\Controllers\Admin\Master\Energy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\EnergyUtilities\EnergyPropertyMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $data['property'] = EnergyPropertyMaster::get();
        $product_props = [];
        foreach ($data['property'] as $property) {
            $product_props[] = [
                'id' => $property['id'],
                'name' => $property['property_name'],
            ];
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $product_props
            ]);
        }
        return view('pages.admin.master.energy.property.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $property =  new EnergyPropertyMaster();
            $property['property_name'] = $request->name;
            $property['description'] = $request->description;
            $property['created_by'] = Auth::user()->id;
            $property['updated_by'] = Auth::user()->id;
            $property->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/energy_utilities/property');
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
            $update = EnergyPropertyMaster::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (EnergyPropertyMaster::where('id', ___decrypt($id))->update($update)) {
                EnergyPropertyMaster::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/energy_utilities/property');
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
        if (EnergyPropertyMaster::whereIn('id', $processIDS)->update($update)) {
            EnergyPropertyMaster::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/energy_utilities/property');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $property = EnergyPropertyMaster::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.energy.property.edit', [
                'property' => $property
            ])->render()
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
            $property = EnergyPropertyMaster::find(___decrypt($id));
            $property['property_name'] = $request->name;
            $property['description'] = $request->description;
            $property['updated_by'] = Auth::user()->id;
            $property['updated_at'] = now();
            $property->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/energy_utilities/property');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
