<?php

namespace App\Http\Controllers\Admin\Master\Chemical\Hazard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Chemical\Hazard\Hazard;
use App\Models\Master\Chemical\Hazard\HazardClass;
use App\Models\Master\Chemical\Hazard\HazardCategory;
use App\Models\Master\Chemical\Hazard\HazardPictogram;
use App\Models\Master\Chemical\Hazard\CodeStatement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HazardController extends Controller
{
    public function index()
    {
        $hazards = Hazard::orderBy('id', 'desc')->get();
        $hazard_details = [];
        $code_statements = [];
        foreach ($hazards as $hazard) {
            $hazard_details[] = [
                "id" => $hazard->id,
                "hazard_class_name" => $hazard->hazard_class_details->hazard_class_name,
                "category_name" => $hazard->hazard_category_details->name,
                "hazard_pictogram" => !empty($hazard->hazard_pictogram_details->hazard_pictogram) ? $hazard->hazard_pictogram_details->hazard_pictogram : '',
                "code_statement_id" => $hazard->code_statement_id,
                "signal_word" => $hazard->signal_word,
                "hazard_code" => $hazard->hazard_code,
                "hazard_statement" => $hazard->hazard_statement,
                "status" => $hazard->status,
            ];
        }
        return view('pages.admin.master.chemical.hazard.hazard.index', compact('hazard_details'));
    }

    public function create()
    {
        $data['hazard_classes'] = HazardClass::get();
        $data['hazard_categories'] = HazardCategory::get();
        $data['hazard_pictograms'] = HazardPictogram::get();
        $data['code_statements'] = CodeStatement::where('type', '3')->get();
        return view('pages.admin.master.chemical.hazard.hazard.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hazard_class_id' => 'required',
            'hazard_category_id' => 'required',
            'hazard_pictogram_id' => 'required',
            // 'signal_word' => 'required',
            'code' => 'required',
            'hazard_statement' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $hazard =  new Hazard();
            if (!empty($request->hazard_class_id)) {
                foreach ($request->hazard_class_id as $class_id) {
                    $h_class_id[] = ___decrypt($class_id);
                }
                $hazard['hazard_class_id'] = $h_class_id;
            }
            if (!empty($request->hazard_category_id)) {
                foreach ($request->hazard_category_id as $category_id) {
                    $h_category_id[] = ___decrypt($category_id);
                }
                $hazard['category_id'] = $h_category_id;
            }
            if (!empty($request->p_codes)) {
                foreach ($request->p_codes as $p_codes) {
                    $h_p_codes[] = ___decrypt($p_codes);
                }
                $hazard['code_statement_id'] = $h_p_codes;
            }


            $hazard['pictogram_id'] = !empty($request->hazard_pictogram_id) ? ___decrypt($request->hazard_pictogram_id) : 0;

            $hazard['signal_word'] = $request->signal_word;

            $hazard['hazard_code'] = $request->code;
            $hazard['hazard_statement'] = $request->hazard_statement;

            

            $hazard['description'] = $request->description;
            $hazard['created_by'] = Auth::user()->id;
            $hazard['updated_by'] = Auth::user()->id;
            $hazard->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/hazard');
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
            $update = Hazard::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (Hazard::where('id', ___decrypt($id))->update($update)) {
                Hazard::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/hazard');
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
        if (Hazard::whereIn('id', $processIDS)->update($update)) {
            Hazard::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/master/chemical/hazard/hazard');
        return $this->populateresponse();
    }

    public function edit($id)
    {
        $data['hazard_classes'] = HazardClass::get();
        $data['hazard_categories'] = HazardCategory::get();
        $data['hazard_pictograms'] = HazardPictogram::get();
        $data['code_statements'] = CodeStatement::get();
        $data['hazards'] = Hazard::where('id', ___decrypt($id))->first();
        return view('pages.admin.master.chemical.hazard.hazard.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hazard_class_id' => 'required',
            'hazard_category_id' => 'required',
            'hazard_pictogram_id' => 'required',
            // 'signal_word' => 'required',
            'code' => 'required',
            'hazard_statement' => 'required',
            'p_codes' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $hazard =  Hazard::find(___decrypt($id));
            if (!empty($request->hazard_class_id)) {
                foreach ($request->hazard_class_id as $class_id) {
                    $h_class_id[] = ___decrypt($class_id);
                }
                $hazard['hazard_class_id'] = $h_class_id;
            }
            if (!empty($request->hazard_category_id)) {
                foreach ($request->hazard_category_id as $category_id) {
                    $h_category_id[] = ___decrypt($category_id);
                }
                $hazard['category_id'] = $h_category_id;
            }
            if (!empty($request->p_codes)) {
                foreach ($request->p_codes as $p_codes) {
                    $h_p_codes[] = ___decrypt($p_codes);
                }
                $hazard['code_statement_id'] = $h_p_codes;
            }
            $hazard['pictogram_id'] = ___decrypt($request->hazard_pictogram_id);
            $hazard['signal_word'] = $request->signal_word;
            $hazard['hazard_code'] = $request->code;
            $hazard['hazard_statement'] = $request->hazard_statement;
            $hazard['description'] = $request->description;
            $hazard['updated_by'] = Auth::user()->id;
            $hazard['updated_at'] = now();
            $hazard->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/master/chemical/hazard/hazard');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
