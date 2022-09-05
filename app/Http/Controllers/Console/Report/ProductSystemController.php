<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSystem\ProductSystem;
use App\Models\Report\ProductSystemReport;
use App\Models\MFG\ProcessSimulation;
use App\Repository\Reports\Interfaces\ProductComparsionInterface;
use Illuminate\Support\Facades\Auth;

class ProductSystemController extends Controller
{
    public $report;

    public function __construct(Request $request, ProductComparsionInterface $report)
    {
        parent::__construct($request);
        $this->report = $report;
    }
    public function index()
    {
        $reports = ProductSystemReport::where('tenant_id', '=', session()->get('tenant_id'))->orderBy('id', 'desc')->get();
        $product_systems = ProductSystem::where('tenant_id', '=', session()->get('tenant_id'))->get();
        return view('pages.console.report.product_system.index', compact('reports','product_systems'));
    }

    public function create()
    {
        $product_systems = ProductSystem::select(['id', 'name'])->where('tenant_id', session()->get('tenant_id'))->get();
        return view('pages.console.report.product_system.create', compact('product_systems'));
    }

    public function productDetail(Request $request)
    {
        $dataEdit = ProductSystem::find(___decrypt($request->id));
        $data['id'] = $dataEdit['id'];
        $data['name'] = $dataEdit['name'];
        $prd = $dataEdit['process'];
        $sinIds = array_column($prd, 'process_sim');
        $processIds = ProcessSimulation::select(['id', 'process_name'])->find($sinIds);
        $data['process'] = $processIds->toArray();
        $data['count'] = count($processIds->toArray());
        return json_encode($data);
    }

    public function store(Request $request)
    {
        try {
            $simulationData = new ProductSystemReport();
            $simulationData->report_name = $request->report_name;
            $simulationData->product_system_id =  ___decrypt($request->product_system_id);
            $simulationData->created_by = Auth::user()->id;
            $simulationData->updated_by = Auth::user()->id;
            $simulationData->tenant_id = session()->get('tenant_id');
            $simulationData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/reports/product_system');
            $this->message = "Product System Report Created Successfully!";
        } catch (\Exception $e) {
            $this->status = true;
            $this->modal = true;
            $this->message =  $e->getMessage();
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        return view('pages.console.report.product_system.view');
    }

    public function edit($id)
    {
        return view('pages.console.report.product_system.edit');
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProductSystemReport::where('id', ___decrypt($id))->update($update)) {
            ProductSystemReport::destroy(___decrypt($id));
        }
        $this->status = true;
        $this->redirect = url('reports/product_system');
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
        if (ProductSystemReport::whereIn('id', $processIDS)->update($update)) {
            ProductSystemReport::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('reports/product_system');
        return $this->populateresponse();
    }
}
