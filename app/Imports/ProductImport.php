<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Product\Chemical;
use App\Models\Product\ChemicalProperties;
use App\Models\Master\Chemical\ChemicalSubPropertyMaster;

class ProductImport implements ToCollection
{
    public function  __construct($product_type_id)
    {
        $this->product_type_id = $product_type_id;
    }

    public function collection(Collection $collection)
    {
        // foreach ($collection as $key => $value) {
        //     $count = array(0, 1, 2, 3);
        //     if (!in_array($key, $count)) {
        //         $is_chemical_exist = Chemical::where('chemical_name', $value[0])->first();
        //         if (empty($is_chemical_exist)) {
        //             $insert_data = array(
        //                 'chemical_name'  => $value[0],
        //                 'molecular_formula'  => $value[1],
        //                 'category_id'   => 1,
        //                 'classification_id'   => 1,
        //                 'product_type_id'   => $this->product_type_id,

        //             );
        //             $chemical_id = Chemical::create($insert_data)->id;
        //         } else {
        //             $chemical_id = $is_chemical_exist->id;
        //         }
        //         if (!empty($value[2])) {
        //             $val = explode(",", $value[2]);
        //             foreach ($val as $amount) {
        //                 $prop_id = 6;
        //                 $sub_prop_id = 185;
        //                 $subprop = ChemicalProperties::where(['chemical_id' => $chemical_id, 'sub_property_id' => $sub_prop_id, 'property_id' => $prop_id])->first();
        //                 $prop = array();
        //                 if (!empty(_arefy($subprop))) {
        //                     $prop = [
        //                         array("id" => 0, "field_type" => "textarea", "field_key" => "Reference Source", "field_value" => ""),
        //                         array("id" => 1, "field_type" => "tags", "field_key" => "Keywords", "field_value" => ""),
        //                         array("id" => 2, "field_type" => "checkbox", "field_key" => "Is Recommended", "field_value" => "")
        //                     ];
        //                 } else {
        //                     $prop = [
        //                         array("id" => 0, "field_type" => "textarea", "field_key" => "Reference Source", "field_value" => ""),
        //                         array("id" => 1, "field_type" => "tags", "field_key" => "Keywords", "field_value" => ""),
        //                         array("id" => 2, "field_type" => "checkbox", "field_key" => "Is Recommended", "field_value" => "on")
        //                     ];
        //                 }
        //                 $chemprop = new ChemicalProperties();
        //                 $sub_prop_master = ChemicalSubPropertyMaster::where('id', $sub_prop_id)->first();
        //                 $sub_prop_master->dynamic_fields;
        //                 foreach ($sub_prop_master->dynamic_fields as $prop_key => $prop_value) {
        //                     $dynamic_prop[$prop_key]['id'] = $prop_key;
        //                     $dynamic_prop[$prop_key]['field_type'] = !empty($prop_value['field_type']) ? $prop_value['field_type'] : '';
        //                     $dynamic_prop[$prop_key]['field_key'] = !empty($prop_value['field_name']) ? $prop_value['field_name'] : '';
        //                     if ($prop_value['field_type'] == 'Select') {
        //                         $dynamic_prop[$prop_key]['unit_name'] = !empty($prop_value['unit_name']) ? $prop_value['unit_name'] : '';
        //                         $dynamic_prop[$prop_key]['unit_value'] = !empty($amount) ? $amount : '';
        //                         $dynamic_prop[$prop_key]['field_value'] = 1;
        //                     }
        //                     // elseif ($prop_value['field_type'] == 'dropdown_only') {
        //                     //     $dynamic_prop[$prop_key]['unit_name'] = !empty($prop_value['unit_name']) ? $prop_value['unit_name'] : '';
        //                     //     $dynamic_prop[$prop_key]['field_value'] = 6;
        //                     // }
        //                 }
        //                 // } elseif ($prop_value['type'] == 'file') {
        //                 //     $folder_name = 'chemical_properties';
        //                 //     $file       = $prop_value['value'];
        //                 //     $extension  = $file->getClientOriginalExtension();
        //                 //     $file_name  = $file->getClientOriginalName();
        //                 //     $file->move('uploads/' . $folder_name, $file_name);
        //                 //     $dynamic_prop[$prop_key]['field_value'] = asset('uploads/' . $folder_name . '/' . $file_name);
        //                 // } elseif ($prop_value['type'] == 'multiselect') {
        //                 //     $dynamic_prop[$prop_key]['unit_name'] = !empty($prop_value['unit_name']) ? $prop_value['unit_name'] : '';
        //                 //     $dynamic_prop[$prop_key]['unit_value'] = !empty($prop_value['unit_value']) ? $prop_value['unit_value'] : '';
        //                 //     if (!empty($prop_value['value'])) {
        //                 //         foreach ($prop_value['value'] as $key => $multiValue) {
        //                 //             $valMulti[$key] = ___decrypt($multiValue);
        //                 //         }
        //                 //         $dynamic_prop[$prop_key]['field_value'] = $valMulti;
        //                 //     }
        //                 // } elseif ($prop_value['type'] == 'add_more') {
        //                 //     $add_more_key = [];
        //                 //     foreach ($prop_value['add_more'] as $keyss_old => $addMore) {
        //                 //         if (!empty($addMore['value'])) {
        //                 //             $add_more_key[$keyss_old]['field_value'] = ___decrypt($addMore['value']);
        //                 //         }
        //                 //         if (!empty($addMore['unit_name'])) {
        //                 //             $add_more_key[$keyss_old]['unit_name'] = $addMore['unit_name'];
        //                 //         }
        //                 //         if (!empty($addMore['key'])) {
        //                 //             $add_more_key[$keyss_old]['field_key'] = ___decrypt($addMore['key']);
        //                 //         }
        //                 //         if (!empty($addMore['unit_value'])) {
        //                 //             $add_more_key[$keyss_old]['unit_value'] = $addMore['unit_value'];
        //                 //         }
        //                 //     }
        //                 //     $dynamic_prop[$prop_key]['add_more_key'] = $add_more_key;
        //                 // } else {
        //                 //     $dynamic_prop[$prop_key]['field_value'] = !empty($prop_value['value']) ? $prop_value['value'] : '';
        //                 //     $dynamic_prop[$prop_key]['field_key'] = !empty($prop_value['key']) ? $prop_value['key'] : '';
        //                 // }
        //                 $chemprop->prop_json = $prop;
        //                 $chemprop->dynamic_prop_json = $dynamic_prop;
        //                 $chemprop->chemical_id = $chemical_id;
        //                 $chemprop->sub_property_id = $sub_prop_id;
        //                 $chemprop->property_id = $prop_id;
        //                 $chemprop->order_by = 1;
        //                 $chemprop->created_by = \Auth::user()->id;
        //                 $chemprop->updated_by = \Auth::user()->id;
        //                 $chemprop->save();
        //             }
        //         }
        //     }
        // }
        foreach ($collection as $key => $value) {
            if ($key != 0) {
                if ($this->product_type_id == 1) {
                    if (!empty($value[11])) {
                        $type =  explode(',', $value[11]);
                    } else {
                        $type = [];
                    }
                    if (!empty($value[10])) {
                        $smile =  explode(',', $value[10]);
                    } else {
                        $smile = [];
                    }
                    $smile =  explode(',', $value[10]);
                    $smiles = [];
                    foreach ($smile as $keyss => $smm) {
                        $smiles[$keyss]['smile'] = $smm;
                        $smiles[$keyss]['types'] = !empty($type[$keyss]) ? $type[$keyss] : '';
                    }

                    $val = [];
                    if (!empty($smiles)) {
                        foreach ($smiles as $keys => $sm) {
                            $val[$keys]['id'] = json_encode($keys + 1);
                            $val[$keys]['types'] = $sm['types'];
                            $val[$keys]['smile'] = $sm['smile'];
                        }
                    }
                    if ($value[14] == 'yes') {
                        $own = 1;
                    } else {
                        $own = 2;
                    }
                    $insert_data = array(
                        'chemical_name'  => $value[0],
                        'category_id'   => 1,
                        'classification_id'   => 1,
                        'product_type_id'   => $this->product_type_id,
                        'tenant_id' => session()->get('tenant_id'),
                        'product_brand_name'   => $value[3],
                        'iupac'   => $value[4],
                        'cas_no' => explode(',', $value[5]),
                        'inchi'   => $value[6],
                        'inchi_key'   => $value[7],
                        'ec_number'   => $value[8],
                        'molecular_formula'   => $value[9],
                        'smiles'    => $val,
                        'other_name' => explode(',', $value[12]),
                        'tags' => explode(',', $value[13]),
                        'own_product'   => $own,
                        'notes'   => $value[15],
                        'status'   => 'active',
                    );
                } else {
                    if ($value[6] == 'yes') {
                        $own = 1;
                    } else {
                        $own = 2;
                    }
                    $insert_data = array(
                        'chemical_name'  => $value[0],
                        'category_id'   => 1,
                        'classification_id'   => 4,
                        'product_type_id'   => $this->product_type_id,
                        'tenant_id' => session()->get('tenant_id'),
                        'product_brand_name'   => $value[3],
                        'other_name' => explode(',', $value[4]),
                        'tags' => explode(',', $value[5]),
                        'own_product'   => $own,
                        'notes'   => $value[7],
                        'status'   => 'active',
                    );
                }

                Chemical::create($insert_data);
            }
        }
    }

    // public function collection(Collection $collection)
    // {
    //     foreach ($collection as $key => $value) {
    //         $insert_data = array(
    //             'title'  => $value[1],
    //             'code'   => $value[0],
    //             'description'   => $value[1],
    //             'type' => 5,
    //             'sub_code_type_id'   => 7,
    //         );
    //         CodeStatement::create($insert_data);
    //     }
    // }
}
