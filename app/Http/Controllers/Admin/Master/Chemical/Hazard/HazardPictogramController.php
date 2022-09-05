<?php

namespace App\Http\Controllers\Admin\Master\Chemical\Hazard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\Hazard\HazardPictogram;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HazardPictogramController extends Controller
{
    public function index()
    {
        $data['hazard_classes'] = HazardPictogram::get();
        return view('pages.admin.master.chemical.hazard.hazard_pictogram.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hazard_pictogram' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $hazard_class =  new HazardPictogram();
            if (!empty($request->hazard_pictogram)) {
                //$image = upload_file($request, 'hazard_pictogram', 'hazard_pictogram');
                $folder_name = 'hazard_pictogram';
                $file       = $request->file('hazard_pictogram');
                $extension  = $file->getClientOriginalExtension();
                $file_name  = $file->getClientOriginalName();
                $file->move($folder_name, $file_name);
                $images =  $folder_name . '/' . $file_name;
                $hazard_class['hazard_pictogram'] = $images;
            }
            $hazard_class['code'] = $request->code;
            $hazard_class['title'] = $request->title;
            $hazard_class['description'] = $request->description;
            $hazard_class['created_by'] = Auth::user()->id;
            $hazard_class['updated_by'] = Auth::user()->id;
            $hazard_class->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/hazard_pictogram');
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
            $update = HazardPictogram::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (HazardPictogram::where('id', ___decrypt($id))->update($update)) {
                HazardPictogram::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/hazard_pictogram');
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
        if (HazardPictogram::whereIn('id', $processIDS)->update($update)) {
            HazardPictogram::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/hazard_pictogram');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $hazard_pictogram = HazardPictogram::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.chemical.hazard.hazard_pictogram.edit', ['hazard_pictogram' => $hazard_pictogram])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hazard_pictogram' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $hazard_class =  HazardPictogram::find(___decrypt($id));
            if (!empty($request->hazard_pictogram)) {
                $folder_name = 'hazard_pictogram';
                $file       = $request->file('hazard_pictogram');
                $extension  = $file->getClientOriginalExtension();
                $file_name  = $file->getClientOriginalName();
                $file->move($folder_name, $file_name);
                $images =  $folder_name . '/' . $file_name;
                $hazard_class['hazard_pictogram'] = $images;
            }
            $hazard_class['code'] = $request->code;
            $hazard_class['title'] = $request->title;
            $hazard_class['description'] = $request->description;
            $hazard_class['updated_by'] = Auth::user()->id;
            $hazard_class['updated_at'] = now();
            $hazard_class->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/hazard_pictogram');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
