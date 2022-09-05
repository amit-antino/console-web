<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Tenant;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\MFG\ProcessSimulation;
use App\Models\ProductSystem\ProductSystem;
use App\Models\OtherInput\Reaction;
use App\Models\Models\ModelDetail;
use App\User;
use App\Models\Product\Chemical;
use App\Models\Report\ExperimentReport;
use App\Models\Report\ProcessAnalysisReport;
use App\Models\Report\ProcessComaprison;
use App\Models\Report\ProductSystemComparsionReport;
use App\Models\Report\ProductSystemReport;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data['tenant_count'] = Tenant::count();
        $data['user_count'] = User::where('role', '!=', 'admin')->count();
        $data['process_simulation_count'] = ProcessSimulation::count();
        $data['product_system_count'] = ProductSystem::count();
        $data['experiment_count'] = ProcessExperiment::count();
        $data['rection_count'] = Reaction::count();
        $data['models_count'] = ModelDetail::count();
        $data['pure_product_count'] = Chemical::where('classification_id', 1)->count();
        $data['product_latest'] = Chemical::latest()->first();
        $data['simulated_product_count'] = Chemical::where('classification_id', 2)->count();
        $data['experiment_product_count'] = Chemical::where('classification_id', 3)->count();
        $data['generic_count'] = Chemical::where('product_type_id', 2)->count();
        $data['overall_count'] = Chemical::count();
        $data['experiment_report_count'] = ExperimentReport::count();
        $data['process_analysis_report_count'] = ProcessAnalysisReport::count();
        $data['process_comparison_report_count'] = ProcessComaprison::count();
        $data['product_system_report_count'] = ProductSystemReport::count();
        $data['product_system_cmp_report_count'] = ProductSystemComparsionReport::count();
        return view('pages.admin.dashboard', $data);
    }
}
