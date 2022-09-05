<?php

namespace App\Http\Controllers\Console\Chemicals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Chemical;
use App\Models\Product\PeriodicTable;
use App\Models\Product\ChemicalProperties;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Chemical\ChemicalCategory;
use App\Models\Master\Chemical\ChemicalClassification;
use App\Models\Organization\Vendor\Vendor;
use App\Models\Organization\Lists\RegulatoryList;
use App\Models\ListProduct;
use App\Imports\ProductImport;

class ChemicalController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'console') {
            $data['chemicals'] = Chemical::where(['created_by' => Auth::user()->id, 'tenant_id' => session()->get('tenant_id')])->with('chemicalClassification', 'chemicalCategory')->orderBy('id', 'desc')->get();
        } else {
            $data['chemicals'] = Chemical::where(['tenant_id' => session()->get('tenant_id')])->with('chemicalClassification', 'chemicalCategory')->orderBy('id', 'desc')->get();
        }
        $classification_id = array_column($data['chemicals']->toArray(), 'classification_id');
        $product_type_id  = array_column($data['chemicals']->toArray(), 'product_type_id');
        $cnt = array_count_values($classification_id);
        $product_type_id_cnt = array_count_values($product_type_id);
        $data['pure_product_count'] = (!empty($cnt) && !empty($cnt[1])) ? $cnt[1] : 0;
        $data['simulated_product_count'] = (!empty($cnt) && !empty($cnt[2])) ? $cnt[2] : 0;
        $data['experiment_product_count'] = (!empty($cnt) && !empty($cnt[3])) ? $cnt[3] : 0;
        $data['generic_count'] =  (!empty($product_type_id_cnt) && !empty($product_type_id_cnt[2])) ? $product_type_id_cnt[2] : 0;
        $data['overall_count'] = (!empty($data['chemicals'])) ? count($data['chemicals']) : 0;
        return view('pages.console.product.chemical.index', $data);
    }

    public function get_product(Request $request)
    {
        try {
            $product = Chemical::where([['id', $request->product_id], ['status', 'active']])->get()->first();
            $product_info = [
                'id' => $product->id,
                'name' => $product->chemical_name,
                'category' => [
                    'id' => $product->category_id,
                    'category_name' => $product->chemicalCategory->name
                ],
                'classification' => [
                    'id' => $product->classification_id,
                    'classification_name' => $product->chemicalClassification->name
                ],
                'cas_no' => $product->cas_no,
                'molecular_formula' => $product->molecular_formula
            ];
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $product_info
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        $data['categories'] = ChemicalCategory::where('status', 'active')->get();
        $data['classifications'] = ChemicalClassification::where('status', 'active')->get();
        $data['vendors'] = Vendor::where('status', 'active')->get();
        return view('pages.console.product.chemical.create', $data);
    }

    public function edit($id)
    {
        $data['chemical'] = Chemical::find(___decrypt($id));
        $data['categories'] = ChemicalCategory::where('status', 'active')->get();
        $data['classifications'] = ChemicalClassification::where('status', 'active')->get();
        $data['vendors'] = Vendor::where('status', 'active')->get();
        return view('pages.console.product.chemical.edit', $data);
    }

    public function show($id)
    {
        $data['chemical'] = Chemical::Select('*')
            ->with([
                'chemicalCategory' => function ($q) {
                    $q->select('id', 'name');
                }, 'chemicalClassification' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->where('id', ___decrypt($id))->first();
        return view('pages.console.product.chemical.view', $data);
    }

    public function store(Request $request)
    {
        $validations = [
            'chemical_name' => ['required'],
            'product_type_id' => ['required'],
            'classification_id' => ['required'],
            'category_id' => ['required'],
            'molecular_formula' => ['nullable'],
        ];
        if ($request->cas_number != "") {
            $cas_numbers = explode(",", $request->cas_number);
            for ($i = 0; $i < count($cas_numbers); $i++) {
                $cas_numbers[$i];
            }
        }
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $data = new Chemical();
            $data['chemical_name'] = $request->chemical_name;
            $data['product_type_id'] = ___decrypt($request->product_type_id);
            $data['tenant_id'] = session()->get('tenant_id');
            $data['molecular_formula'] = $request->molecular_formula;
            $data['category_id'] = ___decrypt($request->category_id);
            $data['classification_id'] = ___decrypt($request->classification_id);
            if ($request->cas_number != "") {
                $cas_numbers = explode(",", $request->cas_number);
            } else {
                $cas_numbers = [];
            }
            $data['cas_no'] = $cas_numbers;
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
            $data['ec_number'] = $request->ec_number;
            $data['product_brand_name'] = $request->product_brand_name;
            $data['iupac'] = $request->iupac;
            $data['inchi'] = $request->inchi;
            $data['inchi_key'] = $request->inchi_key;
            $data['own_product'] = !empty($request->own_product) ? $request->own_product : 0;
            $data['status'] = 'active';
            $data['created_by'] = Auth::user()->id;
            $data['updated_by'] = Auth::user()->id;
            $data['notes'] = $request->notes;
            if (!empty($request->vendor_list)) {
                foreach ($request->vendor_list as $key => $vendors) {
                    $val_vendor[$key] = ___decrypt($vendors);
                }
                $data['vendor_list'] = $val_vendor;
            }
            if (!empty($request->smiles)) {
                foreach ($request->smiles as $key => $sm) {
                    $val[$key]['id'] = json_encode($key);
                    $val[$key]['types'] = $sm['types'];
                    $val[$key]['smile'] = $sm['smile'];
                }
                $data['smiles'] = $val;
            }
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
            $this->message = "Chemical Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function update(Request $request, $id)
    {
        $validations = [
            'chemical_name' => ['required'],
            'product_type_id' => ['required'],
            'classification_id' => ['required'],
            'category_id' => ['required'],
            'molecular_formula' => ['nullable'],
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $data = Chemical::find(___decrypt($id));
            $data['chemical_name'] = $request->chemical_name;
            $data['product_type_id'] = ___decrypt($request->product_type_id);
            $data['tenant_id'] = session()->get('tenant_id');
            $data['molecular_formula'] = $request->molecular_formula;
            $data['category_id'] = ___decrypt($request->category_id);
            $data['classification_id'] = ___decrypt($request->classification_id);
            if ($request->cas_number != "") {
                $cas_numbers = explode(",", $request->cas_number);
            } else {
                $cas_numbers = [];
            }
            $data['cas_no'] = $cas_numbers;
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
            $data['ec_number'] = $request->ec_number;
            $data['product_brand_name'] = $request->product_brand_name;
            $data['iupac'] = $request->iupac;
            $data['inchi'] = $request->inchi;
            $data['inchi_key'] = $request->inchi_key;
            $data['own_product'] = !empty($request->own_product) ? $request->own_product : 0;
            $data['status'] = 'active';
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = now();
            $data['notes'] = $request->notes;
            if (!empty($request->vendor_list)) {
                foreach ($request->vendor_list as $key => $vendors) {
                    $val_vendor[$key] = $vendors;
                }
                $data['vendor_list'] = $val_vendor;
            }
            $val = [];
            if (!empty($request->smiles)) {
                foreach ($request->smiles as $key => $sm) {
                    if (!empty($sm['smile'])) {
                        $val[$key]['id'] = json_encode($key);
                        $val[$key]['types'] = $sm['types'];
                        $val[$key]['smile'] = $sm['smile'];
                    }
                }
                $data['smiles'] = $val;
            }
            if (!empty($request->image)) {
                $image = upload_file($request, 'image', 'image');
                $data['image'] = $image;
            }
            $data->save();
            $last_product_id = $data->id;
            // $prop = ChemicalProperties::where(['sub_property_id' => 3, 'property_id' => 2, 'chemical_id' => $last_product_id])->first();
            // if (empty($prop)) {
            //     if (!empty($last_product_id) && ___decrypt($request->classification_id) == 1) {
            //         $prop_json = [
            //             array("id" => 0, "field_type" => "textarea", "field_key" => "Reference Source", "field_value" => ""),
            //             array("id" => 1, "field_type" => "tags", "field_key" => "Keywords", "field_value" => ""),
            //             array("id" => 2, "field_type" => "checkbox", "field_key" => "Is Recommended", "field_value" => "on")
            //         ];
            //         $prop_dynamic = [
            //             array("id" => 0, "field_type" => "Select", "field_key" => "Chemical Composition", "unit_name" => "chemical_list", "unit_value" => "100", "field_value" => $last_product_id)
            //         ];
            //         $chemprop = new ChemicalProperties();
            //         $chemprop->prop_json = $prop_json;
            //         $chemprop->dynamic_prop_json = $prop_dynamic;
            //         $chemprop->chemical_id = $last_product_id;
            //         $chemprop->sub_property_id = 3;
            //         $chemprop->property_id = 2;
            //         $chemprop->order_by = 1;
            //         $chemprop->updated_by = Auth::user()->id;
            //         $chemprop->save();
            //     }
            // }
            $this->status = true;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = url('product/chemical');
            $this->message = "Chemical Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function addMore(Request $request)
    {
        return response()->json([
            'status' => true,
            'html' => view("pages.console.product.chemical." . $request->type, ['count' => !empty($request->count) ? $request->count : 0])->render()
        ]);
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

    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $product_id = explode(',', ___decrypt($id_string));
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (Chemical::whereIn('id', $product_id)->update($update)) {
            Chemical::destroy($product_id);
        }
        $this->status = true;
        $this->redirect = url('/product/chemical');
        return $this->populateresponse();
    }

    public function importFile(Request $request)
    {
        $validations = [
            //'product_file' => ['required'],
            'product_file' => ['required_without_all:import_json'],
            'import_json' => ['required_without_all:product_file'],
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            if (!empty($request->product_file)) {
                \Excel::import(new ProductImport($request->product_type_id), request()->file('product_file'));
                $this->message = "Chemical CSV uploaded Successfully!";
            }
            if (!empty($request->import_json)) {
                $jsonString = file_get_contents(request()->file('import_json'));
                $data = json_decode($jsonString, true);

                for ($i = 0; $i < count($data); $i++) {
                    if (!empty($data[$i]['SMILES type'])) {
                        $type =  explode(',', $data[$i]['SMILES type']);
                    } else {
                        $type = [];
                    }
                    $smile =  explode(',', $data[$i]['SMILES']);
                    $smiles = [];
                    foreach ($smile as $keyss => $smm) {
                        $smiles[$keyss]['smile'] = $smm;
                        $smiles[$keyss]['types'] = !empty($type[$keyss]) ? $type[$keyss] : '';
                    }

                    $val = [];
                    if (!empty($smiles)) {
                        foreach ($smiles as $keys => $sm) {
                            if (!empty($sm['smile'])) {
                                $val[$keys]['id'] = json_encode($keys + 1);
                                $val[$keys]['types'] = $sm['types'];
                                $val[$keys]['smile'] = $sm['smile'];
                            }
                        }
                    }
                    if ($data[$i]['Own Product'] == 'yes') {
                        $own = 1;
                    } else {
                        $own = 2;
                    }

                    $chemical =  new Chemical();
                    $chemical['tenant_id'] = session()->get('tenant_id');
                    $chemical['chemical_name'] = $data[$i]['Chemical Name'];
                    $chemical['product_type_id'] = $request->product_type_id;
                    $chemical['category_id'] = 1;
                    $chemical['classification_id'] = 1;
                    $chemical['product_brand_name'] = $data[$i]['Brand Name'];
                    $chemical['iupac'] = $data[$i]['IUPAC'];
                    $chemical['cas_no'] = explode(',', $data[$i]['CAS']);
                    $chemical['inchi'] = $data[$i]['INCHI'];
                    $chemical['inchi_key'] = $data[$i]['INCHI key'];
                    $chemical['ec_number'] = $data[$i]['EC number'];
                    $chemical['molecular_formula'] = $data[$i]['Molecular formula'];
                    $chemical['smiles'] = $val;
                    $chemical['own_product'] = $own;
                    $chemical['other_name'] = explode(',', $data[$i]['Other names']);
                    $chemical['tags'] = explode(',', $data[$i]['Tags']);
                    $chemical['notes'] = $data[$i]['Note'];
                    $chemical['status'] = 'active';
                    $chemical['created_by'] = Auth::user()->id;
                    $chemical['updated_by'] = Auth::user()->id;
                    $chemical->save();
                }
                $this->message = "JSON uploaded Successfully!";
            }
            $this->status = true;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = url('product/chemical');
        }
        return $this->populateresponse();
    }

    // public function exportExcle()
    // {
    //     $data = Chemical::all();
    //     $datetime = date('Ymd_his');
    //     $filename = $datetime . "chemical.xlsx";
    //     $savefile = public_path('/download/' . $filename);
    //     $excel = Exporter::make('Excel');
    //     $excel->load($data);
    //     $excel->save($savefile);
    //     return redirect('/organization/user')->with('success', 'User Exported!');
    // }

    public function view_list(Request $request, $id, $chemical_id)
    {
        $list = RegulatoryList::find(___decrypt($id));
        $chemical = Chemical::find(___decrypt($chemical_id));
        $list_product = ListProduct::where('list_id', '=', ___decrypt($id))->whereJsonContains('cas', $chemical->cas_no)->with('hazard_pictogram_details')->get();
        return response()->json([
            'status' => true,
            'html' => view("pages.console.product.chemical.list_details", ['count' => $request->count, $list, 'list' => $list, 'chemical' => $chemical, 'list_product' => $list_product[0]])->render()
        ]);
    }

    public function get_product_using_cas_no(Request $request)
    {
        try {
            $product = Chemical::select('id', 'cas_no')->whereJsonContains('cas_no', $request->cas_no)->where('status', 'active')->first();
            $product_info = [];
            if (!empty($product)) {
                $product_info = [
                    'id' => $product->id,
                    'cas_no' => $product->cas_no,
                ];
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $product_info
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function check_molecular_formula(Request $request)
    {
        if (empty($request->molecular_formula)) {
            $message = 'Molecular formula is either empty or not validated';
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        $temp_m = str_split($request->molecular_formula);
    
        $j_r = -1;
        $n_f = true;
        $re = array();
        for ($i_r = 0; $i_r < sizeof($temp_m); $i_r++) {
            if (ctype_upper($temp_m[$i_r])) {
                if ($n_f == false) {
                    $re[$j_r] = $re[$j_r] . "1";
                    $j_r++;
                    $re[$j_r] = $temp_m[$i_r];
                } else {
                    $j_r++;
                    $re[$j_r] = $temp_m[$i_r];
                    $n_f = false;
                }
            } else if (ctype_lower($temp_m[$i_r])) {
                if (!empty($re[$j_r])) {
                    $re[$j_r] = $re[$j_r] . $temp_m[$i_r];
                } else {
                    $re[$j_r] = $temp_m[$i_r];
                }
                $n_f = false;
            } else if (is_numeric($temp_m[$i_r])) {
                $re[$j_r] .= $temp_m[$i_r];
                $n_f = true;
            }
        }
        if (!preg_match('#[0-9]#', $re[$j_r])) {
            $re[$j_r] .= "1";
            error_reporting(0);
        }
        $number = array();
        $variable = array();
        if (!empty($re)) {
            for ($e = 0; $e < sizeof($re); $e++) {
                $numbers = preg_replace('/[^0-9]/', '', !empty($re[$e]) ? $re[$e] : '');
                $elem = preg_replace('/[^a-zA-Z]/', '', !empty($re[$e]) ? $re[$e] : '');
                $number[$e] = $numbers;
                $variable[$e] = $elem;
                $elem_con = PeriodicTable::where('element_sc', $elem)->first();
                $elem_con = !empty($elem_con->element_sc) ? $elem_con->element_sc : '';
                if (empty($elem_con)) {
                    $message = "Element Not Found";
                    return response()->json([
                        'status' => false,
                        'message' => $message
                    ]);
                }
            }
            return response()->json([
                'status' => true,
                'html' => view("pages.console.product.chemical.validate", ['elements' => $variable, 'numbers' =>  $number])->render()
            ]);
        }
    }
}
