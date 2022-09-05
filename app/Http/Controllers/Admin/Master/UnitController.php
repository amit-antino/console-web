<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterUnit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Imports\UnitType;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $unit_types = MasterUnit::all();
        $master_units = [];
        foreach ($unit_types as $master_unit) {
            $master_units[] = [
                'id' => $master_unit['id'],
                'unit_name' => $master_unit['unit_name'],
                'default_unit' => $master_unit['default_unit'],
                'unit_constants' => $master_unit['unit_constant'],
                'description' => $master_unit['description'],
            ];
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $master_units
            ]);
        }
        return view('pages.admin.master.unit_type.index', compact('unit_types'));
    }

    public function get_unit_type(Request $request)
    {
        try {
            $unit_type = MasterUnit::find($request->unit_id);
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $unit_type
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_json_unit_type(Request $request)
    {
        try {
            $unit_type = MasterUnit::find($request->unit_id);
            foreach ($unit_type->unit_constant as $key => $row) {
                $data[$key]['id'] = $row['id'];
                $data[$key]['text'] = $row['unit_name'];
                //array("text"=>$row['unit_name'], "id"=>$row['id']);
            }
            return response()->json([
                'data' => $data
            ]);
          //  return response()->json(['data' => $raw]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function get_unit_constants(Request $request)
    {
        try {
            $unit_type = MasterUnit::find($request->unit_id);
            $unit_constant_info = [];
            foreach ($unit_type->unit_constant as $unit_constant) {
                if ($unit_constant['id'] == $request->unit_constant_id) {
                    $unit_constant_info = [
                        "id" => $unit_constant['id'],
                        "unit_name" => $unit_constant['unit_name'],
                        "unit_symbol" => $unit_constant['unit_symbol'],
                    ];
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $unit_constant_info
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'unit_name' => 'required',
                'unit_constant.*.unit_name' => 'required',
                'unit_constant.*.unit_symbol' => 'required',
            ],
            [
                'unit_constant.*.unit_name.required' => "The constant name field is required.",
                'unit_constant.*.unit_symbol.required' => "The constant symbol field is required."
            ]
        );
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $type =  new MasterUnit();
            $type['unit_name'] = $request->unit_name;
            //$type['default_unit'] = !empty($request->default_unit) ? ___decrypt($request->default_unit) : 0;
            if (!empty($request->unit_constant)) {
                foreach ($request->unit_constant as $key => $const) {
                    if (!empty($const['unit_name'])) {
                        $val[$key]['id'] = json_encode($key);
                        $val[$key]['unit_name'] = $const['unit_name'];
                        $val[$key]['unit_symbol'] = $const['unit_symbol'];
                    }
                }
                $type['unit_constant'] = $val;
            }
            $type['description'] = $request->description;
            $type['created_by'] = Auth::user()->id;
            $type['updated_by'] = Auth::user()->id;
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/unit_type');
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
            $update = MasterUnit::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (MasterUnit::where('id', ___decrypt($id))->update($update)) {
                MasterUnit::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/unit_type');
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
        if (MasterUnit::whereIn('id', $processIDS)->update($update)) {
            MasterUnit::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/unit_type');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $unit = MasterUnit::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.unit_type.edit', ['unit' => $unit])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'unit_name' => 'required',
            'unit_name' => 'required',
            'unit_constant.*.unit_name' => 'required',
            'unit_constant.*.unit_symbol' => 'required',
        ],
        [
            'unit_constant.*.unit_name.required' => "The constant name field is required.",
            'unit_constant.*.unit_symbol.required' => "The constant symbol field is required.",
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $type = MasterUnit::find(___decrypt($id));
            $type->unit_name = $request->unit_name;
            $type->default_unit = !empty($request->default_unit) ? ___decrypt($request->default_unit) : 0;
            $val=[];
            if (!empty($request->unit_constant)) {
                $i = 0;
                foreach ($request->unit_constant as $key => $const) {
                    if (!empty($const['unit_name'])) {
                        $val[$i]['id'] = json_encode($key);
                        $val[$i]['unit_name'] = $const['unit_name'];
                        $val[$i]['unit_symbol'] = $const['unit_symbol'];
                    }
                    $i++;
                }
                $type->unit_constant = $val;
            }
            $type->description = $request->description;
            $type->updated_by = Auth::user()->id;
            $type->updated_at = now();
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/unit_type');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function addMoreConstant(Request $request)
    {
        return response()->json([
            'status' => true,
            'html' => view("pages.admin.master.unit_type.more_unit", ['count' => $request->count])->render()
        ]);
    }

    public function importFile(Request $request)
    {
        $validations = [
            //'import_file' => ['required'],
            'import_file' =>['required_without_all:import_json'],
            'import_json' =>['required_without_all:import_file'],
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            if (!empty($request->import_file)) {
                \Excel::import(new UnitType(0), request()->file('import_file'));
                $this->message = "CSV uploaded Successfully!";
            }
            if(!empty($request->import_json)){
                $jsonString = file_get_contents(request()->file('import_json'));
                $data = json_decode($jsonString, true);
                
                for($i=0;$i<count($data);$i++){ 
                    $uc_data = explode(";",$data[$i]['Unit Constant']);
                    foreach ($uc_data as $subkey => $const) {
                        $const_det = explode(":",$const);
                        $default_unit = 0;
                        if (!empty($const)) {
                            $unit_constant[$subkey]['id'] = json_encode($subkey);
                            $unit_constant[$subkey]['unit_name'] = $const_det[0];
                            $unit_constant[$subkey]['unit_symbol'] = $const_det[1];
                            if($const_det[0]==$data[$i]['Default Unit']){
                                $default_unit = $subkey;
                            }
                        }
                    }
                    $unittype =  new MasterUnit();
                    $unittype['unit_name'] = $data[$i]['Unit Type'];
                    $unittype['unit_constant'] = $unit_constant;
                    $unittype['default_unit'] = $default_unit;
                    $unittype['status'] = $data[$i]['status'];
                    $unittype['created_by'] = Auth::user()->id;
                    $unittype['updated_by'] = Auth::user()->id;
                    $unittype->save();
                }
                $this->message = "JSON uploaded Successfully!";
            }
            $this->status = true;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = url('admin/master/unit_type');
        }
        
        return $this->populateresponse();
    }

}
