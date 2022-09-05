<?php

namespace App\Http\Controllers\Admin\Master\Chemical\Hazard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\Hazard\HazardSubCodeType;
use App\Models\Master\Chemical\Hazard\HazardCodeType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SubCodeTypeController extends Controller
{
    public function index()
    {
        $data['category'] = HazardSubCodeType::get();
        $data['code_types'] = HazardCodeType::get();
        return view('pages.admin.master.chemical.hazard.code_sub_type.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            
            $type =  new HazardSubCodeType();
            $type['name'] = $request->name;
            $type['code_type_id'] = !empty($request->code_type_id)?___decrypt($request->code_type_id):0;
            $type['description'] = $request->description;
            $type['created_by'] = Auth::user()->id;
            $type['updated_by'] = Auth::user()->id;
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/code_sub_type');
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
            $update = HazardSubCodeType::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (HazardSubCodeType::where('id', ___decrypt($id))->update($update)) {
                HazardSubCodeType::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/code_sub_type');
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
        if (HazardSubCodeType::whereIn('id', $processIDS)->update($update)) {
            HazardSubCodeType::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/code_sub_type');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $cat = HazardSubCodeType::where('id', ___decrypt($id))->first();
        $code_types = HazardCodeType::get();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.chemical.hazard.code_sub_type.edit', ['cat' => $cat, 'code_types' => $code_types])->render()
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
            $type =  HazardSubCodeType::find(___decrypt($id));
            $type['name'] = $request->name;
            $type['code_type_id'] = !empty($request->code_type_id)?___decrypt($request->code_type_id):0;
            $type['description'] = $request->description;
            $type['updated_by'] = Auth::user()->id;
            $type['updated_at'] = now();
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/code_sub_type');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function subCodeTypeList(Request $request)
    {
        $code_sub_types = HazardSubCodeType::where('code_type_id', ___decrypt($request->parameters))->get();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.chemical.hazard.code_statement.sub_code_type', ['code_sub_types' => $code_sub_types])->render()
        ]);
    }
}
