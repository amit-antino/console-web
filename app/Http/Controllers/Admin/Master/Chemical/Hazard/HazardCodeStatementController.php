<?php

namespace App\Http\Controllers\Admin\Master\Chemical\Hazard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\Hazard\CodeStatement;
use App\Models\Master\Chemical\Hazard\HazardCodeType;
use App\Models\Master\Chemical\Hazard\HazardSubCodeType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HazardCodeStatementController extends Controller
{
    public function index()
    {
        $data['code_statements'] = CodeStatement::get();
        $data['code_types'] = HazardCodeType::get();
        return view('pages.admin.master.chemical.hazard.code_statement.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_statement_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $code_statement =  new CodeStatement();
            $code_statement['title'] = $request->code_statement_name;
            $code_statement['code'] = $request->code;
            $code_statement['description'] = $request->description;
            $code_statement['type'] = !empty($request->type) ? ___decrypt($request->type) : 0;
            $code_statement['sub_code_type_id'] = !empty($request->sub_code_type) ? ___decrypt($request->sub_code_type) : 0;
            $code_statement['created_by'] = Auth::user()->id;
            $code_statement['updated_by'] = Auth::user()->id;
            $code_statement->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/code_statement');
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
            $update = CodeStatement::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (CodeStatement::where('id', ___decrypt($id))->update($update)) {
                CodeStatement::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/code_statement');
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
        if (CodeStatement::whereIn('id', $processIDS)->update($update)) {
            CodeStatement::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/code_statement');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $code_statement = CodeStatement::where('id', ___decrypt($id))->first();
        $code_types = HazardCodeType::get();
        $code_sub_types = HazardSubCodeType::where('id', $code_statement->sub_code_type_id)->get();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.chemical.hazard.code_statement.edit', ['code_statement' => $code_statement, 'code_types' => $code_types, 'code_sub_types' => $code_sub_types])->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code_statement_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $code_statement =  CodeStatement::find(___decrypt($id));
            $code_statement['title'] = $request->code_statement_name;
            $code_statement['code'] = $request->code;
            $code_statement['description'] = $request->description;
            $code_statement['type'] = !empty($request->type) ? ___decrypt($request->type) : 0;
            $code_statement['sub_code_type_id'] = !empty($request->sub_code_type) ? ___decrypt($request->sub_code_type) : 0;
            $code_statement['updated_by'] = Auth::user()->id;
            $code_statement['updated_at'] = now();
            $code_statement->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/code_statement');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }

    // public function importFile(Request $request)
    // {
    //     $validations = [
    //         'code_statement_file' => ['required'],
    //     ];
    //     $validator = Validator::make($request->all(), $validations, []);
    //     if ($validator->fails()) {
    //         $this->message = $validator->errors();
    //     } else {
    //         $datetime = date('Ymd_his');
    //         $file = $request->file('code_statement_file');
    //         $filename = $datetime . "_" . $file->getClientOriginalName();
    //         $savepath = public_path('/upload/');
    //         $file->move($savepath, $filename);
    //         $excel = Importer::make('Excel');
    //         $excel->load($savepath . $filename);
    //         $collection = $excel->getCollection();
    //         if ($collection->count() > 0) {
    //             foreach ($collection->toArray() as $key => $value) {
    //                 $insert_data = array(
    //                     'code'   => $value[0],
    //                     'title'  => $value[1],
    //                     'description'   => $value[1],
    //                     'type'   => ___decrypt($request->type),
    //                     'sub_code_type_id'   => ___decrypt($request->sub_code_type)
    //                 );
    //                 CodeStatement::insertGetId($insert_data);
    //             }
    //         }
    //         $this->status = true;
    //         $this->alert   = true;
    //         $this->modal = true;
    //         $this->redirect = url('product/chemical');
    //         $this->message = "admin/master/chemical/hazard/code_statement";
    //     }
    //     return $this->populateresponse();
    // }
}
