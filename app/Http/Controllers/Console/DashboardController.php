<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Chemical;
use App\Models\MFG\ProcessSimulation;
use App\Models\ProductSystem\ProductSystem;
use App\Models\Organization\Lists\RegulatoryList;
use App\Models\ProcessExperiment\ProcessExperiment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Organization\Users\User;
use App\Models\Report\ExperimentReport;
use App\Models\Report\ProcessAnalysisReport;
use App\Models\Report\ProcessComaprison;
use App\Models\Report\ProductSystemComparsionReport;
use App\Models\Report\ProductSystemReport;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $data['pure_product_count'] = Chemical::where('classification_id', 1)->where('tenant_id', session()->get('tenant_id'))->count();
        $data['product_latest'] = Chemical::where('tenant_id', session()->get('tenant_id'))->latest()->first();
        $data['simulated_product_count'] = Chemical::where('classification_id', 2)->where('tenant_id', session()->get('tenant_id'))->count();
        $data['experiment_product_count'] = Chemical::where('classification_id', 3)->where('tenant_id', session()->get('tenant_id'))->count();
        $data['generic_count'] = Chemical::where('product_type_id', 2)->where('tenant_id', session()->get('tenant_id'))->count();
        $data['overall_count'] = Chemical::where('tenant_id', session()->get('tenant_id'))->count();
        $data['regulatory_count'] = RegulatoryList::where('tenant_id', session()->get('tenant_id'))->count();
        $data['processSimulation_count'] = ProcessSimulation::where('tenant_id', session()->get('tenant_id'))->count();
        $data['productSystem_count'] = ProductSystem::where('tenant_id', session()->get('tenant_id'))->count();
        $data['processExperiment_count'] = ProcessExperiment::where('tenant_id', session()->get('tenant_id'))->count();
        $data['experiment_report_count'] = ExperimentReport::where('tenant_id', session()->get('tenant_id'))->count();
        $data['process_analysis_report_count'] = ProcessAnalysisReport::where('tenant_id', session()->get('tenant_id'))->count();
        $data['process_comparison_report_count'] = ProcessComaprison::where('tenant_id', session()->get('tenant_id'))->count();
        $data['product_system_report_count'] = ProductSystemReport::where('tenant_id', session()->get('tenant_id'))->count();
        $data['product_system_cmp_report_count'] = ProductSystemComparsionReport::where('tenant_id', session()->get('tenant_id'))->count();
        Redis::del('process_exp_list');
        return view('pages.console.dashboard', $data);
    }

    public function notification()
    {
        $user = User::find(Auth::user()->id);
        $notification = $user->Notifications;
        // echo "<pre>";
        // print_r($notification);exit;
        // $data['activity_log'] = ActivityLog::Select('*')
        //     ->with([
        //         'user' => function ($q) {
        //             $q->select('id', 'first_name', 'last_name');
        //         }, 'user_menu' => function ($q) {
        //             $q->select('id', 'name', 'menu_url', 'menu_icon');
        //         },
        //     ])->orderBy('id', 'desc')->get();
        // $data['count'] = $data['activity_log']->where('status', 'read')->count();
        // $update['status'] = 'read';
        // ActivityLog::where('causer_id', Auth::user()->id)->update($update);
        return view('pages.console.notification', compact('notification'));
    }

    public function clearActivityLog()
    {
        $user = User::find(Auth::user()->id);
        $user->unreadNotifications->markAsRead();
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        $this->message = "Notification Cleared Successfull!";
        return $this->populateresponse();
    }

    public function coming_soon()
    {
        return view('pages.error.coming_soon');
    }
}
