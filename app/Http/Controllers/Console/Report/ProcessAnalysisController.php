<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use App\Models\Master\ProcessSimulation\ProcessType;
use Illuminate\Http\Request;
use App\Models\Master\ProcessSimulation\SimulationType;
use App\Models\MFG\ProcessSimulation;
use App\Models\OtherInput\EnergyUtility;
use App\Models\Report\ProcessSimulationReport;
use App\Models\Product\Chemical;
use App\Models\MFG\ProcessProfile;
use App\Models\Report\ProcessAnalysisReport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Repository\Eloquent\ProcessAnalysisRepository;
use App\Repository\Reports\Interfaces\ProcessAnalysisInterface;

class ProcessAnalysisController extends Controller
{

    public $report;

    public function __construct(Request $request, ProcessAnalysisInterface $report)
    {
        parent::__construct($request);
        $this->report = $report;
    }
    
    public function index()
    {
        $process_simulation_reports = $this->report->getAll();
        $process_simulations = ProcessSimulation::where('tenant_id', session()->get('tenant_id'))->where('status','active')->get();
        $process_simulation =[];
        foreach( $process_simulations as $k=>$ps){
            $datasetcount = ProcessProfile::where('process_id', $ps->id)->count();
            if($datasetcount>0){
                $process_simulation[$k]['id'] = $ps['id'];
                $process_simulation[$k]['process_name'] = $ps['process_name'];
            }
        }
        return view('pages.console.report.process_analysis.index', compact('process_simulation_reports','process_simulation'));
    }

    public function get_process_simulations(Request $request)
    {
        $simulation = $request->id;
        $process_simulations = ProcessProfile::where([['simulation_type', ___decrypt($simulation)]])->get();
        $simulation_detail = [];
        foreach ($process_simulations as $key => $value) {
            if ($value->processSimulation) {
                $simulation_detail[$value->id]['process_name'] = $value->processSimulation->process_name;
                $simulation_detail[$value->id]['id'] = $value->processSimulation->id;
            } else {
                $simulation_detail[$value->id]['processSimulation'] = "";
            }
        }
        $SimulationDataSourcesType1 = [];
        $dsources = SimulationType::where(["id" => ___decrypt($simulation)])->first();
        if (!empty($dsources['mass_balance'])) {
            $SimulationDataSourcesType1 = $dsources['mass_balance'];
        }
        $SimulationDataSourcesType2 = [];
        if (!empty($dsources['enery_utilities'])) {
            $SimulationDataSourcesType2 = ($dsources['enery_utilities']);
        }
        $data['simulation_detail'] = $simulation_detail;
        $data['SimulationDataSourcesType1'] = $SimulationDataSourcesType1;
        $data['SimulationDataSourcesType2'] = $SimulationDataSourcesType2;

        return json_encode($data);
    }

    public function get_process_simulation_details(Request $request)
    {

        $process_simulations_profile = ProcessProfile::where([['simulation_type', ___decrypt($request->type)], ['process_id', $request->id]])->first();
        $process_simulation = ProcessSimulation::select(['id', 'process_name', 'main_product', 'main_feedstock'])->where('id', $request->id)->get();
        $data = [];
        foreach ($process_simulation as $key => $val) {
            $data['id'] = $val['id'];
            // Test if string contains the word 
            if (strpos($val['main_feedstock'], "ch_") !== false) {
                $chdata = explode('ch_', $val['main_feedstock']);
                $chid = $chdata[1];
                $chemData = Chemical::select(['id', 'chemical_name'])->where('id', $chid)->get();
                foreach ($chemData->toArray() as $value) {
                    $data['main_feedstock'] = $value['chemical_name'];
                    $data['main_feedstock_id'] = $value['id'];
                }
            } else if (strpos($val['main_feedstock'], "en_") !== false) {
                $endata = explode('en_', $val['main_feedstock']);
                $enid = $endata[1];
                $enData = EnergyUtility::select(['id', 'energy_name'])->where('id', $enid)->get();
                foreach ($enData->toArray() as $value) {
                    $data['main_feedstock'] = $value['energy_name'];
                    $data['main_feedstock_id'] = $value['id'];
                }
            } else {
                $data['main_feedstock'] = "";
                $data['main_feedstock_id'] = "";
            }
            if (strpos($val['main_product'], "ch_") !== false) {
                $chdata = explode('ch_', $val['main_product']);
                $chid = $chdata[1];
                $chemData = Chemical::select(['id', 'chemical_name'])->where('id', $chid)->get();
                foreach ($chemData->toArray() as $value) {
                    $data['main_product'] = $value['chemical_name'];
                    $data['main_product_id'] = "ch_" . $value['id'];
                }
            } else if (strpos($val['main_product'], "en_") !== false) {
                $endata = explode('en_', $val['main_product']);
                $enid = $endata[1];
                $enData = EnergyUtility::select(['id', 'energy_name'])->where('id', $enid)->get();
                foreach ($enData->toArray() as $value) {
                    $data['main_product'] = $value['energy_name'];
                    $data['main_product_id'] = "en_" . $value['id'];
                }
            } else {
                $data['main_product'] = "";
                $data['main_product_id'] = "";
            }
        }
        $sourcetype1 = [];
        $sourcetype2 = [];
        if (!empty($process_simulations_profile->mass_basic_io)) {
            array_push($sourcetype1, 1);
        }
        if (!empty($process_simulations_profile->mass_basic_pc)) {
            array_push($sourcetype1, 2);
        }
        if (!empty($process_simulations_profile->mass_basic_pd)) {
            array_push($sourcetype1, 3);
        }
        if (!empty($process_simulations_profile->energy_basic_io)) {
            array_push($sourcetype2, 1);
        }
        if (!empty($process_simulations_profile->energy_process_level)) {
            array_push($sourcetype2, 2);
        }
        if (!empty($process_simulations_profile->energy_detailed_level)) {
            array_push($sourcetype2, 3);
        }
        $SimulationDataSourcesType1 = [];

        $dsources = SimulationType::where(["id" => ___decrypt($request->type)])->first();

        if (!empty($dsources['mass_balance'])) {
            foreach ($dsources['mass_balance'] as $mbkey => $mbval) {
                if (!empty($sourcetype1) && in_array($mbval['id'], $sourcetype1)) {
                    $SimulationDataSourcesType1[$mbkey]['id'] = $mbval['id'];
                    $SimulationDataSourcesType1[$mbkey]['data_source'] = $mbval['data_source'];
                }
            }
        }

        $SimulationDataSourcesType2 = [];
        $energysource = ($dsources['enery_utilities']);
        if (!empty($energysource)) {
            foreach ($energysource as $enkey => $enval) {
                if (!empty($sourcetype2) && in_array($enval['id'], $sourcetype2)) {
                    $SimulationDataSourcesType2[$enkey]['id'] = $enval['id'];
                    $SimulationDataSourcesType2[$enkey]['data_source'] = $enval['data_source'];
                }
            }
        }
        $obj['simulation_detail'] = $data;
        $obj['SimulationDataSourcesType1'] = $SimulationDataSourcesType1;
        $obj['SimulationDataSourcesType2'] = $SimulationDataSourcesType2;
        return json_encode($obj);
    }

