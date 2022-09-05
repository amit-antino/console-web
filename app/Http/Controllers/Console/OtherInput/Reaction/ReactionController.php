<?php

namespace App\Http\Controllers\Console\OtherInput\Reaction;

use App\Http\Controllers\Controller;
use App\Models\OtherInput\Reaction;
use App\Models\OtherInput\Reaction\ReactionPhase;
use App\Models\OtherInput\Reaction\ReactionType;
use Illuminate\Http\Request;
use App\Models\Product\Chemical;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ReactionController extends Controller
{
    public function index()
    {
        $reaction = Reaction::where('tenant_id', session()->get('tenant_id'))->orderBy('id','desc')->get();
        $reactData = [];
        if (!empty($reaction)) {
            foreach ($reaction as $rk => $rv) {
                $reactData[$rk]['id'] = $rv['id'];
                $reactData[$rk]['reaction_name'] = $rv['reaction_name'];
                $reactData[$rk]['reaction_source'] = $rv['reaction_source'];
                $reactData[$rk]['chemical_reaction_left'] = $rv['chemical_reaction_left'];
                $reactData[$rk]['chemical_reaction_right'] = $rv['chemical_reaction_right'];
                $rc = $rv['reactant_component'];
                $pc = $rv['product_component'];
                if (!empty($rc)) {
                    $arr = array_column($rc, 'reactant_chemical_id');
                    $chem = Chemical::select('id', 'chemical_name')->whereIn('id', $arr)->get();
                    if (!empty($chem)) {
                        $reactData[$rk]['reaction_chem_name'] = implode(',', array_column($chem->toArray(), 'chemical_name'));
                    } else {
                        $reactData[$rk]['reaction_chem_name'] = "";
                    }
                }
                if (!empty($pc)) {
                    $arrpc = array_column($pc, 'product_chemical_id');
                    $chem = Chemical::select('id', 'chemical_name')->whereIn('id', $arrpc)->get();
                    if (!empty($chem)) {
                        $reactData[$rk]['product_chem_name'] = implode(',', array_column($chem->toArray(), 'chemical_name'));
                    } else {
                        $reactData[$rk]['product_chem_name'] = "";
                    }
                }
                $reactData[$rk]['balance'] = $rv['balance'];
                $reactData[$rk]['status'] = $rv['status'];
            }
        }
        $data['reactions'] = $reactData;
        return view('pages.console.other_input.reaction.index', $data);
    }

    public function create()
    {
        $data['chemical'] = Chemical::where('tenant_id', session()->get('tenant_id'))->get();
        $data['reaction_type'] = ReactionType::get();
        $data['reaction_phase'] = ReactionPhase::get();
        return view('pages.console.other_input.reaction.create', $data);
    }

    public function store(Request $request)
    {
        $validations = [
            'reaction_name' => ['required'],
            'reaction_type' => ['required'],
            'reactant_chm_r' => ['required'],
            'reactant_chm_p' => ['required'],
            'ra_count_r' => ['required'],
            'ra_count_p' => ['required']
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $reac = new Reaction();
            $reac->tenant_id = session()->get('tenant_id');
            $reac['reaction_name'] = $request->reaction_name;
            $reac['reaction_source'] = $request->reaction_source;
            $reac['reaction_type'] = $request->reaction_type;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $reac['tags'] = $tags;
            $reac['description'] = $request->description;
            $reac['chemical_reaction_left'] = $request->reaction_mole_left;
            $reac['chemical_reaction_right'] = $request->product_mole_right;
            $reac['reaction_reactant'] = $request->reactan_mole;
            $reac['reaction_product'] = $request->product_mole;
            // $reac['notes'] = $request->tinymceExample;
            $reac['balance'] = $request->blnc;
            $reac['created_by'] = Auth::user()->id;
            $reac['updated_by'] = Auth::user()->id;
            if (!empty($request->reactant_chm_r)) {
                foreach ($request->reactant_chm_r as $key => $value) {
                    if (!empty($value)) {
                        $val_r[$key]['id'] = json_encode($key);
                        $val = explode('_', $value);
                        $val_r[$key]['reactant_chemical_id'] = $val[0];
                        $val_r[$key]['reactant_chemical'] = $val[1];
                        $val_r[$key]['stochiometric_coefficient'] = $request->ra_count_r[$key];
                        $val_r[$key]['forward_order'] = $request->fwr[$key];
                        $val_r[$key]['reaction_phase'] = $request->reaction_phase[$key];
                        $val_r[$key]['base_component'] = $request->base_comp[$key];
                    }
                }
                $reac['reactant_component'] = $val_r;
            }
            if (!empty($request->reactant_chm_p)) {
                foreach ($request->reactant_chm_p as $key => $value) {
                    $val_p[$key]['id'] = json_encode($key);
                    $val = explode('_', $value);
                    $val_p[$key]['product_chemical_id'] = $val[0];
                    $val_p[$key]['product_chemical'] = $val[1];
                    $val_p[$key]['stochiometric_coefficient'] = $request->ra_count_p[$key];
                    $val_p[$key]['reaction_phase'] = $request->product_reaction_phase[$key];
                    $val_p[$key]['backward_order'] = $request->bwr_p[$key];
                    $val_p[$key]['base_component'] = $request->base_comp_p[$key];
                }
                $reac['product_component'] = $val_p;
            }
            $reac->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('other_inputs/reaction');
            $this->message = "Reaction Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $data['reaction_data'] = Reaction::find(___decrypt($id));
        $data['reaction'] = $data['reaction_data'];
        $data['rate_user_data'] = $data['reaction_data']["rate_parameter_user"];
        $data['rate_cal_data'] =  $data['reaction_data']["rate_parameter_cal"];
        $data['equi_user_data'] = $data['reaction_data']["equilibrium_user"];
        $data['equi_cal_data'] = $data['reaction_data']["equilibrium_cal"];
        $data['reaction_phase'] = ReactionPhase::get();
        if (!empty($data['reaction_data']['product_component'])) {
            $productAttcolId = array_column($data['reaction_data']['product_component'], 'product_chemical_id');
            $productAttcolname = get_product_name($productAttcolId);
        }
        if (!empty($productAttcolname)) {
            $data['product_component'] = $productAttcolname->toArray();
        } else {
            $data['product_component'] = [];
        }
        if (!empty($data['reaction_data']['reactant_component'])) {
            $reactant_componentcolId = array_column($data['reaction_data']['reactant_component'], 'reactant_chemical_id');
            $reactant_componentcolname = get_product_name($reactant_componentcolId);
        }
        if (!empty($reactant_componentcolname)) {
            $data['reactant_component'] = $reactant_componentcolname->toArray();
        } else {
            $data['reactant_component'] = [];
        }
        return view::make('pages.console.other_input.reaction.view', $data);
    }

    public function edit($id)
    {
        $reaction_data = Reaction::find(___decrypt($id));
        $data['chemical'] = Chemical::where('tenant_id', session()->get('tenant_id'))->get();
        $data['reaction_phase'] = ReactionPhase::get();
        $data['reaction_type'] = ReactionType::get();
        $reactant_component = $reaction_data->reactant_component;
        $product_component = $reaction_data->product_component;
        return View::make('pages.console.other_input.reaction.edit', $data)->with('reaction_phase', $data['reaction_phase'])->with('reaction_data', $reaction_data)->with('chemical', $data['chemical'])->with('reactant_component_data', $reactant_component)->with('product_component_data', $product_component);
    }

    public function update(Request $request, $id)
    {
        $validations = [
            'reaction_name' => ['required'],
            'reaction_type' => ['required'],
            'reactant_chm_r' => ['required'],
            'reactant_chm_p' => ['required'],
            'ra_count_r' => ['required'],
            'ra_count_p' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validations, []);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $reac = Reaction::find(___decrypt($id));
            $reac['tenant_id'] = session()->get('tenant_id');
            $reac['reaction_name'] = $request->reaction_name;
            $reac['reaction_source'] = $request->reaction_source;
            $reac['reaction_type'] = $request->reaction_type;
            if ($request->tags != "") {
                $tags = explode(",", $request->tags);
            } else {
                $tags = [];
            }
            $reac['tags'] = $tags;
            $reac['description'] = $request->description;
            $reac['chemical_reaction_left'] = $request->reaction_mole_left;
            $reac['chemical_reaction_right'] = $request->product_mole_right;
            $reac['reaction_reactant'] = $request->reactan_mole;
            $reac['reaction_product'] = $request->product_mole;
            $reac['notes'] = $request->tinymceExample;
            $reac['balance'] = $request->blnc;
            $reac['updated_by'] = Auth::user()->id;
            if (!empty($request->reactant_chm_r)) {
                foreach ($request->reactant_chm_r as $key => $value) {
                    if (!empty($value)) {
                        $val_r[$key]['id'] = json_encode($key);
                        $val = explode('_', $value);
                        $val_r[$key]['reactant_chemical_id'] = !empty($val[0]) ? $val[0] : '';
                        $val_r[$key]['reactant_chemical'] = !empty($val[1]) ? $val[1] : '';
                        $val_r[$key]['stochiometric_coefficient'] = $request->ra_count_r[$key];
                        $val_r[$key]['reaction_phase'] = $request->reaction_phase[$key];
                        $val_r[$key]['forward_order'] = $request->fwr[$key];
                        $val_r[$key]['base_component'] = $request->base_comp[$key];
                    }
                }
                $reac['reactant_component'] = $val_r;
            }
            if (!empty($request->reactant_chm_p)) {
                foreach ($request->reactant_chm_p as $key => $value) {
                    $val_p[$key]['id'] = json_encode($key);
                    $val = explode('_', $value);
                    $val_p[$key]['product_chemical_id'] = !empty($val[0]) ? $val[0] : '';
                    $val_p[$key]['product_chemical'] = !empty($val[1]) ? $val[1] : '';
                    $val_p[$key]['stochiometric_coefficient'] = $request->ra_count_p[$key];
                    $val_p[$key]['reaction_phase'] = $request->product_reaction_phase[$key];
                    $val_p[$key]['backward_order'] = $request->bwr_p[$key];
                    $val_p[$key]['base_component'] = $request->base_comp_p[$key];
                }
                $reac['product_component'] = $val_p;
            }
            $reac->save();
            $this->alert = true;
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('other_inputs/reaction');
            $this->message = "Reaction updated Successfully!";
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
            Reaction::where('id', ___decrypt($id))->update(['status' => $status]);
        } else {
            Reaction::find(___decrypt($id))->delete();
        }
        $this->status = true;
        //$this->redirect = url('other_inputs/reaction');
        $this->redirect = true;
        return $this->populateresponse();
    }

    // public function importFile(Request $request)
    // {
    //     $validations = [
    //         'select_file' => ['required'],
    //     ];
    //     $validator = Validator::make($request->all(), $validations, []);
    //     if ($validator->fails()) {
    //         $this->message = $validator->errors();
    //     } else {
    //         $datetime = date('Ymd_his');
    //         $file =   $request->file('select_file');
    //         $filename = $datetime . "_" . $file->getClientOriginalName();
    //         $savepath = public_path('/upload/');
    //         $file->move($savepath, $filename);
    //         $excel = Importer::make('Excel');
    //         $excel->load($savepath . $filename);
    //         $collection = $excel->getCollection();
    //         if ($collection->count() > 0) {
    //             foreach ($collection->toArray() as $key => $value) {
    //                 $insert_data = array(
    //                     'equipment_name'  => $value[0],
    //                     'installation_date'   => $value[1],
    //                     'purchased_date'   => $value[2],
    //                     'vendor_id'   => $value[3],
    //                     'equipment_image'   => $value[4],
    //                     'availability'   => $value[5],
    //                     'tags'   => $value[6],
    //                     'country_id'   => $value[7],
    //                     'state_id'   => $value[8],
    //                     'district_id'   => $value[9],
    //                     'pincode'   => $value[10],
    //                     'status'   => $value[11],
    //                     'description'   => $value[12]
    //                 );
    //                 Reaction::insertGetId($insert_data);
    //             }
    //         }
    //         $this->status = true;
    //         $this->alert   = true;
    //         $this->modal = true;
    //         $this->redirect = url('other_inputs/reaction');
    //         $this->message = "reaction CSV uploaded Successfully!";
    //     }
    //     return $this->populateresponse();
    // }

    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $processID = explode(',', ($id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (Reaction::whereIn('id', $processIDS)->update($update)) {
            Reaction::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function addReactent(Request $request)
    {
        $chemical = Chemical::where('tenant_id', session()->get('tenant_id'))->get();
        return response()->json([
            'status' => true,
            'html' => view("pages.console.other_input.reaction." . $request->type, ['count' => $request->count, 'chemical' => $chemical])->render()
        ]);
    }

    public function balanceReactions(Request $request)
    {
        foreach ($request->chemical as $key => $chem) {
            $val = explode(',', $chem);
            $arr1 = $val;
        }
        foreach ($request->stoic_coef_reac as $key => $coef) {
            $val1 = explode(',', $coef);
            $arr2 = $val1;
        }
        $s = "C2H6O";
        $len = strlen($s);
        $html = '';
        if ($len > 0) {
            $prev = $s[0];
            $html = $prev;
            for ($i = 1; $i < $len; $i++) {
                $ch = $s[$i];
                if (is_numeric($ch) && 'a' <= strtolower($prev) && strtolower($prev) <= 'z') {
                    $html .= "<sub>$ch</sub>";
                } else {
                    $html .= $ch;
                }
                $prev = $ch;
            }
        }
        $string = '2O2+2H2+C2H6O';
        $len = strlen($string);
        $str_return = '';
        if ($len > 0) {
            $prev       =    $string[0];
            $str_return =    $prev;
            for ($i = 1; $i < $len; $i++) {
                $ch = $string[$i];
                if (is_numeric($ch)) {
                    if ('a' <= strtolower($prev) && strtolower($prev) <= 'z' || $prev == ')') {
                        if (($string[$i + 1]  == '-' || $string[$i + 1]  == '+') && !in_array(@$string[$i + 2], ['C', 'O', 'H'])) {
                            $str_return .= '<sup>' . $ch . '</sup>';
                            $str_return .= '<sup>' . $string[$i + 1] . '</sup>';
                            $i++;
                        } else {
                            $str_return .= "<sub>$ch</sub>";
                        }
                    } else {
                        $str_return .= $ch;
                        $prev = $ch;
                    }
                } else {
                    $str_return .= $ch;
                    $prev = $ch;
                }
            }
        }
        $input = "C2H6O";
        $res = preg_replace('/(\d+)/', '<sub>$1</sub>', $input);
    }

    // calculation
    public function calculate_reaction_rate(Request $data, $id)
    {
        $A = $data['a'];
        $E = $data['e'];
        $T = $data['t'];
        $R = 8.314;
        $k = ($A * exp(-$E / ($R * $T)));
        echo $k;
    }

    public function checkMolecular(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reactent_molec_formula' => 'nullable',
        ]);
        $atoms_r = array();
        $atoms_p = array();
        $mol_val_r = array();
        $mol_val_p = array();
        $arr_mol_c = array();
        $arr_mol_p = array();
        $reactent = explode("+", $request->reactent_molec_formula);
        $len = count($reactent);
        for ($a = 0; $a < $len; $a++) {
            if (empty($reactent[$a])) {
                $validator->errors()->add('error_message', 'Molecular formula is either empty or not validated');
                $this->message = $validator->errors();
                return $this->populateresponse();
            }
            if (preg_match('/[^A-Z0-9]+,/', $reactent[$a])) {
                // return "Molecular Formula is not allow Special characters";
                $validator->errors()->add('error_message', 'Molecular Formula is not allow Special characters');
                $this->message = $validator->errors();
                return $this->populateresponse();
            }
            $arr = preg_split('/(?=[<@A-Z])/i', $reactent[$a]);
            $arr_t = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $reactent[$a]);
            $mol_r = "";
            for ($ia = 0; $ia < count($arr_t); $ia++) {
                if ($ia > 0) {
                    $mol_r .= $arr_t[$ia];
                }
            }
            $temp_m = str_split($mol_r);
            $stoichemi = $arr[0];
            $j_r = -1;
            $n_f = true;
            $re = array();
            $mul_atom_val = 0;
            $total_atom_stoi = 0;
            $total = 0;
            $td_react = "";
            $sum_of_all = 0;
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
                    error_reporting(0);
                    $re[$j_r] = $re[$j_r] . $temp_m[$i_r];
                    $n_f = false;
                } else if (is_numeric($temp_m[$i_r])) {
                    $re[$j_r] .= $temp_m[$i_r];
                    $n_f = true;
                    error_reporting(0);
                }
            }
            if (!empty($re)) {
                if (!preg_match('#[0-9]#', $re[$j_r])) {
                    $re[$j_r] .= "1";
                    error_reporting(0);
                }
            }
            $number = array();
            $variable_r = array();
            for ($e = 0; $e < sizeof($re); $e++) {
                $numbers = preg_replace('/[^0-9]/', '', $re[$e]);
                $elem = preg_replace('/[^a-zA-Z]/', '', $re[$e]);
                $number[$e] = $numbers;
                $variable_r[$e] = $elem;
                $elem_con = DB::select("select element_sc from periodic_table where element_sc= ?", [$elem]);
                foreach ($elem_con as $con) {
                    if (strlen($con->element_sc) <= 0) {
                        $validator->errors()->add('error_message', 'Elements not found.');
                        $this->message = $validator->errors();
                        return $this->populateresponse();
                    }
                }
            }
            $pr_t = 0;
            $new_t = 0;
            $add_next = 0;
            $pr_st = 0;
            $new_st = 0;
            $nx_st = 0;
            $j = 0;
            $sum_mul_st = 0;
            $total_m = 0;
            $cnt_r = 0;
            $v = 0;
            for ($i = 0; $i < sizeof($variable_r); $i++) {
                $arr_c = array("$variable_r[$i]" => $stoichemi * $number[$i]);
                $arr_mol_c[] = $arr_c;
                $j = ($i + 1);
                $mul_atom_val = $stoichemi * $number[$i];
                array_push($mol_val_r, $variable_r[$i]);
                array_push($atoms_r, $number[$i]);
                $pr_t = $new_t + $number[$i];
                $sum_of_all = $sum_of_all + $pr_t;
                $pr_st = $new_st + $mul_atom_val;
                $sum_mul_st = $sum_mul_st + $pr_st;
            }
            $cnt_r += $j;
            // echo "$sum_of_all+$add_next=";
            $add_next += $sum_of_all;
            $r = 0;
            $v += $add_next + $r;
            $nx_st = $sum_mul_st + $nx_st;
            $t_m = 0;
            // Total of atoms*coefficient
            $total_m += $nx_st + $t_m;
        }
        $cumulitive_values = array();
        foreach ($arr_mol_c as $mol_ckey => $mol_cvalue) {
            foreach ($mol_cvalue as $atom_c_k => $atom_c_v) {
                if (isset($cumulitive_values[$atom_c_k])) {
                    $cumulitive_values[$atom_c_k] = $cumulitive_values[$atom_c_k] + $atom_c_v;
                } else {
                    $cumulitive_values[$atom_c_k] = $atom_c_v;
                }
            }
        }
        /*For product molecular */
        $product = explode("+", $request->product_molec_formula);
        $len_p = count($product);
        if (!empty($product)) {
            for ($p = 0; $p < $len_p; $p++) {
                if (empty($product[$p])) {
                    // echo "Molecular formula is either empty or not validated";
                    $validator->errors()->add('error_message', 'Molecular formula is either empty or not validated');
                    $this->message = $validator->errors();
                    return $this->populateresponse();
                }
                if (preg_match('/[^A-Z0-9]+,/', $product[$p])) {
                    //return "Molecular Formula is not allow Special characters";
                    $validator->errors()->add('error_message', 'Molecular Formula is not allow Special characters');
                    $this->message = $validator->errors();
                    return $this->populateresponse();
                }
                $arr = preg_split('/(?=[<@A-Z])/i', $product[$p]);
                $arr_t = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $product[$p]);
                $mol = "";
                for ($ia = 0; $ia < count($arr_t); $ia++) {
                    if ($ia > 0) {
                        $mol .= $arr_t[$ia];
                    }
                }
                $temp_m = str_split($mol);
                $stoichemi_p = $arr[0];
                $j_r = -1;
                $n_f = true;
                $re = array();
                $mul_atom_val_p = 0;
                $total_atom_stoi_p = 0;
                $total = 0;
                $sum_of_all = 0;
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
                        error_reporting(0);
                        $re[$j_r] = $re[$j_r] . $temp_m[$i_r];
                        $n_f = false;
                    } else if (is_numeric($temp_m[$i_r])) {
                        $re[$j_r] .= $temp_m[$i_r];
                        $n_f = true;
                        error_reporting(0);
                    }
                }
                if (!empty($re)) {
                    if (!preg_match('#[0-9]#', $re[$j_r])) {
                        $re[$j_r] .= "1";
                        error_reporting(0);
                    }
                }
                $number = array();
                $variable_p = array();
                for ($e = 0; $e < sizeof($re); $e++) {
                    $numbers = preg_replace('/[^0-9]/', '', $re[$e]);
                    $elem = preg_replace('/[^a-zA-Z]/', '', $re[$e]);
                    $number[$e] = $numbers;
                    $variable_p[$e] = $elem;
                    $elem_con = DB::select("select element_sc from periodic_table where element_sc= ?", [$elem]);
                    foreach ($elem_con as $con) {
                        if (strlen($con->element_sc) <= 0) {
                            $validator->errors()->add('error_message', 'Elements not found.');
                            $this->message = $validator->errors();
                            return $this->populateresponse();
                        }
                    }
                }
                $pr_t_p = 0;
                $new_t_p = 0;
                $add_next_p = 0;
                $pr_st_p = 0;
                $new_st_p = 0;
                $nx_st_p = 0;
                $sum_mul_st_p = 0;
                $sum_of_all_p = 0;
                $cnt_p = 0;
                $total_m_p = 0;
                for ($i = 0; $i < sizeof($variable_p); $i++) {
                    $arr_p = array("$variable_p[$i]" => $stoichemi_p * $number[$i]);
                    $arr_mol_p[] = $arr_p;
                    $j = ($i + 1);
                    $mul_atom_val_p = $stoichemi_p * $number[$i];
                    array_push($mol_val_p, $variable_p[$i]);
                    array_push($atoms_p, $number[$i]);
                    $pr_t_p = $new_t_p + $number[$i];
                    $sum_of_all_p = $sum_of_all_p + $pr_t_p;
                    $pr_st_p = $new_st_p + $mul_atom_val_p;
                    $sum_mul_st_p = $sum_mul_st_p + $pr_st_p;
                }
                $cnt_p += $j;
                // Total atoms of products
                $add_next_p += $sum_of_all_p;
                $nx_st_p += $sum_mul_st_p + $nx_st_p;
                $t_m_p = 0;
                // Total of atom*coefficient 
                $total_m_p += $nx_st_p + $t_m_p;
            }
        }
        $cumulitive_values_p = array();
        foreach ($arr_mol_p as $mol_pkey => $mol_pvalue) {
            foreach ($mol_pvalue as $atom_p_k => $atom_p_v) {
                if (isset($cumulitive_values_p[$atom_p_k])) {
                    $cumulitive_values_p[$atom_p_k] = $cumulitive_values_p[$atom_p_k] + $atom_p_v;
                } else {
                    $cumulitive_values_p[$atom_p_k] = $atom_p_v;
                }
            }
        }
        return response()->json([
            'status' => true,
            'html' => view('pages.console.other_input.reaction.product-output', [
                'cumulitive_values' => $cumulitive_values,
                'cumulitive_values_p' => $cumulitive_values_p,
                'cumulitive_values_p' => $cumulitive_values_p,
                'variable_p' => $variable_p,
                'variable_r' => $variable_r
            ])->render()
        ]);
    }
}
