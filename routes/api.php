<?php

use Illuminate\Support\Facades\Route;
/// Authenticate
Route::post('/authenticate', 'Auth\LoginController@user_authenticate');
//Route::post('/databse_backup', 'Admin\Tenant\BackupController@databse_backup');

// Master Unit System
Route::post('/masters/unit_system', 'Admin\Master\UnitController@index');
Route::post('/masters/unit_system/unit_type', 'Admin\Master\UnitController@get_unit_type');
Route::post('/masters/unit_system/unit_type/constant', 'Admin\Master\UnitController@get_unit_constants');

// Master Products
Route::post('/masters/product/categories', 'Admin\Master\Chemical\CategoryController@index');
Route::post('/masters/product/classifications', 'Admin\Master\Chemical\ClassificationController@index');
Route::post('/masters/product/properties', 'Admin\Master\Chemical\ChemicalPropertyController@index');
Route::post('/masters/product/sub_properties', 'Admin\Master\Chemical\ChemicalSubPropertyController@index');

// Master Energy Utilities
Route::post('/masters/energy_utilities/properties', 'Admin\Master\Energy\PropertyController@index');
Route::post('/masters/energy_utilities/sub_properties', 'Admin\Master\Energy\SubPropertyController@index');

// Master Experiment
Route::post('/masters/experiment/categories', 'Console\Organization\ProcessExperiment\CategoryController@index');
Route::post('/masters/experiment/classifications', 'Console\Organization\ProcessExperiment\ClassificationController@index');
Route::post('/masters/experiment/conditions', 'Admin\Master\Experiment\ExperimentConditionController@index');
Route::post('/masters/experiment/get_condition', 'Admin\Master\Experiment\ExperimentConditionController@get_condition');
Route::post('/masters/experiment/outcomes', 'Admin\Master\Experiment\ExperimentOutcomeController@index');
Route::post('/masters/experiment/get_outcome', 'Admin\Master\Experiment\ExperimentOutcomeController@get_outcome');

// Master Process Simulation
Route::post('/masters/simulation/stages', 'Admin\Master\ProcessSimulation\SimulationTypeController@index');
Route::post('/masters/simulation/flow_types', 'Admin\Master\ProcessSimulation\FlowTypeController@index');
Route::post('/masters/simulation/status', 'Admin\Master\ProcessSimulation\ProcessStatusController@index');
Route::post('/masters/simulation/categories', 'Admin\Master\ProcessSimulation\ProcessCategoryController@index');
Route::post('/masters/simulation/classifications', 'Admin\Master\ProcessSimulation\ProcessTypeController@index');
/////////////////END MASTER//////////////

