<?php

namespace App\Http\Controllers\Console\Organization\Lists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Lists\RegulatoryList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization\Lists\ClassificationList;
use App\Models\Organization\Lists\CategoryList;
use App\Imports\ListProductImport;
use App\Models\ListProduct;

class ListController extends Controller
{
    public function index()
    {
        $regulatory_lists = RegulatoryList::where('tenant_id', session()->get('tenant_id'))->get();
        $regulatory_list_info = [];
        foreach ($regulatory_lists as $regulatory_list) {
            $regulatory_list_info[] = [
                "id" => $regulatory_list->id,
                "list_name" => $regulatory_list->list_name,
                "classification" => $regulatory_list->classificationList->classification_name,
                "category" => $regulatory_list->categoryList->category_name,
                "compilation" => $regulatory_list->compilation,
                "color_code" => $regulatory_list->color_code,
                "status" => $regulatory_list->status,
                "updated_at" => date('d/m/Y h:i:s A', strtotime($regulatory_list->updated_at))
            ];
        }
        return view('pages.console.tenant.list.index', compact('regulatory_list_info'));
    }

    public function create()
    {
        $data['CategoryList'] = CategoryList::where('status', 'active')->get();
        $data['ClassificationList'] = ClassificationList::where('status', 'active')->get();
        return view('pages.console.tenant.list.create', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'list_name' => 'required',
            'classification_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $listData = new RegulatoryList();
            $listData->tenant_id = session()->get('tenant_id');
            $listData->list_name = $request->list_name;
            $listData->classification_id = ___decrypt($request->classification_id);
            $listData->color_code = $request->color_code;
            $listData->display_hazard_code = isset($request->display_hazard_code) ? '1' : "0";
            $listData->category_id = ___decrypt($request->category_id);
            $listData->region = isset($request->region) ? $request->region : '';
            $listData->country_id = isset($request->country_id) ? ___decrypt($request->country_id) : 0;
            $listData->state = isset($request->state) ? $request->state : "";
            $listData->source_name = isset($request->source_name) ? $request->source_name : "";
            $listData->source_url = isset($request->source_url) ? $request->source_url : "";
            $listData->no_of_list = isset($request->no_of_list) ? $request->no_of_list : 0;
            $listData->hover_msg = isset($request->hover_msg) ? $request->hover_msg : '';
            $listData->match_type = isset($request->match_type) ? $request->match_type : "";
            $listData->hazard_code = isset($request->hazard_code) ? $request->hazard_code : "";
            $listData->compilation = isset($request->compilation) ? $request->compilation : "";
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $listData->tags = $tags;
            if (!empty($request->source_file)) {
                $source_file_csv = upload_file($request, 'source_file', 'source_file');
                $listData->source_file = $source_file_csv;
            }
            // if (!empty($request->csv_file)) {
            //     $source_file_csv = upload_file($request, 'csv_file', 'csv_file');
            //     $listData->converted_file = $source_file_csv;
            // }
            $listData->description = isset($request->description) ? $request->description : '';
            $listData->field_of_display = !empty($request->field_of_display) ? $request->field_of_display : '';
            $listData->created_by = Auth::user()->id;
            $listData->updated_by = Auth::user()->id;
            $listData->status = 'active';
            $listData->save();
            if (!empty($request->csv_file)) {
                \Excel::import(new ListProductImport($listData->id), request()->file('csv_file'));
            }
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/list');
            $this->message = "List Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $data['list_data'] = RegulatoryList::Select('*')
            ->with([
                'chemicalLists' => function ($q) {
                    $q->select('*')->with('hazard_pictogram_details');
                },
                'classificationList' => function ($q) {
                    $q->select('*');
                },
                'categoryList' => function ($q) {
                    $q->select('*');
                }
            ])->where('id', ___decrypt($id))->first();
        //  $data['list_data'] = RegulatoryList::find(___decrypt($id));
        return view('pages.console.tenant.list.view', $data);
    }

    public function edit($id)
    {
        $data['list'] = RegulatoryList::find(___decrypt($id));
        $data['category_list'] = CategoryList::where('status', 'active')->get();
        $data['classification_list'] = ClassificationList::where('status', 'active')->get();
        return view('pages.console.tenant.list.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'list_name' => 'required',
            'classification_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $listData = RegulatoryList::find(___decrypt($id));
            $listData->tenant_id = session()->get('tenant_id');
            $listData->list_name = $request->list_name;
            $listData->classification_id = ___decrypt($request->classification_id);
            $listData->color_code = $request->color_code;
            $listData->display_hazard_code = isset($request->display_hazard_code) ? '1' : "0";;
            $listData->category_id = ___decrypt($request->category_id);
            $listData->region = isset($request->region) ? $request->region : '';
            $listData->country_id = isset($request->country_id) ? ___decrypt($request->country_id) : 0;
            $listData->state = isset($request->state) ? $request->state : "";
            $listData->source_name = isset($request->source_name) ? $request->source_name : "";
            $listData->source_url = isset($request->source_url) ? $request->source_url : "";
            $listData->no_of_list = isset($request->no_of_list) ? $request->no_of_list : 0;
            $listData->hover_msg = isset($request->hover_msg) ? $request->hover_msg : '';
            $listData->match_type = isset($request->match_type) ? $request->match_type : "";
            $listData->hazard_code = isset($request->hazard_code) ? $request->hazard_code : "";
            $listData->compilation = isset($request->compilation) ? $request->compilation : "";
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $listData->tags = $tags;
            if (!empty($request->source_file)) {
                $source_file_csv = upload_file($request, 'source_file', 'source_file');
                $listData->source_file = $source_file_csv;
            }
            $listData->description = isset($request->description) ? $request->description : '';
            $listData->field_of_display = !empty($request->field_of_display) ? $request->field_of_display : '';
            $listData->updated_by = Auth::user()->id;
            $listData->updated_at = now();
            $listData->status = 'active';
            $listData->save();
            if (!empty($request->csv_file)) {
                ListProduct::where('list_id', $listData->id)->delete();
                \Excel::import(new ListProductImport($listData->id), request()->file('csv_file'));
            }
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('organization/list');
            $this->message = "List Updated Successfully!";
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
            $update = RegulatoryList::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (RegulatoryList::where('id', ___decrypt($id))->update($update)) {
                RegulatoryList::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('organization/list');
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
        if (RegulatoryList::whereIn('id', $processIDS)->update($update)) {
            RegulatoryList::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('organization/list');
        return $this->populateresponse();
    }
}
