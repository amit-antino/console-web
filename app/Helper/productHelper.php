<?php

use App\Models\Master\Chemical\ChemicalPropertyMaster;
use App\Models\MFG\ProcessSimulation;
use App\Models\MFG\ProductCreation;
use App\Models\Product\Chemical;
use App\Models\Product\ChemicalProperties;
use Illuminate\Support\Facades\Auth;

function getproducthelper($request)
{
    $val_cas = [];
    if (!empty($request->product)) {
        foreach ($request->product as $key => $c_no) {
            if (___decrypt($c_no) != 0) {
                $dataExits = ProductCreation::select("new_product_id")->where(["simulation_type" => ___decrypt($request->simulation_type), "stream_id" => ($key + 1), "process_id" => $request->process_id, "product_id" => ___decrypt($c_no), "datasource" => "pc"])->first();
            }
            $sum = 0;
            foreach ($request->ass as $k => $v) {
                if (isset($request->objassprd[$key][$k])) {
                    $val_cas[$key]['id'] = [___decrypt($c_no)];
                    if (isset($dataExits['new_product_id']) && $dataExits['new_product_id'] != NULL) {
                        $val_cas[$key]['creted_prd_id'] = [$dataExits['new_product_id']];
                    } else {
                        $val_cas[$key]['creted_prd_id'] = [0];
                    }
                    $val_cas[$key]['detail'][$k] = $request->objassprd[$key][$k];
                }
            }
        }
    }
    $sumArr = [];
    foreach ($val_cas as $vk => $viv) {
        $sum = getsumofproduct($viv['id'][0]);
        $total = array_sum($viv['detail']);
        if ($sum != $total) {
            $sumArr[$vk]['stream_name'] = $vk + 1;
            $sumArr[$vk]['product'] = $viv['id'][0];
            $sumArr[$vk]['sum'] = array_sum($viv['detail']);
            $sumArr[$vk]['creted_prd_id'] = $viv['creted_prd_id'][0];
            if ($viv['creted_prd_id'][0] != 0) {
                $sumArr[$vk]['chemName'] = getsingleChemicalName($viv['creted_prd_id'][0]);
            } else {
                $sumArr[$vk]['chemName'] = "";
            }
        }
    }
    return $sumArr;
}

function getsumofproduct($id)
{
    $propData = ChemicalProperties::select('id', 'dynamic_prop_json', 'prop_json')->where('product_id', $id)->where([['property_id', 2], ['sub_property_id', 3]])->get();
    $jsonArr = [];
    $newArr = [];
    if (!empty($propData)) {
        $sum = 0;
        foreach ($propData as $key => $value) {
            $obj = $value['dynamic_prop_json'];
            foreach ($value['dynamic_prop_json'] as $objkey => $objval) {
                if ($objval['unit_id'] == "chemical_list") {
                    $sum = $sum + $objval['value'];
                }
            }
        }
    }
    return $sum;
}

function createProductProp($arr)
{
    if (!empty($arr)) {
        foreach ($arr as $ke => $v) {
            if (!empty($v['dynamic_prop_json'])) {
                $chemprop = new ChemicalProperties();
                $chemprop['prop_json'] = $v['prop_json'];
                $chemprop['dynamic_prop_json'] = $v['dynamic_prop_json'];
                $chemprop['product_id'] = $v['product_id'];
                $chemprop['property_id'] = $v['property_id'];
                $chemprop['sub_property_id'] = $v['sub_property_id'];
                $chemprop['order_by'] = $v['order_by'];
                $chemprop['created_by'] = $v['created_by'];
                $chemprop['updated_by'] = $v['updated_by'];
                $chemprop->save();
            }
        }
    }
}


