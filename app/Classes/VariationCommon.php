<?php

namespace App\Classes;

use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\ProcessExperiment\Variation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class VariationCommon
{

    public  function variation_list($request, $redis_update = '', $exp_id = 0)
    {
        if (!empty($request->experiment_id)) {
            $exp_id = ___decrypt($request->experiment_id);
        }
        if (!empty($request->process_experiment_id)) {
            $exp_id = ___decrypt($request->process_experiment_id);
        }
        
        $cachedVariation = Redis::get('experiment_variation' . session()->get('tenant_id') . $exp_id);
        if (empty(json_decode($cachedVariation)->variation_details) || !empty($redis_update)) {
            $process_experiment = ProcessExperiment::find($exp_id);
            if (Auth::user()->role == 'console') {
                $variations = Variation::where('created_by', Auth::user()->id)->where('experiment_id', $exp_id)->orderBy('id', 'desc')->get();
            } else {
                $variations = Variation::where('experiment_id', $exp_id)->orderBy('id', 'desc')->get();
            }
            $variation_details = [];
            if (!empty($variations)) {
                foreach ($variations as $variation) {
                    $total_no_simulation = SimulateInput::where('variation_id', $variation->id)->count();
                    $variation_details[] = [
                        "id" => $variation->id,
                        "variation_name" => $variation->name,
                        "description" => $variation->description,
                        "total_no_simulation" => $total_no_simulation,
                        "updated_by" => get_user_name($variation->updated_by),
                        "created_by" => get_user_name($variation->created_by),
                        "created_at" => date('d/m/Y h:i:s A', strtotime($variation->created_at)),
                        "updated_at" => date('d/m/Y h:i:s A', strtotime($variation->updated_at)),
                        "experiment_id" => $variation->experiment_id,
                        "status" => $variation->status
                    ];
                }
            }
            $experiment_variation = [
                "id" => $process_experiment->id,
                "name" => $process_experiment->process_experiment_name,
                "variation_details" => $variation_details,
                "variation_details" => $variation_details,
                "viewflag" => $request->viewflag
            ];
            Redis::del('experiment_variation' . session()->get('tenant_id') . $process_experiment->id);
            Redis::set('experiment_variation' . session()->get('tenant_id') . $process_experiment->id, json_encode($experiment_variation), 'EX', 120);
        } else {
            $experiment_variation = json_decode($cachedVariation, TRUE);
        }
        return $experiment_variation;
    }
}
