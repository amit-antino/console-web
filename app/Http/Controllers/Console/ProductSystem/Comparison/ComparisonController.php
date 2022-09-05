<?php

namespace App\Http\Controllers\Console\ProductSystem\Comparison;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSystem\ProductSystem;
use App\Models\ProductSystem\ProductComparison;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class ComparisonController extends Controller
{
    public function index()
    {
        $data['product_sys_count'] = ProductSystem::select(['id', 'name'])->where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->count();
        $data['data'] = ProductComparison::where('tenant_id', session()->get('tenant_id'))->orderByDesc('id')->get();
        return view('pages.console.product_system.comparison.index', $data);
    }

    public function create()
    {
        $data['product_sys'] = ProductSystem::select(['id', 'name'])->where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        return view('pages.console.product_system.comparison.create', compact('data'));
    }

    public function chartRender()
    {
        $response = Http::get('')->json();
        $data = array(
            array("yarn" => "Algae", "price" => 392),
            array("yarn" => "Coconut-Nanollose", "price" => 185),
        );
        $bublechart = array(
            array("labeldata" => "Algae", "backgroundColor" => "#ffe69d", "borderColor" => "#fbbc06", "x" => 322, "y" => 4000, "r" => 10),
            array("labeldata" => "Coconut-Nanollose", "backgroundColor" => "#bbd4ff", "borderColor" => "#4d8af0", "x" => 522, "y" => 850, "r" => 20)
        );
        $radarchart = array("datasets" => [
            array("label" => "Algae", "data" => [1, 2, 3]),
            array("label" => "Coconut-Nanollose", "data" => [10, 20, 30])
        ]);
        return json_encode(array("barchart" => $data, "bublechart" => $bublechart, "radar" => $radarchart));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comparison_name' => 'required',
            'product_system' => 'required'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $prdData = new ProductComparison();
            $prdData->tenant_id = session()->get('tenant_id');
            $prdData->comparison_name  = $request->comparison_name;
            $prdData->product_system  = $request->product_system;
            $prdData->description = $request->description;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $prdData->tags = $tags;
            $prdData->created_by = Auth::user()->id;
            $prdData->updated_by = Auth::user()->id;
            $prdData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/product_system/comparison');
            $this->message = "Process System Comparisons Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $data['product_sys'] = ProductSystem::select(['id', 'name'])->where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        $data['edit'] = ProductComparison::find(___decrypt($id));
        return view('pages.console.product_system.comparison.view', compact('data'));
    }

    public function edit($id)
    {
        $data['product_sys'] = ProductSystem::select(['id', 'name'])->where('status', 'active')->where('tenant_id', session()->get('tenant_id'))->get();
        $data['edit'] = ProductComparison::find(___decrypt($id));
        return view('pages.console.product_system.comparison.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comparison_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $prdData =   ProductComparison::find(___decrypt($id));
            $prdData->tenant_id = session()->get('tenant_id');
            $prdData->comparison_name  = $request->comparison_name;
            $prdData->product_system  = $request->product_system;
            $prdData->description = $request->description;
            $prdData->tags = $request->tags;
            $prdData->updated_by = Auth::user()->id;
            $prdData->updated_at = now();
            $prdData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/product_system/comparison');
            $this->message = "Process System Comparisons Updated Successfully!";
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
            $update = ProductComparison::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ProductComparison::where('id', ___decrypt($id))->update($update)) {
                ProductComparison::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('/product_system/comparison');
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
        if (ProductComparison::whereIn('id', $processIDS)->update($update)) {
            ProductComparison::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('/product_system/comparison');
        return $this->populateresponse();
    }
}
