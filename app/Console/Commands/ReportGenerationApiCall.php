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


class ReportGenerationApiCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ReportGeneration:ApiCall';

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
    private $com='';
    public function __construct()
    {
        parent::__construct();
        $this->com=new Common();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $match[]=['job_id','>',0];
        $status=array('pending');
        foreach($status as $st)
        {
            $match[]=['status','=',$st];
            $reportList=ExperimentReport::where($match)->orderBy('queue_id','asc')->get();
            if(!is_null($reportList))
            {
                foreach($reportList as $rpt)
                {
                    $tenant = getTenentCalURL($rpt->tenant_id);
                    if ($rpt->report_type == "1") {
                        $calc_url = !empty($tenant['calc_url']) ? $tenant['calc_url'] : env('GENERATE_REPORT');
                        //$calc_url = env('GENERATE_REPORT');
                        $url = $calc_url . '/api/v1/experiment/generate/forward_report';
                    } else {
                        $calc_url = !empty($tenant['calc_url']) ? $tenant['calc_url'] : env('GENERATE_REPORT');
                        $url = $calc_url . '/api/v1/experiment/generate/reverse_report';
                    }
                    $data = [
                        'report_id' => $rpt->id,
                        'simulate_input_id' => $rpt->simulation_input_id,
                        'tenant_id' => $rpt->tenant_id,
                        'request_type' => env('REQUEST_TYPE'),
                        'user_id' => $rpt->created_by
                    ];
                    $client = new Client();
                    $options = [
                        'form' => $data,
                        // 'http_errors' => false,
                        //'timeout' => 3
                    ];
                    $this->com->callApi('POST',$url,$data);
                    //$promise = $client->request('POST', $url, $options);
                }
            }
        }
    }
}