function total_chemical_composition($product_id, $sub_property_id, $property_id, $request, $id = '')
{
    $subprop = ChemicalProperties::where(['product_id' => $product_id, 'sub_property_id' => $sub_property_id, 'property_id' => $property_id]);
    if (!empty($id)) {
        $subprop->where('id', '!=', ___decrypt($id));
    }
    $subprop = $subprop->get();
    $dynamic_prop_val = 0;
    if (!empty(_arefy($subprop))) {
        foreach ($subprop as $keyss => $product_prop) {
            if (!empty($product_prop->dynamic_prop_json)) {
                foreach ($product_prop->dynamic_prop_json as  $prop_value) {
                    if ($prop_value['field_type_id'] == '5') {
                        $dynamic_prop_val += !empty($prop_value['value']) ? $prop_value['value'] : 0;
                    }
                }
            }
        }
    }
    $dynamic_prop_val2 = 0;
    if (!empty($request->dynamic_prop)) {
        foreach ($request->dynamic_prop as  $prop_value) {
            if ($prop_value['type'] == '5') {
                $dynamic_prop_val2 += !empty($prop_value['value']) ? $prop_value['value'] : 0;
            }
        }
    }
    $total_val = $dynamic_prop_val2 + $dynamic_prop_val;
    return $total_val;
}

function getsubprpertyValue($parameters)
{
    $product_props = ChemicalProperties::where([[
        'product_id', ($parameters)
    ], [
        'property_id', 3
    ], ['recommended', 'on']])->get();
    $props_details = [];
    if (!empty(_arefy($product_props))) {
        foreach ($product_props as $key => $value) {
            $pro_value = get_properties_details_sub($value, 1);
            $props_details[] = $pro_value;
        }
    }
    $obj = [];
    if (!empty($props_details)) {
        foreach ($props_details as $pk => $pv) {
            $obj['product_name'] = getsingleChemicalName($pv['product_id']);
            $propname = get_master_product_props($pv['property_id']);
            $subpropname = ChemicalSubPropertyMaster::where('id', $pv['sub_property_id'])->first();
            $obj['property_name'] = $propname['property_name'];
            $obj['sub_property_name'][$pv['sub_property_id']]['property_name'] = $subpropname['sub_property_name'];
            if (!empty($pv['data'])) {
                foreach ($pv['data'] as $sk => $sv) {
                    $obj['sub_property_name'][$pv['sub_property_id']]['value'][$sk]['value'] = $sv['value'];
                    if (!empty($sv['unit_constant_name'])) {
                        $obj['sub_property_name'][$pv['sub_property_id']]['value'][$sk]['unit_constant_name'] = $sv['unit_constant_name'];
                    } else {
                        $obj['sub_property_name'][$pv['sub_property_id']]['value'][$sk]['unit_constant_name'] = '';
                    }
                }
            } else {
                $obj['sub_property_name'][$pv['sub_property_id']]['value'] = $pv['value'];
                if (!empty($pv['unit_constant_name'])) {
                    $obj['sub_property_name'][$pv['sub_property_id']]['unit_constant_name'] = $pv['unit_constant_name'];
                } else {
                    $obj['sub_property_name'][$pv['sub_property_id']]['unit_constant_name'] = '';
                }
            }
        }
    }
    return ($obj);
}

function getAssociateValue($parameters, $unit_id = 10)
{
    $jsonArr = [];
    $sum = 0;
    $product_props = ChemicalProperties::select('id', 'dynamic_prop_json')->where([[
        'product_id', ___decrypt($parameters)
    ], [
        'property_id', 2
    ], [
        'sub_property_id', 3
    ]])->get();
    if (!empty(_arefy($product_props))) {
        foreach ($product_props as $key => $value) {
            $obj = $value['dynamic_prop_json'];
            $arrayName = [];
            foreach ($value['dynamic_prop_json'] as $objkey => $objval) {
                if ($objval['unit_id'] == "chemical_list") {
                    $jsonArr[$key]['chem_id'] = $objval['unit_constant_id'];
                    $chemName = Chemical::select('id', 'chemical_name')->where('id', $objval['unit_constant_id'])->first();
                    $jsonArr[$key]['chemical_name'] = $chemName['chemical_name'];
                    $jsonArr[$key]['unit_value'] = $objval['value'];
                    $sum = $sum + $objval['value'];
                }
            }
        }
    } else {
        $jsonArr[0]['chem_id'] = ___decrypt($parameters);
        $chemName = Chemical::select('id', 'chemical_name')->where('id', ___decrypt($parameters))->first();
        $jsonArr[0]['chemical_name'] = $chemName['chemical_name'];
        $jsonArr[0]['unit_value'] = 0;
        $sum = $sum;
    }
    $data['prod'] = Chemical::Select('id', 'chemical_name')->where('id', ___decrypt($parameters))->first();
    $data['master_unit'] = [];
    $data['jsonArr'] = $jsonArr;
    $data['sum'] = $sum;
    return $data;
}


