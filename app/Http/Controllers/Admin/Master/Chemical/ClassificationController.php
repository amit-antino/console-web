<?php

namespace App\Http\Controllers\Admin\Master\Chemical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\ChemicalClassification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ClassificationController extends Controller
{
    public function index(Request $request)
    {
        $data['classification'] = ChemicalClassification::all();
        $classifications = [];
        foreach ($data['classification'] as $classification) {
            if ($classification['status'] == 'active') {
                $classifications[] = [
                    'id' => $classification['id'],
                    'name' => $classification['name'],
                ];
            }
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $classifications
            ]);
        }
        return view('pages.admin.master.chemical.classification.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $type =  new ChemicalClassification();
            $type['name'] = $request->name;
            $type['description'] = $request->description;
            $type['created_by'] = Auth::user()->id;
            $type['updated_by'] = Auth::user()->id;
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/classification');
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
            $update = ChemicalClassification::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['updated_at'] = now();
            $update['updated_by'] = Auth::user()->id;
            if (ChemicalClassification::where('id', ___decrypt($id))->update($update)) {
                ChemicalClassification::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/classification');
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
        if (ChemicalClassification::whereIn('id', $processIDS)->update($update)) {
            ChemicalClassification::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/classification');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $class = ChemicalClassification::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.chemical.classification.edit', ['class' => $class])->render()
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
            $type =  ChemicalClassification::find(___decrypt($id));
            $type['name'] = $request->name;
            $type['description'] = $request->description;
            $type['updated_by'] = Auth::user()->id;
            $type['updated_at'] = now();
            $type->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/classification');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
