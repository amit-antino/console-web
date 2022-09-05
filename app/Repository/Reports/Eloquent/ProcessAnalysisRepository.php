<?php

namespace App\Repository\Reports\Eloquent;

use App\Models\Report\ProcessAnalysisReport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repository\Reports\Interfaces\ProcessAnalysisInterface;
use GuzzleHttp\Client;

class ProcessAnalysisRepository implements ProcessAnalysisInterface
{
    public function getAll()
    {
        $process_simulation_reports = ProcessAnalysisReport::where('tenant_id',session()->get('tenant_id'))->with('processSimulation','processDataset')->get();
        return $process_simulation_reports;
    }

    public function createReport($request)
    {
        $simulationData = new ProcessAnalysisReport();
        $simulationData->report_name = $request->report_name;
        $simulationData->process_id =  ___decrypt($request->process_id);
        $simulationData->dataset_id =  ___decrypt($request->dataset_id);
        $simulationData->tenant_id = session()->get('tenant_id');
        $simulationData->created_by = Auth::user()->id;
        $simulationData->updated_by = Auth::user()->id;
        $simulationData->description = $request->description;
        $simulationData->save();
        $report_id = $simulationData->id;
        $user_id = Auth::user()->id;
        $var = env('GENERATE_REPORT');
        $url = $var . '/api/v1/process_simulation/generate_report';
        $ds = [];
        //dd($url);
        

        $dataSource = json_encode(array_merge($ds));
        $t_id = session('tenant_id');
        $data = [
            'tenant_id' => $t_id,
            'user_id' => $user_id,
            'process_simulation_id' => $simulationData->process_id,
            'dataset_id' =>___decrypt($request->dataset_id),           
            'report_id'=>$report_id
        ];
        // dd($data);
        $client = new Client();
                    $options = [
                        'form_params' => $data,
                        // 'http_errors' => false,
                        'timeout' => 3
                    ];
                    $promise = $client->request('POST', $url, $options);

        $status = true;
        return $status;
    }

    public function destroy($id)
    {
        $del = 0;
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProcessAnalysisReport::where('id', ___decrypt($id))->update($update)) {
            $del = ProcessAnalysisReport::destroy(___decrypt($id));
        }
        return $del;
    }
}
