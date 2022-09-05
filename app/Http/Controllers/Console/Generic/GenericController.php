<?php

namespace App\Http\Controllers\Console\Generic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Chemical;
use App\Models\Master\Chemical\ChemicalCategory;
use App\Models\Master\Chemical\ChemicalClassification;
use App\Models\Organization\Vendor\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Chemical\ProductType;
use App\Models\Product\ChemicalProperties;

class GenericController extends Controller
{
    public function create()
    {
        $data['categories'] = ChemicalCategory::where('status', 'active')->get();
        $data['classifications'] = ChemicalClassification::where('status', 'active')->get();
        $data['product_type'] = ProductType::where('status', 'active')->get();
        $data['vendors'] = Vendor::where('status', 'active')->get();
        return view('pages.console.product.generic.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $validations = [
                'name' => ['required'],
                'classification_id' => ['required'],
                'category_id' => ['required']
            ];
            $validator = Validator::make($request->all(), $validations, []);
            if ($validator->fails()) {
                $this->message = $validator->errors();
            } else {
                $data = new Chemical();
                $data['chemical_name'] = $request->name;
                $data['tenant_id'] = session()->get('tenant_id');
                $data['product_type_id'] = ___decrypt($request->product_type_id);
                $data['category_id'] = ___decrypt($request->category_id);
                $data['classification_id'] = ___decrypt($request->classification_id);
                $data['product_brand_name'] = $request->product_brand_name;
                $data['own_product'] = !empty($request->own_product) ? $request->own_product : 0;
                $data['notes'] = $request->notes;
                if ($request->other_name != "") {
                    $other_names = explode(",", $request->other_name);
                } else {
                    $other_names = [];
                }
                $data['other_name'] = $other_names;
                if ($request->tags != "") {
                    $tags = explode(",", $request->tags);
                } else {
                    $tags = [];
                }
                $data['tags'] = $tags;
                if (!empty($request->vendor_list)) {
                    foreach ($request->vendor_list as $key => $vendors) {
                        $val_vendor[$key] = ___decrypt($vendors);
                    }
                    $data['vendor_list'] = $val_vendor;
                }
                $data['status'] = 'active';
                $data['created_by'] = Auth::user()->id;
                $data['updated_by'] = Auth::user()->id;
                if (!empty($request->image)) {
                    $image = upload_file($request, 'image', 'image');
                    $data['image'] = $image;
                }
                $data->save();
                $last_product_id = $data->id;
                if (!empty($last_product_id) && ___decrypt($request->classification_id) == 1) {
                    $prop_json = [
                        array("id" => 0, "field_type_id" => "8", "value" => ""),
                        array("id" => 1, "field_type_id" => "9", "value" => "")
                    ];
                    $prop_dynamic = [
                        array("id" => 0, "field_type_id" => "5", "unit_id" => "chemical_list", "value" => "100", "unit_constant_id" => $last_product_id)
                    ];
                    $chemprop = new ChemicalProperties();
                    $chemprop->prop_json = $prop_json;
                    $chemprop->dynamic_prop_json = $prop_dynamic;
                    $chemprop->product_id = $last_product_id;
                    $chemprop->sub_property_id = 3;
                    $chemprop->property_id = 2;
                    $chemprop->order_by = 1;
                    $chemprop->created_by = Auth::user()->id;
                    $chemprop->updated_by = Auth::user()->id;
                    $chemprop->save();
                }
                $this->status = true;
                $this->alert = true;
                $this->modal = true;
                $this->redirect = url('product/chemical');
                $this->message = "Generic Product Added Successfully!";
            }
            return $this->populateresponse();
        } catch (\Exception $e) {
            $this->status = false;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = url('product/chemical');
            $this->message = "Generic Product Failed to Create! - " + $e->getMessage();
            return $this->populateresponse();
        }
    }

    public function show($id)
    {
        $data['generic'] = Chemical::find(___decrypt($id));
        return view('pages.console.product.generic.view', $data);
    }

    public function edit($id)
    {
        $data['generic'] = Chemical::find(___decrypt($id));
        $data['product_type'] = ProductType::where('status', 'active')->get();
        $data['categories'] = ChemicalCategory::where('status', 'active')->get();
        $data['classifications'] = ChemicalClassification::where('status', 'active')->get();
        $data['vendors'] = Vendor::where('status', 'active')->get();
        return view('pages.console.product.generic.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $validations = [
                'name' => ['required'],
                'classification_id' => ['required'],
                'category_id' => ['required']
            ];
            $validator = Validator::make($request->all(), $validations, []);
            if ($validator->fails()) {
                $this->message = $validator->errors();
            } else {
                $data = Chemical::find(___decrypt($id));
                $data['chemical_name'] = $request->name;
                $data['product_type_id'] = ___decrypt($request->product_type_id);
                $data['category_id'] = ___decrypt($request->category_id);
                $data['classification_id'] = ___decrypt($request->classification_id);
                $data['product_brand_name'] = $request->product_brand_name;
                $data['own_product'] = !empty($request->own_product) ? $request->own_product : 0;
                $data['notes'] = $request->notes;
                if ($request->other_name != "") {
                    $other_names = explode(",", $request->other_name);
                } else {
                    $other_names = [];
                }
                $data['other_name'] = $other_names;
                if ($request->tags != "") {
                    $tags = explode(",", $request->tags);
                } else {
                    $tags = [];
                }
                $data['tags'] = $tags;
                if (!empty($request->vendor_list)) {
                    foreach ($request->vendor_list as $key => $vendors) {
                        $val_vendor[$key] = ___decrypt($vendors);
                    }
                    $data['vendor_list'] = $val_vendor;
                }
                if (!empty($request->image)) {
                    $image = upload_file($request, 'image', 'image');
                    $data['image'] = $image;
                }
                $data['status'] = 'active';
                $data['updated_by'] = Auth::user()->id;
                $data['updated_at'] = now();
                $data->save();
                $last_product_id = $data->id;
                $prop = ChemicalProperties::where(['sub_property_id' => 3, 'property_id' => 2, 'product_id' => $last_product_id])->first();
                if (empty($prop)) {
                    if (!empty($last_product_id) && ___decrypt($request->classification_id) == 1) {
                        $prop_json = [
                            array("id" => 0, "field_type" => "textarea", "field_key" => "Reference Source", "field_value" => ""),
                            array("id" => 1, "field_type" => "tags", "field_key" => "Keywords", "field_value" => ""),
                            array("id" => 2, "field_type" => "checkbox", "field_key" => "Is Recommended", "field_value" => "on")
                        ];
                        $prop_dynamic = [
                            array("id" => 0, "field_type" => "Select", "field_key" => "Chemical Composition", "unit_name" => "chemical_list", "unit_value" => "100", "field_value" => $last_product_id)
                        ];
                        $chemprop = new ChemicalProperties();
                        $chemprop->prop_json = $prop_json;
                        $chemprop->dynamic_prop_json = $prop_dynamic;
                        $chemprop->product_id = $last_product_id;
                        $chemprop->sub_property_id = 3;
                        $chemprop->property_id = 2;
                        $chemprop->order_by = 1;
                        $chemprop->created_by = Auth::user()->id;
                        $chemprop->updated_by = Auth::user()->id;
                        $chemprop->save();
                    }
                }
                $this->status = true;
                $this->alert = true;
                $this->modal = true;
                $this->redirect = url('product/chemical');
                $this->message = "Generic Product Updated Successfully!";
            }
            return $this->populateresponse();
        } catch (\Exception $e) {
            $this->status = false;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = url('product/chemical');
            $this->message = "Generic Product Failed to Update! - " + $e->getMessage();
            return $this->populateresponse();
        }
    }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = Chemical::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (Chemical::where('id', ___decrypt($id))->update($update)) {
                Chemical::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('product/chemical');
        return $this->populateresponse();
    }
}
