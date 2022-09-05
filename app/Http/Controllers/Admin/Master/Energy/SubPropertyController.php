<?php

namespace App\Http\Controllers\Admin\Master\Energy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\EnergyUtilities\EnergySubPropertyMaster;
use App\Models\Master\EnergyUtilities\EnergyPropertyMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\MasterUnit;

class SubPropertyController extends Controller
{
    public function index(Request $request)
    {
        $data['sub_properties'] = EnergySubPropertyMaster::Select('*')
            ->with([
                'main_prop' => function ($q) {
                    $q->select('*');
                }
            ])
            ->orderBy('id', 'desc')->get();
        $data['property'] = EnergyPropertyMaster::get();
        $sub_props = [];
        foreach ($data['sub_properties'] as $sub_prop) {
            $sub_props[] = [
                'energy_property_id' => $sub_prop['property_id'],
                'property_name' => $sub_prop['main_prop']['property_name'],
                'sub_property_id' => $sub_prop['id'],
                'sub_property_name' => $sub_prop['sub_property_name']
            ];
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $sub_props
            ]);
        }
        return view('pages.admin.master.energy.sub_property.index', $data);
    }

    public function create()
    {
        $data['sub_property'] = EnergySubPropertyMaster::where(['status' => 'active'])->get();
        $id = [2, 6, 7];
        $data['unit_types'] = MasterUnit::select('id', 'unit_name')->whereIn('id', $id)->where(['status' => 'active'])->get();
        $data['properties'] = EnergyPropertyMaster::where(['status' => 'active'])->get();
        return view('pages.admin.master.energy.sub_property.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required',
            'base_unit_type' => 'required',
            'sub_property_name' => 'required',
            'dynamic_fields.*.field_name' => 'required',
            'dynamic_fields.*.field_type' => 'required'
        ], [
            'dynamic_fields.*.field_name.required' => 'The field name is required.',

            'dynamic_fields.*.field_type.required' => 'The field type is required.'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $sub_property =  new EnergySubPropertyMaster();
            $sub_property->property_id = ___decrypt($request->property_id);
            $sub_property->base_unit = ___decrypt($request->base_unit_type);
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
            $this->redirect = url('admin/master/energy_utilities/sub_property');
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
            $update = EnergySubPropertyMaster::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (EnergySubPropertyMaster::where('id', ___decrypt($id))->update($update)) {
                EnergySubPropertyMaster::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/energy_utilities/sub_property');
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        //dd($processID);
        foreach ($processID as $idval) {
            $processIDS[] = $idval;
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (EnergySubPropertyMaster::whereIn('id', $processIDS)->update($update)) {
            EnergySubPropertyMaster::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/energy_utilities/sub_property');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $idss = [2, 6, 7];
        $data['sub_props'] = [];
        $data['master_units'] = MasterUnit::get();
        $data['base_unit_types'] = MasterUnit::select('id', 'unit_name')->whereIn('id', $idss)->where(['status' => 'active'])->get();
        $data['sub_property'] = EnergySubPropertyMaster::where('id', ___decrypt($id))->first();
        $data['properties'] = EnergyPropertyMaster::where(['status' => 'active'])->get();
        return view('pages.admin.master.energy.sub_property.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'property' => 'required',
            'base_unit_type' => 'required',
            'sub_property_name' => 'required',
            'dynamic_fields.*.field_name' => 'required',
            'dynamic_fields.*.field_type' => 'required'
        ], [
            'dynamic_fields.*.field_name.required' => 'The field name is required.',

            'dynamic_fields.*.field_type.required' => 'The field type is required.'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $sub_property =  EnergySubPropertyMaster::find(___decrypt($id));
            $sub_property->property_id = ___decrypt($request->property);
            $sub_property->sub_property_name = $request->sub_property_name;
            $sub_property->base_unit = ___decrypt($request->base_unit_type);
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
            $this->redirect = url('admin/master/energy_utilities/sub_property');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function addMoreProp(Request $request)
    {
        return response()->json([
            'status' => true,
            'html' => view("pages.admin.master.energy.sub_property.prop", [
                'count' => $request->count
            ])->render()
        ]);
    }

    public function ConstantUnitList(Request $request)
    {
        $id = ___decrypt($request->parameters);
        $master_units = MasterUnit::where(['id' => $id, 'status' => 'active'])->first();
        if (!empty($master_units)) {
            return response()->json([
                'status' => true,
                'html' => view("pages.admin.master.energy.sub_property.unit_list", [
                    'count' => 0,
                    'units' => $master_units->unit_constant,
                    'select_type' => $request->parameters
                ])->render()
            ]);
        }
    }
}
