<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Chemical;
use App\Models\MFG\ProcessSimulation;
use App\Models\MFG\ProcessProfile;
use App\Models\OtherInput\EnergyUtility;
use App\Models\Master\ProcessSimulation\SimulationType;
use App\Repository\Reports\Interfaces\ProcesComparsionReport;
use App\Models\Report\ProcessComaprison;
use Illuminate\Support\Facades\Auth;

class ProcessComparisonController extends Controller
{
    public $report;
    public function __construct(Request $request, ProcesComparsionReport $report)
    {
        parent::__construct($request);
        $this->report = $report;
    }
    public function index()
    {
        $process_comparsion_reports = $this->report->getAll();
        return view('pages.console.report.process_comparison.index', compact('process_comparsion_reports'));
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
        $process_simulation = ProcessSimulation::select(['id', 'process_name', 'main_product', 'main_feedstock'])->where('id', $request->id)->get();
        $data = [];
        foreach ($process_simulation as $key => $val) {
            $data['id'] = $val['id'];
            $data['process_name'] = $val['process_name'];
            // Test if string contains the word 
            if (strpos($val['main_feedstock'], "ch_") !== false) {
                $chdata = explode('ch_', $val['main_feedstock']);
                $chid = $chdata[1];
                $chemData = Chemical::select(['id', 'chemical_name'])->where('id', $chid)->get();
                foreach ($chemData->toArray() as $value) {
                    $data['main_feedstock'] = $value['chemical_name'];
                }
            } else if (strpos($val['main_feedstock'], "en_") !== false) {
                $endata = explode('en_', $val['main_feedstock']);
                $enid = $endata[1];
                $enData = EnergyUtility::select(['id', 'energy_name'])->where('id', $enid)->get();
                foreach ($enData->toArray() as $value) {
                    $data['main_feedstock'] = $value['energy_name'];
                }
            } else {
                $data['main_feedstock'] = "";
            }
            if (strpos($val['main_product'], "ch_") !== false) {
                $chdata = explode('ch_', $val['main_product']);
                $chid = $chdata[1];
                $chemData = Chemical::select(['id', 'chemical_name'])->where('id', $chid)->get();
                foreach ($chemData->toArray() as $value) {
                    $data['main_product'] = $value['chemical_name'];
                }
            } else if (strpos($val['main_product'], "en_") !== false) {
                $endata = explode('en_', $val['main_product']);
                $enid = $endata[1];
                $enData = EnergyUtility::select(['id', 'energy_name'])->where('id', $enid)->get();
                foreach ($enData->toArray() as $value) {
                    $data['main_product'] = $value['energy_name'];
                }
            } else {
                $data['main_product'] = "";
            }
        }
        return json_encode($data);
    }

    public function create()
    {
        $simulation_types = SimulationType::all();
        return view('pages.console.report.process_comparison.create', compact('simulation_types'));
    }

    public function store(Request $request)
    {
        try {
            $response = $this->report->createReport($request);
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/reports/process_comparison');
            $this->message = "Process Analysis Report Created Successfully!";
        } catch (\Exception $e) {
            $this->status = true;
            $this->modal = true;
            $this->message =  $e->getMessage();
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        echo "comming soon";
        return view('pages.console.report.process_comparison.view');
    }

    public function edit($id)
    {
        return view('pages.console.report.process_comparison.edit');
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
        $this->redirect = url('reports/process_comparison');
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
        if (ProcessComaprison::whereIn('id', $processIDS)->update($update)) {
            ProcessComaprison::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('reports/process_comparison');
        return $this->populateresponse();
    }
}
