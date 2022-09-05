<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

//Route::group(['localhost:8000' => '{subdomain}.{domain}'], function () {
// Authentication Routes...
Route::get('', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::prefix('admin')->namespace('Admin')->middleware(['admin', 'prevent-back-history'])->group(function () {
    Route::get('/ticket/{id}', 'Ticket\AdminTicketController@getView');
    Route::delete('/ticket/{id}', 'Ticket\AdminTicketController@destroy');
    Route::get('/ticket', 'Ticket\AdminTicketController@index');
    Route::get('/dashboard', 'AdminDashboardController@index');
    Route::get('chemical-unit-select-list', 'Master\Chemical\ChemicalSubPropertyController@selectList');
    Route::get('constant_unit_list', 'Master\Energy\SubPropertyController@ConstantUnitList');

    Route::resource('tenant', 'Tenant\TenantController');
    Route::resource('log', 'LogController');
    Route::get('admin_users/{user_id}/set-password', 'AdminUserController@setPassword');
    Route::post('admin_users/{user_id}/set-password', 'AdminUserController@newPassword');
    Route::resource('/admin_users/{id}/manage', 'AdminUserManageController');
    Route::post('/admin_users/bulk-delete', 'AdminUserController@bulkDelete');
    Route::post('/admin_users/getmenu', 'AdminUserManageController@getmenu');
    Route::resource('/admin_users', 'AdminUserController');
    Route::get('/job-queue', 'JobsQueueController@index');
    Route::get('/delete-jobsqueue/simulateinputjob/{id}', 'JobsQueueController@deleteSimulateInputJob');
    Route::get('/delete-jobsqueue/jobqueue/{id}', 'JobsQueueController@destroy');
    Route::post('/job-queue/bulk-delete', 'JobsQueueController@bulkDelete');
    Route::prefix('tenant')->namespace('Tenant')->group(function () {
        Route::post('bulk-delete', 'TenantController@bulkDelete');
        Route::get('/manage/{id}', 'TenantController@manage');
        Route::get('/manage/{id}/database_config', 'TenantController@databaseConfig');
        Route::post('/manage/{id}/database_config', 'TenantController@databaseMigrate');
        Route::post('/manage/{id}/seed_data', 'TenantController@seedData');

        Route::get('/role', function () {
            return view('pages.admin.tenant.role.index');
        });
        Route::get('{id}/backup_run', 'BackupController@backup_run');
        Route::resource('{id}/backup', 'BackupController');

        Route::get('{id}/user/{user_id}/set-password', 'UserController@setPassword');
        Route::post('{id}/user/{user_id}/set-password', 'UserController@newPassword');

        Route::post('{id}/user/bulk-delete', 'UserController@bulkDelete');
        Route::resource('{id}/user', 'UserController');
        Route::post('{id}/role/bulk-delete', 'RoleController@bulkDelete');
        Route::resource('{id}/role', 'RoleController');
        Route::resource('{id}/data_request', 'DataRequest\DataRequestController');
        Route::post('{id}/data_request/bulk-delete', 'DataRequest\DataRequestController@bulkDelete');
        Route::get('{tenant_id}/data_request/{id}/download_csv', 'DataRequest\DataRequestController@downloadCSV');

        Route::post('{id}/locations/bulk-delete', 'LocationController@bulkDelete');
        Route::resource('{id}/locations', 'LocationController');

        Route::post('{id}/user_group/bulk-delete', 'UserGroupController@bulkDelete');
        Route::resource('{id}/user_group', 'UserGroupController');
        Route::post('{id}/designation/bulk-delete', 'DesignationController@bulkDelete');
        Route::resource('{id}/designation', 'DesignationController');

        Route::post('{id}/calc_url/bulk-delete', 'CalcServerController@bulkDelete');
        Route::resource('{id}/calc_url', 'CalcServerController');

        Route::post('{id}/tour_guide/bulk-delete', 'TourGuideController@bulkDelete');
        Route::resource('{id}/tour_guide', 'TourGuideController');

        Route::get('{id}/user_permission/group_user_list', 'UserPermissionController@group_user_list');
        Route::post('{id}/user_permission/bulk-delete', 'UserPermissionController@bulkDelete');
        Route::resource('{id}/user_permission', 'UserPermissionController');
        Route::resource('{id}/logo_image', 'LogoImageController');
        Route::resource('{id}/document_update', 'DocumentUpdateController');

        Route::get('{id}/tenant_location_fetch', 'ProjectController@location_fetch');
        Route::post('{id}/project/bulk-delete', 'ProjectController@bulkDelete');
        Route::resource('{id}/project', 'ProjectController');

        Route::prefix('/{id}/experiment')->namespace('Experiment')->group(function () {
            Route::get('/', 'UnitImageController@experiment_manage');

            Route::post('/unit_image/bulk-delete', 'UnitImageController@bulkDelete');
            Route::resource('unit_image', 'UnitImageController');
            Route::resource('condition', 'ExperimentConditionController');
            Route::post('condition/bulk-delete', 'ExperimentConditionController@bulkDelete');
            Route::post('/condition/importFile', 'ExperimentConditionController@importFile');

            Route::resource('outcome', 'ExperimentOutcomeController');
            Route::post('/outcome/bulk-delete', 'ExperimentOutcomeController@bulkDelete');
            Route::post('/outcome/importFile', 'ExperimentOutcomeController@importFile');
            Route::resource('equipment_unit', 'EquipmentUnitController');
            Route::post('/equipment_unit/bulk-delete', 'EquipmentUnitController@bulkDelete');
            Route::resource('models', 'ModelsController');
            Route::post('/models/bulk-delete', 'ModelsController@bulkDelete');

            Route::post('/criteria/bulk-delete', 'CriteriaController@bulkDelete');
            Route::resource('criteria', 'CriteriaController');
            Route::post('/priority/bulk-delete', 'PriorityController@bulkDelete');
            Route::resource('priority', 'PriorityController');
            Route::post('/category/bulk-delete', 'CategoryController@bulkDelete');
            Route::resource('/category', 'CategoryController');
            Route::post('/classification/bulk-delete', 'ClassificationController@bulkDelete');
            Route::resource('/classification', 'ClassificationController');

            //////////////////
            Route::resource('/models', 'ModelController');
            //////////////////
            Route::resource('/dataset', 'DatasetController');
            //////////////////
            Route::resource('/dataset_request', 'DataRequestController');
        });
        Route::prefix('/{id}/reaction')->namespace('Reaction')->group(function () {
            Route::get('/', 'ReactionTypeController@reaction_manage');
            Route::post('/reaction_type/bulk-delete', 'ReactionTypeController@bulkDelete');
            Route::resource('reaction_type', 'ReactionTypeController');
            Route::post('/phase/bulk-delete', 'ReactionPhaseController@bulkDelete');
            Route::resource('phase', 'ReactionPhaseController');
        });
        Route::prefix('{id}/list')->namespace('Lists')->group(function () {
            Route::get('/', 'CategoryController@lists_manage');
            Route::post('/category/bulk-delete', 'CategoryController@bulkDelete');
            Route::resource('/category', 'CategoryController');
            Route::post('/classification/bulk-delete', 'ClassificationController@bulkDelete');
            Route::resource('/classification', 'ClassificationController');
        });
    });

    Route::resource('/user/profile', 'ProfileController');

    Route::prefix('master')->namespace('Master')->group(function () {
        Route::prefix('tenant')->namespace('Tenant')->group(function () {
            Route::post('organization_type/bulk-delete', 'OrganizationTypeController@bulkDelete');
            Route::resource('/organization_type', 'OrganizationTypeController');
            Route::post('plan/bulk-delete', 'PlanController@bulkDelete');
            Route::resource('/plan', 'PlanController');
        });

        Route::post('unit_type/add-more-constant-field', 'UnitController@addMoreConstant');
        Route::post('unit_type/bulk-delete', 'UnitController@bulkDelete');
        Route::get('unit_list', 'UnitController@get_json_unit_type');
        Route::resource('/unit_type', 'UnitController');
        Route::resource('/currency', 'CurrencyController');
        Route::resource('/settings', 'CurrencyController');
        Route::post('/unit_type/importfile', 'UnitController@importFile');

        Route::prefix('chemical')->namespace('Chemical')->group(function () {
            Route::post('category/bulk-delete', 'CategoryController@bulkDelete');
            Route::resource('/category', 'CategoryController');

            Route::post('classification/bulk-delete', 'ClassificationController@bulkDelete');
            Route::resource('/classification', 'ClassificationController');

            Route::post('property/bulk-delete', 'ChemicalPropertyController@bulkDelete');
            Route::resource('/property', 'ChemicalPropertyController');

            Route::post('sub_property/add-more-sub-property-field', 'ChemicalSubPropertyController@addMoreProp');
            Route::post('sub_property/bulk-delete', 'ChemicalSubPropertyController@bulkDelete');
            Route::resource('sub_property', 'ChemicalSubPropertyController');

            Route::prefix('hazard')->namespace('Hazard')->group(function () {
                Route::post('/hazard_class/bulk-delete', 'HazardClassController@bulkDelete');
                Route::resource('/hazard_class', 'HazardClassController');
                Route::post('/hazard_pictogram/bulk-delete', 'HazardPictogramController@bulkDelete');
                Route::resource('/hazard_pictogram', 'HazardPictogramController');
                Route::post('/code_statement_import', 'HazardCodeStatementController@importFile');
                Route::post('/code_statement/bulk-delete', 'HazardCodeStatementController@bulkDelete');
                Route::resource('/code_statement', 'HazardCodeStatementController');
                Route::post('/category/bulk-delete', 'HazardCategoryController@bulkDelete');
                Route::resource('/category', 'HazardCategoryController');
                Route::post('/hazard/bulk-delete', 'HazardController@bulkDelete');
                Route::resource('/hazard', 'HazardController');

                Route::post('/code_type/bulk-delete', 'CodeTypeController@bulkDelete');
                Route::resource('/code_type', 'CodeTypeController');

                Route::get('/sub_code_type_list', 'SubCodeTypeController@subCodeTypeList');
                Route::post('/code_sub_type/bulk-delete', 'SubCodeTypeController@bulkDelete');
                Route::resource('/code_sub_type', 'SubCodeTypeController');
            });
        });

        Route::prefix('process_simulation')->namespace('ProcessSimulation')->group(function () {
            Route::post('/type/bulk-delete', 'ProcessTypeController@bulkDelete');
            Route::resource('type', 'ProcessTypeController');

            Route::post('/process_status/bulk-delete', 'ProcessStatusController@bulkDelete');
            Route::resource('process_status', 'ProcessStatusController');

            Route::post('/category/bulk-delete', 'ProcessCategoryController@bulkDelete');
            Route::resource('category', 'ProcessCategoryController');

            Route::post('/flow_type/bulk-delete', 'FlowTypeController@bulkDelete');
            Route::resource('flow_type', 'FlowTypeController');

            Route::post('/add-more-simulation-field/{type}', 'SimulationTypeController@addMore');
            Route::post('/simulation_type/bulk-delete', 'SimulationTypeController@bulkDelete');
            Route::resource('simulation_type', 'SimulationTypeController');
        });

        Route::prefix('energy_utilities')->namespace('Energy')->group(function () {
            Route::post('/property/bulk-delete', 'PropertyController@bulkDelete');
            Route::resource('property', 'PropertyController');

            Route::post('/sub_property/add-more-sub-property-field', 'SubPropertyController@addMoreProp');
            Route::post('/sub_property/bulk-delete', 'SubPropertyController@bulkDelete');
            Route::resource('sub_property', 'SubPropertyController');
        });
    });
});
Route::group(['namespace' => 'Console', 'middleware' => ['console', 'prevent-back-history']], function () {
    Route::get('experiment/experiment/sim_excel_config/{id}/stream_data', 'Experiment\ProcessExperiment\SimulationExcelConfigController@showStream');
    Route::post('experiment/experiment/sim_excel_config/save_raw_material', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveRawMaterial');
    Route::post('experiment/experiment/sim_excel_config/get_master_units', 'Experiment\ProcessExperiment\SimulationExcelConfigController@master_units');
    Route::post('experiment/experiment/sim_excel_config/master_condition_config', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveMasterCondition');
    Route::post('experiment/experiment/sim_excel_config/master_outcome_config', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveMasterOutcome');
    Route::post('experiment/experiment/sim_excel_config/exp_condition_config', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveExpCondition');
    Route::post('experiment/experiment/sim_excel_config/exp_outcome_config', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveExpOutcome');
    Route::get('experiment/experiment/sim_excel_config/{id}/download/{type}', 'Experiment\ProcessExperiment\SimulationExcelConfigController@DownloadTemplate');
    Route::get('experiment/experiment/sim_excel_config/{id}/download_with_data', 'Experiment\ProcessExperiment\SimulationExcelConfigController@DownloadTemplateWithData');
    Route::post('experiment/experiment/sim_excel_config/bulk-delete', 'Experiment\ProcessExperiment\SimulationExcelConfigController@bulkDelete');

    Route::get('organization/{tenant_id}/user_permission/group_user_list', 'Organization\UserPermissionController@group_user_list');
    //Product
    Route::resource('/ticket', 'Ticket\UserTicketController');
    Route::get('/downloaddoc', 'Ticket\UserTicketController@download');
    Route::post('product/chemical/importFile', 'Chemicals\ChemicalController@importFile');
    Route::post('product/chemical/check_molecular_formula', 'Chemicals\ChemicalController@check_molecular_formula');
    //

    Route::get('/notification', 'DashboardController@notification');
    Route::get('/clear-all-notification', 'DashboardController@clearActivityLog');
    Route::post('/add-more-chemicals-field', 'Chemicals\ChemicalController@addMore');
    Route::post('/add-more-chemicals-dynamic-add-field', 'Chemicals\PropertiesController@addMoreDynamicFields');
    Route::get('product/chemical/list_view/{list_id}/{chemical_id}', 'Chemicals\ChemicalController@view_list');

    ///ProductSystem
    Route::get("product_system/product/simulationproduct", "ProductSystem\ProductSystem\ProductSystemController@simulationproduct");
    Route::get('product_system/product_processList', 'ProductSystem\ProductSystem\ProductSystemController@processList');
    Route::get('product_system/process_simulation_datasetList', 'ProductSystem\ProductSystem\ProductSystemController@processSimulationDatasetList');
    Route::get('product_system/product_simulation_typelist', 'ProductSystem\ProductSystem\ProductSystemController@productSimulationTypelist');
    Route::post('product_system/product-addmore', 'ProductSystem\ProductSystem\ProductSystemController@addMore');
    Route::delete('product_system/product/delete-added-item/{id}', 'ProductSystem\ProductSystem\ProductSystemController@deleteAddedSimulationproccess');
    Route::get('product_system/product/{id}/processSimprofile', 'ProductSystem\ProductSystem\ProductSystemController@showSimulationConfig');


    Route::prefix('mfg_process')->group(function () {
        Route::get('simulation/{id}/replicate', 'MFG\ProcessSimulationController@replicatePopup');
        Route::post('simulation/{id}/replicate', 'MFG\ProcessSimulationController@replicateSimuation');
        Route::post('simulation/bulk-delete', 'MFG\ProcessSimulationController@bulkDelete');
        Route::resource('simulation/{process_id}/dataset', 'MFG\ProcessDatasetController');
        Route::post('simulation/dataset/status', 'MFG\ProcessDatasetController@status');
        Route::get('simulation/{id}/dataset_config', 'MFG\ProcessDatasetController@DatasetConfig');
        Route::get('simulation/{id}/view_config', 'MFG\ProcessDatasetController@DatasetConfig');
        Route::get('simulation/dataset/edit_config', 'MFG\ProcessDatasetController@EditConfig');
        Route::post('simulation/dataset/save_basic_io', 'MFG\ProcessDatasetController@SaveBasicio');
        Route::post('simulation/dataset/delete_basic_io', 'MFG\ProcessDatasetController@DeleteBasicio');
        Route::post('simulation/dataset/save_energy_basic_io', 'MFG\ProcessDatasetController@SaveEnergyBasicio');
        Route::post('simulation/dataset/delete_energy_basic_io', 'MFG\ProcessDatasetController@DeleteEnergyBasicio');
        Route::post('simulation/dataset/key_process_info', 'MFG\ProcessDatasetController@KeyProcessInfo');
        Route::post('simulation/dataset/qual_assesment', 'MFG\ProcessDatasetController@QualAssesment');
        Route::post('simulation/dataset/bulkdelete', 'MFG\ProcessDatasetController@BulkDelete');
        Route::get('simulation/dataset/get_unit_constant/{id}', 'MFG\ProcessDatasetController@GetUnitConstant');
        Route::post('simulation/getpps', 'MFG\ProcessDatasetController@getpps');
        Route::post('simulation/getcapitalCost', 'MFG\ProcessDatasetController@getcapitalCost');
        Route::post('simulation/capitalCostEditModel', 'MFG\ProcessDatasetController@getcapitalCosteditModel');
        Route::post('simulation/dataset/capitalCostSave', 'MFG\ProcessDatasetController@capitalCostSave');
        Route::post('simulation/dataset/capitalCostEditModel', 'MFG\ProcessDatasetController@getcapitalCosteditModel');
        Route::post('simulation/dataset/delete_keyprocessinfo_img', 'MFG\ProcessDatasetController@deleteKeyProcessInfoImg');
    });

    Route::resource("data_request", "DataRequest\DataRequestController");
    Route::get('/data_request/{id}/download_csv', 'DataRequest\DataRequestController@downloadCSV');
    ////Experiment
    Route::get("experiment/experiment_units/equipment_condition_outcome", "Experiment\ExperimentUnit\ExperimentController@equipment_condition_outcome");

    ///REPORT
    Route::get("reports/process_analysis/process_simulations", "Report\ProcessAnalysisController@get_process_simulations");
    Route::post("reports/process_analysis/getstages", "Report\ProcessAnalysisController@getstages");
    Route::get('reports/process_analysis/showdata', 'Report\ProcessAnalysisController@showData')->name('process_analysis_report');

    Route::get("reports/process_comparison/process_simulations", "Report\ProcessComparisonController@get_process_simulations");
    Route::post("reports/experiment/getConfiguration", "Report\ExperimentsController@getConfiguration");
    Route::post("reports/experiment/getDataset", "Report\ExperimentsController@getDataset");
    Route::get('reports/experiment/data', 'Report\ExperimentsController@showData')->name('process_exp_report');
    Route::get('reports/experiment/chart', 'Report\ExperimentsController@chartRender');
    Route::get('reports/experiment/downloadjson/{id}', 'Report\ExperimentsController@downloadjson');
    Route::post('reports/experiment/{id}/retry', 'Report\ExperimentsController@retry');
    Route::get('reports/experiment/work/job/list', 'Report\ExperimentsController@show_jobs');
    Route::post("reports/experiment/editname", "Report\ExperimentsController@editReportname");
    Route::post("reports/experiment/updateName", "Report\ExperimentsController@updateName");


    ///OTHER INPUTS
    Route::post('other_inputs/reaction/reaction_check_mole', 'OtherInput\Reaction\ReactionController@checkMolecular');
    Route::post('other_inputs/reaction/{id}/calculate_reaction_rate', 'OtherInput\Reaction\ReactionController@calculate_reaction_rate');
    Route::post('experiment/experiment_units/importfile', 'Experiment\ExperimentUnit\ExperimentController@importFile');

    ///Experiments
    Route::prefix('experiment/experiment')->namespace('Experiment\ProcessExperiment')->group(function () {

        Route::post('product_raw_material_list', 'ProcessDiagramController@product_raw_material_list');
        Route::get('/sim_config_output/list', 'SimulateInputController@list');
        Route::get('/sim_config_setpoint/list', 'SimulationSetPointController@list');
        Route::post('experiment_unit/add_more', 'ProcessExperimentController@exp_unit_add_more');
        Route::get('/exp_profile_master', 'ProcessExperimentController@showExpMaster');
        Route::get('/getstreamdata', 'ProcessExperimentController@getstreamdata')->name('getstreamdata');
        Route::get('/exp_profile', 'ProcessExperimentController@showExp')->name('process_exp_profile');


        Route::get('/exp_unit_condition', 'ProcessExperimentController@expUnitCondition')->name('exp_unit_condition');
        Route::get('/exp_unit_outcomes', 'ProcessExperimentController@expoutcomes')->name('exp_unit_outcomes');
        Route::get('/set_unit_condition', 'ProcessExperimentController@setUnitcondition')->name('set_unit_condition');
        Route::get('/exp_messure_data', 'ProcessExperimentController@expmessurData')->name('exp_messure_data');
        //////OUTPUT-Measured-Exp-Unit-OUTCOME-Ajax-URL//////////
        Route::get('output-measured-data-exp-outcome-edit', 'SimulationOutputController@expUnitOutcomeEditPopup');
        Route::post('output-measured-data-exp-outcome-addlist', 'SimulationOutputController@expUnitOutcomeList');
        ////////END//////////////
        Route::post('add-exp-unit-condition-list', 'SimulationOutputController@expUnitConditionList');

        Route::get('edit-exp-unit-condition-popup', 'SimulationOutputController@editExpUnitConditionPopup');
        Route::get('edit-exp-unit-outcome-popup', 'SimulationOutputController@editExpUnitOutcomePopup');
        Route::get('/edit_master_outcome_output_popup', 'SimulationOutputController@outcomeMasterPopup');
        Route::get('/edit_master_condition_output_popup', 'SimulationOutputController@conditionMasterPopup');

        Route::post('add-condition-outcome-list', 'SimulationOutputController@addConditionOutcomeList');
        Route::post('/add_condition_outcome_list', 'SimulationOutputController@masterOutcomeOutPut');
        Route::post('/add_condition_list', 'SimulationOutputController@masterConditionOutPutList');
        //////Setpoint-Master-Exp_Outcome-Ajax-URL//////////
        Route::get('setpoint-master-exp-outcome-edit-popup', 'SimulationSetPointController@masterExpOutcomeEditPopup');
        Route::post('setpoint-master-exp-outcome-list', 'SimulationSetPointController@masterOutcomeList');
        ////////END////////////// 
        //////Setpoint-Master-Condition-Ajax-URL//////////
        Route::get('setpoint-master-condition-edit-popup', 'SimulationSetPointController@masterConditionEditPopup');
        Route::post('setpoint-master-condition-list', 'SimulationSetPointController@masterConditionList');
        ////////END//////////////
        //////Setpoint-Unit-Condition-Ajax-URL//////////
        Route::get('setpoint-unit-condition-edit-popup', 'SimulationSetPointController@unitConditionEditPopup');
        Route::post('setpoint-unit-condition-list', 'SimulationSetPointController@unitConditionList');
        Route::post('range-value-field', 'SimulationSetPointController@rangeValueField');
        ////////END//////////////
        //////Setpoint-Exp-Unit-OUTCOME-Ajax-URL//////////
        Route::get('setpoint-exp-unit-outcome-edit-popup', 'SimulationSetPointController@expUnitOutcomeEditPopup');
        Route::post('setpoint-exp-unit-outcome-list', 'SimulationSetPointController@expUnitOutcomeList');
        ////////END//////////////
        Route::post('simlated_updated_output', 'SimulationOutputController@simulatedOutPut');
        Route::post('simlated_updated_outputprd', 'SimulationOutputController@simulatedOutPutprd');
        Route::post('simlated_updated_setpoint', 'SimulationSetPointController@simulatedSetPoint');
        Route::post('simulate_output/raw_material_list', 'SimulationOutputController@rawMaterialList');
        Route::post('simulate_set_point/raw_material_list', 'SimulationSetPointController@rawMaterialList');

        Route::resource('simulate_output', 'SimulationOutputController');
        Route::resource('simulation_input', 'SimulateInputController');
        Route::resource('process_exp_associated', 'AssociatedController');
        Route::post('upload_associate_model', 'AssociatedController@upload_associate_model');
        Route::post('delete_associate_model', 'AssociatedController@delete_model');
        Route::post('status_associate_model', 'AssociatedController@update_status_model');
        Route::post('render_edit_models', 'AssociatedController@render_edit_models');
        Route::post('get_models_file', 'AssociatedController@get_models_file');
        Route::post('getFileContent_models', 'AssociatedController@getFileContent_models');
        Route::post('update_associated_model', 'AssociatedController@update_associated_model');
        //exp_dataset_update
        Route::resource('process_exp_dataset', 'DatasetModelController');
        Route::post('status_dataset_model', 'DatasetModelController@update_status_dataset');
        Route::post('delete_dataset_model', 'DatasetModelController@delete_dataset');
        Route::post('exp_dataset_update', 'DatasetModelController@exp_dataset_update');
        // Route::post('dataset_list', 'DatasetModelController@dataset_list');
        Route::post('upload_dataset_model', 'DatasetModelController@upload_dataset_model');
        Route::post('upload_updated_dataset_model', 'DatasetModelController@updated_dataset_model');
        Route::resource('process_exp_datarequest', 'DatasetRequestController');
        Route::post('datareq_list', 'DatasetRequestController@datareq_list');
        Route::post('upload_datareq_model', 'DatasetRequestController@upload_datareq_model');
        Route::post('delete_data_request', 'DatasetRequestController@delete_data_request');
        //upload_updated_dataset_model
        Route::post('view_profile', 'ProcessExperimentController@get_profile_view');
        Route::post('simulation_config_store', 'SimulationSetPointController@simulation_config_store');
        Route::resource('simulate_set_point', 'SimulationSetPointController');
        Route::get('/{id}/view_config', 'ProcessExperimentController@SimulationConfig')->name('view_config');;
    });

    Route::prefix('experiment')->namespace('Experiment\ProcessExperiment')->group(function () {
        Route::post('/experimentProfile/saveprofile', 'ProcessExperimentProfileController@saveprofile');
        Route::delete('/experimentProfile/{id}/{pid}/{uid}', 'ProcessExperimentProfileController@destroy');
        Route::get('/experimentProfile/{id}/{pid}/{uid}/Edit', 'ProcessExperimentProfileController@getProfile');
        Route::get('/experimentProfile/{id}/{pid}/{uid}/master_io_Edit', 'ProcessExperimentProfileController@masterIOProfile');
        Route::post('/experimentProfile/saveprofilemaster', 'ProcessExperimentProfileController@saveprofilemaster');

        Route::get("experiment/{experiment_id}/manage/{variation_id}/edit", "VariationController@edit");
        Route::get("experiment/{experiment_id}/manage/{variation_id}/show", "ProcessConfigController@show");
        Route::get('experiment/simulation_excel_config_store/{id}', 'SimulationExcelConfigController@DownloadTemplateWithData');
        Route::resource("variation", "VariationController");
        Route::post('variation/bulkdelvariation', 'VariationController@bulkDelete');
        Route::post('variation/deleteVartion', 'VariationController@deleteVartion');
        Route::post("variation/edit", "VariationController@editdata");
        Route::post("variation/updateVarition", "VariationController@updateVarition");
        Route::post('experiment/bulk-delete', 'ProcessConfigController@bulkDelete');
        Route::post('variation/status', 'VariationController@update_status');

        Route::resource("process_diagram", "ProcessDiagramController");
        Route::post('process_diagram/bulkdelDiagram', 'ProcessDiagramController@bulkDelete');
        Route::post('process_diagram/deleteDiagram', 'ProcessDiagramController@deleteDiagram');
        Route::resource("plant_data", "PlantDataController");
        Route::resource("data_sets", "DataSetsController");
        Route::resource("process_exp_energflow", "ProcessEnergyFlowController");
        Route::post('process_exp_energflow/bulk-delete', 'ProcessEnergyFlowController@bulkDelete');
        Route::get('raw_material/{id}/popup', 'ProcessDiagramController@raw_material_edit_popup');
        Route::get('raw_material/{id}/popup_set_point', 'ProcessDiagramController@raw_material_edit_popup_set_point');
        Route::post("process_diagram/update", "ProcessDiagramController@update");
        Route::post("process_diagram/edit", "ProcessDiagramController@editdata");
        Route::post("process_diagram/getimgmodel", "ProcessDiagramController@getimgmodel");
        Route::post("process_diagram/saveimgmodel", "ProcessDiagramController@saveimgmodel");
        Route::get('/variation/{id}/applyconfig', 'ProcessConfigController@applyConfig');
        Route::post('/experiment/getProductAssociate', 'ProcessExperimentController@getProductAssociate');
        Route::post("/experiment/checkStream", "ProcessExperimentController@checkStream");
        Route::get('/associated_unit', 'ProcessExperimentController@getAssociateData');
        Route::get('/add_condition_outcome_popup', 'ProcessExperimentController@addConditionOutcomePopup');
        Route::post('model/bulkdelmodel', 'AssociatedController@bulkDelete');
        Route::post('dataset/bulkdeldataset', 'DatasetModelController@bulkDelete');
        Route::post('data_request/bulkdeldata_request', 'DatasetRequestController@bulkDelete');
        Route::post('experiment/clone', 'ProcessExperimentController@cloneExp');
        Route::post('experiment/cloneVariation', 'ProcessExperimentController@cloneVariation');
        Route::post('experiment/clonesimInput', 'ProcessExperimentController@clonesimInput');
    });
    Route::get('data_management/data_sets/ajax_list', 'DataManagement\DataSetsController@list_experiment');

    Route::group(['middleware' => ['PermissionModule']], function () {
        Route::get('/dashboard', 'DashboardController@dashboard');
        Route::prefix('product')->group(function () {
            Route::post('/chemical/bulk-delete', 'Chemicals\ChemicalController@bulkDelete');
            Route::resource('chemical', 'Chemicals\ChemicalController');
            // Custom Manage Property action routes
            Route::resource('/chemical/{id}/addprop', 'Chemicals\PropertiesController');
            Route::get('/chemical/{id}/property/{prop_id}/{type}', 'Chemicals\PropertiesController@subProperty');
            Route::resource('generic', 'Generic\GenericController');
        });

        Route::prefix('mfg_process')->group(function () {
            Route::post('simulation/{id}/copy_to_knowledge', 'MFG\ProcessSimulationController@copy_to_knowledge');
            Route::get('simulation/{id}/manage', 'MFG\ProcessSimulationController@manage');
            Route::get('simulation/{id}/view', 'MFG\ProcessSimulationController@manage');

            Route::resource('simulation', 'MFG\ProcessSimulationController');
        });


        Route::prefix('organization')->namespace('Organization')->group(function () {
            Route::get('/settings', 'OrganizationController@index');
            Route::get('/masters', 'OrganizationController@masters');

            Route::post('/profile/default_preference', 'ProfileController@default_preference');
            Route::resource('/profile', 'ProfileController');
            Route::resource('list', 'Lists\ListController');
            Route::post('list/bulk-delete', 'Lists\ListController@bulkDelete');

            Route::post('{tenant_id}/user_management/bulk-delete', 'UserController@bulkDelete');
            Route::resource('{tenant_id}/user_management', 'UserController');

            Route::post('{tenant_id}/designation/bulk-delete', 'DesignationController@bulkDelete');
            Route::resource('{tenant_id}/designation', 'DesignationController');

            Route::post('{tenant_id}/user_group/bulk-delete', 'UserGroupController@bulkDelete');
            Route::post('{tenant_id}/user_group/importfile', 'UserGroupController@importFile');
            Route::resource('{tenant_id}/user_group', 'UserGroupController');

            Route::post('{tenant_id}/user_permission/bulk-delete', 'UserPermissionController@bulkDelete');
            Route::resource('{tenant_id}/user_permission', 'UserPermissionController');

            Route::prefix('vendor')->namespace('Vendor')->group(function () {
                Route::get('/{id}/manage', 'VendorController@manage');
                Route::post('/category/bulk-delete', 'CategoryController@bulkDelete');
                Route::resource('/category', 'CategoryController');
                Route::post('/classification/bulk-delete', 'ClassificationController@bulkDelete');
                Route::resource('/classification', 'ClassificationController');
                Route::post('/bulk-delete', 'VendorController@bulkDelete');
                Route::post('/importFile', 'VendorController@importFile');
                Route::resource('/contact', 'ContactController');
                Route::resource('/location', 'LocationController');
            });
            Route::resource('vendor', 'Vendor\VendorController');
        });

        Route::prefix('other_inputs')->namespace('OtherInput')->group(function () {
            Route::post('/add-more-energy-field', 'Energy\EnergyController@addMore');
            Route::post('/add-more-energy-dynamic-add-field', 'Energy\EnergyController@addMoreDynamicFields');
            Route::post('add-more-reactent-field', 'Reaction\ReactionController@addReactent');
            Route::post('balance-reactant', 'Reaction\ReactionController@balanceReactions');
            Route::post('energy/importFile', 'Energy\EnergyController@importFile');
            Route::post('energy/bulk-delete', 'Energy\EnergyController@bulkDelete');
            Route::resource("/energy", "Energy\EnergyController");
            // Custom Manage Property action routes
            Route::resource('/energy/{id}/addprop', 'Energy\PropertiesController');
            Route::get('/energy/{id}/property/{prop_id}/{type}', 'Energy\PropertiesController@subProperty');
            Route::post('equipment/importFile', 'Equipment\EquipmentController@importFile');
            Route::post('equipment/bulk-delete', 'Equipment\EquipmentController@bulkDelete');
            Route::resource("/equipment", "Equipment\EquipmentController");
            // end prop route for equipment
            Route::post('reaction/importFile', 'Reaction\ReactionController@importFile');
            Route::post('reaction/bulk-delete', 'Reaction\ReactionController@bulkDelete');
            Route::resource("reaction", "Reaction\ReactionController");
            // Reaction Prop
            Route::resource('reaction/{id}/addprop', 'Reaction\PropertiesController');
        });

        Route::prefix('reports')->group(function () {
            Route::get("/process_analysis/process_simulation_details", "Report\ProcessAnalysisController@get_process_simulation_details");
            Route::post('process_analysis/bulk-delete', 'Report\ProcessAnalysisController@bulkDelete');
            Route::resource("/process_analysis", "Report\ProcessAnalysisController");
            Route::get("/process_comparison/process_simulation_details", "Report\ProcessComparisonController@get_process_simulation_details");
            Route::post('process_comparison/bulk-delete', 'Report\ProcessComparisonController@bulkDelete');
            Route::resource("/process_comparison", "Report\ProcessComparisonController");
            Route::post('product_system_comparison/bulk-delete', 'Report\ProductSystemComparisonController@bulkDelete');
            Route::resource("/product_system_comparison", "Report\ProductSystemComparisonController");
            Route::get("/product_system/productDetail", "Report\ProductSystemController@productDetail");
            Route::post('product_system/bulk-delete', 'Report\ProductSystemController@bulkDelete');
            Route::resource("/product_system", "Report\ProductSystemController");

            // Experiments Reports
            Route::resource("/experiment", "Report\ExperimentsController");
            Route::prefix('experiment')->group(function () {
                Route::post('/bulk-delete', 'Report\ExperimentsController@bulkDelete');
            });
        });

        Route::prefix('knowledge_bank')->group(function () {
            Route::resource("/process_simulation", "KnowledgeBank\ProcessSimulation\ProcessSimulationController");
            Route::resource("/report", "KnowledgeBank\Report\ReportController");
        });

        Route::prefix('product_system')->namespace('ProductSystem')->group(function () {
            Route::post('/product/bulk-delete', 'ProductSystem\ProductSystemController@bulkDelete');
            Route::get("/product/{id}/manage", "ProductSystem\ProductSystemController@show");
            Route::resource("/product", "ProductSystem\ProductSystemController");
            Route::get("/profile/{id}/create", "ProductSystem\ProductProfileController@create");
            Route::get('/comparison/chart1', 'Comparison\ComparisonController@chartRender');
            Route::post('/comparison/bulk-delete', 'Comparison\ComparisonController@bulkDelete');
            Route::resource("/comparison", "Comparison\ComparisonController");
        });

        Route::prefix('experiment')->namespace('Experiment')->group(function () {
            Route::post('/experiment_units/bulk-delete', 'ExperimentUnit\ExperimentController@bulkDelete');
            Route::resource("/experiment_units", "ExperimentUnit\ExperimentController");
            Route::resource("process_diagram", "ProcessExperiment\ProcessDiagramController");
            Route::post("process_diagram/getDiagramImageView", "ProcessExperiment\ProcessDiagramController@getDiagramImageView");
            Route::post('experiment/associate_model', 'ProcessExperiment\AssociatedController@associate_model');
            Route::post('experiment/dataset_list', 'ProcessExperiment\DatasetModelController@dataset_list');
            Route::prefix('experiment')->namespace('ProcessExperiment')->group(function () {
                Route::get('view_varition', 'ProcessExperimentController@get_vartion_view');
                Route::post('view_configuration', 'ProcessExperimentController@get_configuration_view');
                Route::post('view_exp_configuration', 'ProcessExperimentController@get_experiment_variation');
                Route::post('view_associate_model', 'AssociatedController@view_associate_model');
                Route::post('view_dataset', 'AssociatedController@view_dataset');
                Route::post('view_datarequest', 'AssociatedController@view_datarequest');
                Route::get('/{id}/manage', 'ProcessExperimentController@manage');
                Route::get('/{id}/view', 'ProcessExperimentController@manage');
                Route::post('/simulation_input/{id}/copy_to_knowledge', 'SimulateInputController@copy_to_knowledge');
                Route::get('/{id}/sim_config', 'ProcessExperimentController@SimulationConfig')->name('simulation_config');
                Route::get('/{id}/sim_config/{simulate_id}/edit', 'SimulationSetPointController@simulateEdit');
                Route::get('/{id}/sim_config/{simulate_id}/show', 'SimulationSetPointController@simulateShow');
                Route::post('/bulk-delete', 'ProcessExperimentController@bulkDelete');
                Route::resource('/{id}/sim_excel_config', 'SimulationExcelConfigController');
                Route::post('simulation_excel_config_store', 'SimulationExcelConfigController@store');
                Route::get('/sim_excel_config/{id}/manage', 'SimulationExcelConfigController@manage');
                Route::POST('{id}/sim_excel_config_delete', 'SimulationExcelConfigController@destroy');
                Route::POST('simulation-input-imported-report', 'SimInpTemplateUploadController@index');
                //Route::get('/stream_data', 'SimulationExcelConfigController@showStream');
            });
            Route::resource("experiment", "ProcessExperiment\ProcessExperimentController");
        });
        Route::get('/models/get-file-content/{file_id}', 'Models\ModelsController@getFileContent');
        Route::post('/models/bulk-delete', 'Models\ModelsController@bulkDelete');
        Route::resource("/models", "Models\ModelsController");
        Route::resource("/graph-in", "Graph\GraphController");

        Route::prefix('data_management')->namespace('DataManagement')->group(function () {
            Route::post('/data_sets/bulk-delete', 'DataSetsController@bulkDelete');
            Route::resource("/data_sets", "DataSetsController");

            Route::post("data_curation/{id}/retry", "DataCurationController@retry");
            Route::post('/data_curation/bulk-delete', 'DataCurationController@bulkDelete');
            Route::resource("/data_curation", "DataCurationController");

            Route::post('data_rules/bulk-delete', 'CurationRuleController@bulkDelete');
            Route::resource("data_rules", "CurationRuleController");
        });
        Route::post('/add-more-reactent-field', 'OtherInput\Reaction\ReactionController@addReactent');

        Route::resource('/sap/cloud_connect', 'Sap\SapController');
    });
});

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
///////////USER REGISTRATION SET NEW PASSWORD/////////
Route::get('create-new-password/{token}/pass', 'Auth\ResetPasswordController@createPassword');
Route::post('create-new-password/{token}/pass', 'Auth\ResetPasswordController@newPassword');

// Confirm Password (added in v6.2)
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Email Verification Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify'); // v6.x
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('unauthorized', 'LocationController@error_auth_user');
//Route::get('/authenticate/twofactor', 'Auth\LoginController@two_factor');
Route::get('/authenticate/two_factor_auth/{token}/otp_verify', 'Auth\LoginController@two_factor');
Route::post('/authenticate/two_factor_auth/{token}/otp_verify', 'Auth\LoginController@two_factor_auth');
Route::post('/authenticate/resend_otp', 'Auth\LoginController@resend_otp');

Route::get('set_side_bar_cookie', 'LocationController@setSession');

Route::get('coming_soon', 'Console\DashboardController@coming_soon');
Route::post('experiment/experiment_units/stream-add-more', 'Console\Experiment\ExperimentUnit\ExperimentController@streamAddMore');
Route::post('experiment/experiment_units/clone', 'Console\Experiment\ExperimentUnit\ExperimentController@cloneExpUnit');
Route::get('/custome_error', function () {
    return view('pages.error.cusome_error');
});


Route::post('experiment/data_set/raw_material/add_more_product', 'Console\Experiment\ProcessExperiment\SimulationOutputController@add_more_raw_product');
Route::post('experiment/data_set/raw_material/add_more_product_set_point', 'Console\Experiment\ProcessExperiment\SimulationOutputController@add_more_raw_product_set_point');
Route::resource("product_system/profile", "Console\ProductSystem\ProductSystem\ProductProfileController");
Route::post('product_system/profile/bulk-delete', 'Console\ProductSystem\ProductSystem\ProductProfileController@bulkDelete');

Route::group(['namespace' => 'Console', 'middleware' => ['console', 'prevent-back-history']], function () {
    Route::get('experiment/experiment/sim_excel_config/{id}/stream_data', 'Experiment\ProcessExperiment\SimulationExcelConfigController@showStream');
    Route::post('experiment/experiment/sim_excel_config/save_raw_material', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveRawMaterial');
    Route::post('experiment/experiment/sim_excel_config/get_master_units', 'Experiment\ProcessExperiment\SimulationExcelConfigController@master_units');
    Route::post('experiment/experiment/sim_excel_config/master_condition_config', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveMasterCondition');
    Route::post('experiment/experiment/sim_excel_config/master_outcome_config', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveMasterOutcome');
    Route::post('experiment/experiment/sim_excel_config/exp_condition_config', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveExpCondition');
    Route::post('experiment/experiment/sim_excel_config/exp_outcome_config', 'Experiment\ProcessExperiment\SimulationExcelConfigController@saveExpOutcome');
    Route::get('experiment/experiment/sim_excel_config/{id}/download/{type}', 'Experiment\ProcessExperiment\SimulationExcelConfigController@DownloadTemplate');
    Route::get('experiment/experiment/sim_excel_config/{id}/download/{type}', 'Experiment\ProcessExperiment\SimulationExcelConfigController@DownloadTemplate');
    Route::get('experiment/experiment/configuration/import_sim_input', 'Experiment\ProcessExperiment\SimulationExcelConfigController@importModal');
    Route::post('experiment/experiment/configuration/insert_sim_input', 'Experiment\ProcessExperiment\SimulateInputController@importSimInput');

    //simulation input excel upload
    Route::post('experiment/experiment/configuration/uploadExcelSimInp', 'Experiment\ProcessExperiment\SimulateInputController@uploadSimulationInputExcel');

    Route::post('experiment/experiment/simulation_config/bulk-delete', 'Experiment\ProcessExperiment\SimulateInputController@bulkDelete');
    Route::post('experiment/experiment/simulation_config/bulk-generate-report', 'Experiment\ProcessExperiment\SimulateInputController@bulkGenerateReport');

    Route::post('experiment/experiment/sim_config/status/{id}', 'Experiment\ProcessExperiment\SimulateInputController@updateStatus');
    //Product
    Route::resource('/ticket', 'Ticket\UserTicketController');
    Route::get('/downloaddoc', 'Ticket\UserTicketController@download');
    Route::post('product/chemical/importFile', 'Chemicals\ChemicalController@importFile');
    Route::post('product/chemical/check_molecular_formula', 'Chemicals\ChemicalController@check_molecular_formula');
    //

    Route::get('/notification', 'DashboardController@notification');
    Route::get('/clear-all-notification', 'DashboardController@clearActivityLog');
    Route::post('/add-more-chemicals-field', 'Chemicals\ChemicalController@addMore');
    Route::post('/add-more-chemicals-dynamic-add-field', 'Chemicals\PropertiesController@addMoreDynamicFields');
    Route::get('product/chemical/list_view/{list_id}/{chemical_id}', 'Chemicals\ChemicalController@view_list');

    ///ProductSystem
    Route::get("product_system/product/simulationproduct", "ProductSystem\ProductSystem\ProductSystemController@simulationproduct");
    Route::get('product_system/product_processList', 'ProductSystem\ProductSystem\ProductSystemController@processList');
    Route::post('product_system/product-addmore', 'ProductSystem\ProductSystem\ProductSystemController@addMore');
    Route::get('product_system/product/{id}/processSimprofile', 'ProductSystem\ProductSystem\ProductSystemController@showSimulationConfig');

    Route::resource("data_request", "DataRequest\DataRequestController");
    Route::get('/data_request/{id}/download_csv', 'DataRequest\DataRequestController@downloadCSV');
    ////Experiment
    Route::get("experiment/experiment_units/equipment_condition_outcome", "Experiment\ExperimentUnit\ExperimentController@equipment_condition_outcome");

    ///REPORT
    Route::get("reports/process_analysis/process_simulations", "Report\ProcessAnalysisController@get_process_simulations");
    Route::get("reports/process_comparison/process_simulations", "Report\ProcessComparisonController@get_process_simulations");
    Route::post("reports/experiment/getConfiguration", "Report\ExperimentsController@getConfiguration");
    Route::post("reports/experiment/getDataset", "Report\ExperimentsController@getDataset");
    Route::get('reports/experiment/data', 'Report\ExperimentsController@showData')->name('process_exp_report');
    Route::get('reports/experiment/chart', 'Report\ExperimentsController@chartRender');
    Route::get('reports/experiment/downloadjson/{id}', 'Report\ExperimentsController@downloadjson');
    Route::post('reports/experiment/{id}/retry', 'Report\ExperimentsController@retry');
    Route::get('reports/experiment/work/job/list', 'Report\ExperimentsController@show_jobs');

    ///OTHER INPUTS
    Route::post('other_inputs/reaction/reaction_check_mole', 'OtherInput\Reaction\ReactionController@checkMolecular');
    Route::post('other_inputs/reaction/{id}/calculate_reaction_rate', 'OtherInput\Reaction\ReactionController@calculate_reaction_rate');
    Route::post('experiment/experiment_units/importfile', 'Experiment\ExperimentUnit\ExperimentController@importFile');

    ///Experiments
    Route::prefix('experiment/experiment')->namespace('Experiment\ProcessExperiment')->group(function () {

        Route::post('product_raw_material_list', 'ProcessDiagramController@product_raw_material_list');
        Route::get('/sim_config_output/list', 'SimulateInputController@list');
        Route::get('/sim_config_setpoint/list', 'SimulationSetPointController@list');
        Route::post('experiment_unit/add_more', 'ProcessExperimentController@exp_unit_add_more');
        Route::get('/exp_profile_master', 'ProcessExperimentController@showExpMaster');
        Route::get('/getstreamdata', 'ProcessExperimentController@getstreamdata')->name('getstreamdata');
        Route::get('/exp_profile', 'ProcessExperimentController@showExp')->name('process_exp_profile');


        Route::get('/exp_unit_condition', 'ProcessExperimentController@expUnitCondition')->name('exp_unit_condition');
        Route::get('/exp_unit_outcomes', 'ProcessExperimentController@expoutcomes')->name('exp_unit_outcomes');
        Route::get('/set_unit_condition', 'ProcessExperimentController@setUnitcondition')->name('set_unit_condition');
        Route::get('/exp_messure_data', 'ProcessExperimentController@expmessurData')->name('exp_messure_data');
        //////OUTPUT-Measured-Exp-Unit-OUTCOME-Ajax-URL//////////
        Route::get('output-measured-data-exp-outcome-edit', 'SimulationOutputController@expUnitOutcomeEditPopup');
        Route::post('output-measured-data-exp-outcome-addlist', 'SimulationOutputController@expUnitOutcomeList');
        ////////END//////////////
        Route::post('add-exp-unit-condition-list', 'SimulationOutputController@expUnitConditionList');

        Route::get('edit-exp-unit-condition-popup', 'SimulationOutputController@editExpUnitConditionPopup');
        Route::get('edit-exp-unit-outcome-popup', 'SimulationOutputController@editExpUnitOutcomePopup');
        Route::get('/edit_master_outcome_output_popup', 'SimulationOutputController@outcomeMasterPopup');
        Route::get('/edit_master_condition_output_popup', 'SimulationOutputController@conditionMasterPopup');

        Route::post('add-condition-outcome-list', 'SimulationOutputController@addConditionOutcomeList');
        Route::post('/add_condition_outcome_list', 'SimulationOutputController@masterOutcomeOutPut');
        Route::post('/add_condition_list', 'SimulationOutputController@masterConditionOutPutList');
        //////Setpoint-Master-Exp_Outcome-Ajax-URL//////////
        Route::get('setpoint-master-exp-outcome-edit-popup', 'SimulationSetPointController@masterExpOutcomeEditPopup');
        Route::post('setpoint-master-exp-outcome-list', 'SimulationSetPointController@masterOutcomeList');
        ////////END////////////// 
        //////Setpoint-Master-Condition-Ajax-URL//////////
        Route::get('setpoint-master-condition-edit-popup', 'SimulationSetPointController@masterConditionEditPopup');
        Route::post('setpoint-master-condition-list', 'SimulationSetPointController@masterConditionList');
        ////////END//////////////
        //////Setpoint-Unit-Condition-Ajax-URL//////////
        Route::get('setpoint-unit-condition-edit-popup', 'SimulationSetPointController@unitConditionEditPopup');
        Route::post('setpoint-unit-condition-list', 'SimulationSetPointController@unitConditionList');
        Route::post('range-value-field', 'SimulationSetPointController@rangeValueField');
        ////////END//////////////
        //////Setpoint-Exp-Unit-OUTCOME-Ajax-URL//////////
        Route::get('setpoint-exp-unit-outcome-edit-popup', 'SimulationSetPointController@expUnitOutcomeEditPopup');
        Route::post('setpoint-exp-unit-outcome-list', 'SimulationSetPointController@expUnitOutcomeList');
        ////////END//////////////
        Route::post('simlated_updated_output', 'SimulationOutputController@simulatedOutPut');
        Route::post('simlated_updated_outputprd', 'SimulationOutputController@simulatedOutPutprd');
        Route::post('simlated_updated_setpoint', 'SimulationSetPointController@simulatedSetPoint');
        Route::post('simulate_output/raw_material_list', 'SimulationOutputController@rawMaterialList');
        Route::post('simulate_set_point/raw_material_list', 'SimulationSetPointController@rawMaterialList');

        Route::resource('simulate_output', 'SimulationOutputController');
        Route::resource('simulation_input', 'SimulateInputController');
        Route::resource('process_exp_associated', 'AssociatedController');
        Route::post('upload_associate_model', 'AssociatedController@upload_associate_model');
        Route::post('delete_associate_model', 'AssociatedController@delete_model');
        Route::post('status_associate_model', 'AssociatedController@update_status_model');
        Route::post('render_edit_models', 'AssociatedController@render_edit_models');
        Route::post('get_models_file', 'AssociatedController@get_models_file');
        Route::post('getFileContent_models', 'AssociatedController@getFileContent_models');
        Route::post('update_associated_model', 'AssociatedController@update_associated_model');
        //exp_dataset_update
        Route::resource('process_exp_dataset', 'DatasetModelController');
        Route::post('status_dataset_model', 'DatasetModelController@update_status_dataset');
        Route::post('delete_dataset_model', 'DatasetModelController@delete_dataset');
        Route::post('exp_dataset_update', 'DatasetModelController@exp_dataset_update');
        Route::post('upload_dataset_model', 'DatasetModelController@upload_dataset_model');
        Route::post('upload_updated_dataset_model', 'DatasetModelController@updated_dataset_model');
        Route::resource('process_exp_datarequest', 'DatasetRequestController');
        Route::post('datareq_list', 'DatasetRequestController@datareq_list');
        Route::post('upload_datareq_model', 'DatasetRequestController@upload_datareq_model');
        Route::post('delete_data_request', 'DatasetRequestController@delete_data_request');
        //upload_updated_dataset_model
        Route::post('view_profile', 'ProcessExperimentController@get_profile_view');
        Route::post('simulation_config_store', 'SimulationSetPointController@simulation_config_store');
        Route::resource('simulate_set_point', 'SimulationSetPointController');
        Route::get('/{id}/view_config', 'ProcessExperimentController@SimulationConfig')->name('view_config');;
    });

    Route::prefix('experiment')->namespace('Experiment\ProcessExperiment')->group(function () {
        Route::post('/experimentProfile/saveprofile', 'ProcessExperimentProfileController@saveprofile');
        Route::delete('/experimentProfile/{id}/{pid}/{uid}', 'ProcessExperimentProfileController@destroy');
        Route::get('/experimentProfile/{id}/{pid}/{uid}/Edit', 'ProcessExperimentProfileController@getProfile');
        Route::get('/experimentProfile/{id}/{pid}/{uid}/master_io_Edit', 'ProcessExperimentProfileController@masterIOProfile');
        Route::post('/experimentProfile/saveprofilemaster', 'ProcessExperimentProfileController@saveprofilemaster');

        Route::get("experiment/{experiment_id}/manage/{variation_id}/edit", "VariationController@edit");
        Route::get("experiment/{experiment_id}/manage/{variation_id}/show", "ProcessConfigController@show");

        Route::resource("variation", "VariationController");
        Route::post('variation/bulkdelvariation', 'VariationController@bulkDelete');
        Route::post('variation/deleteVartion', 'VariationController@deleteVartion');
        Route::post("variation/edit", "VariationController@editdata");
        Route::post("variation/updateVarition", "VariationController@updateVarition");
        Route::post('experiment/bulk-delete', 'ProcessConfigController@bulkDelete');
        Route::post('variation/status', 'VariationController@update_status');

        Route::resource("process_diagram", "ProcessDiagramController");
        Route::post('process_diagram/bulkdelDiagram', 'ProcessDiagramController@bulkDelete');
        Route::post('process_diagram/deleteDiagram', 'ProcessDiagramController@deleteDiagram');
        Route::resource("plant_data", "PlantDataController");
        Route::resource("data_sets", "DataSetsController");
        Route::resource("process_exp_energflow", "ProcessEnergyFlowController");
        Route::post('process_exp_energflow/bulk-delete', 'ProcessEnergyFlowController@bulkDelete');
        Route::get('raw_material/{id}/popup', 'ProcessDiagramController@raw_material_edit_popup');
        Route::get('raw_material/{id}/popup_set_point', 'ProcessDiagramController@raw_material_edit_popup_set_point');
        Route::post("process_diagram/update", "ProcessDiagramController@update");
        Route::post("process_diagram/edit", "ProcessDiagramController@editdata");
        Route::post("process_diagram/getimgmodel", "ProcessDiagramController@getimgmodel");
        Route::post("process_diagram/saveimgmodel", "ProcessDiagramController@saveimgmodel");
        Route::get('/variation/{id}/applyconfig', 'ProcessConfigController@applyConfig');
        Route::post('/experiment/getProductAssociate', 'ProcessExperimentController@getProductAssociate');
        Route::post("/experiment/checkStream", "ProcessExperimentController@checkStream");
        Route::get('/associated_unit', 'ProcessExperimentController@getAssociateData');
        Route::get('/add_condition_outcome_popup', 'ProcessExperimentController@addConditionOutcomePopup');
        Route::post('model/bulkdelmodel', 'AssociatedController@bulkDelete');
        Route::post('dataset/bulkdeldataset', 'DatasetModelController@bulkDelete');
        Route::post('data_request/bulkdeldata_request', 'DatasetRequestController@bulkDelete');
        Route::post('experiment/clone', 'ProcessExperimentController@cloneExp');
        Route::post('experiment/cloneVariation', 'ProcessExperimentController@cloneVariation');
        Route::post('experiment/clonesimInput', 'ProcessExperimentController@clonesimInput');
    });
    Route::get('data_management/data_sets/ajax_list', 'DataManagement\DataSetsController@list_experiment');

    Route::group(['middleware' => ['PermissionModule']], function () {
        Route::get('/dashboard', 'DashboardController@dashboard');
        Route::prefix('product')->group(function () {
            Route::post('/chemical/bulk-delete', 'Chemicals\ChemicalController@bulkDelete');
            Route::resource('chemical', 'Chemicals\ChemicalController');
            // Custom Manage Property action routes
            Route::resource('/chemical/{id}/addprop', 'Chemicals\PropertiesController');
            Route::get('/chemical/{id}/property/{prop_id}/{type}', 'Chemicals\PropertiesController@subProperty');
            Route::resource('generic', 'Generic\GenericController');
        });

        Route::prefix('organization')->namespace('Organization')->group(function () {
            Route::get('/settings', 'OrganizationController@index');
            Route::get('/masters', 'OrganizationController@masters');

            Route::post('/profile/default_preference', 'ProfileController@default_preference');
            Route::resource('/profile', 'ProfileController');
            Route::resource('list', 'Lists\ListController');
            Route::post('list/bulk-delete', 'Lists\ListController@bulkDelete');

            Route::post('{tenant_id}/user_management/bulk-delete', 'UserController@bulkDelete');
            Route::resource('{tenant_id}/user_management', 'UserController');

            Route::post('{tenant_id}/designation/bulk-delete', 'DesignationController@bulkDelete');
            Route::resource('{tenant_id}/designation', 'DesignationController');

            Route::post('{tenant_id}/user_group/bulk-delete', 'UserGroupController@bulkDelete');
            Route::post('{tenant_id}/user_group/importfile', 'UserGroupController@importFile');
            Route::resource('{tenant_id}/user_group', 'UserGroupController');

            Route::post('{tenant_id}/user_permission/bulk-delete', 'UserPermissionController@bulkDelete');
            Route::resource('{tenant_id}/user_permission', 'UserPermissionController');

            Route::prefix('vendor')->namespace('Vendor')->group(function () {
                Route::get('/{id}/manage', 'VendorController@manage');
                Route::post('/category/bulk-delete', 'CategoryController@bulkDelete');
                Route::resource('/category', 'CategoryController');
                Route::post('/classification/bulk-delete', 'ClassificationController@bulkDelete');
                Route::resource('/classification', 'ClassificationController');
                Route::post('/bulk-delete', 'VendorController@bulkDelete');
                Route::post('/importFile', 'VendorController@importFile');
                Route::resource('/contact', 'ContactController');
                Route::resource('/location', 'LocationController');
            });
            Route::resource('vendor', 'Vendor\VendorController');
        });

        Route::prefix('other_inputs')->namespace('OtherInput')->group(function () {
            Route::post('/add-more-energy-field', 'Energy\EnergyController@addMore');
            Route::post('/add-more-energy-dynamic-add-field', 'Energy\EnergyController@addMoreDynamicFields');
            Route::post('add-more-reactent-field', 'Reaction\ReactionController@addReactent');
            Route::post('balance-reactant', 'Reaction\ReactionController@balanceReactions');
            Route::post('energy/importFile', 'Energy\EnergyController@importFile');
            Route::post('energy/bulk-delete', 'Energy\EnergyController@bulkDelete');
            Route::resource("/energy", "Energy\EnergyController");
            // Custom Manage Property action routes
            Route::resource('/energy/{id}/addprop', 'Energy\PropertiesController');
            Route::get('/energy/{id}/property/{prop_id}/{type}', 'Energy\PropertiesController@subProperty');
            Route::post('equipment/importFile', 'Equipment\EquipmentController@importFile');
            Route::post('equipment/bulk-delete', 'Equipment\EquipmentController@bulkDelete');
            Route::resource("/equipment", "Equipment\EquipmentController");
            // end prop route for equipment
            Route::post('reaction/importFile', 'Reaction\ReactionController@importFile');
            Route::post('reaction/bulk-delete', 'Reaction\ReactionController@bulkDelete');
            Route::resource("reaction", "Reaction\ReactionController");
            // Reaction Prop
            Route::resource('reaction/{id}/addprop', 'Reaction\PropertiesController');
        });

        Route::prefix('reports')->group(function () {
            Route::get("/process_analysis/process_simulation_details", "Report\ProcessAnalysisController@get_process_simulation_details");
            Route::post('process_analysis/bulk-delete', 'Report\ProcessAnalysisController@bulkDelete');
            Route::resource("/process_analysis", "Report\ProcessAnalysisController");
            Route::get("/process_comparison/process_simulation_details", "Report\ProcessComparisonController@get_process_simulation_details");
            Route::post('process_comparison/bulk-delete', 'Report\ProcessComparisonController@bulkDelete');
            Route::resource("/process_comparison", "Report\ProcessComparisonController");
            Route::post('product_system_comparison/bulk-delete', 'Report\ProductSystemComparisonController@bulkDelete');
            Route::resource("/product_system_comparison", "Report\ProductSystemComparisonController");
            Route::get("/product_system/productDetail", "Report\ProductSystemController@productDetail");
            Route::post('product_system/bulk-delete', 'Report\ProductSystemController@bulkDelete');
            Route::resource("/product_system", "Report\ProductSystemController");

            // Experiments Reports
            Route::resource("/experiment", "Report\ExperimentsController");
            Route::prefix('experiment')->group(function () {
                Route::post('/bulk-delete', 'Report\ExperimentsController@bulkDelete');
            });
        });

        Route::prefix('knowledge_bank')->group(function () {
            Route::resource("/process_simulation", "KnowledgeBank\ProcessSimulation\ProcessSimulationController");
            Route::resource("/report", "KnowledgeBank\Report\ReportController");
        });

        Route::prefix('product_system')->namespace('ProductSystem')->group(function () {
            Route::post('/product/bulk-delete', 'ProductSystem\ProductSystemController@bulkDelete');
            Route::get("/product/{id}/manage", "ProductSystem\ProductSystemController@show");
            Route::resource("/product", "ProductSystem\ProductSystemController");
            Route::get("/profile/{id}/create", "ProductSystem\ProductProfileController@create");
            //Route::resource("/profile", "ProductSystem\ProductProfileController");
            // Route::post('/profile/bulk-delete', 'ProductSystem\ProductProfileController@bulkDelete');
            Route::get('/comparison/chart1', 'Comparison\ComparisonController@chartRender');
            Route::post('/comparison/bulk-delete', 'Comparison\ComparisonController@bulkDelete');
            Route::resource("/comparison", "Comparison\ComparisonController");
        });

        Route::prefix('experiment')->namespace('Experiment')->group(function () {
            Route::post('/experiment_units/bulk-delete', 'ExperimentUnit\ExperimentController@bulkDelete');
            Route::resource("/experiment_units", "ExperimentUnit\ExperimentController");
            Route::resource("process_diagram", "ProcessExperiment\ProcessDiagramController");
            Route::post("process_diagram/getDiagramImageView", "ProcessExperiment\ProcessDiagramController@getDiagramImageView");
            Route::post('experiment/associate_model', 'ProcessExperiment\AssociatedController@associate_model');
            Route::post('experiment/dataset_list', 'ProcessExperiment\DatasetModelController@dataset_list');
            Route::prefix('experiment')->namespace('ProcessExperiment')->group(function () {
                Route::get('view_varition', 'ProcessExperimentController@get_vartion_view');
                Route::post('view_configuration', 'ProcessExperimentController@get_configuration_view');
                Route::post('view_exp_configuration', 'ProcessExperimentController@get_experiment_variation');
                Route::post('view_associate_model', 'AssociatedController@view_associate_model');
                Route::post('view_dataset', 'AssociatedController@view_dataset');
                Route::post('view_datarequest', 'AssociatedController@view_datarequest');
                Route::get('/{id}/manage', 'ProcessExperimentController@manage');
                Route::get('/{id}/view', 'ProcessExperimentController@manage');
                Route::post('/simulation_input/{id}/copy_to_knowledge', 'SimulateInputController@copy_to_knowledge');
                Route::get('/{id}/sim_config', 'ProcessExperimentController@SimulationConfig')->name('simulation_config');
                Route::post('/bulk-delete', 'ProcessExperimentController@bulkDelete');
                Route::resource('/{id}/sim_excel_config', 'SimulationExcelConfigController');
                //Route::post('simulation_excel_config_store', 'SimulationExcelConfigController@store');
                Route::get('/sim_excel_config/{id}/manage', 'SimulationExcelConfigController@manage');
            });

            Route::resource("experiment", "ProcessExperiment\ProcessExperimentController");
        });
        Route::get('/models/get-file-content/{file_id}', 'Models\ModelsController@getFileContent');
        Route::post('/models/bulk-delete', 'Models\ModelsController@bulkDelete');
        Route::resource("/models", "Models\ModelsController");
        Route::resource("/graph-in", "Graph\GraphController");

        Route::prefix('data_management')->namespace('DataManagement')->group(function () {
            Route::post('/data_sets/bulk-delete', 'DataSetsController@bulkDelete');
            Route::resource("/data_sets", "DataSetsController");

            Route::post("data_curation/{id}/retry", "DataCurationController@retry");
            Route::post('/data_curation/bulk-delete', 'DataCurationController@bulkDelete');
            Route::resource("/data_curation", "DataCurationController");

            Route::post('data_rules/bulk-delete', 'CurationRuleController@bulkDelete');
            Route::resource("data_rules", "CurationRuleController");
        });


        Route::post('/add-more-reactent-field', 'OtherInput\Reaction\ReactionController@addReactent');

        Route::resource('/sap/cloud_connect', 'Sap\SapController');
    });
});