// Console Products and Properties
Route::prefix('product')->group(function () {
    Route::post('/info', 'Console\Chemicals\ChemicalController@get_product');
    Route::post('/properties/safety', 'Console\Chemicals\PropertiesController@getSafetyDetail');
    Route::post('/properties/health', 'Console\Chemicals\PropertiesController@get_product_properties_health');
    Route::post('/properties/enviroment', 'Console\Chemicals\PropertiesController@get_product_properties_enviroment');
    Route::post('/cas_no', 'Console\Chemicals\ChemicalController@get_product_using_cas_no');
    Route::post('/properties', 'Console\Chemicals\PropertiesController@get_properties');
    Route::post('/properties/sub_properties', 'Console\Chemicals\PropertiesController@get_property_sub_properties');
    Route::post('/property/sub_property', 'Console\Chemicals\PropertiesController@get_property_sub_property');
    Route::post('/commercial/pricing', 'Console\Chemicals\PropertiesController@product_pricing');
    Route::post('/sustainability_info/ced', 'Console\Chemicals\PropertiesController@product_sustainability_ced');
    Route::post('/sustainability_info/ghge', 'Console\Chemicals\PropertiesController@product_sustainability_ghge');
    Route::post('/sustainability_info/carbon_content', 'Console\Chemicals\PropertiesController@product_sustainability_carbon_content');
    Route::post('/sustainability_info/water_usage', 'Console\Chemicals\PropertiesController@product_sustainability_water_usage');
    Route::post('/sustainability_info/eutrophication_potential', 'Console\Chemicals\PropertiesController@product_sustainability_eutrophication_potential');
    Route::post('/physio_chemical/lower_heat_value', 'Console\Chemicals\PropertiesController@product_physio_chemical_lower_heat_value');
    Route::post('/physio_chemical/molecular_weight', 'Console\Chemicals\PropertiesController@product_physio_chemical_molecular_weight');
    Route::post('/physio_chemical/boiling_point', 'Console\Chemicals\PropertiesController@product_physio_chemical_boiling_point');
    Route::post('/physio_chemical/density', 'Console\Chemicals\PropertiesController@product_physio_chemical_density');
    Route::post('/physio_chemical/dynamic_viscosity', 'Console\Chemicals\PropertiesController@product_physio_chemical_dynamic_viscosity');
    Route::post('/physio_chemical/self_diffusion_coefficient_liquid', 'Console\Chemicals\PropertiesController@product_physio_chemical_self_diffusion_coefficient_liquid');
    Route::post('/physio_chemical/vapor_pressure', 'Console\Chemicals\PropertiesController@product_physio_chemical_vapor_pressure');
    Route::post('/physio_chemical/solubility', 'Console\Chemicals\PropertiesController@product_physio_chemical_solubility');
    Route::post('/physio_chemical/mass_transfer_coefficient', 'Console\Chemicals\PropertiesController@product_physio_chemical_mass_transfer_coefficient');
    Route::post('/physio_chemical/chemical_heat_capacity_gas', 'Console\Chemicals\PropertiesController@product_physio_chemical_heat_capacity_gas');
    Route::post('/physio_chemical/chemical_heat_capacity_solid', 'Console\Chemicals\PropertiesController@product_physio_chemical_heat_capacity_solid');
    Route::post('/physio_chemical/chemical_heat_capacity_liquid', 'Console\Chemicals\PropertiesController@product_physio_chemical_heat_capacity_liquid');
    Route::post('/physio_chemical/heat_of_vaporization', 'Console\Chemicals\PropertiesController@product_physio_chemical_heat_of_vaporization');
    Route::post('/physio_chemical/enthalpy_of_formation', 'Console\Chemicals\PropertiesController@product_physio_chemical_enthalpy_of_formation');
    Route::post('/physio_chemical/enthalpy_of_combustion', 'Console\Chemicals\PropertiesController@product_physio_chemical_enthalpy_of_combustion');
    Route::post('/physio_chemical/melting_point', 'Console\Chemicals\PropertiesController@product_physio_chemical_melting_point');
});

// Console Experiment
Route::prefix('experiment_unit')->group(function () {
    Route::post('/all', 'Console\Experiment\ExperimentUnit\ExperimentController@get_experiment_units');
    Route::post('/info', 'Console\Experiment\ExperimentUnit\ExperimentController@get_experiment_unit_info');
});

// Console Equipment Unit
Route::prefix('equipment_unit')->group(function () {

    Route::post('/all', 'Console\Organization\Experiment\EquipmentUnit\EquipmentUnitController@get_equipment_units');
    Route::post('/info', 'Console\Organization\Experiment\EquipmentUnit\EquipmentUnitController@get_equipment_unit_info');
});

// Console Process Simulation
Route::prefix('process_simulation')->group(function () {
    Route::post('/info', 'Console\MFG\ProcessSimulationController@get_process_simulation_info');
    Route::post('/profile', 'Console\MFG\ProcessSimulationController@get_ps_profile');
    Route::post('/profile/stage', 'Console\MFG\ProcessSimulationController@get_ps_profile_stage');
    Route::post('/details', 'Console\MFG\ProcessSimulationController@get_ps_details');
    Route::post('/capex_estimate', 'Console\MFG\ProcessSimulationController@get_ps_capex_estimate');
    Route::post('/get_mass_output', 'Console\MFG\ProcessSimulationController@get_mass_output');
    Route::post('/get_mass_input', 'Console\MFG\ProcessSimulationController@get_mass_input');
    Route::post('/get_process_type', 'Console\MFG\ProcessSimulationController@get_process_type');
});