function get_product_name($arr)
{
    $data = Chemical::select('chemical_name')->whereIn('id', $arr)->get();
    return $data;
}

function getsingleChemicalName($product_id)
{
    try {
        $data = Chemical::select('chemical_name')->where('id', $product_id)->first();
        return $data['chemical_name'];
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}


function getsingleChemicaldetail($product_id)
{
    $data = Chemical::select('chemical_name', 'category_id', 'classification_id')->where('id', $product_id)->first();
    return $data;
}


function get_product_details($product_id)
{
    $product = Chemical::select('id', 'chemical_name', 'category_id', 'classification_id', 'molecular_formula', 'smiles', 'cas_no', 'iupac', 'inchi', 'inchi_key', 'ec_number', 'status')->where('id', $product_id)->get()->first();
    $product_info = [
        "id" => $product->id,
        "name" => $product->chemical_name,
        "category" => $product->chemicalCategory->name,
        "classification" => $product->chemicalClassification->name,
        "molecular_formula" => $product->molecular_formula,
        "smiles" => $product->smiles,
        "cas_no" => $product->cas_no,
        "iupac" => $product->iupac,
        "inchi" => $product->inchi,
        "inchi_key" => $product->inchi_key,
        "ec_number" => $product->ec_number,
        "status" => $product->status
    ];
    return $product_info;
}



function get_product_details_arr($product_id)
{
    $products = Chemical::select('id', 'chemical_name', 'category_id', 'classification_id', 'molecular_formula', 'smiles', 'cas_no', 'iupac', 'inchi', 'inchi_key', 'ec_number', 'status')->whereIn('id', $product_id)->with('chemicalCategory', 'chemicalClassification')->get();
    $product_info = [];
    if (!empty($products)) {
        foreach ($products as $k => $product) {
            $product_info[] = [
                "id" => $product->id,
                "name" => $product->chemical_name,
                "category" => $product->chemicalCategory->name,
                "classification" => $product->chemicalClassification->name,
                "molecular_formula" => $product->molecular_formula,
                "smiles" => $product->smiles,
                "cas_no" => $product->cas_no,
                "iupac" => $product->iupac,
                "inchi" => $product->inchi,
                "inchi_key" => $product->inchi_key,
                "ec_number" => $product->ec_number,
                "status" => $product->status
            ];
        }
    }
    return $product_info;
}


function get_master_product_props($property_id)
{
    try {
        $properties = ChemicalPropertyMaster::where('id', $property_id)->first();
        return $properties;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}


function createProduct($request)
{
    $prdIds = $request['new_product']['prd_ids'];
    $prdNames = $request['new_product']['prd_name'];
    $str_ids = $request['new_product']['str_ids'];
    $data_source = $request['new_product']['data_source'];
    $checkIds = $request['new_product']['chk_ids'];
    $new_prd_ids = $request['new_product']['new_prd_ids'];
    $saveArr = [];
    $assoSaveArr = [];
    $assoUpdateArr = [];
    $updateArr = [];
    $newstridarr = [];
    if (!empty($str_ids)) {
        foreach ($str_ids as $sk => $newstrid) {
            $newstridarr[$sk] = ($newstrid - 1);
        }
    }
    if (!empty($newstridarr)) {
        foreach ($newstridarr as $ck => $cv) {
            if ($checkIds[$ck] != 0 && $new_prd_ids[$ck] == 0) {
                $chemname = getsingleChemicaldetail($prdIds[$ck]);
                if ($prdNames[$ck] != "") {
                    $saveArr[$cv]['chemical_name'] = $prdNames[$ck];
                } else {
                    $saveArr[$cv]['chemical_name'] = "PID-" . $request['process_id'];
                }
                $saveArr[$cv]['chem_id'] = $prdIds[$ck];
                $saveArr[$cv]['simulation_type'] = ___decrypt($request['simulation_type']);
                $saveArr[$cv]['process_id'] = $request['process_id'];
                $saveArr[$cv]['stream_id'] = $str_ids[$ck];
                $saveArr[$cv]['category_id'] = $chemname['category_id'];
                $saveArr[$cv]['classification_id'] = 3;
                $saveArr[$cv]['updated_by'] = Auth::user()->id;
                $saveArr[$cv]['created_by'] = Auth::user()->id;
                $saveArr[$cv]['data_source'] = $data_source;
                if (!empty($request->ass)) {
                    foreach ($request->ass as $assprdkey => $assprdvalue) {
                        if (($prdIds[$ck]) != 0) {
                            foreach ($request->objassprd as $ok => $ov) {
                                if (!empty($newstridarr) && in_array($ok, $newstridarr)) {
                                    if ($ov[$assprdkey] != 0) {
                                        $assoSaveArr[$ok][___decrypt($assprdvalue)] = $ov[$assprdkey];
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $chemname = getsingleChemicaldetail($new_prd_ids[$ck]);
                if ($prdNames[$ck] != "") {
                    $updateArr[$cv]['chemical_name'] = $prdNames[$ck];
                } else {
                    $updateArr[$cv]['chemical_name'] =  "PID-" . $request['process_id'];
                }
                $updateArr[$cv]['chem_id'] = $new_prd_ids[$ck];
                $updateArr[$cv]['simulation_type'] = ___decrypt($request['simulation_type']);
                $updateArr[$cv]['process_id'] = $request['process_id'];
                $updateArr[$cv]['stream_id'] = $str_ids[$ck];
                $updateArr[$cv]['category_id'] = 2;
                $updateArr[$cv]['classification_id'] = 3;
                $updateArr[$cv]['updated_by'] = Auth::user()->id;
                $updateArr[$cv]['created_by'] = Auth::user()->id;
                $updateArr[$cv]['data_source'] = $data_source;
                if (!empty($request->ass)) {
                    foreach ($request->ass as $assprdkey => $assprdvalue) {
                        if ($new_prd_ids[$ck] != 0) {
                            foreach ($request->objassprd as $ok => $ov) {
                                if (!empty($newstridarr) && in_array($ok, $newstridarr)) {
                                    if ($ov[$assprdkey] != 0) {
                                        $assoUpdateArr[$ok][___decrypt($assprdvalue)] = $ov[$assprdkey];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $getPropIdsVal = [];
    $new_prd_ids_update = [];
    $updateid = [];
    if (!empty($updateArr)) {
        foreach ($updateArr as $key => $value) {
            $updateid[$key] =
                [
                    'id' => $value['chem_id'], 'chemical_name' => $value['chemical_name'], 'product_type_id' => 1, 'category_id' => $value['category_id'], 'classification_id' => $value['classification_id'],
                    'updated_by' => $value['updated_by'], 'created_by' => $value['created_by']
                ];
            if ($value['chem_id'] != 0) {
                $new_prd_ids_update[$key] = $value['chem_id'];
            }
        }
    }
    if (!empty($new_prd_ids_update)) {
        $getPropIds = ChemicalProperties::select('id')->whereIn('product_id', $new_prd_ids_update)->where(['property_id' => 2, 'sub_property_id' => 3])->get();
    }
    if (!empty($getPropIds)) {
        $ids = array_column($getPropIds->toArray(), 'id');
        ChemicalProperties::destroy($ids);
    }
    if (!empty($updateid)) {
        foreach ($updateid as $ukey => $uval) {
            $f = Chemical::where('id', $uval['id'])->update($uval);
        }
    }
    $new_oroduct_arr = [];
    $id = [];
    if (!empty($saveArr)) {
        foreach ($saveArr as $key => $value) {
            $id[$key] = Chemical::insertGetId(
                [
                    'chemical_name' => $value['chemical_name'], 'product_type_id' => 1, 'category_id' => $value['category_id'], 'classification_id' => $value['classification_id'],
                    'updated_by' => $value['updated_by'], 'created_by' => $value['created_by']
                ]
            );
        }
    }
    $simulation_product = ProcessSimulation::select(['product'])->find($request['process_id']);
    $simulation_productArr = [];
    $cnt = count($simulation_product['product']);
    if (!empty($id)) {
        foreach ($id as $key => $val) {
            if (array_key_exists($key, $saveArr)) {
                $new_oroduct_arr[$key]['process_id'] = $saveArr[$key]['process_id'];
                $new_oroduct_arr[$key]['new_product_id'] = $val;
                $new_oroduct_arr[$key]['prd_id'] = $saveArr[$key]['chem_id'];;
                $new_oroduct_arr[$key]['stream_id'] = $saveArr[$key]['stream_id'];
                $new_oroduct_arr[$key]['datasource'] = $saveArr[$key]['data_source'];
                $new_oroduct_arr[$key]['simulation_type'] = $saveArr[$key]['simulation_type'];;
                $new_oroduct_arr[$key]['updated_by'] = Auth::user()->id;
                $new_oroduct_arr[$key]['created_by'] = Auth::user()->id;
            }
        }
    }
    $existing_product = $simulation_product['product'];
    $prop_json = [];
    $dynamic_prop_json = [];
    $dynamic_prop_json_update = [];
    $prop_json_update = [];
    if (!empty($assoSaveArr)) {
        foreach ($assoSaveArr as $assprdkey => $assprdvalue) {
            foreach ($assprdvalue as $ak => $v) {
                $dynamic_prop_json[$assprdkey][$ak]['id'] = 0;
                $dynamic_prop_json[$assprdkey][$ak]['unit_id'] = "chemical_list";
                $dynamic_prop_json[$assprdkey][$ak]['field_type_id'] = 5;
                $dynamic_prop_json[$assprdkey][$ak]['value'] = ($v);
                $dynamic_prop_json[$assprdkey][$ak]['unit_constant_id'] = ($ak);
                $prop_json[$assprdkey] = getpropData();
            }
        }
    }
    if (!empty($assoUpdateArr)) {
        foreach ($assoUpdateArr as $updatekey => $pdatevalue) {
            foreach ($pdatevalue as $akupdate => $updateval) {
                $dynamic_prop_json_update[$updatekey][$akupdate]['id'] = 0;
                $dynamic_prop_json_update[$updatekey][$akupdate]['unit_id'] = "chemical_list";
                $dynamic_prop_json_update[$updatekey][$akupdate]['field_type_id'] = 5;
                $dynamic_prop_json_update[$updatekey][$akupdate]['value'] = ($updateval);
                $dynamic_prop_json_update[$updatekey][$akupdate]['unit_constant_id'] = ($akupdate);
                $prop_json_update[$updatekey] = getpropData();
            }
        }
    }
    $create_property = [];
    if (!empty($id)) {
        foreach ($id as $key => $val) {
            $simulation_productArr[$key]['id'] = $cnt;
            $simulation_productArr[$key]['product'] = "ch_" . $val;
            if (!empty($dynamic_prop_json)) {
                foreach ($dynamic_prop_json as $dkey => $dval) {
                    if ($dkey == $key) {
                        foreach ($dval as $dkd => $dd) {
                            $newdd = array($dd);
                            $create_property[] = [
                                "dynamic_prop_json" => $newdd, "product_id" => $val, "prop_json" => $prop_json[$key],
                                "property_id" => 2, "sub_property_id" => 3, "order_by" => 1, "created_by" => Auth::user()->id, "updated_by" => Auth::user()->id
                            ];
                        }
                    }
                }
            }
            $cnt++;
        }
    }
    if (!empty($new_prd_ids_update)) {
        $update_property = updateProp($new_prd_ids_update, $dynamic_prop_json_update, $prop_json_update);
    }
    if (!empty($create_property)) {
        createProductProp($create_property);
    }
    if (!empty($update_property)) {
        createProductProp($update_property);
    }
    $newArr = array_merge($existing_product, $simulation_productArr);
    $flg = updateSimulation($newArr, $request['process_id']);
    $newid = [];
    if (!empty($new_oroduct_arr)) {
        foreach ($new_oroduct_arr as $key => $value) {
            $newid[] = ProductCreation::insertGetId(
                [
                    'process_id' => $value['process_id'], 'simulation_type' => $value['simulation_type'], 'new_product_id' => $value['new_product_id'],
                    'product_id' => $value['prd_id'], 'stream_id' => $value['stream_id'], 'datasource' => $value['datasource'], 'updated_by' => $value['updated_by'], 'created_by' => $value['created_by']
                ]
            );
        }
    }
    return $newid;
}
