<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(ChemicalPropertyMastersTableSeeder::class);
        $this->call(ChemicalSubPropertyMastersTableSeeder::class);
        $this->call(ChemicalCategoriesTableSeeder::class);
        $this->call(ChemicalClassificationsTableSeeder::class);
        $this->call(CodeStatementsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);

        $this->call(CriteriaMastersTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(EnergyPropertyMastersTableSeeder::class);
        $this->call(EnergySubPropertyMastersTableSeeder::class);
        $this->call(ExperimentConditionMastersTableSeeder::class);
        $this->call(ExperimentOutcomeMastersTableSeeder::class);
        $this->call(FlowTypeMasterTableSeeder::class);
        $this->call(HazardsTableSeeder::class);
        $this->call(HazardCategoriesTableSeeder::class);
        $this->call(HazardClassesTableSeeder::class);
        $this->call(HazardCodeTypesTableSeeder::class);
        $this->call(HazardPictogramsTableSeeder::class);
        $this->call(HazardSubCodeTypesTableSeeder::class);
       // $this->call(JobsTableSeeder::class);
        $this->call(MasterUnitsTableSeeder::class);
      //  $this->call(MigrationsTableSeeder::class);
        //$this->call(NotificationsTableSeeder::class);
        $this->call(PriorityMastersTableSeeder::class);
        $this->call(ProcessCategoriesTableSeeder::class);
        $this->call(ProcessStatusesTableSeeder::class);
        $this->call(ProcessTypesTableSeeder::class);
        $this->call(SimulationTypesTableSeeder::class);

        $this->call(ReactionTypesTableSeeder::class);
        $this->call(TenantsTableSeeder::class);
        $this->call(TenantConfigsTableSeeder::class);
        $this->call(TenantMasterPlansTableSeeder::class);
        $this->call(TenantMasterTypesTableSeeder::class);
        $this->call(TenantUsersTableSeeder::class);
        $this->call(TimeZonesTableSeeder::class);
        $this->call(UserMenusTableSeeder::class);
       
        $this->call(UserPermissionsTableSeeder::class);
        $this->call(ChemicalsTableSeeder::class);
        $this->call(ExperimentReportsTableSeeder::class);
        $this->call(ProcessDiagramsTableSeeder::class);
        $this->call(ProcessExperimentsTableSeeder::class);
        $this->call(ProcessExpProfilesTableSeeder::class);
        $this->call(ProcessExpProfileMastersTableSeeder::class);
        $this->call(VariationsTableSeeder::class);
        $this->call(SimulateInputsTableSeeder::class);
        $this->call(ExperimentUnitsTableSeeder::class);
        $this->call(EquipmentUnitsTableSeeder::class);
        $this->call(EquipmentsTableSeeder::class);
        $this->call(ChemicalPropertiesTableSeeder::class);
        $this->call(ExperimentCategoriesTableSeeder::class);
        $this->call(ExperimentClassificationsTableSeeder::class);
        $this->call(ExperimentUnitImagesTableSeeder::class);
        $this->call(SimulateInputExcelTemplatesTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(PeriodicTableSeeder::class);
        $this->call(ActivityLogsTableSeeder::class);
        $this->call(AssociatedModelsTableSeeder::class);
        $this->call(CategoryListsTableSeeder::class);
        $this->call(ClassificationListsTableSeeder::class);
        $this->call(CurationRulesTableSeeder::class);
        $this->call(DataCurationsTableSeeder::class);
        $this->call(DataRequestModelsTableSeeder::class);
        $this->call(DataRequestsTableSeeder::class);
        $this->call(DatasetModelsTableSeeder::class);
        $this->call(DatasetsTableSeeder::class);
        $this->call(DbBackupsTableSeeder::class);
        $this->call(EnergyUtilitiesTableSeeder::class);
        $this->call(EnergyUtilityPropertiesTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(KnowledgeBanksTableSeeder::class);
        $this->call(ListProductsTableSeeder::class);
        $this->call(MacAddressesTableSeeder::class);
        $this->call(ModelDetailsTableSeeder::class);
        $this->call(ModelFilesTableSeeder::class);
        $this->call(PeriodicTablesTableSeeder::class);
        $this->call(ProcessAnalysisReportsTableSeeder::class);
        $this->call(ProcessComaprisonsTableSeeder::class);
        $this->call(ProcessExpEnergyFlowsTableSeeder::class);
        $this->call(ProcessProfilesTableSeeder::class);
        $this->call(ProcessSimulationReportsTableSeeder::class);
        $this->call(ProcessSimulationsTableSeeder::class);
        $this->call(ProductComparisonsTableSeeder::class);
        $this->call(ProductCreationsTableSeeder::class);
        $this->call(ProductSystemComparsionReportsTableSeeder::class);
        $this->call(ProductSystemProfilesTableSeeder::class);
        $this->call(ProductSystemReportsTableSeeder::class);
        $this->call(ProductSystemsTableSeeder::class);
        $this->call(ProductTypesTableSeeder::class);
        $this->call(ReactionPhasesTableSeeder::class);
        $this->call(ReactionPropertiesTableSeeder::class);
        $this->call(ReactionsTableSeeder::class);
        $this->call(RegulatoryListsTableSeeder::class);
        $this->call(SimInpTemplateUploadsTableSeeder::class);
        $this->call(ToleranceReportsTableSeeder::class);
        $this->call(UserTicketsTableSeeder::class);
        $this->call(VendorCategoriesTableSeeder::class);
        $this->call(VendorClassificationsTableSeeder::class);
        $this->call(VendorContactDetailsTableSeeder::class);
        $this->call(VendorLocationsTableSeeder::class);
        $this->call(VendorsTableSeeder::class);
        $this->call(JobsQueuesTableSeeder::class);
    }
}