// Console Experiments
Route::prefix('experiment')->group(function () {
    //Route::post('/variation/simulate_input', 'Console\Experiment\ProcessExperiment\SimulateInputController@get_simulate_input_data');
    Route::post('/variation/simulate_input', 'Console\Experiment\ProcessExperiment\SimulateInputController@get_simulate_input_data_new');
    //
    Route::post('/info', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_process_experiment');
    Route::post('/product_list', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_experiment_product_list');
    Route::post('/profile', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_pe_profile');
    Route::post('/profile/configuration', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_pe_profile_config');
    Route::post('/profile/configuration/datasets', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_pe_profile_config_datasets');
    Route::post('/profile/configuration/dataset', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_pe_profile_config_dataset');
    Route::post('/profile/configuration/dataset/forward', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_simulate_input');
    Route::post('/profile/configuration/dataset/backward', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_pe_profile_config_dataset_backward');
    Route::post('/profile/process_diagram', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_pe_profile_diagram');
    Route::post('/profile/process_diagram/stream', 'Console\Experiment\ProcessExperiment\ProcessExperimentController@get_pe_profile_diagram');
    
    Route::post('/experiment_unit/list', 'Console\Experiment\ExperimentUnit\ExperimentController@get_experiment_units_for_experiment');
    Route::post('/experiment_unit/info', 'Console\Experiment\ExperimentUnit\ExperimentController@get_experiment_units_for_experiment_by_id');
   
    Route::post('/equipment_unit/list', 'Console\Organization\Experiment\EquipmentUnit\EquipmentUnitController@get_equipment_unit_for_experiment');
    Route::post('/equipment_unit/info', 'Console\Organization\Experiment\EquipmentUnit\EquipmentUnitController@get_equipment_unit_for_experiment_by_id');

    // Forward Model
    Route::prefix('forward')->group(function () {
        Route::post('/master_condition', 'Console\Experiment\ProcessExperiment\SimulateInputController@get_simulate_input_master_condition');
        Route::post('/master_outcome_list', 'Console\Experiment\ProcessExperiment\SimulateInputController@get_simulate_input_master_outcome_list');
        Route::post('/master_outcome', 'Console\Experiment\ProcessExperiment\SimulateInputController@get_simulate_input_master_outcome');
        Route::post('/exp_unit_outcome_list', 'Console\Experiment\ProcessExperiment\SimulateInputController@get_simulate_input_unit_outcome_list');
        Route::post('/exp_unit_outcome', 'Console\Experiment\ProcessExperiment\SimulateInputController@get_simulate_input_unit_outcome');
        Route::post('/exp_unit_condition_list', 'Console\Experiment\ProcessExperiment\SimulateInputController@get_simulate_input_unit_condition_list');
        Route::post('/exp_unit_condition', 'Console\Experiment\ProcessExperiment\SimulateInputController@get_simulate_input_unit_condition');
    });

});

// Console Energy Utilities
Route::prefix('energy_utility')->group(function () {
    Route::post('/info', 'Console\OtherInput\Energy\EnergyController@get_energy_utility');
    Route::post('/commercial/pricing', 'Console\OtherInput\Energy\PropertiesController@energy_commercial_pricing');
    Route::post('/sustainability_info/ced', 'Console\OtherInput\Energy\PropertiesController@energy_sustainability_info_ced');
    Route::post('/sustainability_info/ghge', 'Console\OtherInput\Energy\PropertiesController@energy_sustainability_info_ghge');
    Route::post('/sustainability_info/carbon_content', 'Console\OtherInput\Energy\PropertiesController@energy_sustainability_info_carbon_content');
    Route::post('/sustainability_info/water_usage', 'Console\OtherInput\Energy\PropertiesController@energy_sustainability_info_water_usage');
});
Route::post('/process_output', 'Console\Report\ExperimentsController@process_output');

// product System
Route::post('product_system/profile', 'Console\ProductSystem\ProductSystem\ProductSystemController@get_product_system_info');