    public function create()
    {
        $simulation_types = SimulationType::all();
        return view('pages.console.report.process_analysis.create', compact('simulation_types'));
    }

    public function store(Request $request)
    {
        try {
            $response = $this->report->createReport($request);
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/reports/process_analysis');
            $this->message = "Process Analysis Report Created Successfully!";
        } catch (\Exception $e) {
            $this->status = true;
            $this->modal = true;
            $this->message =  $e->getMessage();
        }
        return $this->populateresponse();
    }

    public function show($id){
        $report = ProcessAnalysisReport::find(___decrypt($id));
        $process_simulation = ProcessSimulation::with('processType')->find($report['process_id']);
        $dataset = ProcessProfile::find($report['dataset_id']);
        $simulationtype = get_simulation_stage($dataset['simulation_type']);
        $response = $report['report_json'];
        $response = json_decode($response, true);
        $reportinfo =[
            "id"=>$report['id'],
            "name"=>$report['report_name'],
            "created_at"=>$report['created_at'],
            "status"=>$report['status'],
            "process_name"=>$process_simulation['name'],
            "dataset_name"=>$dataset['dataset_name'],
            "process_type" => $process_simulation['processType']['name'],
            "simulation_stage"=>$simulationtype['simulation_name'],
        ];
        $report_menus = [];
        foreach (array_keys($response) as $k) {
            if (!empty($response[$k]))
                array_push($report_menus, $k);
        }
        foreach ($report_menus as $menu) {
            $report_menu[] = str_replace("_", " ", $menu);
        }
        $re_order_menu = array_slice($report_menu, 0, 9);
        return view('pages.console.report.process_analysis.view', compact('reportinfo','re_order_menu'));
    }
    
    public function showData(Request $request){
        //dd($request->all());
        $report = ProcessAnalysisReport::find(___decrypt($request->report_id));
        $response = $report['report_json'];
        $response = json_decode($response, true);
        $menu = "";
        if (strpos($request->value, ' ')) {
            $menu = str_replace(" ", "_", $request->value);
        } else {
            $menu = $request->value;
        }
        
        if($menu = "process_data"){
            $data = $response['process_data'];
            $html = view('pages.console.report.process_analysis.tabs.'  . $menu, compact('data'))->render();
            return response()->json(['success' => true,  'html' => $html]);
            //dd($key_data_inputs,$commercial_info);
        }
    }

    public function edit($id)
    {
        return view('pages.console.report.process_analysis.edit');
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $response = $this->report->destroy($id);
        if ($response == 1) {
            $this->status = true;
        } else {
            $this->status = false;
        }
        $this->redirect = true;
        return $this->populateresponse();
    }
    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $processID = explode(',', ($id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProcessAnalysisReport::whereIn('id', $processIDS)->update($update)) {
            ProcessAnalysisReport::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('reports/process_analysis');
        return $this->populateresponse();
    }
}
