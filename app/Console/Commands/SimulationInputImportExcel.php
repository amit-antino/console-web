<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Experiment\SimulateInputExcelTemplate;
use App\Models\ProcessExperiment\Variation;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\Experiment\sim_inp_template_upload;
use Maatwebsite\Excel\Facades\Excel;
use Log;

class SimulationInputImportExcel extends Command
{
    protected $signature = 'Input:SimulationInputImportExcel';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $input = new SimulationInputImportExcel();
        $match[] = ['excel_file', '!=', NULL];
        $match[] = ['status', '=', 0];
        $templatelist = sim_inp_template_upload::where($match)->get();
        // $templatelist = SimulateInputExcelTemplate::where(function ($query) {
        //     $query->where("excel_template_file","!=",NULL)
        //         ->where("import_status","=",0);
        // })->orWhere(function($query) {
        //     $query->where("reverse_template_file","!=",NULL)
        //         ->where("reverse_import_status","=",0);	
        // })->get();
        if (!is_null($templatelist)) {
            foreach ($templatelist as $list) {
                $variation = Variation::find($list->variation_id);
                if($list->tenant_id>0)
                    $inputFileName = public_path('assets/uploads/simulation_input_excel/'.$list->tenant_id.'/'. $list['excel_file']);
                else
                    $inputFileName = public_path('assets/uploads/simulation_input_excel/' . $list['excel_file']);
                if ($list['type'] == "forward" && $inputFileName != NULL) {
                    $input->forwardData($inputFileName, $list, $variation);
                }
                if ($list['type'] == "reverse" && $inputFileName != NULL) {
                    $input->reverseData($inputFileName, $list, $variation);
                }
            }
        }
    }
    
    public function forwardData($inputFileName = null, $list = null, $variation = null)
    {
        $rows =  Excel::toArray([], $inputFileName);
        $filenm = explode('#', $list['excel_file']);
        foreach ($rows[0][0] as $key => $value) {
            if ($value == NULL)
                continue;
            $row = array("key" => $key, "value" => $value);
            $table[] = $row;
        }
        $r = 3;
        if (isset($rows[0][3])) {
            for ($rows[0][3]; $r < sizeof($rows[0]); $r++) {
                $raw_material = [];
                $master_condition = [];
                $master_outcome = [];
                $exp_condition = [];
                $exp_outcome = [];
                for ($i = 0; $i < sizeof($table); $i++) {
                    $ckey = $table[$i]['key'];
                    $nkey = isset($table[$i + 1]) ? $table[$i + 1]['key'] : sizeof($rows[0][2]);
                    $raw_id = 1;
                    $mcond_id = 1;
                    $mout_id = 1;
                    $eucond_id = 1;
                    $euout_id = 1;
                    if ($table[$i]['value'] == "Raw Material") {
                        if (isset($table[$i + 1])) {
                            $data = array();
                            for ($j = $ckey; $j <= $nkey; $j++) {
                                if ($rows[0][1][$j] == NULL)
                                    continue;
                                $row2 = array("key" => $j, "value" => $rows[0][1][$j]);
                                $data[] = $row2;
                            }
                            if (isset($data[0])) {
                                for ($c = 0; $c < sizeof($data); $c++) {
                                    $cckey = $data[$c]['key'];
                                    $nckey = isset($data[$c + 1]) ? $data[$c + 1]['key'] : $nkey;
                                    $stream = explode('#', $data[$c]['value']);
                                    if(!isset($stream[2]))
                                        continue;
                                    for ($pcol = $cckey; $pcol < $nckey; $pcol++) {
                                        $product = explode('#', $rows[0][2][$pcol]);
                                        if ($pcol == $cckey) {
                                            $value_flow_rate = isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0;
                                            $unit_constant_id = is_numeric($product[1])?0:___decrypt($product[1]);
                                        } else {
                                            $products[] = [
                                                "product_id" => ___decrypt($product[1]),
                                                "value" => isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0,
                                                "value_flow_rate" => 0,
                                                "unit_constant_id" => 0
                                            ];
                                        }
                                    }
                                    $raw_material[] = [
                                        'id' => $raw_id,
                                        'pfd_stream_id' => ___decrypt($stream[1]),
                                        'unit_id' => is_numeric($stream[2])?0:___decrypt($stream[2]),
                                        'value_flow_rate' => isset($value_flow_rate) ? $value_flow_rate : 0,
                                        'unit_constant_id' => isset($unit_constant_id) ? $unit_constant_id : 0,
                                        'product' => isset($products) ? $products : [],
                                    ];
                                    $products = [];
                                    $raw_id++;
                                }
                            }
                        }
                    }
                    if ($table[$i]['value'] == "Master Condition") {
                        for ($pcol = $ckey; $pcol < $nkey; $pcol++) {
                            $product = explode('#', $rows[0][2][$pcol]);
                           
                            $master_condition[] = [
                                "id" => $mcond_id,
                                "value" => isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0,
                                "unit_id" => is_numeric($product[2])?$product[2]:___decrypt($product[2]),
                                "condition_id" => ___decrypt($product[1]),
                                "unit_constant_id" => is_numeric($product[3])?$product[3]:___decrypt($product[3]),
                            ];
                            $mcond_id++;
                        }
                    }
                    if ($table[$i]['value'] == "Master Outcome") {

                        for ($pcol = $ckey; $pcol < $nkey; $pcol++) {

                            $product = explode('#', $rows[0][2][$pcol]);
                            $master_outcome[] = [
                                "id" => $mout_id,
                                "value" => isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0,
                                "unit_id" => is_numeric($product[2])?0:___decrypt($product[2]),
                                "criteria" => 0,
                                "priority" => 0,
                                "max_value" => 0,
                                "outcome_id" => ___decrypt($product[1]),
                                "unit_constant_id" => is_numeric($product[3])?0:___decrypt($product[3]),
                            ];
                            $mout_id++;
                        }
                    }
                    if ($table[$i]['value'] == "Experiment Unit Condition") {
                        if (isset($table[$i])) {
                            $data = array();
                            for ($j = $ckey; $j <= $nkey; $j++) {
                                // Log::info($rows[0][1][$j]);
                                if ($rows[0][1][$j] == NULL)
                                    continue;
                                $row2 = array("key" => $j, "value" => $rows[0][1][$j]);
                                $data[] = $row2;
                            }
                            // Log::info($data);
                            if (isset($data[0])) {
                                for ($c = 0; $c < sizeof($data); $c++) {
                                    // Log::info(sizeof($data));
                                    $cckey = $data[$c]['key'];
                                    $nckey = isset($data[$c + 1]) ? $data[$c + 1]['key'] : $nkey;
                                    $stream = explode('#', $data[$c]['value']);
                                 
                                    for ($pcol = $cckey; $pcol <$nckey; $pcol++) {
                                        $product = explode('#', $rows[0][2][$pcol]);
                                        $exp_condition[] = [
                                            "id" => $eucond_id,
                                            "value" => isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0,
                                            "unit_id" => isset($product[2])?$product[2]!=0?___decrypt($product[2]):0:0,
                                            "criteria" => 0,
                                            "priority" => 0,
                                            "max_value" => 0,
                                            "exp_unit_id" => ___decrypt($stream[1]),
                                            "condition_id" => ___decrypt($product[1]),
                                            "unit_constant_id" => !empty($product[3])?___decrypt($product[3]):0,
                                        ];
                                       
                                        $eucond_id++;
                                    }
                                }
                                // Log::info($exp_condition);
                            }
                        }
                    }
                    if ($table[$i]['value'] == "Experiment Unit Outcome") {
                        if (isset($table[$i])) {
                            $data = array();
                            for ($j = $ckey; $j <= $nkey; $j++) {
                                if (isset($rows[0][1][$j])) {
                                    if ($rows[0][1][$j] == NULL)
                                        continue;
                                    $row2 = array("key" => $j, "value" => $rows[0][1][$j]);
                                    $data[] = $row2;
                                }
                            }
                            if (isset($data[0])) {
                                for ($c = 0; $c < sizeof($data); $c++) {
                                    $cckey = $data[$c]['key'];
                                    $nckey = isset($data[$c + 1]) ? $data[$c + 1]['key'] : sizeof($rows[0][2]);
                                    $stream = explode('#', $data[$c]['value']);
                                    for ($pcol = $cckey; $pcol < $nckey; $pcol++) {
                                        $product = explode('#', $rows[0][2][$pcol]);
                                       
                                        if (!isset($product[2]))
                                            break;
                                        if (!isset($product[3]))
                                            break;
                                        $exp_outcome[] = [
                                            "id" => $euout_id,
                                            "value" => isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0,
                                            "unit_id" => ___decrypt($product[2]),
                                            "criteria" => 0,
                                            "priority" => 0,
                                            "max_value" => 0,
                                            "exp_unit_id" => ___decrypt($stream[1]),
                                            "outcome_id" => ___decrypt($product[1]),
                                            "unit_constant_id" => $product[3]!=null?___decrypt($product[3]):0,
                                        ];
                                        $euout_id++;
                                    }
                                }
                            }
                        }
                    }
                }
                // Log::info($variation['experiment_id']);
                // Log::info($list['variation_id']);
                // Log::info($list['id']);
                // Log::info($filenm[1]);
                // Log::info($rows[0][$r][0] .' ('.$list['template_name'].')');
                // Log::info(json_encode($raw_material));
                // Log::info(json_encode($master_condition));
                // Log::info(json_encode($master_outcome));
                // Log::info('final');
                // Log::info(json_encode($exp_condition));
                // Log::info(json_encode($exp_outcome));
                $sinput = new SimulateInput();
                $sinput->file_id = $list['id'];
                $sinput->experiment_id = $variation['experiment_id'];
                $sinput->variation_id = $list['variation_id'];
                $sinput->template_id = $list['template_id'];
                $sinput->simulate_input_type = $list['type'];
                $sinput->name = $rows[0][$r][0] . ' (' . $list['template_name'] . ')';
                $sinput->raw_material = $raw_material;
                $sinput->master_condition = $master_condition;
                $sinput->master_outcome = $master_outcome;
                $sinput->unit_condition = $exp_condition;
                $sinput->unit_outcome = $exp_outcome;
                $sinput->created_by = $list['entry_by'];
                $sinput->updated_by = $list['entry_by'];
                $sinput->save();
                
            }
            $list->status = 1;
            $list->save();
        } else {
            $list->status = 2;
            $list->save();
        }
    }

    public function reverseData($inputFileName = null, $list = null, $variation = null)
    {
        // Log::info('reverse');
        $rows =  Excel::toArray([], $inputFileName);
        $filenm = explode('#', $list['excel_file']);
        foreach ($rows[0][0] as $key => $value) {
            if ($value == NULL)
                continue;
            $row = array("key" => $key, "value" => $value);
            $table[] = $row;
        }
        $r = 3;
        if (isset($rows[0][3])) {
            for ($rows[0][3]; $r < sizeof($rows[0]); $r++) {
                $raw_material = [];
                $master_condition = [];
                $master_outcome = [];
                $exp_condition = [];
                $exp_outcome = [];
                for ($i = 0; $i < sizeof($table); $i++) {
                    $ckey = $table[$i]['key'];
                    $nkey = isset($table[$i + 1]) ? $table[$i + 1]['key'] : sizeof($rows[0][2]);
                    $raw_id = 1;
                    $mcond_id = 1;
                    $mout_id = 1;
                    $eucond_id = 1;
                    $euout_id = 1;
                    if ($table[$i]['value'] == "Raw Material") {
                        if (isset($table[$i + 1])) {
                            $data = array();
                            for ($j = $ckey; $j <= $nkey; $j++) {
                                if ($rows[0][1][$j] == NULL)
                                    continue;
                                $row2 = array("key" => $j, "value" => $rows[0][1][$j]);
                                $data[] = $row2;
                            }
                            if (isset($data[0])) {
                                for ($c = 0; $c < sizeof($data); $c++) {
                                    $cckey = $data[$c]['key'];
                                    $nckey = isset($data[$c + 1]) ? $data[$c + 1]['key'] : $nkey;
                                    $stream = explode('#', $data[$c]['value']);
                                    if(!isset($stream[2]))
                                        break;
                                    for ($pcol = $cckey; $pcol < $nckey; $pcol++) {

                                        $product = explode('#', $rows[0][2][$pcol]);
                                        if ($pcol == $cckey) {
                                            $value_flow_rate = isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0;
                                            $unit_constant_id = is_numeric($product[1])?$product[1]:___decrypt($product[1]);
                                        } else {
                                            $value = isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0;
                                            $val = explode('#', $value);
                                            $value = explode(',', $val[0]);
                                            if (isset($val[1])) {
                                                if (trim($val[1]) == "=")
                                                    $criteria = 1;
                                                else if (trim($val[1]) == "<")
                                                    $criteria = 2;
                                                else if (trim($val[1]) == ">")
                                                    $criteria = 3;
                                                else if (trim($val[1]) == "Range")
                                                    $criteria = 4;
                                            } else
                                                $criteria = 1;
                                            $products[] = [
                                                "product_id" => ___decrypt($product[1]),
                                                "value" => isset($value[0]) ? $value[0] : $value,
                                                "value_flow_rate" => 0,
                                                'criteria' => $criteria,
                                                "unit_constant_id" => 0,
                                                "max_value" => isset($value[1]) ? $value[1] : 0
                                            ];
                                        }
                                    }
                                    $raw_material[] = [
                                        'id' => $raw_id,
                                        'pfd_stream_id' => ___decrypt($stream[1]),
                                        'unit_id' => ___decrypt($stream[2]),
                                        'value_flow_rate' => isset($value_flow_rate) ? $value_flow_rate : 0,
                                        'unit_constant_id' => isset($unit_constant_id) ? $unit_constant_id : 0,
                                        'product' => isset($products) ? $products : [],
                                    ];
                                    $products = [];
                                    $raw_id++;
                                }
                            }
                        }
                    }
                    if ($table[$i]['value'] == "Master Condition") {
                        for ($pcol = $ckey; $pcol < $nkey; $pcol++) {
                            $product = explode('#', $rows[0][2][$pcol]);
                           
                            $value = isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0;
                            $val = explode('#', $value);
                            $value = explode(',', $val[0]);
                            if (isset($val[1])) {
                                if (trim($val[1]) == "=")
                                    $criteria = 1;
                                else if (trim($val[1]) == "<")
                                    $criteria = 2;
                                else if (trim($val[1]) == ">")
                                    $criteria = 3;
                                else if (trim($val[1]) == "Range")
                                    $criteria = 4;
                            } else
                                $criteria = 1;
                            $master_condition[] = [
                                "id" => $mcond_id,
                                "value" => isset($value[0]) ? $value[0] : $value,
                                "unit_id" => is_numeric($product[2])?0:___decrypt($product[2]),
                                "condition_id" =>___decrypt($product[1]),
                                'criteria' => $criteria,
                                "unit_constant_id" => is_numeric($product[3])?0:___decrypt($product[3]),
                            ];
                            $mcond_id++;
                        }
                    }
                    if ($table[$i]['value'] == "Master Outcome") {

                        for ($pcol = $ckey; $pcol < $nkey; $pcol++) {
                            $product = explode('#', $rows[0][2][$pcol]);
                            $value = isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0;
                            $val = explode('#', $value);
                            $value = explode(',', $val[0]);
                            if (isset($val[1])) {
                                if (trim($val[1]) == "=")
                                    $criteria = 1;
                                else if (trim($val[1]) == "<")
                                    $criteria = 2;
                                else if (trim($val[1]) == ">")
                                    $criteria = 3;
                                else if (trim($val[1]) == "Range")
                                    $criteria = 4;
                            } else
                                $criteria = 1;
                            $master_outcome[] = [
                                "id" => $mout_id,
                                "value" => isset($value[0]) ? $value[0] : $value,
                                "unit_id" => is_numeric($product[2])?0:___decrypt($product[2]),
                                'criteria' => $criteria,
                                "priority" => 0,
                                "max_value" => isset($value[1]) ? $value[1] : 0,
                                "outcome_id" => ___decrypt($product[1]),
                                "unit_constant_id" => is_numeric($product[3])?0:___decrypt($product[3]),
                            ];
                            $mout_id++;
                        }
                    }
                    if ($table[$i]['value'] == "Experiment Unit Condition") {
                        if (isset($table[$i])) {
                            $data = array();
                            for ($j = $ckey; $j <= $nkey; $j++) {
                                if ($rows[0][1][$j] == NULL)
                                    continue;
                                $row2 = array("key" => $j, "value" => $rows[0][1][$j]);
                                $data[] = $row2;
                            }
                            if (isset($data[0])) {
                                for ($c = 0; $c < sizeof($data); $c++) {
                                    $cckey = $data[$c]['key'];
                                    $nckey = isset($data[$c + 1]) ? $data[$c + 1]['key'] : $nkey;
                                    $stream = explode('#', $data[$c]['value']);
                                    for ($pcol = $cckey; $pcol < $nckey; $pcol++) {
                                        $product = explode('#', $rows[0][2][$pcol]);
                                        $value = isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0;
                                        $val = explode('#', $value);
                                        $value = explode(',', $val[0]);
                                        if (isset($val[1])) {
                                            if (trim($val[1]) == "=")
                                                $criteria = 1;
                                            else if (trim($val[1]) == "<")
                                                $criteria = 2;
                                            else if (trim($val[1]) == ">")
                                                $criteria = 3;
                                            else if (trim($val[1]) == "Range")
                                                $criteria = 4;
                                        } else
                                            $criteria = 1;
                                        $exp_condition[] = [
                                            "id" => $eucond_id,
                                            "value" => isset($value[0]) ? $value[0] : $value,
                                            "unit_id" => isset($product[2])?$product[2]!=0?___decrypt($product[2]):0:0,
                                            'criteria' => $criteria,
                                            "priority" => 0,
                                            "max_value" => isset($value[1]) ? $value[1] : 0,
                                            "exp_unit_id" => ___decrypt($stream[1]),
                                            "condition_id" => ___decrypt($product[1]),
                                            "unit_constant_id" => !empty($product[3])?___decrypt($product[3]):0,
                                        ];
                                        $eucond_id++;
                                    }
                                }
                            }
                        }
                    }
                    if ($table[$i]['value'] == "Experiment Unit Outcome") {
                        if (isset($table[$i])) {

                            $data = array();
                            for ($j = $ckey; $j <= $nkey; $j++) {
                                if (isset($rows[0][1][$j])) {
                                    if ($rows[0][1][$j] == NULL)
                                        continue;
                                    $row2 = array("key" => $j, "value" => $rows[0][1][$j]);
                                    $data[] = $row2;
                                }
                            }
                            if (isset($data[0])) {
                                for ($c = 0; $c < sizeof($data); $c++) {
                                    $cckey = $data[$c]['key'];
                                    $nckey = isset($data[$c + 1]) ? $data[$c + 1]['key'] : sizeof($rows[0][2]);
                                    $stream = explode('#', $data[$c]['value']);
                                    for ($pcol = $cckey; $pcol < $nckey; $pcol++) {
                                        $product = explode('#', $rows[0][2][$pcol]);
                                        if (!isset($product[2]))
                                            break;
                                        $value = isset($rows[0][$r][$pcol]) ? $rows[0][$r][$pcol] : 0;
                                        $val = explode('#', $value);
                                        $value = explode(',', $val[0]);
                                        if (isset($val[1])) {
                                            if (trim($val[1]) == "=")
                                                $criteria = 1;
                                            else if (trim($val[1]) == "<")
                                                $criteria = 2;
                                            else if (trim($val[1]) == ">")
                                                $criteria = 3;
                                            else if (trim($val[1]) == "Range")
                                                $criteria = 4;
                                        } else
                                            $criteria = 1;
                                        $exp_outcome[] = [
                                            "id" => $euout_id,
                                            "value" => isset($value[0]) ? $value[0] : $value,
                                            "unit_id" => isset($product[2])?$product[2]!=0?___decrypt($product[2]):0:0,
                                            'criteria' => $criteria,
                                            "priority" => 0,
                                            "max_value" => isset($value[1]) ? $value[1] : 0,
                                            "exp_unit_id" => ___decrypt($stream[1]),
                                            "outcome_id" => ___decrypt($product[1]),
                                            "unit_constant_id" => $product[3]!=null?___decrypt($product[3]):0,
                                        ];
                                        $euout_id++;
                                    }
                                }
                            }
                        }
                    }
                }
                // Log::info($variation['experiment_id']);
                // Log::info($list['variation_id']);
                // Log::info($list['id']);
                // Log::info($filenm[1]);
                // Log::info($rows[0][$r][0] .' ('.$list['template_name'].')');
                // Log::info(json_encode($raw_material));
                // Log::info(json_encode($master_condition));
                // Log::info(json_encode($master_outcome));
                // Log::info(json_encode($exp_condition));
                // Log::info(json_encode($exp_outcome));
                $sinput = new SimulateInput();
                $sinput->file_id = $list['id'];
                $sinput->experiment_id = $variation['experiment_id'];
                $sinput->variation_id = $list['variation_id'];
                $sinput->template_id = $list['template_id'];
                $sinput->simulate_input_type = $list['type'];
                $sinput->name = $rows[0][$r][0] . ' (' . $list['template_name'] . ')';
                $sinput->raw_material = $raw_material;
                $sinput->master_condition = $master_condition;
                $sinput->master_outcome = $master_outcome;
                $sinput->unit_condition = $exp_condition;
                $sinput->unit_outcome = $exp_outcome;
                $sinput->created_by = $list['entry_by'];
                $sinput->updated_by = $list['entry_by'];
                $sinput->save();
            }
            $list->status = 1;
            $list->save();
        } else {
            $list->status = 2;
            $list->save();
        }
    }
}
