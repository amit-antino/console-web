<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MFG\ProcessSimulation;
use App\Observers\ProcessSimulationObserver;
use App\Observers\ProcessProfileObserver;
use App\Models\MFG\ProcessProfile;
use App\Models\Product\Chemical;
use App\Observers\ChemicalObserver;
use App\Models\ProcessExperiment\ExperimentUnit;
use App\Models\ProcessExperiment\ProcessExperiment;
use App\Models\ProductSystem\ProductComparison;
use App\Models\ProductSystem\ProductSystem;
use App\Observers\ExperimentUnitObserver;
use App\Observers\ProcessExperimentObserver;
use App\Observers\ProductComparisonObserver;
use App\Observers\ProductSystemObserver;
use App\Models\Models\ModelDetail;
use App\Observers\ModelDetailObserver;
use App\Models\OtherInput\EnergyUtility;
use App\Models\OtherInput\EnergyUtilityProperty;
use App\Observers\EnergyUtilityObserver;
use App\Observers\EnergyUtilityPropertyObserver;
use App\Models\OtherInput\Equipments;
use App\Models\OtherInput\Reaction;
use App\Observers\EquipmentsObserver;
use App\Observers\ReactionObserver;
use App\Models\Report\ExperimentReport;
use App\Observers\ExperimentReportObserver;
use App\Models\Experiment\ProcessDiagram;
use App\Observers\ProcessDiagramObserver;
use App\Models\ProcessExperiment\ProcessExpEnergyFlow;
use App\Observers\ProcessExpEnergyFlowObserver;
use App\Models\ProcessExperiment\ProcessExpProfile;
use App\Models\ProcessExperiment\ProcessExpProfileMaster;

use App\Observers\ProcessExpProfileMasterObserver;
use App\Observers\ProcessExpProfileObserver;

use App\Models\Organization\Vendor\Vendor;
use App\Observers\VendorObserver;
use App\Models\Organization\Users\User;
use App\Models\Organization\Users\Department;
use App\Models\Organization\Users\Designation;
use App\Models\Organization\Users\Employee;
use App\Observers\UserObserver;
use App\Observers\DepartmentObserver;
use App\Observers\DesignationObserver;
use App\Observers\EmployeeObserver;
use App\Models\Product\ChemicalProperties;
use App\Models\Report\ProcessAnalysisReport;
use App\Models\Report\ProcessComaprison;
use App\Observers\ChemicalPropertiesObserver;
use App\Observers\ProcessAnalysisReportObserver;
use App\Observers\ProcessComaprisonObserver;

class NotificationProvider extends ServiceProvider
{
    public function register()
    {
    }
    
    public function boot()
    {
        ProcessSimulation::observe(ProcessSimulationObserver::class);
        ProcessProfile::observe(ProcessProfileObserver::class);
        Chemical::observe(ChemicalObserver::class);
        ProcessExperiment::observe(ProcessExperimentObserver::class);
        ExperimentUnit::observe(ExperimentUnitObserver::class);
        ProductComparison::observe(ProductComparisonObserver::class);
        ProductSystem::observe(ProductSystemObserver::class);
        ModelDetail::observe(ModelDetailObserver::class);
        EnergyUtility::observe(EnergyUtilityObserver::class);
        EnergyUtilityProperty::observe(EnergyUtilityPropertyObserver::class);
        Equipments::observe(EquipmentsObserver::class);
        Reaction::observe(ReactionObserver::class);
        ExperimentReport::observe(ExperimentReportObserver::class);
        ProcessDiagram::observe(ProcessDiagramObserver::class);
        ProcessExpEnergyFlow::observe(ProcessExpEnergyFlowObserver::class);
        ProcessExpProfile::observe(ProcessExpProfileObserver::class);
        ProcessExpProfileMaster::observe(ProcessExpProfileMasterObserver::class);     
        Vendor::observe(VendorObserver::class);
        User::observe(UserObserver::class);
        Department::observe(DepartmentObserver::class);
        Designation::observe(DesignationObserver::class);
        Employee::observe(EmployeeObserver::class);
        ChemicalProperties::observe(ChemicalPropertiesObserver::class);
        ProcessAnalysisReport::observe(ProcessAnalysisReportObserver::class);
        ProcessComaprison::observe(ProcessComaprisonObserver::class);
    }
}
