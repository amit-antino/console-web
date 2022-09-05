<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\Common;
use App\Models\Experiment\JobsQueue;
use App\Models\ProcessExperiment\SimulateInput;
use App\Models\Report\ExperimentReport;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Client;
use Log;

class MultipleGenerationReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MultipleGeneration:Report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $com = '';
    public function __construct()
    {
        parent::__construct();
        $this->com = new Common();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jobslist = JobsQueue::where(array('jobs'=>'report generation','status'=>0))->orderBy('id', 'asc')->get();
        if (!is_null($jobslist)) {
            foreach ($jobslist as $job) {
                $data = json_decode($job);
                // Log::info($data->id);
                // Log::info($data->queue_data);
                $queueData = json_decode($data->queue_data);
                // Log::info($queueData->teneant);
                // Log::info($queueData->data);
                if ($queueData->data) {
                    $check = 0;
                    foreach (json_decode($queueData->data) as $key => $simulation) {
                        $rptnm = "report" . $queueData->teneant . ___decrypt($simulation).$job->id.($key+1);
                        $simulationInput = SimulateInput::find(___decrypt($simulation));
                        // Log::info($simulation);
                        try {
                            $simulationData = new ExperimentReport();
                            $simulationData->job_id = $job->id;
                            $simulationData->queue_id = $key+1;
                            $simulationData->tenant_id = $queueData->teneant;
                            $simulationData->name = $rptnm;
                            $simulationData->experiment_id = $simulationInput->experiment_id;
                            $simulationData->variation_id = $simulationInput->variation_id;
                            $simulationData->simulation_input_id = ___decrypt($simulation);
                            $simulationData->report_type = $simulationInput->simulate_input_type == "forward" ? 1 : 2;
                            $simulationData->status = "pending";
                            $simulationData->created_by = $job->created_by;
                            $simulationData->updated_by = $job->created_by;
                            $simulationData->timestamps = false;
                            $simulationData->created_at = now();
                            if ($simulationData->save()) {
                                $check = 1;
                            }
                            $status = true;
                            $message = "Added Successfully!";
                        } catch (\Exception $e) {
                            $status = false;
                            $message = $e->getMessage();
                        }
                       
                    }

                    $job->status = 1;
                    $job->save();
                }
            }
        }
    }
}
