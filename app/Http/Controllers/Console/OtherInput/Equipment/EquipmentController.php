<?php

namespace App\Http\Controllers\Console\OtherInput\Equipment;

use App\Http\Controllers\Controller;
use App\Models\OtherInput\Equipments;
use App\Models\OtherInput\EquipmentProperties;
use App\Models\Organization\Vendor\Vendor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Excel;
use Barryvdh\DomPDF\PDF;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipments::where('tenant_id', session()->get('tenant_id'))
            ->with([
                'vendor' => function ($q) {
                    $q->select('id', 'name');
                }
            ])
            ->orderBy('id', 'desc')->get();
        return view('pages.console.other_input.equipment.index', compact('equipments'));
    }

    public function create()
    {
        $vendors = Vendor::select('id', 'name')->where(['status' => 'active'])->where('tenant_id', session()->get('tenant_id'))->get();
        return view('pages.console.other_input.equipment.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validations = [
            'equipment_name' => ['required'],
            'installation_date' => ['required'],
            'purchased_date' => ['required'],
            //'vendor_id' => ['required'],
            'availability' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $equipment = new Equipments();
            $equipment->tenant_id = session()->get('tenant_id');
            $equipment->equipment_name = $request->equipment_name;
            $equipment->installation_date = $request->installation_date;
            $equipment->purchased_date = $request->purchased_date;
            $equipment->availability = !empty($request->availability) ? $request->availability : 'false';

            $equipment->vendor_id = !empty($request->vendor_id) ? ___decrypt($request->vendor_id) : 0;
            $equipment->country_id = $request->country_id;
            $equipment->state = $request->state;
            $equipment->city = $request->city;
            if (!empty($request->equipment_image)) {
                $image = upload_file($request, 'equipment_image', 'equipment_image');
                $equipment->equipment_image = $image;
            }
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $equipment->tags = $tags;
            $equipment->description = $request->description;
            $equipment->created_by = Auth::user()->id;
            $equipment->updated_by = Auth::user()->id;
            $equipment->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('other_inputs/equipment');
            $this->message = "Equipment Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $data['equipment'] = Equipments::Select('*')
            ->with([
                'vendor' => function ($q) {
                    $q->select('id', 'name');
                }
            ])
            ->where('id', ___decrypt($id))->first();
        return view('pages.console.other_input.equipment.view', $data);
    }

    public function edit($id)
    {
        $equipment = Equipments::find(___decrypt($id));
        $vendors = Vendor::select('id', 'name')->where(['status' => 'active'])->where('tenant_id', session()->get('tenant_id'))->get();
        return view('pages.console.other_input.equipment.edit', compact('equipment', 'vendors'));
    }

    public function update(Request $request, $id)
    {
        $validations = [
            'equipment_name' => ['required'],
            'installation_date' => ['required'],
            'purchased_date' => ['required'],
            //'vendor_id' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $equipment = Equipments::find(___decrypt($id));
            $equipment->tenant_id = session()->get('tenant_id');
            $equipment->equipment_name = $request->equipment_name;
            $equipment->installation_date = $request->installation_date;
            $equipment->purchased_date = $request->purchased_date;
            $equipment->vendor_id = !empty($request->vendor_id) ? ___decrypt($request->vendor_id) : 0;
            $equipment->country_id = $request->country_id;
            $equipment->state = $request->state;
            $equipment->city = $request->city;
            if (!empty($request->equipment_image)) {
                $image = upload_file($request, 'equipment_image', 'equipment_image');
                $equipment->equipment_image = $image;
            }
            $equipment->availability = $request->availability;
            $equipment->description = $request->description;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $equipment->tags = $tags;
            $equipment->updated_by = Auth::user()->id;
            $equipment->updated_at = now();
            $equipment->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/other_inputs/equipment');
            $this->message = "Equipment Updated Successfully!";
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
            $update = Equipments::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (Equipments::where('id', ___decrypt($id))->update($update)) {
                Equipments::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('other_inputs/equipment');
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
    //         $file =   $request->file('select_file');
    //         $filename = $datetime . "_" . $file->getClientOriginalName();
    //         $savepath = public_path('/upload/');
    //         $file->move($savepath, $filename);
    //         $excel = Importer::make('Excel');
    //         $excel->load($savepath . $filename);
    //         $collection = $excel->getCollection();
    //         if ($collection->count() > 0) {
    //             foreach ($collection->toArray() as $key => $value) {
    //                 $insert_data = array(
    //                     'equipment_name'  => $value[0],
    //                     'installation_date'   => $value[1],
    //                     'purchased_date'   => $value[2],
    //                     'vendor_list'   => $value[3],
    //                     'equipment_image'   => $value[4],
    //                     'availability'   => $value[5],
    //                     'tags'   => $value[6],
    //                     'country_id'   => $value[7],
    //                     'state'   => $value[8],
    //                     'city'   => $value[9],
    //                     'pincode'   => $value[10],
    //                     'status'   => $value[11],
    //                     'description'   => $value[12],
    //                 );
    //                 Equipments::insertGetId($insert_data);
    //             }
    //         }
    //         $this->status = true;
    //         $this->alert   = true;
    //         $this->modal = true;
    //         $this->redirect = url('other_inputs/equipment');
    //         $this->message = "Equipment CSV uploaded Successfully!";
    //     }
    //     return $this->populateresponse();
    // }

    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $processID = explode(',', ($id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (Equipments::whereIn('id', $processIDS)->update($update)) {
            Equipments::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('other_inputs/equipment');
        return $this->populateresponse();
    }
}
