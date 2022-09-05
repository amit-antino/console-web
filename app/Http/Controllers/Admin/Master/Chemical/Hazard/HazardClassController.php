<?php

namespace App\Http\Controllers\Admin\Master\Chemical\Hazard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\Hazard\HazardClass;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HazardClassController extends Controller
{
    public function index()
    {
        $data['hazard_classes'] = HazardClass::get();
        return view('pages.admin.master.chemical.hazard.hazard_class.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hazard_class_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $hazard_class =  new HazardClass();
            $hazard_class['hazard_class_name'] = $request->hazard_class_name;
            $hazard_class['description'] = $request->description;
            $hazard_class['created_by'] = Auth::user()->id;
            $hazard_class['updated_by'] = Auth::user()->id;
            $hazard_class->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/hazard_class');
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
            $update = HazardClass::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (HazardClass::where('id', ___decrypt($id))->update($update)) {
                HazardClass::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/hazard_class');
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
        if (HazardClass::whereIn('id', $processIDS)->update($update)) {
            HazardClass::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/hazard_class');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $hazard_class = HazardClass::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.chemical.hazard.hazard_class.edit', ['hazard_class' => $hazard_class])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hazard_class_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $hazard_class =  HazardClass::find(___decrypt($id));
            $hazard_class['hazard_class_name'] = $request->hazard_class_name;
            $hazard_class['description'] = $request->description;
            $hazard_class['updated_by'] = Auth::user()->id;
            $hazard_class['updated_at'] = now();
            $hazard_class->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/hazard_class');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
