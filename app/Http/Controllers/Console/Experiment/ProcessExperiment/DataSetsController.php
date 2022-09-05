<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use App\Models\Experiment\ProcessDiagram;
use Illuminate\Http\Request;

class DataSetsController extends Controller
{
    public function index()
    {
        return view('pages.console.experiment.dataset.index');
    }    

    public function store(Request $request)
    {
        $reverse_master_product_io = [];
        if (!empty($variation['process_flow_table'])) {
            $r_key = 0;
            foreach ($variation['process_flow_table'] as $r_key => $process_diagram_id) {
                $process_diagram_data = ProcessDiagram::find($process_diagram_id);
                if ($process_diagram_data->openstream == 1) {
                    $process_diagram[$r_key]['id'] = intval($r_key + 1);
                    $process_diagram[$r_key]['pfd_stream_id'] = $process_diagram_data->id;
                    $process_diagram[$r_key]['unit_id'] = 0;
                    $process_diagram[$r_key]['value_flow_rate'] = 0;
                    $process_diagram[$r_key]['unit_constant_id'] = 0;
                    $process_diagram[$r_key]['product'] = [];
                }
            }
            $reverse_master_product_io = $process_diagram;
        }
        $r_master_conditions = [];
        if (!empty($variation['unit_specification']['master_units']['conditions'])) {
            foreach ($variation['unit_specification']['master_units']['conditions'] as $r_key => $condition_value) {
                $r_master_conditions[$r_key]['id'] = $r_key + 1;
                $r_master_conditions[$r_key]['condition_id'] = $condition_value;
                $r_master_conditions[$r_key]['unit_id'] = '';
                $r_master_conditions[$r_key]['value'] = '';
                $r_master_conditions[$r_key]['unit_constant_id'] = '';
            }
        }
        $r_master_outcomes = [];
        if (!empty($variation['unit_specification']['master_units']['outcomes'])) {
            foreach ($variation['unit_specification']['master_units']['outcomes'] as $r_key => $outcome_value) {
                $r_master_outcomes[$r_key]['id'] = $r_key + 1;
                $r_master_outcomes[$r_key]['outcome_id'] = $outcome_value;
                $r_master_outcomes[$r_key]['unit_id'] = '';
                $r_master_outcomes[$r_key]['value'] = '';
                $r_master_outcomes[$r_key]['unit_constant_id'] = '';
            }
        }
        $experiment_unit_profile = [];
        if (!empty($variation['unit_specification']['experiment_units'])) {
            $experiment_unit_profile = $variation['unit_specification']['experiment_units'];
        }
        $exp_unit_outcomes = [];
        $exp_unit_conditions = [];
        $i = 0;
        foreach ($experiment_unit_profile as $r_keys => $exp_unit_profile) {
            $exp_unit_id['exp_unit_id'] = $exp_unit_profile['pe_experiment_unit_id'];
            if (!empty($exp_unit_profile['outcomes'])) {
                foreach ($exp_unit_profile['outcomes'] as $r_key => $outcome_value) {
                    $exp_unit_outcomes[$i]['id'] = $i + 1;
                    $exp_unit_outcomes[$i]['exp_unit_id'] = $exp_unit_profile['pe_experiment_unit_id'];
                    $exp_unit_outcomes[$i]['outcome_id'] = $outcome_value;
                    $exp_unit_outcomes[$i]['unit_id'] = '';
                    $exp_unit_outcomes[$i]['value'] = '';
                    $exp_unit_outcomes[$i]['unit_constant_id'] = '';
                    $i++;
                }
            }
        }
        $j = 0;
        foreach ($experiment_unit_profile as $r_keys => $exp_unit_profile) {
            $exp_unit_id['exp_unit_id'] = $exp_unit_profile['pe_experiment_unit_id'];
            if (!empty($exp_unit_profile['conditions'])) {
                foreach ($exp_unit_profile['conditions'] as $r_key => $condition_value) {
                    $exp_unit_conditions[$j]['id'] = $j + 1;
                    $exp_unit_conditions[$j]['exp_unit_id'] = $exp_unit_profile['pe_experiment_unit_id'];
                    $exp_unit_conditions[$j]['condition_id'] = $condition_value;
                    $exp_unit_conditions[$j]['unit_id'] = '';
                    $exp_unit_conditions[$j]['value'] = '';
                    $exp_unit_conditions[$j]['unit_constant_id'] = '';
                    $j++;
                }
            }
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
