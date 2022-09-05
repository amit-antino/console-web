<?php

namespace App\Http\Controllers\Console\Chemicals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Chemical;
use App\Models\Product\ChemicalProperties;
use App\Models\Master\Chemical\ChemicalPropertyMaster;
use App\Models\Master\Chemical\ChemicalSubPropertyMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PropertiesController extends Controller
{
    public function index($chemical_id)
    {
        $chemical_id = ___decrypt($chemical_id);
        $data['product'] = Chemical::find($chemical_id);
        $properties = ChemicalPropertyMaster::select('id', 'property_name')->where(['status' => 'active'])->get();
        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $prop[$key]['id'] = $property->id;
                $prop[$key]['property_name'] = $property->property_name;
                if (!empty($property->sub_property_data)) {
                    foreach ($property->sub_property_data as $sub_key => $sub_prop) {
                        $prop[$key]['sub_property'][$sub_key]['sub_property_id'] = $sub_prop->id;
                        $prop[$key]['sub_property'][$sub_key]['sub_property_name'] = $sub_prop->sub_property_name;
                        $sub_prop_merge_array = array_merge($sub_prop->dynamic_fields, $sub_prop->fields);
                        $prop[$key]['sub_property'][$sub_key]['dynamic_fields'] = $sub_prop_merge_array;
                        $chemical_prop = ChemicalProperties::where(['product_id' => $chemical_id, 'property_id' => $sub_prop->property_id, 'sub_property_id' => $sub_prop->id])->get();
                        if (!empty(_arefy($chemical_prop))) {
                            foreach ($chemical_prop as $key_chem_prop => $chem_prop) {
                                $prop[$key]['sub_property'][$sub_key]['chemical_properties'][$key_chem_prop]['id'] = $chem_prop->id;
                                $prop[$key]['sub_property'][$sub_key]['chemical_properties'][$key_chem_prop]['product_id'] = $chem_prop->product_id;
                                $merge_array = array_merge($chem_prop->dynamic_prop_json, $chem_prop->prop_json);
                                $dynamic = [];

                                foreach ($merge_array as $fields_key => $dynamic_val) {
                                    if ($chem_prop->sub_property_id == $sub_prop->id) {
                                        $dynamic[$fields_key]['id'] = !empty($dynamic_val['id']) ? $dynamic_val['id'] : '';
                                        $dynamic[$fields_key]['field_type_id'] = !empty($dynamic_val['field_type_id']) ? $dynamic_val['field_type_id'] : '';
                                        $dynamic[$fields_key]['value'] = !empty($dynamic_val['value']) ? $dynamic_val['value'] : '';
                                        $dynamic[$fields_key]['field_name'] = !empty($sub_prop_merge_array[$fields_key]['field_name']) ? $sub_prop_merge_array[$fields_key]['field_name'] : '';
                                        $arr = array(5, 6, 7, 13);
                                        $select_list = [];
                                        if (in_array($dynamic_val['field_type_id'], $arr)) {
                                            $dynamic[$fields_key]['unit_constant_id'] = !empty($dynamic_val['unit_constant_id']) ? $dynamic_val['unit_constant_id'] : '';
                                            if ($dynamic_val['field_type_id'] == 13) {
                                                foreach ($dynamic_val['add_more_key'] as $add_key => $add_more) {
                                                    if (!empty($add_more['unit_id'])) {
                                                        foreach ($add_more['unit_id'] as $constant_id => $unit_id) {
                                                            $select_list[$add_key]['refrence_source'] = !empty($add_more['refrence_source']) ? $add_more['refrence_source'] : '';
                                                            $select_list[$add_key]['add_more_id'] = !empty($add_more['id']) ? $add_more['id'] : '';
                                                            $select_list[$add_key]['recommended'] = !empty($add_more['recommended']) ? $add_more['recommended'] : 'off';
                                                            $unit_constant_id = !empty($add_more['unit_constant_id'][$constant_id]) ? $add_more['unit_constant_id'][$constant_id] : '';
                                                            $values = !empty($add_more['value'][$constant_id]) ? $add_more['value'][$constant_id] : '';
                                                            $select_list[$add_key]['add_more'][] = get_dynamic_list($unit_id, $property->id, $unit_constant_id, $values);
                                                        }
                                                    }
                                                }
                                            } else {
                                                $dynamic[$fields_key]['unit_id'] = !empty($dynamic_val['unit_id']) ? $dynamic_val['unit_id'] : '';
                                                $select_list = get_dynamic_list($dynamic_val['unit_id'], $property->id);
                                            }
                                            $dynamic[$fields_key]['select_list'] = !empty($select_list) ? $select_list : [];
                                        }
                                    }
                                }

                                $prop[$key]['sub_property'][$sub_key]['chemical_properties'][$key_chem_prop]['dynamic_json'] = $dynamic;
                                $prop[$key]['sub_property'][$sub_key]['chemical_properties'][$key_chem_prop]['recommended'] = $chem_prop->recommended;
                                $prop[$key]['sub_property'][$sub_key]['chemical_properties'][$key_chem_prop]['created_at'] = dateTimeFormate($chem_prop->created_at);
                                $prop[$key]['sub_property'][$sub_key]['chemical_properties'][$key_chem_prop]['updated_at'] = dateTimeFormate($chem_prop->updated_at);
                            }
                        }
                    }
                }
            }
        }
        $data['properties'] = $prop;
        $data['main_porperty'] = $properties;
        return view('pages.console.product.chemical.manage_properties.list', $data);
    }

    public function subProperty(Request $request, $chemical_id, $property_id, $type)
    {
        $chemical_id = ___decrypt($chemical_id);
        $property_id = ___decrypt($property_id);
        $product = Chemical::Select('id', 'classification_id', 'chemical_name')->where(['id' => $chemical_id])->first();
        $property = ChemicalPropertyMaster::select('id', 'property_name')->where(['id' => $property_id])->first();
        $properties['product_id'] = $product->id;
        $properties['product_name'] = $product->chemical_name;
        $properties['classification_id'] = $product->classification_id;
        $properties['property_id'] = $property->id;
        $properties['property_name'] = $property->property_name;
        if ($type == 'form') {
            $sub_property_id = ___decrypt($request->parameters);
            $sub_prop = ChemicalSubPropertyMaster::where('id', $sub_property_id)->first();
            if (!empty($sub_prop)) {
                $properties['sub_property']['id'] = $sub_prop->id;
                $properties['sub_property']['sub_property_name'] = $sub_prop->sub_property_name;
                foreach ($sub_prop->dynamic_fields as $fields_key => $dynamic_fields) {
                    $dynamic[$fields_key]['id'] = !empty($dynamic_fields['id']) ? $dynamic_fields['id'] : '';
                    $dynamic[$fields_key]['field_name'] = !empty($dynamic_fields['field_name']) ? $dynamic_fields['field_name'] : '';
                    $dynamic[$fields_key]['field_type_id'] = !empty($dynamic_fields['field_type_id']) ? $dynamic_fields['field_type_id'] : '';
                    $arr = array(5, 6, 7, 13);
                    $select_list = [];
                    if (in_array($dynamic_fields['field_type_id'], $arr)) {
                        $dynamic[$fields_key]['unit_id'] = !empty($dynamic_fields['unit_id']) ? $dynamic_fields['unit_id'] : '';
                        if ($dynamic_fields['field_type_id'] == 13) {
                            foreach ($dynamic_fields['unit_id'] as $unit_id) {
                                $select_list[] = get_dynamic_list($unit_id, $property->id);
                            }
                        } else {
                            $select_list = get_dynamic_list($dynamic_fields['unit_id'], $property->id);
                        }
                        $dynamic[$fields_key]['select_list'] = !empty($select_list) ? $select_list : [];
                    }
                }
                foreach ($sub_prop->fields as $fields_key => $static_fields) {
                    $static[$fields_key]['id'] = !empty($static_fields['id']) ? $static_fields['id'] : '';
                    $static[$fields_key]['field_name'] = !empty($static_fields['field_name']) ? $static_fields['field_name'] : '';
                    $static[$fields_key]['field_type_id'] = !empty($static_fields['field_type_id']) ? $static_fields['field_type_id'] : '';
                }
                $properties['sub_property']['fields'] = $static;
                $properties['sub_property']['dynamic_fields'] = $dynamic;
            }
            return response()->json([
                'status' => true,
                'html' => view('pages.console.product.chemical.manage_properties.add.dynamic-form', ['properties' => $properties])->render()
            ]);
        } else {
            if (!empty($property->sub_property_data)) {
                foreach ($property->sub_property_data as $sub_key => $sub_prop) {
                    $properties['sub_properties'][$sub_key]['id'] = $sub_prop->id;
                    $properties['sub_properties'][$sub_key]['sub_property_name'] = $sub_prop->sub_property_name;
                }
            }
            return response()->json([
                'status' => true,
                'html' => view('pages.console.product.chemical.manage_properties.add', ['property' => $properties])->render()
            ]);
        }
    }

    public function edit($product_id, $chemical_property_id)
    {
        $product_id = ___decrypt($product_id);
        $chemical_property_id = ___decrypt($chemical_property_id);
        $product = Chemical::Select('id', 'classification_id', 'chemical_name')->where(['id' => $product_id])->first();
        $chemical_properties = ChemicalProperties::find($chemical_property_id);
        $property = ChemicalPropertyMaster::select('id', 'property_name')->where(['id' => $chemical_properties->property_id])->first();
        $properties['chemical_property_id'] = $chemical_property_id;
        $properties['product_id'] = $product->id;
        $properties['product_name'] = $product->chemical_name;
        $properties['classification_id'] = $product->classification_id;
        $properties['property_id'] = $property->id;
        $properties['sub_property_id'] = $chemical_properties->sub_property_id;
        $properties['property_name'] = $property->property_name;
        $sub_prop = $chemical_properties->sub_property_prop;
        if (!empty($sub_prop)) {
            $properties['sub_property']['id'] = $sub_prop->id;
            $properties['sub_property']['sub_property_name'] = $sub_prop->sub_property_name;
            $dynamic = [];
            $fields = [];
            foreach ($chemical_properties->dynamic_prop_json as $fields_key => $dynamic_val) {
                if ($chemical_properties->sub_property_id == $sub_prop->id) {
                    $dynamic[$fields_key]['id'] = !empty($dynamic_val['id']) ? $dynamic_val['id'] : 0;
                    $dynamic[$fields_key]['field_type_id'] = !empty($dynamic_val['field_type_id']) ? $dynamic_val['field_type_id'] : '';
                    $dynamic[$fields_key]['value'] = !empty($dynamic_val['value']) ? $dynamic_val['value'] : '';
                    $dynamic[$fields_key]['field_name'] = !empty($sub_prop->dynamic_fields[$fields_key]['field_name']) ? $sub_prop->dynamic_fields[$fields_key]['field_name'] : '';
                    $arr = array(5, 6, 7, 13);
                    $select_list = [];
                    if (in_array($dynamic_val['field_type_id'], $arr)) {
                        $dynamic[$fields_key]['unit_constant_id'] = !empty($dynamic_val['unit_constant_id']) ? $dynamic_val['unit_constant_id'] : '';
                        if ($dynamic_val['field_type_id'] == 13) {
                            foreach ($dynamic_val['add_more_key'] as $add_key => $add_more) {
                                $select_list[$add_key]['refrence_source'] = !empty($add_more['refrence_source']) ? $add_more['refrence_source'] : '';
                                $select_list[$add_key]['recommended'] = !empty($add_more['recommended']) ? $add_more['recommended'] : 'off';
                                foreach ($add_more['unit_id'] as $constant_id => $unit_id) {
                                    $unit_constant_id = !empty($add_more['unit_constant_id'][$constant_id]) ? $add_more['unit_constant_id'][$constant_id] : '';
                                    $values = !empty($add_more['value'][$constant_id]) ? $add_more['value'][$constant_id] : '';
                                    $select_list[$add_key]['add_more'][] = get_dynamic_list($unit_id, $property->id, $unit_constant_id, $values);
                                }
                            }
                        } else {
                            $dynamic[$fields_key]['unit_id'] = !empty($dynamic_val['unit_id']) ? $dynamic_val['unit_id'] : '';
                            $select_list = get_dynamic_list($dynamic_val['unit_id'], $property->id);
                        }
                        $dynamic[$fields_key]['select_list'] = !empty($select_list) ? $select_list : [];
                    }
                }
            }
            foreach ($chemical_properties->prop_json as $fields_keyss => $static_val) {
                if ($chemical_properties->sub_property_id == $sub_prop->id) {
                    $fields[$fields_keyss]['id'] = !empty($static_val['id']) ? $static_val['id'] : 0;
                    $fields[$fields_keyss]['field_type_id'] = !empty($static_val['field_type_id']) ? $static_val['field_type_id'] : '';
                    $fields[$fields_keyss]['value'] = !empty($static_val['value']) ? $static_val['value'] : '';
                    $fields[$fields_keyss]['field_name'] = !empty($sub_prop->fields[$fields_keyss]['field_name']) ? $sub_prop->fields[$fields_keyss]['field_name'] : '';
                }
            }
            $properties['sub_property']['dynamic_fields'] = $dynamic;
            $properties['sub_property']['fields'] = $fields;
        }
        $sub_props = ChemicalSubPropertyMaster::where('property_id', $property->id)->get();
        foreach ($sub_props as $key_sub_prop => $sub_prop_list) {
            $sub_prop_lists[$key_sub_prop]['id'] = $sub_prop_list['id'];
            $sub_prop_lists[$key_sub_prop]['sub_property_name'] = $sub_prop_list['sub_property_name'];
        }
        $properties['sub_prop_list'] = $sub_prop_lists;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.product.chemical.manage_properties.edit', ['property' => $properties])->render()
        ]);
    }

    public function store(Request $request, $chemical_id)
    {
        $validations = [
            'property_id' => ['required'],
        ];
        $customMessages = [
            'dynamic_prop.*.value.required' => 'The unit type field is required.'
        ];
        $validator = Validator::make($request->all(), $validations, $customMessages);
        if (___decrypt($request->main_property_id) == 2) {
            $total_val = total_chemical_composition(___decrypt($chemical_id), !empty($request->property_id) ? ___decrypt($request->property_id) : 0, ___decrypt($request->main_property_id), $request);
            if ($total_val > 100) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('property_id', 'You can not total Add more than 100.');
                });
            }
        }
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $subprop = ChemicalProperties::where(['product_id' => ___decrypt($chemical_id), 'sub_property_id' => ___decrypt($request->property_id), 'property_id' => ___decrypt($request->main_property_id), 'recommended' => 'on'])->first();
            $chemprop = new ChemicalProperties();
            $prop = array();
            foreach ($request->prop as $prop_key => $prop_value) {
                $prop[$prop_key]['id'] = $prop_key;
                $prop[$prop_key]['field_type_id'] = !empty($prop_value['type']) ? $prop_value['type'] : '';
                $prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : 0;
            }
            foreach ($request->dynamic_prop as $prop_key => $prop_value) {
                $dynamic_prop[$prop_key]['id'] = $prop_key;
                $dynamic_prop[$prop_key]['field_type_id'] = !empty($prop_value['type']) ? $prop_value['type'] : '';
                if ($prop_value['type'] == '5' || $prop_value['type'] == '6') {
                    $dynamic_prop[$prop_key]['unit_id'] = !empty($prop_value['unit_id']) ? $prop_value['unit_id'] : '';
                    $dynamic_prop[$prop_key]['unit_constant_id'] = !empty($prop_value['unit_constant_id']) ? ___decrypt($prop_value['unit_constant_id']) : '';
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : 0;
                } elseif ($prop_value['type'] == '11') {
                    $folder_name = 'chemical_properties';
                    if (!empty($prop_value['value'])) {
                        $file       = $prop_value['value'];
                        $file_name  = $file->getClientOriginalName();
                        $file->move('uploads/' . $folder_name, $file_name);
                        $dynamic_prop[$prop_key]['value'] = asset('uploads/' . $folder_name . '/' . $file_name);
                    } else {
                        $dynamic_prop[$prop_key]['value'] = '';
                    }
                } elseif ($prop_value['type'] == '7') {
                    $dynamic_prop[$prop_key]['unit_id'] = !empty($prop_value['unit_id']) ? $prop_value['unit_id'] : '';
                    $unit_cons = [];
                    if (!empty($prop_value['unit_constant_id'])) {
                        foreach ($prop_value['unit_constant_id'] as  $unit_constant_id) {
                            $unit_cons[] = ___decrypt($unit_constant_id);
                        }
                    }
                    $dynamic_prop[$prop_key]['unit_constant_id'] = $unit_cons;
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : 0;
                    if (!empty($prop_value['value'])) {
                        foreach ($prop_value['value'] as $key => $multiValue) {
                            $valMulti[$key] = ___decrypt($multiValue);
                        }
                        $dynamic_prop[$prop_key]['value'] = $valMulti;
                    }
                } elseif ($prop_value['type'] == '13') {
                    $add_more_key = [];
                    foreach ($prop_value['add_more'] as $keyss_old => $addMore) {
                        $add_more_key[$keyss_old]['id'] = $keyss_old + 1;
                        if (!empty($addMore['unit_constant_id'])) {
                            foreach ($addMore['unit_constant_id'] as $ck => $cons_unit_id) {
                                $add_const_id[$ck] = ___decrypt($cons_unit_id);
                            }
                            $add_more_key[$keyss_old]['unit_constant_id'] = $add_const_id;
                        }
                        if (!empty($addMore['unit_id'])) {
                            $add_more_key[$keyss_old]['unit_id'] = $addMore['unit_id'];
                        }
                        if (!empty($addMore['value'])) {
                            $add_more_key[$keyss_old]['value'] = $addMore['value'];
                        }
                        if (!empty($addMore['refrence_source'])) {
                            $add_more_key[$keyss_old]['refrence_source'] = $addMore['refrence_source'];
                        }
                        if (!empty($addMore['recommended'])) {
                            $add_more_key[$keyss_old]['recommended'] = $addMore['recommended'];
                        }
                    }
                    $dynamic_prop[$prop_key]['add_more_key'] = $add_more_key;
                } else {
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : 0;
                }
            }
            $chemprop->prop_json = $prop;
            $chemprop->dynamic_prop_json = $dynamic_prop;
            $chemprop->product_id = ___decrypt($chemical_id);
            $chemprop->sub_property_id = ___decrypt($request->property_id);
            $chemprop->property_id = ___decrypt($request->main_property_id);
            $chemprop->order_by = 1;
            if (empty($subprop)) {
                $chemprop->recommended = 'on';
            } else {
                $chemprop->recommended = 'off';
            }
            $chemprop->created_by = Auth::user()->id;
            $chemprop->updated_by = Auth::user()->id;
            $chemprop->save();
            $this->status = true;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Chemical Property Record Updated !";
        }
        return $this->populateresponse();
    }

    public function update(Request $request, $chemical_id, $id)
    {
        $validations = [
            'property_id' => ['required']
        ];
        $customMessages = [
            'dynamic_prop.*.value.required' => 'The unit type field is required.'
        ];
        $validator = Validator::make($request->all(), $validations, $customMessages);
        if (___decrypt($request->main_property_id) == 2) {
            $total_val = total_chemical_composition(___decrypt($chemical_id), ___decrypt($request->property_id), ___decrypt($request->main_property_id), $request, $id);
            if ($total_val > 100) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('property_id', 'You can not total Add more than 100.');
                });
            }
        }
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $subprop = ChemicalProperties::where(['product_id' => ___decrypt($chemical_id), 'sub_property_id' => ___decrypt($request->property_id), 'property_id' => ___decrypt($request->main_property_id), 'recommended' => 'on'])->first();
            $chemical_property_edit = ChemicalProperties::find(___decrypt($id));
            $prop = array();
            foreach ($request->prop as $prop_key => $prop_value) {
                $prop[$prop_key]['id'] = $prop_key;
                $prop[$prop_key]['field_type_id'] = !empty($prop_value['type']) ? $prop_value['type'] : '';
                $prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : 0;
            }
            foreach ($request->dynamic_prop as $prop_key => $prop_value) {
                $dynamic_prop[$prop_key]['id'] = $prop_key;
                $dynamic_prop[$prop_key]['field_type_id'] = !empty($prop_value['type']) ? $prop_value['type'] : '';
                if ($prop_value['type'] == '5' || $prop_value['type'] == '6') {
                    $dynamic_prop[$prop_key]['unit_id'] = !empty($prop_value['unit_id']) ? $prop_value['unit_id'] : '';
                    $dynamic_prop[$prop_key]['unit_constant_id'] = !empty($prop_value['unit_constant_id']) ? ___decrypt($prop_value['unit_constant_id']) : '';
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : 0;
                } elseif ($prop_value['type'] == '11') {
                    $folder_name = 'chemical_properties';
                    $file       = $prop_value['value'];
                    $file_name  = $file->getClientOriginalName();
                    $file->move('uploads/' . $folder_name, $file_name);
                    $dynamic_prop[$prop_key]['value'] = asset('uploads/' . $folder_name . '/' . $file_name);
                } elseif ($prop_value['type'] == '7') {
                    $dynamic_prop[$prop_key]['unit_id'] = !empty($prop_value['unit_id']) ? $prop_value['unit_id'] : '';
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : 0;
                    $unit_cons = [];
                    if (!empty($prop_value['unit_constant_id'])) {
                        foreach ($prop_value['unit_constant_id'] as  $unit_constant_id) {
                            $unit_cons[] = ___decrypt($unit_constant_id);
                        }
                    }
                    $dynamic_prop[$prop_key]['unit_constant_id'] = $unit_cons;
                } elseif ($prop_value['type'] == '13') {
                    $add_more_key = [];
                    foreach ($prop_value['add_more'] as $keyss_old => $addMore) {
                        $add_more_key[$keyss_old]['id'] = $keyss_old + 1;
                        if (!empty($addMore['unit_constant_id'])) {
                            foreach ($addMore['unit_constant_id'] as $ck => $cons_unit_id) {
                                $add_const_id[$ck] = ___decrypt($cons_unit_id);
                            }
                            $add_more_key[$keyss_old]['unit_constant_id'] = $add_const_id;
                        }
                        if (!empty($addMore['unit_id'])) {
                            $add_more_key[$keyss_old]['unit_id'] = $addMore['unit_id'];
                        }
                        if (!empty($addMore['value'])) {
                            $add_more_key[$keyss_old]['value'] = $addMore['value'];
                        }
                        if (!empty($addMore['refrence_source'])) {
                            $add_more_key[$keyss_old]['refrence_source'] = $addMore['refrence_source'];
                        }
                        if (!empty($addMore['recommended'])) {
                            $add_more_key[$keyss_old]['recommended'] = $addMore['recommended'];
                        }
                    }
                    $dynamic_prop[$prop_key]['add_more_key'] = $add_more_key;
                } else {
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : 0;
                }
            }
            $chemical_property_edit->prop_json = $prop;
            $chemical_property_edit->dynamic_prop_json = $dynamic_prop;
            $chemical_property_edit->product_id = ___decrypt($chemical_id);
            $chemical_property_edit->sub_property_id = ___decrypt($request->property_id);
            $chemical_property_edit->property_id = ___decrypt($request->main_property_id);
            $chemical_property_edit->order_by = 1;
            if (empty(_arefy($subprop))) {
                $chemical_property_edit->recommended = 'on';
            }
            $chemical_property_edit->updated_by = Auth::user()->id;
            $chemical_property_edit->updated_at = now();
            $chemical_property_edit->save();
            $this->status = true;
            $this->alert = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Chemical Property Record updated !";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $chemid, $id)
    {
        if ($request->type == 'add_more') {
            $msg = "Chemical Property status successfully changed.";
            $chemprop = ChemicalProperties::find(___decrypt($id));
            $chemprop->dynamic_prop_json;
            $update_json = [];
            foreach ($chemprop->dynamic_prop_json as $key_json => $dynamic_json) {
                $update_json[$key_json]['id'] = $dynamic_json['id'];
                $update_json[$key_json]['field_type_id'] = $dynamic_json['field_type_id'];
                if (!empty($dynamic_json['add_more_key'])) {
                    foreach ($dynamic_json['add_more_key'] as $key_add_more => $add_more) {
                        $update_json[$key_json]['add_more_key'][$key_add_more]['id'] = $add_more['id'];
                        $update_json[$key_json]['add_more_key'][$key_add_more]['unit_constant_id'] = $add_more['unit_constant_id'];
                        $update_json[$key_json]['add_more_key'][$key_add_more]['unit_id'] = $add_more['unit_id'];
                        $update_json[$key_json]['add_more_key'][$key_add_more]['value'] = $add_more['value'];
                        $update_json[$key_json]['add_more_key'][$key_add_more]['refrence_source'] = !empty($add_more['refrence_source']) ? $add_more['refrence_source'] : '';
                        if ($add_more['id'] == $request->add_more_id) {
                            $update_json[$key_json]['add_more_key'][$key_add_more]['recommended'] = 'on';
                        } else {
                            $update_json[$key_json]['add_more_key'][$key_add_more]['recommended'] = 'off';
                        }
                    }
                }
            }
            $chemprop->dynamic_prop_json = $update_json;
            $chemprop->save();
        } else {
            $chemprop = ChemicalProperties::find(___decrypt($id));
            if (!empty($request->status) || !empty($request->type)) {
                $msg = "Chemical Property status successfully changed.";

                $update['recommended'] = 'off';
                ChemicalProperties::where(['product_id' => $chemprop->product_id, 'property_id' => $chemprop->property_id, 'sub_property_id' => $chemprop->sub_property_id])->update($update);
                $chemprop_update = ChemicalProperties::find(___decrypt($id));
                $chemprop_update->recommended = 'on';
                $chemprop_update->updated_by = Auth::user()->id;
                $chemprop_update->updated_at = now();
                $chemprop_update->save();
            } else {
                $msg = "Chemical property deleted successfully.";

                $chemprop->delete();
            }
        }
        $this->redirect = true;
        $this->status = true;
        $this->alert = true;
        $this->modal = true;
        $this->message = $msg;
        return $this->populateresponse();
    }

    public function addMoreDynamicFields(Request $request)
    {
        $units_id = explode(',', $request->type);
        foreach ($units_id as $unit_id) {
            $select_list[] = get_dynamic_list($unit_id, 0);
        }
        return response()->json([
            'status' => true,
            'html' => view("pages.console.product.chemical.manage_properties.add.add-more-dynamic-form", ['count' => $request->count, 'select_list' => $select_list, 'new_count' => $request->new_count, 'property_id' => 1])->render()
        ]);
    }

    public function get_property_sub_property(Request $request)
    {
        try {
            $props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'recommended', 'created_by')->where([
                'product_id' => $request->product_id, 'sub_property_id' => $request->sub_property_id, 'property_id' => $request->property_id, 'recommended' => 'on'
            ])->first();
            $pro_value = [];
            if (!empty($props)) {
                $pro_value = get_properties_details_sub($props);
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $pro_value
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

    public function get_property_sub_properties(Request $request)
    {
        try {
            $data_props = ChemicalProperties::where([
                'product_id' => $request->product_id, 'property_id' => $request->property_id
            ])->get();
            $props_details = [];
            if (!empty($data_props)) {
                foreach ($data_props as $props) {
                    $pro_value = get_properties_details_sub($props);
                    $props_details[] = [
                        'property_id' => $props->property_id,
                        'sub_property_id' => $props->sub_property_id,
                        'property_details' => $pro_value,
                    ];
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function get_properties(Request $request)
    {
        $props_details = get_product_properties_helper($request->product_id);
        //dd($props_details);
        return response()->json([
            'success' => true,
            'status_code' => 200,
            'status' => true,
            'data' => $props_details
        ]);
    }

    public function product_pricing(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 197, 'recommended' => 'on'])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_pricing($props->dynamic_prop_json, 1, 6, $props->created_by, $props->property_id, $props->sub_property_id);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_sustainability_ced(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 184])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props, 1);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_sustainability_ghge(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 186])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_sustainability_carbon_content(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 183])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props, 2);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_sustainability_water_usage(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 190])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_sustainability_eutrophication_potential(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 185])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_lower_heat_value(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 90])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_molecular_weight(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 103])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_boiling_point(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 9])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_density(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 29])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_dynamic_viscosity(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 35])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_self_diffusion_coefficient_liquid(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 112])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_vapor_pressure(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 143])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_solubility(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 118])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_mass_transfer_coefficient(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 91])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_heat_capacity_gas(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 196])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_heat_capacity_solid(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 64])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_heat_capacity_liquid(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 63])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_heat_of_vaporization(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 70])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_enthalpy_of_formation(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 46])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_enthalpy_of_combustion(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 45])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function product_physio_chemical_melting_point(Request $request)
    {
        try {
            $product_props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => 94])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_conversion_details($props);
                if (!empty($pro_value)) {
                    $props_details = $pro_value;
                }
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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


    public function getSafetyDetail(Request $request)
    {
        try {
            $props_details = [];
            $sub_props = ChemicalSubPropertyMaster::select('id', 'property_id', 'dynamic_fields')->whereIn('id', [163, 198, 165, 180, 166, 105, 143, 105, 164, 175, 168, 105, 9, 143])->get();
            foreach ($sub_props as $sub_prop) {
                $props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => $sub_prop->id, 'recommended' => 'on'])->first();
                $pro_value = get_properties_details_safety($props, $sub_prop);
                $props_details[] = $pro_value;
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function get_product_properties_health(Request $request)
    {
        try {

            $props_details = [];
            $sub_props = ChemicalSubPropertyMaster::select('id', 'property_id', 'dynamic_fields')->whereIn('id', [171, 165, 170, 163, 180, 166, 198])->get();
            foreach ($sub_props as $sub_prop) {
                $props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => $sub_prop->id, 'recommended' => 'on'])->first();
                $pro_value = get_properties_details_safety($props, $sub_prop);
                $props_details[] = $pro_value;
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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

    public function get_product_properties_enviroment(Request $request)
    {
        try {

            $props_details = [];
            $sub_props = ChemicalSubPropertyMaster::select('id', 'property_id', 'dynamic_fields')->whereIn('id', [171, 165, 163, 180, 167, 169, 182, 166, 198, 102])->get();
            foreach ($sub_props as $sub_prop) {
                $props = ChemicalProperties::select('id', 'recommended', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by')->where(['product_id' => $request->product_id, 'sub_property_id' => $sub_prop->id, 'recommended' => 'on'])->first();
                $pro_value = get_properties_details_safety($props, $sub_prop);
                $props_details[] = $pro_value;
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $props_details
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
}
