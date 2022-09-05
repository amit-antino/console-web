<?php

namespace App\Http\Controllers\Console\OtherInput\Energy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherInput\EnergyUtility;
use App\Models\Master\EnergyUtilities\EnergyPropertyMaster;
use App\Models\OtherInput\EnergyUtilityProperty;
use App\Models\Master\EnergyUtilities\EnergySubPropertyMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PropertiesController extends Controller
{
    public function index($energy_id)
    {
        $energy_id = ___decrypt($energy_id);
        $data['product'] = EnergyUtility::find($energy_id);
        $properties = EnergyPropertyMaster::select('id', 'property_name')->where(['status' => 'active'])->get();
        if (!empty($properties)) {
            foreach ($properties as $key => $property) {
                $prop[$key]['id'] = $property->id;
                $prop[$key]['property_name'] = $property->property_name;
                if (!empty($property->energy_sub_property_data)) {
                    foreach ($property->energy_sub_property_data as $sub_key => $sub_prop) {
                        $prop[$key]['sub_property'][$sub_key]['sub_property_id'] = $sub_prop->id;
                        $prop[$key]['sub_property'][$sub_key]['sub_property_name'] = $sub_prop->sub_property_name;
                        $sub_prop_merge_array = array_merge($sub_prop->dynamic_fields, $sub_prop->fields);
                        $prop[$key]['sub_property'][$sub_key]['dynamic_fields'] = $sub_prop_merge_array;
                        $chemical_prop = EnergyUtilityProperty::where(['energy_id' => $energy_id, 'property_id' => $sub_prop->property_id, 'sub_property_id' => $sub_prop->id])->get();
                        if (!empty(_arefy($chemical_prop))) {
                            foreach ($chemical_prop as $key_chem_prop => $chem_prop) {
                                $prop[$key]['sub_property'][$sub_key]['energy_properties'][$key_chem_prop]['id'] = $chem_prop->id;
                                $prop[$key]['sub_property'][$sub_key]['energy_properties'][$key_chem_prop]['energy_id'] = $chem_prop->energy_id;
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
                                $prop[$key]['sub_property'][$sub_key]['energy_properties'][$key_chem_prop]['dynamic_json'] = $dynamic;
                                $prop[$key]['sub_property'][$sub_key]['energy_properties'][$key_chem_prop]['recommended'] = $chem_prop->recommended;
                                $prop[$key]['sub_property'][$sub_key]['energy_properties'][$key_chem_prop]['created_at'] = dateTimeFormate($chem_prop->created_at);
                                $prop[$key]['sub_property'][$sub_key]['energy_properties'][$key_chem_prop]['updated_at'] = dateTimeFormate($chem_prop->updated_at);
                            }
                        }
                    }
                }
            }
        }
        $data['properties'] = $prop;
        $data['main_porperty'] = $properties;
        return view('pages.console.other_input.energy.manage_properties.list', $data);
    }

    public function subProperty(Request $request, $energy_id, $property_id, $type)
    {
        $energy_id = ___decrypt($energy_id);
        $property_id = ___decrypt($property_id);
        $product = EnergyUtility::where(['id' => $energy_id])->first();
        $property = EnergyPropertyMaster::select('id', 'property_name')->where(['id' => $property_id])->first();
        $properties['product_id'] = $product->id;
        $properties['product_name'] = $product->energy_name;
        $properties['property_id'] = $property->id;
        $properties['property_name'] = $property->property_name;
        if ($type == 'form') {
            $sub_property_id = ___decrypt($request->parameters);
            $sub_prop = EnergySubPropertyMaster::where(['id' => $sub_property_id])->first();
            if (!empty($sub_prop)) {
                $properties['sub_property']['id'] = $sub_prop->id;
                $properties['sub_property']['sub_property_name'] = $sub_prop->sub_property_name;
                foreach ($sub_prop->dynamic_fields as $fields_key => $dynamic_fields) {
                    $dynamic[$fields_key]['id'] = !empty($dynamic_fields['id']) ? $dynamic_fields['id'] : '';
                    $dynamic[$fields_key]['field_name'] = !empty($dynamic_fields['field_name']) ? $dynamic_fields['field_name'] : '';
                    $dynamic[$fields_key]['field_type_id'] = !empty($dynamic_fields['field_type_id']) ? $dynamic_fields['field_type_id'] : '';
                    $dynamic[$fields_key]['unit_constant_id'] = !empty($dynamic_fields['unit_constant_id']) ? $dynamic_fields['unit_constant_id'] : '';
                    $arr = array(5, 6, 7, 13);
                    $select_list = [];
                    $unit_constant_id = !empty($dynamic_fields['unit_constant_id']) ? $dynamic_fields['unit_constant_id'] : '';
                    if (in_array($dynamic_fields['field_type_id'], $arr)) {
                        $dynamic[$fields_key]['unit_id'] = !empty($dynamic_fields['unit_id']) ? $dynamic_fields['unit_id'] : '';
                        if ($dynamic_fields['field_type_id'] == 13) {
                            foreach ($dynamic_fields['unit_id'] as $unit_id) {
                                $select_list[] = get_dynamic_list($unit_id, $property->id, $unit_constant_id);
                            }
                        } else {
                            $select_list = get_dynamic_list($dynamic_fields['unit_id'], $property->id, $unit_constant_id);
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
                'html' => view('pages.console.other_input.energy.manage_properties.add.dynamic-form', ['properties' => $properties])->render()
            ]);
        } else {
            $base_id[0] = $product->base_unit_type;
            $base_id[1] = 0;

            $sub_props = EnergySubPropertyMaster::where(['property_id' => $property->id])->WhereIn('base_unit', $base_id)->orderBy('sub_property_name', 'asc')->get();
            if (!empty($sub_props)) {
                foreach ($sub_props as $sub_key => $sub_prop) {
                    $properties['sub_properties'][$sub_key]['id'] = $sub_prop->id;
                    $properties['sub_properties'][$sub_key]['sub_property_name'] = $sub_prop->sub_property_name;
                }
            }
            return response()->json([
                'status' => true,
                'html' => view('pages.console.other_input.energy.manage_properties.add', ['property' => $properties])->render()
            ]);
        }
    }

    public function store(Request $request, $energy_id)
    {
        $validations = [
            'property_id' => ['required'],
            'dynamic_prop.*.value' => ['required']
        ];
        $customMessages = [
            'dynamic_prop.*.value.required' => 'The unit type field is required.'
        ];
        $validator = Validator::make($request->all(), $validations, $customMessages);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $subprop = EnergyUtilityProperty::where(['energy_id' => ___decrypt($energy_id), 'sub_property_id' => ___decrypt($request->property_id), 'property_id' => ___decrypt($request->main_property_id), 'recommended' => 'on'])->first();
            $chemprop = new EnergyUtilityProperty();
            $prop = array();
            foreach ($request->prop as $prop_key => $prop_value) {
                $prop[$prop_key]['id'] = $prop_key;
                $prop[$prop_key]['field_type_id'] = !empty($prop_value['type']) ? $prop_value['type'] : '';
                $prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : '';
            }
            foreach ($request->dynamic_prop as $prop_key => $prop_value) {
                $dynamic_prop[$prop_key]['id'] = $prop_key;
                $dynamic_prop[$prop_key]['field_type_id'] = !empty($prop_value['type']) ? $prop_value['type'] : '';
                if ($prop_value['type'] == '5' || $prop_value['type'] == '6') {
                    $dynamic_prop[$prop_key]['unit_id'] = !empty($prop_value['unit_id']) ? $prop_value['unit_id'] : '';
                    $dynamic_prop[$prop_key]['unit_constant_id'] = !empty($prop_value['unit_constant_id']) ? ___decrypt($prop_value['unit_constant_id']) : '';
                    $dynamic_prop[$prop_key]['default_constant_id'] = !empty($prop_value['default_constant_id']) ? ___decrypt($prop_value['default_constant_id']) : '';
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : '';
                } elseif ($prop_value['type'] == '11') {
                    $folder_name = 'energy_properties';
                    $file       = $prop_value['value'];
                    $file_name  = $file->getClientOriginalName();
                    $file->move('uploads/' . $folder_name, $file_name);
                    $dynamic_prop[$prop_key]['value'] = asset('uploads/' . $folder_name . '/' . $file_name);
                } elseif ($prop_value['type'] == '7') {
                    $dynamic_prop[$prop_key]['unit_id'] = !empty($prop_value['unit_id']) ? $prop_value['unit_id'] : '';
                    $dynamic_prop[$prop_key]['unit_constant_id'] = !empty($prop_value['unit_constant_id']) ? ___decrypt($prop_value['unit_constant_id']) : '';
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : '';
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
                            $add_more_key[$keyss_old]['unit_constant_id'] = ___decrypt($addMore['unit_constant_id']);
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
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : '';
                }
            }
            $chemprop->prop_json = $prop;
            $chemprop->dynamic_prop_json = $dynamic_prop;
            $chemprop->energy_id = ___decrypt($energy_id);
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
            $this->message = "Energy Utility Property Record Updated !";
        }
        return $this->populateresponse();
    }

    public function update(Request $request, $energy_id, $id)
    {
        $validations = [
            'property_id' => ['required'],
            'dynamic_prop.*.value' => ['required']
        ];
        $customMessages = [
            'dynamic_prop.*.value.required' => 'The unit type field is required.'
        ];
        $validator = Validator::make($request->all(), $validations, $customMessages);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $subprop = EnergyUtilityProperty::where(['energy_id' => ___decrypt($energy_id), 'sub_property_id' => ___decrypt($request->property_id), 'property_id' => ___decrypt($request->main_property_id), 'recommended' => 'on'])->first();
            $chemical_property_edit = EnergyUtilityProperty::find(___decrypt($id));
            $prop = array();
            foreach ($request->prop as $prop_key => $prop_value) {
                $prop[$prop_key]['id'] = $prop_key;
                $prop[$prop_key]['field_type_id'] = !empty($prop_value['type']) ? $prop_value['type'] : '';
                $prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : '';
            }
            foreach ($request->dynamic_prop as $prop_key => $prop_value) {
                $dynamic_prop[$prop_key]['id'] = $prop_key;
                $dynamic_prop[$prop_key]['field_type_id'] = !empty($prop_value['type']) ? $prop_value['type'] : '';
                if ($prop_value['type'] == '5' || $prop_value['type'] == '6') {
                    $dynamic_prop[$prop_key]['unit_id'] = !empty($prop_value['unit_id']) ? $prop_value['unit_id'] : '';
                    $dynamic_prop[$prop_key]['unit_constant_id'] = !empty($prop_value['unit_constant_id']) ? ___decrypt($prop_value['unit_constant_id']) : '';
                    $dynamic_prop[$prop_key]['default_constant_id'] = !empty($prop_value['default_constant_id']) ? ___decrypt($prop_value['default_constant_id']) : '';
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : '';
                } elseif ($prop_value['type'] == '11') {
                    $folder_name = 'energy_properties';
                    $file       = $prop_value['value'];
                    $file_name  = $file->getClientOriginalName();
                    $file->move('uploads/' . $folder_name, $file_name);
                    $dynamic_prop[$prop_key]['value'] = asset('uploads/' . $folder_name . '/' . $file_name);
                } elseif ($prop_value['type'] == '7') {
                    $dynamic_prop[$prop_key]['unit_id'] = !empty($prop_value['unit_id']) ? $prop_value['unit_id'] : '';
                    $dynamic_prop[$prop_key]['unit_constant_id'] = !empty($prop_value['unit_constant_id']) ? ___decrypt($prop_value['unit_constant_id']) : '';
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : '';
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
                            $add_more_key[$keyss_old]['unit_constant_id'] = ___decrypt($addMore['unit_constant_id']);
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
                    $dynamic_prop[$prop_key]['value'] = !empty($prop_value['value']) ? $prop_value['value'] : '';
                }
            }
            $chemical_property_edit->prop_json = $prop;
            $chemical_property_edit->dynamic_prop_json = $dynamic_prop;
            $chemical_property_edit->energy_id = ___decrypt($energy_id);
            $chemical_property_edit->sub_property_id = ___decrypt($request->property_id);
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
            $this->message = "Energy Utility Property Record updated !";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $energy_id, $id)
    {
        if ($request->type == 'add_more') {
            $chemprop = EnergyUtilityProperty::find(___decrypt($id));
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
            $chemprop = EnergyUtilityProperty::find(___decrypt($id));
            if (!empty($request->status) || !empty($request->type)) {
                $update['recommended'] = 'off';
                EnergyUtilityProperty::where(['energy_id' => $chemprop->energy_id, 'property_id' => $chemprop->property_id, 'sub_property_id' => $chemprop->sub_property_id])->update($update);
                $chemprop_update = EnergyUtilityProperty::find(___decrypt($id));
                $chemprop_update->recommended = 'on';
                $chemprop_update->updated_by = Auth::user()->id;
                $chemprop_update->updated_at = now();
                $chemprop_update->save();
            } else {
                $chemprop->delete();
            }
        }
        $this->status = true;
        $this->alert = true;
        $this->modal = true;
        $this->redirect = true;
        $this->message = "Energy Utility Property Record updated !";
        return $this->populateresponse();
    }

    public function edit($energy_id, $energy_property_id)
    {
        $energy_id = ___decrypt($energy_id);
        $energy_property_id = ___decrypt($energy_property_id);
        $product = EnergyUtility::where(['id' => $energy_id])->first();
        $energy_properties = EnergyUtilityProperty::find($energy_property_id);
        $property = EnergyPropertyMaster::select('id', 'property_name')->where(['id' => $energy_properties->property_id])->first();
        $properties['energy_property_id'] = $energy_property_id;
        $properties['energy_id'] = $product->id;
        $properties['product_name'] = $product->energy_name;
        $properties['property_id'] = $property->id;
        $properties['sub_property_id'] = $energy_properties->sub_property_id;
        $properties['property_name'] = $property->property_name;
        $sub_prop = EnergySubPropertyMaster::where('id', $energy_properties->sub_property_id)->first();
        if (!empty($sub_prop)) {
            $properties['sub_property']['id'] = $sub_prop->id;
            $properties['sub_property']['sub_property_name'] = $sub_prop->sub_property_name;
            $dynamic = [];
            $fields = [];
            foreach ($energy_properties->dynamic_prop_json as $fields_key => $dynamic_val) {
                if ($energy_properties->sub_property_id == $sub_prop->id) {
                    $dynamic[$fields_key]['id'] = !empty($dynamic_val['id']) ? $dynamic_val['id'] : 0;
                    $dynamic[$fields_key]['field_type_id'] = !empty($dynamic_val['field_type_id']) ? $dynamic_val['field_type_id'] : '';
                    $dynamic[$fields_key]['value'] = !empty($dynamic_val['value']) ? $dynamic_val['value'] : '';
                    $dynamic[$fields_key]['default_constant_id'] = !empty($dynamic_val['default_constant_id']) ? $dynamic_val['default_constant_id'] : '';
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
            foreach ($energy_properties->prop_json as $fields_keyss => $static_val) {
                if ($energy_properties->sub_property_id == $sub_prop->id) {
                    $fields[$fields_keyss]['id'] = !empty($static_val['id']) ? $static_val['id'] : 0;
                    $fields[$fields_keyss]['field_type_id'] = !empty($static_val['field_type_id']) ? $static_val['field_type_id'] : '';
                    $fields[$fields_keyss]['value'] = !empty($static_val['value']) ? $static_val['value'] : '';
                    $fields[$fields_keyss]['field_name'] = !empty($sub_prop->fields[$fields_keyss]['field_name']) ? $sub_prop->fields[$fields_keyss]['field_name'] : '';
                }
            }
            $properties['sub_property']['dynamic_fields'] = $dynamic;
            $properties['sub_property']['fields'] = $fields;
        }
        $sub_props = EnergySubPropertyMaster::where('property_id', $property->id)->get();
        foreach ($sub_props as $key_sub_prop => $sub_prop_list) {
            $sub_prop_lists[$key_sub_prop]['id'] = $sub_prop_list['id'];
            $sub_prop_lists[$key_sub_prop]['sub_property_name'] = $sub_prop_list['sub_property_name'];
        }
        $properties['sub_prop_list'] = $sub_prop_lists;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.other_input.energy.manage_properties.edit', ['property' => $properties])->render()
        ]);
    }

    public function addMoreDynamicFields(Request $request)
    {
        return response()->json([
            'status' => true,
            'html' => view("pages.console.other_input.energy.manage_properties.add.add-more-dynamic-form", ['count' => $request->count, 'unit_name' => $request->type, 'new_count' => $request->new_count, 'property_id' => 1])->render()
        ]);
    }

    public function energy_commercial_pricing(Request $request)
    {
        try {
            $energy = EnergyUtility::find($request->energy_id);
            if ($energy->base_unit_type == 7) {
                $sub_property_id = 4;
            } elseif ($energy->base_unit_type == 6) {
                $sub_property_id = 39;
            } elseif ($energy->base_unit_type == 2) {
                $sub_property_id = 38;
            } else {
                $sub_property_id = 0;
            }
            $product_props = EnergyUtilityProperty::select('id', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'created_by', 'recommended')->where(['energy_id' => $request->energy_id, 'sub_property_id' => $sub_property_id, 'recommended' => 'on'])->get();
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

    public function energy_sustainability_info_ced(Request $request)
    {
        try {
            $energy = EnergyUtility::find($request->energy_id);
            if ($energy->base_unit_type == 7) {
                $sub_property_id = 11;
            } elseif ($energy->base_unit_type == 6) {
                $sub_property_id = 26;
            } elseif ($energy->base_unit_type == 2) {
                $sub_property_id = 25;
            } else {
                $sub_property_id = 0;
            }
            $product_props = EnergyUtilityProperty::select('id', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'recommended')->where(['energy_id' => $request->energy_id, 'sub_property_id' => $sub_property_id, 'recommended' => 'on'])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_details_sub($props);
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

    public function energy_sustainability_info_ghge(Request $request)
    {
        try {
            $energy = EnergyUtility::find($request->energy_id);
            if ($energy->base_unit_type == 7) {
                $sub_property_id = 14;
            } elseif ($energy->base_unit_type == 6) {
                $sub_property_id = 29;
            } elseif ($energy->base_unit_type == 2) {
                $sub_property_id = 27;
            } else {
                $sub_property_id = 0;
            }
            $product_props = EnergyUtilityProperty::select('id', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'recommended')->where(['energy_id' => $request->energy_id, 'sub_property_id' => $sub_property_id, 'recommended' => 'on'])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_details_sub($props);
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

    public function energy_sustainability_info_carbon_content(Request $request)
    {
        try {
            $sub_property_id = 10;
            $product_props = EnergyUtilityProperty::select('id', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'recommended')->where(['energy_id' => $request->energy_id, 'sub_property_id' => $sub_property_id, 'recommended' => 'on'])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_details_sub($props);
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

    public function energy_sustainability_info_water_usage(Request $request)
    {
        try {
            $energy = EnergyUtility::find($request->energy_id);
            if ($energy->base_unit_type == 7) {
                $sub_property_id = 18;
            } elseif ($energy->base_unit_type == 6) {
                $sub_property_id = 37;
            } elseif ($energy->base_unit_type == 2) {
                $sub_property_id = 36;
            } else {
                $sub_property_id = 0;
            }
            $product_props = EnergyUtilityProperty::select('id', 'property_id', 'sub_property_id', 'prop_json', 'dynamic_prop_json', 'recommended')->where(['energy_id' => $request->energy_id, 'sub_property_id' => $sub_property_id, 'recommended' => 'on'])->get();
            $props_details = [];
            foreach ($product_props as $props) {
                $pro_value = get_properties_details_sub($props);
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
}
