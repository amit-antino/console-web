<?php

namespace App\Classes;

use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\ProcessExperiment\Variation;
use App\Models\Tenant\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class SimulationInputCommon
{

    public  function simuation_input_list($redis_update = '')
    {
        $cachedExperiment = Redis::get('process_exp_list' . session()->get('tenant_id'));
        if (empty($cachedExperiment) || !empty($redis_update)) {
            if (Auth::user()->role == 'console') {
                $process_experiments = ProcessExperiment::where('created_by', Auth::user()->id)->where('tenant_id', session()->get('tenant_id'))->with('experiment_category', 'get_project')->get();
            } else {
                $process_experiments = ProcessExperiment::where('tenant_id', session()->get('tenant_id'))->with('experiment_category', 'get_project')->get();
            }
            $process_exp_list = [];
            $classifications = [];
            foreach ($process_experiments as $process_experiment) {
                $varcount = Variation::where('experiment_id', $process_experiment->id)->get();
                $simInputcount = SimulateInput::where('experiment_id', $process_experiment->id)->get();
                if (Auth::user()->role != 'admin') {
                    $pro = Project::where('id', $process_experiment->project_id)->first();
                    $users = !empty($pro->users) ? $pro->users : [];
                    if (in_array(Auth::user()->id, $users)) {
                        if (!empty($process_experiment->classification_id)) {
                            $classifications = experiment_classification($process_experiment->classification_id);
                        }
                        $process_exp_list[] = [
                            "id" => $process_experiment->id,
                            "name" => $process_experiment->process_experiment_name,
                            "category" => (!empty($process_experiment->category_id)) ? $process_experiment->experiment_category->name : '',
                            "classification" => $classifications,
                            "data_source" => $process_experiment->data_source,
                            "status" => $process_experiment->status,
                            "created_by" => get_user_name($process_experiment->created_by),
                            "project" => (!empty($process_experiment->project_id)) ? $process_experiment->get_project->name : '',
                            "variation_count" => count($varcount->toArray()),
                            "simInputcount" => count($simInputcount->toArray())
                        ];
                    }
                } else {
                    if (!empty($process_experiment->classification_id)) {
                        $classifications = experiment_classification($process_experiment->classification_id);
                    }
                    $process_exp_list[] = [
                        "id" => $process_experiment->id,
                        "name" => !empty($process_experiment->process_experiment_name) ? $process_experiment->process_experiment_name : '',
                        "category" => (!empty($process_experiment->experiment_category->name)) ? $process_experiment->experiment_category->name : '',
                        "classification" => $classifications,
                        "data_source" => $process_experiment->data_source,
                        "status" => $process_experiment->status,
                        "created_by" => get_user_name($process_experiment->created_by),
                        "project" => (!empty($process_experiment->get_project->name)) ? $process_experiment->get_project->name : '',
                        "variation_count" => count($varcount->toArray()),
                        "simInputcount" => count($simInputcount->toArray())
                    ];
                }
            }
            Redis::del('process_exp_list' . session()->get('tenant_id'));
            Redis::set('process_exp_list' . session()->get('tenant_id'), json_encode($process_exp_list), 'EX', 120);
        } else {
            $process_exp_list = json_decode($cachedExperiment, TRUE);
        }
        return $process_exp_list;
    }

    // public  function experiment_create($redis_update='')
    // {
    //     $process_exp_create = Redis::get('process_exp_create' . session()->get('tenant_id'));
    //     if (empty($cachedExperiment) || !empty($redis_update)) {

    //         Redis::del('process_exp_create' . session()->get('tenant_id'));
    //         Redis::set('process_exp_create' . session()->get('tenant_id'), json_encode($process_exp_list), 'EX', 120);
    //     } else {
    //         $process_exp_create = json_decode($process_exp_create, TRUE);
    //     }
    //     return $process_exp_create;
    // }
}
