<?php

namespace App\Http\Controllers\Admin\Master\Chemical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\ChemicalSubPropertyMaster;
use App\Models\Master\Chemical\ChemicalPropertyMaster;
use App\Models\Master\MasterUnit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ChemicalSubPropertyController extends Controller
{
    public function index(Request $request)
    {
        $sub_properties = ChemicalSubPropertyMaster::Select('*')
            ->with([
                'main_prop' => function ($q) {
                    $q->select('*');
                }
            ])
            ->get();
        $sub_props = [];
        foreach ($sub_properties as $sub_prop) {
            $sub_props[] = [
                'property_id' => $sub_prop['property_id'],
                'property_name' => $sub_prop['main_prop']['property_name'],
                'sub_property_id' => $sub_prop['id'],
                'sub_property_name' => $sub_prop['sub_property_name']
            ];
        }
        $properties = ChemicalPropertyMaster::all();
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $sub_properties
            ]);
        }
        return view('pages.admin.master.chemical.sub_property.index', compact('properties', 'sub_properties'));
    }

    public function create()
    {
        $sub_properties = ChemicalSubPropertyMaster::all();
        $properties = ChemicalPropertyMaster::where('status', 'active')->get();
        return view('pages.admin.master.chemical.sub_property.create', compact('properties', 'sub_properties'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required',
            'sub_property_name' => 'required',
            'dynamic_fields.*.field_name' => 'required',
            'dynamic_fields.*.field_type' => 'required',

        ],[
            'dynamic_fields.*.field_name.required'=>'The field name is required.',

            'dynamic_fields.*.field_type.required'=>'The field type is required.'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $sub_property = new ChemicalSubPropertyMaster();
            $sub_property->property_id = ___decrypt($request->property_id);
            $sub_property->sub_property_name = $request->sub_property_name;
            if (!empty($request->fields)) {
                $val = array();
                foreach ($request->fields as $key => $const) {
                    if (!empty($const['field_name'])) {
                        $val[$key]['id'] = json_encode($key + 1);
                        $val[$key]['field_name'] = $const['field_name'];
                        $val[$key]['field_type_id'] = $const['field_type'];
                        $val[$key]['unit_id'] = !empty($const['unit_name']) ? ___decrypt($const['unit_name']) : '';
                    }
                }
                $sub_property->fields = $val;
            }
            if (!empty($request->dynamic_fields)) {
                $dynamic_val = array();
                foreach ($request->dynamic_fields as $keys => $dynamic_const) {
                    if (!empty($dynamic_const['field_name'])) {
                        $dynamic_val[$keys]['id'] = json_encode($keys + 1);
                        $dynamic_val[$keys]['field_name'] = $dynamic_const['field_name'];
                        $dynamic_val[$keys]['field_type_id'] = $dynamic_const['field_type'];
                        $dynamic_val[$keys]['unit_id'] = !empty($dynamic_const['unit_name']) ? ___decrypt($dynamic_const['unit_name']) : '';
                    }
                }
                $sub_property->dynamic_fields = $dynamic_val;
            }
            $sub_property['created_by'] = Auth::user()->id;
            $sub_property['updated_by'] = Auth::user()->id;
            $sub_property->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/sub_property');
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
            $update = ChemicalSubPropertyMaster::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ChemicalSubPropertyMaster::where('id', ___decrypt($id))->update($update)) {
                ChemicalSubPropertyMaster::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/sub_property');
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
        if (ChemicalSubPropertyMaster::whereIn('id', $processIDS)->update($update)) {
            ChemicalSubPropertyMaster::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/sub_property');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $sub_props = ChemicalSubPropertyMaster::get();
        $master_units = MasterUnit::get();
        $sub_property = ChemicalSubPropertyMaster::where('id', ___decrypt($id))->first();
        $properties = ChemicalPropertyMaster::all();
        return view('pages.admin.master.chemical.sub_property.edit', compact('properties', 'sub_property', 'sub_props', 'master_units'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'property' => 'required',
            'sub_property_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $sub_property = ChemicalSubPropertyMaster::find(___decrypt($id));
            $sub_property->property_id = ___decrypt($request->property);
            $sub_property->sub_property_name = $request->sub_property_name;
            if (!empty($request->fields)) {
                $val = array();
                foreach ($request->fields as $key => $const) {
                    if (!empty($const['field_name'])) {
                        $val[$key]['id'] = json_encode($key + 1);
                        $val[$key]['field_name'] = $const['field_name'];
                        $val[$key]['field_type_id'] = $const['field_type'];
                        $val[$key]['unit_id'] = !empty($const['unit_name']) ? ___decrypt($const['unit_name']) : '';
                    }
                }
                $sub_property->fields = $val;
            }
            if (!empty($request->dynamic_fields)) {
                $dynamic_val = array();
                foreach ($request->dynamic_fields as $keys => $dynamic_const) {
                    if (!empty($dynamic_const['field_name'])) {
                        $dynamic_val[$keys]['id'] = json_encode($keys + 1);
                        $dynamic_val[$keys]['field_name'] = $dynamic_const['field_name'];
                        $dynamic_val[$keys]['field_type_id'] = $dynamic_const['field_type'];
                        $dynamic_val[$keys]['unit_id'] = !empty($dynamic_const['unit_name']) ? ___decrypt($dynamic_const['unit_name']) : '';
                    }
                }
                $sub_property->dynamic_fields = $dynamic_val;
            }
            $sub_property['updated_by'] = Auth::user()->id;
            $sub_property['updated_at'] = now();
            $sub_property->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/sub_property');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function addMoreProp(Request $request)
    {
        return response()->json([
            'status' => true,
            'html' => view("pages.admin.master.chemical.sub_property.prop", [
                'count' => $request->count
            ])->render()
        ]);
    }

    public function selectList(Request $request)
    {
        $master_units = MasterUnit::where('status', 'active')->get();
        $sub_props = ChemicalSubPropertyMaster::where('status', 'active')->get();
        if (empty($request->count)) {
            $count = 0;
        } else {
            $count = $request->count;
        }
        return response()->json([
            'status' => true,
            'html' => view("pages.admin.master.chemical.sub_property.units", [
                'count' => $count,
                'sub_props' => $sub_props,
                'master_units' => $master_units,
                'select_type' => $request->parameters
            ])->render()
        ]);
    }
}
