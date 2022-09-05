<?php

namespace App\Http\Controllers\Console\OtherInput\Energy;

use App\Http\Controllers\Controller;
use App\Models\OtherInput\EnergyUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\MasterUnit;
use App\Models\Organization\Vendor\Vendor;

class EnergyController extends Controller
{
    public function index()
    {
        $data['energy_utilities'] = EnergyUtility::where('tenant_id', session()->get('tenant_id'))->orderBy('id','desc')->get();
        return view('pages.console.other_input.energy.index', $data);
    }

    public function get_energy_utility(Request $request)
    {
        try {
            $energy = EnergyUtility::select('id', 'energy_name', 'base_unit_type', 'vendor_id', 'description')->where('id', $request->energy_id)->where('status', 'active')->get()->first();
            $energy_info = [
                'id' => $energy->id,
                'name' => $energy->energy_name,
                'base_unit' => [
                    'id' => $energy->base_unit_type,
                    'unit_name' => $energy->unit_type->unit_name
                ],
                'vendor' => [
                    'id' => $energy->vendor_id,
                    'vendor_name' => $energy->vendor->name
                ],
                'description' => $energy->description,
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $energy_info
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        $id = [2, 6, 7, 326];
        $data['unit_types'] = MasterUnit::select('id', 'unit_name')->whereIn('id', $id)->where(['status' => 'active'])->get();
        $data['vendors'] = Vendor::select('id', 'name')->where(['status' => 'active'])->where('tenant_id', session()->get('tenant_id'))->get();
        return view('pages.console.other_input.energy.create', $data);
    }

    public function store(Request $request)
    {
        $validations = [
            'energy_name' => 'required',
            'base_unit_type' => 'required',
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $energy_utility = new EnergyUtility();
            $energy_utility->tenant_id = session()->get('tenant_id');
            $energy_utility->energy_name = $request->energy_name;
            $energy_utility->base_unit_type = ___decrypt($request->base_unit_type);
            $energy_utility->vendor_id = !empty($request->vendor_id) ? ___decrypt($request->vendor_id) : 0;
            $energy_utility->country_id = $request->country_id;
            $energy_utility->state = $request->state;
            $energy_utility->city = $request->city;
            $energy_utility->description = isset($request->description) ? $request->description : '';
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $energy_utility->tags = $tags;
            $energy_utility->created_by = Auth::user()->id;
            $energy_utility->updated_by = Auth::user()->id;
            $energy_utility->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('other_inputs/energy');
            $this->message = "Energy and Utility Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $energy_utility = EnergyUtility::find(___decrypt($id));
        $data['energy_name'] = $energy_utility->energy_name;
        $data['energy_id'] = $energy_utility->id;
        $data['status'] = $energy_utility->status;
        $data['vendor'] = !empty($energy_utility->vendor->name) ? $energy_utility->vendor->name : '';
        $data['base_unit'] = !empty($energy_utility->unit_type->unit_name) ? $energy_utility->unit_type->unit_name : '';
        $data['country'] = !empty($energy_utility->country->name) ? $energy_utility->country->name : '';
        $data['state'] = !empty($energy_utility->state->name) ? $energy_utility->state->name : '';
        $data['city'] = !empty($energy_utility->city->name) ? $energy_utility->city->name : '';
        $data['tags'] = !empty($energy_utility->tags) ? $energy_utility->tags : '';
        $data['description'] = !empty($energy_utility->description) ? $energy_utility->description : '';
        return view('pages.console.other_input.energy.view', compact('data'));
    }

    public function edit($id)
    {
        $data['energy_utility'] = EnergyUtility::find(___decrypt($id));
        $ids = [2, 6, 7, 326];
        $data['unit_types'] = MasterUnit::select('id', 'unit_name')->whereIn('id', $ids)->where(['status' => 'active'])->get();
        $data['vendors'] = Vendor::select('id', 'name')->where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        return View::make('pages.console.other_input.energy.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validations = [
            'energy_name' => ['required'],
            'base_unit_type' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $energy_utility = EnergyUtility::find(___decrypt($id));
            $energy_utility->tenant_id = session()->get('tenant_id');
            $energy_utility->energy_name = $request->energy_name;
            $energy_utility->base_unit_type = ___decrypt($request->base_unit_type);
            $energy_utility->vendor_id = !empty($request->vendor_id) ? ___decrypt($request->vendor_id) : 0;
            $energy_utility->country_id = $request->country_id;
            $energy_utility->state = $request->state;
            $energy_utility->city = $request->city;
            $energy_utility->description = $request->description;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $energy_utility->tags = $tags;
            $energy_utility->updated_by = Auth::user()->id;
            $energy_utility->updated_at = now();
            $energy_utility->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/other_inputs/energy');
            $this->message = "Energy and Utility Updated Successfully!";
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
            $update = EnergyUtility::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (EnergyUtility::where('id', ___decrypt($id))->update($update)) {
                EnergyUtility::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('other_inputs/energy');
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $processID = explode(',', ($id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (EnergyUtility::whereIn('id', $processIDS)->update($update)) {
            EnergyUtility::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('other_inputs/energy');
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
    //                     'energy_name'  => $value[0],
    //                     'base_unit_type'   => $value[1],
    //                     'vendor_id'   => $value[2],
    //                     'tags'   => $value[3],
    //                     'country_id'   => $value[4],
    //                     'state'   => $value[5],
    //                     'city'   => $value[6],
    //                     'pincode'   => $value[7],
    //                 );
    //                 EnergyUtility::insertGetId($insert_data);
    //             }
    //         }
    //         $this->status = true;
    //         $this->alert = true;
    //         $this->modal = true;
    //         $this->redirect = url('other_inputs/energy');
    //         $this->message = "Energy CSV uploaded Successfully!";
    //     }
    //     return $this->populateresponse();
    // }

    public function addMore(Request $request)
    {
        return response()->json([
            'status' => true,
            'html' => view("pages.console.other_input.energy." . $request->type, ['count' => $request->count])->render()
        ]);
    }

    public function addMoreDynamicFields(Request $request)
    {
        return response()->json([
            'status' => true,
            'html' => view("pages.console.other_input.energy.manage_properties.add-more-dynamic-form", ['count' => $request->count, 'unit_name' => $request->type, 'new_count' => $request->new_count])->render()
        ]);
    }
}
