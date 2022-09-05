<?php

use App\Models\Master\MasterUnit;
use App\Models\Product\ChemicalProperties;

function get_properties_conversion_pricing($dynamic_prop_json = [], $constant_unit_id = '', $constant_unit_id_2 = '', $user_id = '', $property_id = '', $sub_property_id = '')
{
    $pro_value = [];
    foreach ($dynamic_prop_json as  $key => $dynamic_value) {
        if ($dynamic_value['field_type_id'] == '5' || $dynamic_value['field_type_id'] == '6') {
            if ($dynamic_value['unit_id'] == 19) {
                $unit_val = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                $value = number_format($unit_val, 10, '.', '');
            }

            if ($dynamic_value['unit_id'] == 29) {
                $unit_val = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                $value = number_format($unit_val, 10, '.', '');
            }
        }
    }
    $pro_value['unit_id'] = !empty($dynamic_value['unit_id']) ? $dynamic_value['unit_id'] : '';
    $pro_value['unit_constant_id'] = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : '';
    $pro_value['property_id'] = !empty($property_id) ? $property_id : '';
    $pro_value['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
    $pro_value['value'] = !empty($value) ? $value : 0;
    return $pro_value;
}

function get_properties_conversion_details($property,  $constant_unit_id = '')
{
    $pro_value = [];
    foreach ($property->dynamic_prop_json as  $key => $dynamic_value) {
        if ($dynamic_value['field_type_id'] == '5' || $dynamic_value['field_type_id'] == '6') {
            $constant_unit_id = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : 0;
            $unit_val = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
            $value = get_unit_conversion_value($dynamic_value['unit_id'], $unit_val, $constant_unit_id);
            $pro_value['property_id'] = $property->property_id;
            $pro_value['sub_property_id'] = $property->sub_property_id;
            $pro_value['value'] = !empty($value) ? $value : 0;
            $pro_value['unit_id'] = !empty($dynamic_value['unit_id']) ? $dynamic_value['unit_id'] : '';
            $pro_value['unit_constant_id'] = !empty($constant_unit_id) ? $constant_unit_id : '';
        } elseif ($dynamic_value['field_type_id'] == '12') {
            $pro_value['property_id'] = $property->property_id;
            $pro_value['sub_property_id'] = $property->sub_property_id;
            $pro_value['unit_constant_id'] = !empty($constant_unit_id) ? $constant_unit_id : '';
        } elseif ($dynamic_value['field_type_id'] == '13') {
            $i = 0;
            $add_more_val = [];
            foreach ($dynamic_value['add_more_key'] as $prop_value_add_more) {
                if (!empty($prop_value_add_more['recommended']) && $prop_value_add_more['recommended'] == 'on') {
                    foreach ($prop_value_add_more['unit_id'] as $count => $units) {
                        $constant_unit_id = !empty($prop_value_add_more['unit_constant_id'][$count]) ? $prop_value_add_more['unit_constant_id'][$count] : 0;
                        $unit_val = !empty($prop_value_add_more['value'][$count]) ? $prop_value_add_more['value'][$count] : 0;
                        $value = get_unit_conversion_value($prop_value_add_more['unit_id'], $unit_val, $constant_unit_id);
                        $add_more_val[$i]['value'] = !empty($value) ? $value : 0;
                        $add_more_val[$i]['unit_id'] = !empty($prop_value_add_more['unit_id'][$count]) ? $prop_value_add_more['unit_id'][$count] : '';
                        $add_more_val[$i]['unit_constant_id'] = !empty($constant_unit_id) ? $constant_unit_id : '';
                        $i++;
                    }
                }
            }
            $pro_value['property_id'] = $property->property_id;
            $pro_value['sub_property_id'] = $property->sub_property_id;
            $pro_value['data'] = $add_more_val;
        }
    }
    return $pro_value;
}

function get_properties_conversion_details_energy($dynamic_prop_json = [], $prop_json = '', $constant_unit_id = '', $user_id = '')
{
    $pro_value = [];
    foreach ($dynamic_prop_json as  $key => $dynamic_value_prop) {
        $dynamic_value = array_merge($dynamic_value_prop, $arrayName);
        if ($dynamic_value['is_recomended'] == "on") {
            if ($dynamic_value['field_type_id'] == 'Select' || $dynamic_value['field_type_id'] == 'dropdown_only') {
                $units = MasterUnit::where('id', $dynamic_value['unit_name'])->first();
                $unit_constant = !empty($units['unit_constant']) ? $units['unit_constant'] : [];
                $unitConstantName = '';
                $constant_unit_id = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                foreach ($unit_constant as $constant) {
                    if ($constant['id'] == $constant_unit_id) {
                        $unitConstantName = $constant['unit_name'];
                        break;
                    }
                }
                $unit_val = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                $value = get_unit_conversion_value(23, $unit_val, $constant_unit_id);
                $pro_value['sub_property_name'] = !empty($dynamic_value['field_key']) ? $dynamic_value['field_key'] : '';
                $pro_value['value'] = !empty($value) ? $value : 0;
                $pro_value['unit_id'] = !empty($dynamic_value['unit_name']) ? $dynamic_value['unit_name'] : '';
                $pro_value['unit_name'] = !empty($units['unit_name']) ? $units['unit_name'] : '';
                $pro_value['unit_constant_id'] = !empty($constant_unit_id) ? $constant_unit_id : '';
                $pro_value['unit_constant_name'] = !empty($unitConstantName) ? $unitConstantName : '';
            } elseif ($dynamic_value['field_type_id'] == 'Number') {
                $pro_value['sub_property_name'] = !empty($dynamic_value['field_key']) ? $dynamic_value['field_key'] : '';
                $pro_value['field_value'] = !empty($constant_unit_id) ? $constant_unit_id : '';
            } elseif ($dynamic_value['field_type_id'] == 'add_more') {
                foreach ($dynamic_value['add_more_key'] as $prop_value_add_more) {
                    $unit_data = MasterUnit::whereIn('id', $prop_value_add_more['unit_name'])->get();
                    foreach ($unit_data as $count => $units) {
                        $unit_constant = $units->unit_constant;
                        $unit_constant = !empty($units['unit_constant']) ? $units['unit_constant'] : [];
                        $unitConstantName = '';
                        $constant_unit_id = !empty($prop_value_add_more['field_value'][$count]) ? $prop_value_add_more['field_value'][$count] : 0;
                        foreach ($unit_constant as $constant) {
                            if ($constant['id'] == $constant_unit_id) {
                                $unitConstantName = $constant['unit_name'];
                                break;
                            }
                        }
                        $unit_val = !empty($prop_value_add_more['unit_value'][$count]) ? $prop_value_add_more['unit_value'][$count] : 0;
                        $value = get_unit_conversion_value(23, $unit_val, $constant_unit_id);
                        $pro_value['sub_property_name'] = !empty($prop_value_add_more['field_key'][$count]) ? $prop_value_add_more['field_key'][$count] : '';
                        $pro_value['value'] = !empty($value) ? $value : 0;
                        $pro_value['unit_id'] = !empty($prop_value_add_more['unit_name'][$count]) ? $prop_value_add_more['unit_name'][$count] : '';
                        $pro_value['unit_name'] = !empty($units['unit_name']) ? $units['unit_name'] : '';
                        $pro_value['unit_constant_id'] = !empty($constant_unit_id) ? $constant_unit_id : '';
                        $pro_value['unit_constant_name'] = !empty($unitConstantName) ? $unitConstantName : '';
                    }
                }
            }
        }
    }
    return $pro_value;
}

function getDefaultUnit_constant($id)
{
    $default = MasterUnit::select('id', 'default_unit')->where('id', $id)->first();
    return $default['default_unit'];
}

function get_unit_conversion_value($unit_id, $unit_val, $constant_unit_id, $user_id = 1)
{
    return  number_format($unit_val, 10, '.', '');
    // if ($unit_id == 19) {
    //     $value = get_currency(date('Y-m-d'), $constant_unit_id, $unit_val, '', array(), $user_id);
    // } elseif ($unit_id == 4) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_volumentric_flowrate($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 5) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_pressure($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 7) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_mass($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 8) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_density($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 10) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = mass_flow_rate($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 11) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = specific_energy($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 15) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_molar_energy($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 12) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_temperature($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 14) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_time($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 16) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_carbon_content($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 17) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_ld50($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 18) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_weight_concentration($constant_unit_id, $unit_val);
    //     }
    // } elseif ($unit_id == 20) {
    //     $val = getDefaultUnit_constant($unit_id);
    //     if ($val == $constant_unit_id) {
    //         $value = get_default_value($constant_unit_id, $unit_val);
    //     } else {
    //         $value = get_cat($constant_unit_id, $unit_val);
    //     }
    // } else {
    //     $value = get_default_value($constant_unit_id, $unit_val);
    // }
    // return $value;
}


function get_properties_details_sub($property, $prop_value = 0)
{
    $pro_value = [];
    $property_id = $property->property_id;
    $sub_property_id = $property->sub_property_id;
    $key = 0;
    foreach ($property->dynamic_prop_json as  $dynamic_value) {
        if ($property->recommended == "on" && !empty($dynamic_value)) {
            $pro_value[$key]['product_id'] = $property->product_id;
            if ($dynamic_value['field_type_id'] == '5' || $dynamic_value['field_type_id'] == '6') {
                $unit_val = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                $arrs = array('177', '166', '180', '163', '182', '175', '165', '173', '174', '198');
                if (in_array($dynamic_value['unit_id'], $arrs)) {
                    $code_id = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : 0;
                    $select_list = get_dynamic_list($dynamic_value['unit_id'], $property->property_id, $dynamic_value['unit_constant_id']);
                    foreach ($select_list['units'] as $unit) {
                        if ($unit['id'] == $code_id) {
                            $value = $unit['unit_name'];
                        }
                    }
                } else {
                    $select_list = get_dynamic_list($dynamic_value['unit_id']);
                    $unit_name = '';
                    $name = !empty($select_list['name']) ? $select_list['name'] : '';
                    foreach ($select_list['units'] as $unit) {
                        if ($unit['id'] == $dynamic_value['unit_constant_id']) {
                            $unit_name = $unit['unit_name'];
                        }
                    }
                    $constant_unit_id = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : 0;
                    if ($prop_value == 1) {
                        $value = $unit_val;
                    } else {
                        $value = get_unit_conversion_value($dynamic_value['unit_id'], $unit_val, $constant_unit_id);
                    }
                    $pro_value[$key]['unit_id'] = !empty($dynamic_value['unit_id']) ? intval($dynamic_value['unit_id']) : '';
                    $pro_value[$key]['unit_name'] = !empty($name) ? $name : '';
                    $pro_value[$key]['unit_constant_id'] = !empty($constant_unit_id) ? intval($constant_unit_id) : '';
                    $pro_value[$key]['unit_constant_name'] = !empty($unit_name) ? $unit_name : '';
                }
                $pro_value[$key]['property_id'] = !empty($property_id) ? $property_id : '';
                $pro_value[$key]['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                $pro_value[$key]['value'] = !empty($value) ? $value : 0;
            } elseif ($dynamic_value['field_type_id'] == '13') {
                $i = 0;
                $add_more_val = [];
                foreach ($dynamic_value['add_more_key'] as $prop_value_add_more) {
                    if (!empty($prop_value_add_more['recommended']) && $prop_value_add_more['recommended'] == 'on') {
                        foreach ($prop_value_add_more['unit_id'] as $count => $units) {
                            $select_list = get_dynamic_list($prop_value_add_more['unit_id'][$count]);
                            $unit_name = '';
                            $name = $select_list['name'];
                            foreach ($select_list['units'] as $unit) {
                                if ($unit['id'] == $prop_value_add_more['unit_constant_id'][$count]) {
                                    $unit_name = $unit['unit_name'];
                                }
                            }
                            $constant_unit_id = !empty($prop_value_add_more['unit_constant_id'][$count]) ? $prop_value_add_more['unit_constant_id'][$count] : 0;
                            $unit_val = !empty($prop_value_add_more['value'][$count]) ? $prop_value_add_more['value'][$count] : 0;
                            if ($prop_value == 1) {
                                $value = $unit_val;
                            } else {
                                $value = get_unit_conversion_value($prop_value_add_more['unit_id'], $unit_val, $constant_unit_id);
                            }
                            $add_more_val[$i]['value'] = !empty($value) ? $value : 0;
                            $add_more_val[$i]['unit_id'] = !empty($prop_value_add_more['unit_id'][$count]) ? intval($prop_value_add_more['unit_id'][$count]) : '';
                            $add_more_val[$i]['unit_name'] = !empty($name) ? $name : '';
                            $add_more_val[$i]['unit_constant_id'] = !empty($constant_unit_id) ? intval($constant_unit_id) : '';
                            $add_more_val[$i]['unit_constant_name'] = !empty($unit_name) ? $unit_name : '';
                            $i++;
                        }
                    }
                }
                $pro_value[$key]['property_id'] = $property_id;
                $pro_value[$key]['sub_property_id'] = $sub_property_id;
                $pro_value[$key]['data'] = $add_more_val;
            } elseif ($dynamic_value['field_type_id'] == '7') {
                $arrs = array('177', '166', '180', '163', '182', '175', '165', '173', '174', '198');
                if (in_array($dynamic_value['unit_id'], $arrs)) {
                    $code_id = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : [];
                    $select_list = get_dynamic_list($dynamic_value['unit_id'], $property->property_id, $dynamic_value['unit_constant_id']);
                    foreach ($select_list['units'] as $unit) {
                        if (in_array($unit['id'], $code_id)) {
                            $value[] = $unit['unit_name'];
                        }
                    }
                    $pro_value[$key]['property_id'] = !empty($property_id) ? $property_id : '';
                    $pro_value[$key]['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                    $pro_value[$key]['value'] = !empty($value) ? $value : [];
                } else {
                    $pro_value[$key]['property_id'] = !empty($property_id) ? $property_id : '';
                    $pro_value[$key]['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                    $pro_value[$key]['value'] = !empty($dynamic_value['value']) ? $dynamic_value['value'] : [];
                }
            } elseif ($dynamic_value['field_type_id'] == '1') {
                // dd($dynamic_value);
                $pro_value[$key]['property_id'] = !empty($property_id) ? $property_id : '';
                $pro_value[$key]['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                $pro_value[$key]['value'] = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
            } else {
                $pro_value[$key]['property_id'] = !empty($property_id) ? $property_id : '';
                $pro_value[$key]['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                $pro_value[$key]['value'] = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
            }
        } else {
            if ($property_id == 2) {
                if ($dynamic_value['field_type_id'] == '5') {
                    $pro_value[$key]['property_id'] = !empty($property_id) ? $property_id : '';
                    $pro_value[$key]['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                    $pro_value[$key]['product_id'] = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : '';
                    $pro_value[$key]['value'] = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                } elseif ($dynamic_value['field_type_id'] == '1') {
                    $pro_value[$key]['property_id'] = !empty($property_id) ? $property_id : '';
                    $pro_value[$key]['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                    $pro_value[$key]['value'] = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                }
            }
        }
        $key++;
    }
    // if ($sub_property_id == 197) {
    //     dd($pro_value,$property->dynamic_prop_json);
    // }
    return $pro_value;
}

function get_properties_details_safety($chemical_prop, $sub_prop_field)
{
    $pro_value = [];
    if (!empty($chemical_prop)) {
        $property_id = $chemical_prop->property_id;
        $sub_property_id = $chemical_prop->sub_property_id;
        foreach ($chemical_prop->dynamic_prop_json as  $key => $dynamic_value) {
            if ($chemical_prop->recommended == "on") {
                if ($dynamic_value['field_type_id'] == '5' || $dynamic_value['field_type_id'] == '6') {
                    $unit_val = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                    $arrs = array('177', '166', '180', '163', '182', '175', '165', '173', '174', '198');
                    if (in_array($dynamic_value['unit_id'], $arrs)) {
                        $code_id = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : 0;
                        $select_list = get_dynamic_list($dynamic_value['unit_id'], $property_id, $dynamic_value['unit_constant_id']);
                        foreach ($select_list['units'] as $unit) {
                            if ($unit['id'] == $code_id) {
                                $value = $unit['unit_name'];
                            }
                        }
                    } else {
                        $constant_unit_id = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : 0;
                        $value = get_unit_conversion_value($dynamic_value['unit_id'], $unit_val, $constant_unit_id);
                        $pro_value['unit_id'] = !empty($dynamic_value['unit_id']) ? intval($dynamic_value['unit_id']) : '';
                        $pro_value['unit_constant_id'] = !empty($constant_unit_id) ? intval($constant_unit_id) : '';
                    }
                    $pro_value['property_id'] = !empty($property_id) ? $property_id : '';
                    $pro_value['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                    $pro_value['value'] = !empty($value) ? $value : 0;
                } elseif ($dynamic_value['field_type_id'] == '13') {
                    $i = 0;
                    $add_more_val = [];
                    foreach ($dynamic_value['add_more_key'] as $prop_value_add_more) {
                        if (!empty($prop_value_add_more['recommended']) && $prop_value_add_more['recommended'] == 'on') {
                            foreach ($prop_value_add_more['unit_id'] as $count => $units) {
                                $constant_unit_id = !empty($prop_value_add_more['unit_constant_id'][$count]) ? $prop_value_add_more['unit_constant_id'][$count] : 0;
                                $unit_val = !empty($prop_value_add_more['value'][$count]) ? $prop_value_add_more['value'][$count] : 0;
                                $value = get_unit_conversion_value($prop_value_add_more['unit_id'], $unit_val, $constant_unit_id);
                                $add_more_val[$i]['value'] = !empty($value) ? $value : 0;
                                $add_more_val[$i]['unit_id'] = !empty($prop_value_add_more['unit_id'][$count]) ? intval($prop_value_add_more['unit_id'][$count]) : '';
                                $add_more_val[$i]['unit_constant_id'] = !empty($constant_unit_id) ? intval($constant_unit_id) : '';
                                $i++;
                            }
                        }
                    }
                    $pro_value['property_id'] = $property_id;
                    $pro_value['sub_property_id'] = $sub_property_id;
                    $pro_value['data'] = $add_more_val;
                } elseif ($dynamic_value['field_type_id'] == '7') {
                    $arrs = array('177', '166', '180', '163', '182', '175', '165', '173', '174', '198');
                    if (in_array($dynamic_value['unit_id'], $arrs)) {
                        $code_id = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : [];
                        $select_list = get_dynamic_list($dynamic_value['unit_id'], $property_id, $dynamic_value['unit_constant_id']);
                        foreach ($select_list['units'] as $unit) {
                            if (in_array($unit['id'], $code_id)) {
                                $value[] = $unit['unit_name'];
                            }
                        }
                        $pro_value['property_id'] = !empty($property_id) ? $property_id : '';
                        $pro_value['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                        $pro_value['value'] = !empty($value) ? $value : [];
                    } else {
                        $pro_value['property_id'] = !empty($property_id) ? $property_id : '';
                        $pro_value['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                        $pro_value['value'] = !empty($dynamic_value['value']) ? $dynamic_value['value'] : [];
                    }
                } elseif ($dynamic_value['field_type_id'] == '1') {
                    $pro_value['property_id'] = !empty($property_id) ? $property_id : '';
                    $pro_value['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                    $pro_value['value'] = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                }
            } else {
                if ($property_id == 2) {
                    if ($dynamic_value['field_type_id'] == '5') {
                        $pro_value['property_id'] = !empty($property_id) ? $property_id : '';
                        $pro_value['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                        $pro_value['product_id'] = !empty($dynamic_value['unit_constant_id']) ? $dynamic_value['unit_constant_id'] : '';
                        $pro_value['value'] = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                    } elseif ($dynamic_value['field_type_id'] == '1') {
                        $pro_value['property_id'] = !empty($property_id) ? $property_id : '';
                        $pro_value['sub_property_id'] = !empty($sub_property_id) ? $sub_property_id : '';
                        $pro_value['value'] = !empty($dynamic_value['value']) ? $dynamic_value['value'] : 0;
                    }
                }
            }
        }
    } else {
        $property_id = $sub_prop_field->property_id;
        $sub_property_id = $sub_prop_field->id;
        foreach ($sub_prop_field->dynamic_fields as $sub_field) {
            if (!empty($sub_field['field_type_id'])) {
                if ($sub_field['field_type_id'] == '5' || $sub_field['field_type_id'] == '6') {
                    $pro_value['property_id'] = $property_id;
                    $pro_value['sub_property_id'] = $sub_property_id;
                    $pro_value['value'] =  0;
                    $pro_value['unit_id'] =  0;
                    $pro_value['unit_constant_id'] =  0;
                } elseif ($sub_field['field_type_id'] == '7') {
                    $pro_value['property_id'] = $property_id;
                    $pro_value['sub_property_id'] = $sub_property_id;
                    $pro_value['value'] =  [];
                } elseif ($sub_field['field_type_id'] == '13') {
                    $pro_value['property_id'] = $property_id;
                    $pro_value['sub_property_id'] = $sub_property_id;
                    $pro_value['data'] = [];
                } elseif ($sub_field['field_type_id'] == '1' || $sub_field['field_type_id'] == '12') {
                    $pro_value['property_id'] = $property_id;
                    $pro_value['sub_property_id'] = $sub_property_id;
                    $pro_value['value'] =  0;
                }
            }
        }
    }
    return $pro_value;
}
/////////////this function only for safety api
function get_default_constant_unit($sub_property_id, $unit_id, $constant_unit_id)
{
    $unit_constant_id = '';
    if ($sub_property_id == 105) {
        if ($unit_id == 12) {
            if (1 == $constant_unit_id) {
                return 'yes';
            } else {
                return 'no';
            }
        } else {
            if (9 == $constant_unit_id) {
                return 'yes';
            } else {
                return 'no';
            }
        }
    } elseif ($sub_property_id == 9) { //boiling
        if (1 == $constant_unit_id) {
            return 'yes';
        } else {
            return 'no';
        }
    } elseif ($sub_property_id == 164) { ///flash poin
        if (1 == $constant_unit_id) {
            return 'yes';
        } else {
            return 'no';
        }
    } elseif ($sub_property_id == 168) { //idlh
        if (1 == $constant_unit_id) {
            return 'yes';
        } else {
            return 'no';
        }
    } elseif ($sub_property_id == 170) { //ld50
        if (3 == $constant_unit_id) {
            return 'yes';
        } else {
            return 'no';
        }
    } elseif ($sub_property_id == 171) {
        if (1 == $constant_unit_id) {
            return 'yes';
        } else {
            return 'no';
        }
    } elseif ($sub_property_id == 167) {
        if (4 == $constant_unit_id) {
            return 'yes';
        } else {
            return 'no';
        }
    } elseif ($sub_property_id == 169) { //aquatic
        if (1 == $constant_unit_id) {
            return 'yes';
        } else {
            return 'no';
        }
    } elseif ($sub_property_id == 143) {
        if ($unit_id == 12) {
            if (1 == $constant_unit_id) {
                return 'yes';
            } else {
                return 'no';
            }
        } else {
            if (9 == $constant_unit_id) {
                return 'yes';
            } else {
                return 'no';
            }
        }
    }
}

function get_product_properties_helper($product_id)
{
    try {
        $data_props = ChemicalProperties::where('product_id', $product_id)->get();
        $props_details = [];
        $count=0;
        foreach ($data_props as $props) {
            $props_details[$count] = get_properties_details_sub($props, 0);
            $count++;
        }
        return $props_details;
        // return response()->json([
        //     'success' => true,
        //     'status_code' => 200,
        //     'status' => true,
        //     'data' => $props_details
        // ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'status_code' => 500,
            'status' => false,
            'data' => $e->getMessage()
        ]);
    }
}
