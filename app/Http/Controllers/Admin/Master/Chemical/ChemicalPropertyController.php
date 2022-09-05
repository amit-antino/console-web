<?php

namespace App\Http\Controllers\Admin\Master\Chemical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\ChemicalPropertyMaster;
use App\Models\Master\Chemical\ChemicalSubPropertyMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ChemicalPropertyController extends Controller
{
    public function index(Request $request)
    {
        $data['property'] = ChemicalPropertyMaster::get();
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
        return view('pages.admin.master.chemical.property.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $property = new ChemicalPropertyMaster();
            $property['property_name'] = $request->name;
            $property['created_by'] = Auth::user()->id;
            $property['updated_by'] = Auth::user()->id;
            $property->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/property');
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
            $update = ChemicalPropertyMaster::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ChemicalPropertyMaster::where('id', ___decrypt($id))->update($update)) {
                ChemicalPropertyMaster::destroy(___decrypt($id));
                $update_sub['deleted_at'] = now();
                ChemicalSubPropertyMaster::where('property_id', ___decrypt($id))->update($update_sub);
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/property');
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
        if (ChemicalPropertyMaster::whereIn('id', $processIDS)->update($update)) {
            ChemicalPropertyMaster::destroy($processIDS);
            $update_sub['deleted_at'] = now();
           // foreach ($processID as $idval) {
                ChemicalSubPropertyMaster::whereIn('property_id', $processIDS)->update($update_sub);
           // }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/property');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $property = ChemicalPropertyMaster::where('id', ___decrypt($id))->first();
        return response()->json([
            'status'    => true,
            'html'      => view('pages.admin.master.chemical.property.edit', ['property' => $property])->render()
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
            $property =  ChemicalPropertyMaster::find(___decrypt($id));
            $property['property_name'] = $request->name;
            $property['updated_by'] = Auth::user()->id;
            $property['updated_at'] = now();
            $property->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/property');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
