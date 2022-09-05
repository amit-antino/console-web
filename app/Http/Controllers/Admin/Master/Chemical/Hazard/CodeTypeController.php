<?php

namespace App\Http\Controllers\Admin\Master\Chemical\Hazard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\Hazard\HazardCodeType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CodeTypeController extends Controller
{
    public function index()
    {
        $data['category'] = HazardCodeType::get();

        $cnt=$data;
        return view('pages.admin.master.chemical.hazard.code_type.index', $data ,$cnt);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $type = new HazardCodeType();
            $type['name'] = $request->name;
            $type['description'] = $request->description;
            $type['created_by'] = Auth::user()->id;
            $type['updated_by'] = Auth::user()->id;
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/code_type');
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
            $update = HazardCodeType::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (HazardCodeType::where('id', ___decrypt($id))->update($update)) {
                HazardCodeType::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/code_type');
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
        if (HazardCodeType::whereIn('id', $processIDS)->update($update)) {
            HazardCodeType::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/code_type');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $cat = HazardCodeType::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.chemical.hazard.code_type.edit', ['cat' => $cat])->render()
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
            $type = HazardCodeType::find(___decrypt($id));
            $type['name'] = $request->name;
            $type['description'] = $request->description;
            $type['updated_by'] = Auth::user()->id;
            $type['updated_at'] = now();
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/code_type');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
