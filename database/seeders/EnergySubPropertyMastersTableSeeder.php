<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EnergySubPropertyMastersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('energy_sub_property_masters')->delete();
        
        \DB::table('energy_sub_property_masters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 7,
            'sub_property_name' => 'Enthalpy Change of Combustion (Dhcomb)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "22", "field_name": "Enthalpy Change of Combustion (Dhcomb)", "field_type_id": "5", "unit_constant_id": "1"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-21 23:58:58',
                'updated_at' => '2021-02-19 01:08:28',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
                'property_id' => 4,
                'base_unit' => 0,
                'sub_property_name' => 'Files',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "field_name": "Files", "field_type_id": "11"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 00:00:19',
                'updated_at' => '2020-12-22 00:00:19',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 0,
                'property_id' => 4,
                'base_unit' => 0,
                'sub_property_name' => 'Notes/Comments',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "field_name": "Notes/Comments", "field_type_id": "8"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 00:00:51',
                'updated_at' => '2020-12-22 00:00:51',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 0,
                'property_id' => 3,
                'base_unit' => 7,
                'sub_property_name' => 'Price',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "29", "field_name": "Price", "field_type_id": "5", "unit_constant_id": "1"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 00:01:37',
                'updated_at' => '2021-02-19 01:45:20',
            ),
            4 => 
            array (
                'id' => 6,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 7,
            'sub_property_name' => 'Enthalpy Change of Vaporization (Dhvap)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "22", "field_name": "Enthalpy Change of Vaporization (Dhvap)", "field_type_id": "5", "unit_constant_id": "4"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:42:13',
                'updated_at' => '2021-02-19 01:15:54',
            ),
            5 => 
            array (
                'id' => 7,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 0,
                'sub_property_name' => 'Pressure',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "5", "field_name": "Pressure", "field_type_id": "5"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:42:53',
                'updated_at' => '2020-12-25 04:28:47',
            ),
            6 => 
            array (
                'id' => 8,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 7,
            'sub_property_name' => 'Specific Heat Capacity (Cp)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "21", "field_name": "Specific Heat Capacity (Cp)", "field_type_id": "5", "unit_constant_id": "1"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:45:21',
                'updated_at' => '2021-02-19 01:18:23',
            ),
            7 => 
            array (
                'id' => 9,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 0,
                'sub_property_name' => 'Temperature',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "12", "field_name": "Temperature", "field_type_id": "5"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:47:57',
                'updated_at' => '2020-12-25 04:29:36',
            ),
            8 => 
            array (
                'id' => 10,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 0,
                'sub_property_name' => 'Carbon Content',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "16", "field_name": "Carbon Content", "field_type_id": "5"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:51:02',
                'updated_at' => '2020-12-25 04:30:00',
            ),
            9 => 
            array (
                'id' => 11,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 7,
                'sub_property_name' => 'Cummulative Energy Demand',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "23", "field_name": "Cummulative Energy Demand", "field_type_id": "5", "unit_constant_id": "1"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:55:42',
                'updated_at' => '2021-02-19 01:30:22',
            ),
            10 => 
            array (
                'id' => 12,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 0,
                'sub_property_name' => 'Energy Content',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "11", "field_name": "Energy Content", "field_type_id": "5"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:00:27',
                'updated_at' => '2021-02-12 01:27:51',
            ),
            11 => 
            array (
                'id' => 13,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 0,
                'sub_property_name' => 'Eutrophication potential',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "43", "field_name": "Eutrophication potential", "field_type_id": "5"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:01:46',
                'updated_at' => '2020-12-25 04:31:18',
            ),
            12 => 
            array (
                'id' => 14,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 7,
                'sub_property_name' => 'Greenhouse Gas Emission',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "24", "field_name": "Greenhouse Gas Emission", "field_type_id": "5", "unit_constant_id": "1"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:02:46',
                'updated_at' => '2021-02-19 01:32:16',
            ),
            13 => 
            array (
                'id' => 15,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 7,
                'sub_property_name' => 'Land Usage',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "28", "field_name": "Land Usage", "field_type_id": "5", "unit_constant_id": "3"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:05:20',
                'updated_at' => '2021-02-19 01:38:43',
            ),
            14 => 
            array (
                'id' => 16,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 7,
            'sub_property_name' => 'Non Renewable Energy Use (NREU)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "25", "field_name": "Select Non Renewable Energy Use (NREU)", "field_type_id": "5", "unit_constant_id": "1"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:06:01',
                'updated_at' => '2021-02-19 01:40:06',
            ),
            15 => 
            array (
                'id' => 17,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 7,
            'sub_property_name' => 'Renewable Energy Use (REU)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "26", "field_name": "Renewable Energy Use (REU)", "field_type_id": "5", "unit_constant_id": "1"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:06:59',
                'updated_at' => '2021-02-19 01:41:39',
            ),
            16 => 
            array (
                'id' => 18,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 7,
                'sub_property_name' => 'Water Usage',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "27", "field_name": "Water Usage", "field_type_id": "5", "unit_constant_id": "1"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:08:00',
                'updated_at' => '2021-03-03 22:33:09',
            ),
            17 => 
            array (
                'id' => 19,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 6,
            'sub_property_name' => 'Enthalpy Change of Combustion (Dhcomb)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "22", "field_name": "Enthalpy Change of Combustion (Dhcomb)", "field_type_id": "5", "unit_constant_id": "3"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-21 23:58:58',
                'updated_at' => '2021-02-19 01:11:34',
            ),
            18 => 
            array (
                'id' => 20,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 2,
            'sub_property_name' => 'Enthalpy Change of Combustion (Dhcomb)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "22", "field_name": "Enthalpy Change of Combustion (Dhcomb)", "field_type_id": "5", "unit_constant_id": "2"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-21 23:58:58',
                'updated_at' => '2021-02-19 01:11:16',
            ),
            19 => 
            array (
                'id' => 21,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 2,
            'sub_property_name' => 'Enthalpy Change of Vaporization (Dhvap)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "22", "field_name": "Enthalpy Change of Vaporization (Dhvap)", "field_type_id": "5", "unit_constant_id": "5"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:42:13',
                'updated_at' => '2021-02-19 01:17:08',
            ),
            20 => 
            array (
                'id' => 22,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 6,
            'sub_property_name' => 'Enthalpy Change of Vaporization (Dhvap)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "22", "field_name": "Enthalpy Change of Vaporization (Dhvap)", "field_type_id": "5", "unit_constant_id": "6"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:42:13',
                'updated_at' => '2021-02-19 01:17:24',
            ),
            21 => 
            array (
                'id' => 23,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 2,
            'sub_property_name' => 'Specific Heat Capacity (Cp)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "21", "field_name": "Specific Heat Capacity (Cp)", "field_type_id": "5", "unit_constant_id": "2"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:45:21',
                'updated_at' => '2021-02-19 01:19:40',
            ),
            22 => 
            array (
                'id' => 24,
                'tenant_id' => 0,
                'property_id' => 1,
                'base_unit' => 6,
            'sub_property_name' => 'Specific Heat Capacity (Cp)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "21", "field_name": "Specific Heat Capacity (Cp)", "field_type_id": "5", "unit_constant_id": "3"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:45:21',
                'updated_at' => '2021-02-19 01:20:05',
            ),
            23 => 
            array (
                'id' => 25,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 2,
                'sub_property_name' => 'Cummulative Energy Demand',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "23", "field_name": "Cummulative Energy Demand", "field_type_id": "5", "unit_constant_id": "2"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:55:42',
                'updated_at' => '2021-02-19 01:31:03',
            ),
            24 => 
            array (
                'id' => 26,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 6,
                'sub_property_name' => 'Cummulative Energy Demand',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "23", "field_name": "Cummulative Energy Demand", "field_type_id": "5", "unit_constant_id": "3"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 22:55:42',
                'updated_at' => '2021-02-19 01:31:17',
            ),
            25 => 
            array (
                'id' => 27,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 2,
                'sub_property_name' => 'Greenhouse Gas Emission',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "24", "field_name": "Greenhouse Gas Emission", "field_type_id": "5", "unit_constant_id": "2"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:02:46',
                'updated_at' => '2021-02-19 01:33:02',
            ),
            26 => 
            array (
                'id' => 29,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 6,
                'sub_property_name' => 'Greenhouse Gas Emission',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "24", "field_name": "Greenhouse Gas Emission", "field_type_id": "5", "unit_constant_id": "3"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:02:46',
                'updated_at' => '2021-02-19 01:35:58',
            ),
            27 => 
            array (
                'id' => 30,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 2,
                'sub_property_name' => 'Land Usage',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "28", "field_name": "Land Usage", "field_type_id": "5", "unit_constant_id": "1"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:05:20',
                'updated_at' => '2021-02-19 01:39:22',
            ),
            28 => 
            array (
                'id' => 31,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 6,
                'sub_property_name' => 'Land Usage',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "28", "field_name": "Land Usage", "field_type_id": "5", "unit_constant_id": "2"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:05:20',
                'updated_at' => '2021-02-19 01:39:33',
            ),
            29 => 
            array (
                'id' => 32,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 2,
            'sub_property_name' => 'Non Renewable Energy Use (NREU)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "25", "field_name": "Select Non Renewable Energy Use (NREU)", "field_type_id": "5", "unit_constant_id": "2"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:06:01',
                'updated_at' => '2021-02-19 01:40:48',
            ),
            30 => 
            array (
                'id' => 33,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 6,
            'sub_property_name' => 'Non Renewable Energy Use (NREU)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "25", "field_name": "Select Non Renewable Energy Use (NREU)", "field_type_id": "5", "unit_constant_id": "3"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:06:01',
                'updated_at' => '2021-02-19 01:41:00',
            ),
            31 => 
            array (
                'id' => 34,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 2,
            'sub_property_name' => 'Renewable Energy Use (REU)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "26", "field_name": "Renewable Energy Use (REU)", "field_type_id": "5", "unit_constant_id": "2"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:06:59',
                'updated_at' => '2021-02-19 01:42:15',
            ),
            32 => 
            array (
                'id' => 35,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 6,
            'sub_property_name' => 'Renewable Energy Use (REU)',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
            'dynamic_fields' => '[{"id": "0", "unit_id": "26", "field_name": "Renewable Energy Use (REU)", "field_type_id": "5", "unit_constant_id": "3"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:06:59',
                'updated_at' => '2021-02-19 01:42:27',
            ),
            33 => 
            array (
                'id' => 36,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 2,
                'sub_property_name' => 'Water Usage',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "27", "field_name": "Water Usage", "field_type_id": "5", "unit_constant_id": "2"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:08:00',
                'updated_at' => '2021-03-03 22:32:54',
            ),
            34 => 
            array (
                'id' => 37,
                'tenant_id' => 0,
                'property_id' => 2,
                'base_unit' => 6,
                'sub_property_name' => 'Water Usage',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "27", "field_name": "Water Usage", "field_type_id": "5", "unit_constant_id": "3"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 23:08:00',
                'updated_at' => '2021-03-03 22:32:36',
            ),
            35 => 
            array (
                'id' => 38,
                'tenant_id' => 0,
                'property_id' => 3,
                'base_unit' => 2,
                'sub_property_name' => 'Price',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "29", "field_name": "Price", "field_type_id": "5", "unit_constant_id": "2"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 00:01:37',
                'updated_at' => '2021-02-19 01:46:54',
            ),
            36 => 
            array (
                'id' => 39,
                'tenant_id' => 0,
                'property_id' => 3,
                'base_unit' => 6,
                'sub_property_name' => 'Price',
                'fields' => '[{"id": "0", "field_name": "Reference Source", "field_type_id": "8"}, {"id": "1", "field_name": "Keywords", "field_type_id": "9"}]',
                'dynamic_fields' => '[{"id": "0", "unit_id": "29", "field_name": "Price", "field_type_id": "5", "unit_constant_id": "3"}]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2020-12-22 00:01:37',
                'updated_at' => '2021-02-19 01:47:12',
            ),
        ));
        
        
    }
}