<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSystem\ProductSystem;
use App\Repository\Reports\Interfaces\ProductComparsionInterface;
use App\Models\Report\ProductSystemComparsionReport;
use Illuminate\Support\Facades\Auth;

class ProductSystemComparisonController extends Controller
{
    public $report;

    public function __construct(Request $request, ProductComparsionInterface $report)
    {
        parent::__construct($request);
        $this->report = $report;
    }
    public function index()
    {
        $reports = $this->report->getAll();
        return view('pages.console.report.product_system_comparison.index', compact('reports'));
    }

    public function create()
    {
        $product_systems = ProductSystem::select(['id', 'name'])->where('tenant_id',session()->get('tenant_id'))->get();
        return view('pages.console.report.product_system_comparison.create', compact('product_systems'));
    }

    public function store(Request $request)
    {
        try {
            $response = $this->report->createReport($request);
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('/reports/product_system_comparison');
            $this->message = "Product System Comparsion Report Created Successfully!";
        } catch (\Exception $e) {
            $this->status = true;
            $this->modal = true;
            $this->message =  $e->getMessage();
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        return view('pages.console.report.product_system_comparison.view');
    }

    public function edit($id)
    {
        return view('pages.console.report.product_system_comparison.edit');
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
        $this->redirect = url('reports/product_system_comparison');
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
        if (ProductSystemComparsionReport::whereIn('id', $processIDS)->update($update)) {
            ProductSystemComparsionReport::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('reports/product_system_comparison');
        return $this->populateresponse();
    }
}
