<?php

namespace App\Http\Controllers\Console\DataManagement;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\DataManagement\CurationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CurationRuleController extends Controller
{

    public function index()
    {
        $tenant_id = Session::get('tenant_id');
        $data['data_rules'] = CurationRule::where(['tenant_id' => $tenant_id])->get();
        return view('pages.console.data_management.data_rules.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rule_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant_id = Session::get('tenant_id');
            $data_curation =  new CurationRule();
            $data_curation['tenant_id'] = $tenant_id;
            $data_curation['name'] = $request->rule_name;
            $data_curation['description'] = $request->description;
            $data_curation['tags'] = $request->tags;
            $data_curation['updated_by'] = Auth::user()->id;
            $data_curation['created_by'] = Auth::user()->id;
            $data_curation->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('data_management/data_rules');
            $this->message = "Data Rule Added Successfully.";
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
            $update = CurationRule::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (CurationRule::where('id', ___decrypt($id))->update($update)) {
                CurationRule::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = true;
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
        if (CurationRule::whereIn('id', $processIDS)->update($update)) {
            CurationRule::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
    public function show($id)
    {
        $data_rules = CurationRule::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.console.data_management.data_sets.edit', ['data_rules' => $data_rules])->render()
        ]);
    }
}
