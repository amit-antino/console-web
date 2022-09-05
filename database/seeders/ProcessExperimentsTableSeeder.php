<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProcessExperimentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('process_experiments')->delete();
        
        \DB::table('process_experiments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 6,
                'project_id' => 1,
                'process_experiment_name' => 'testexperiment',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "cm", "exp_unit": 1, "created_by": 70}]',
                'classification_id' => '[]',
                'chemical' => '[1]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 70,
                'updated_by' => 70,
                'deleted_at' => NULL,
                'created_at' => '2022-02-01 02:51:02',
                'updated_at' => '2022-02-01 02:51:02',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 6,
                'project_id' => 1,
                'process_experiment_name' => 'testexperiment2',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "cm", "exp_unit": 1, "created_by": 70}]',
                'classification_id' => '[]',
                'chemical' => '[1]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 70,
                'updated_by' => 70,
                'deleted_at' => NULL,
                'created_at' => '2022-02-01 04:55:15',
                'updated_at' => '2022-02-01 04:55:15',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 1,
                'project_id' => 3,
                'process_experiment_name' => 'test',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "unit1", "exp_unit": 2, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[17, 18, 19]',
                'data_source' => NULL,
                'main_product_input' => '[18]',
                'main_product_output' => '[18]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-02-16 04:38:55',
                'updated_at' => '2022-03-16 01:35:19',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 10,
                'project_id' => 4,
                'process_experiment_name' => 'Testexperiment',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Testexperiment 1", "exp_unit": 6, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[30]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-03 03:59:11',
                'updated_at' => '2022-03-03 03:59:11',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 10,
                'project_id' => 5,
                'process_experiment_name' => 'Expetest',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Experiment test", "exp_unit": 7, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[34]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-03 04:35:49',
                'updated_at' => '2022-03-03 04:35:49',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 10,
                'project_id' => 6,
                'process_experiment_name' => 'Experimentname00000',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Experimentunit name101", "exp_unit": 8, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[30, 34]',
                'data_source' => NULL,
                'main_product_input' => '[34, 30]',
                'main_product_output' => '[34, 30]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-08 03:01:39',
                'created_at' => '2022-03-04 01:02:55',
                'updated_at' => '2022-03-08 03:01:39',
            ),
            6 => 
            array (
                'id' => 7,
                'tenant_id' => 10,
                'project_id' => 0,
                'process_experiment_name' => 'clone__experiment',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Experimentunit name101", "exp_unit": 8, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[30, 34]',
                'data_source' => NULL,
                'main_product_input' => '[34, 30]',
                'main_product_output' => '[34, 30]',
                'energy_id' => NULL,
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-08 04:02:51',
                'created_at' => '2022-03-04 01:20:28',
                'updated_at' => '2022-03-08 04:02:51',
            ),
            7 => 
            array (
                'id' => 8,
                'tenant_id' => 10,
                'project_id' => 4,
                'process_experiment_name' => 'experiment nametest101',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Experiment test", "exp_unit": 7, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[34]',
                'data_source' => NULL,
                'main_product_input' => '[34]',
                'main_product_output' => '[34]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-05 04:22:55',
                'updated_at' => '2022-03-05 04:22:55',
            ),
            8 => 
            array (
                'id' => 9,
                'tenant_id' => 10,
                'project_id' => 5,
                'process_experiment_name' => 'Experiment11111',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Experimentunit name101", "exp_unit": 8, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[38]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-07 20:59:43',
                'updated_at' => '2022-03-07 20:59:43',
            ),
            9 => 
            array (
                'id' => 10,
                'tenant_id' => 10,
                'project_id' => 0,
                'process_experiment_name' => 'Testexperiment',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Testexperiment 1", "exp_unit": 6, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[30]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => NULL,
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 03:49:38',
                'updated_at' => '2022-03-08 03:49:38',
            ),
            10 => 
            array (
                'id' => 11,
                'tenant_id' => 10,
                'project_id' => 4,
                'process_experiment_name' => 'exp222',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "test2", "exp_unit": 15, "created_by": 27}, {"id": "2", "unit": "test2", "exp_unit": 15, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[34]',
                'data_source' => NULL,
                'main_product_input' => '[34]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 04:35:34',
                'updated_at' => '2022-03-08 04:35:34',
            ),
            11 => 
            array (
                'id' => 12,
                'tenant_id' => 10,
                'project_id' => 0,
                'process_experiment_name' => 'Testexperiment',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Testexperiment 1", "exp_unit": 6, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[30]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => NULL,
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 20:58:03',
                'updated_at' => '2022-03-08 20:58:03',
            ),
            12 => 
            array (
                'id' => 13,
                'tenant_id' => 10,
                'project_id' => 0,
                'process_experiment_name' => 'Testexperiment',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Testexperiment 1", "exp_unit": 6, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[30]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => NULL,
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 20:58:16',
                'updated_at' => '2022-03-08 20:58:16',
            ),
            13 => 
            array (
                'id' => 14,
                'tenant_id' => 10,
                'project_id' => 4,
                'process_experiment_name' => 'Demo experiment name',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Test experiment", "exp_unit": 10, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[30, 41, 43]',
                'data_source' => NULL,
                'main_product_input' => '[43]',
                'main_product_output' => '[30]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 23:47:57',
                'updated_at' => '2022-03-08 23:47:57',
            ),
            14 => 
            array (
                'id' => 15,
                'tenant_id' => 1,
                'project_id' => 3,
                'process_experiment_name' => 'dsd',
                'category_id' => 1,
                'experiment_unit' => '[{"id": "1", "unit": "dsgg", "exp_unit": 2, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[17]',
                'data_source' => NULL,
                'main_product_input' => '[17]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-11 22:13:09',
                'created_at' => '2022-03-09 22:52:31',
                'updated_at' => '2022-03-11 22:13:09',
            ),
            15 => 
            array (
                'id' => 16,
                'tenant_id' => 1,
                'project_id' => 3,
                'process_experiment_name' => 'Demo experiment',
                'category_id' => 1,
                'experiment_unit' => '[{"id": "1", "unit": "test", "exp_unit": 3, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[17]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-10 23:50:16',
                'created_at' => '2022-03-10 23:50:00',
                'updated_at' => '2022-03-10 23:50:16',
            ),
            16 => 
            array (
                'id' => 17,
                'tenant_id' => 1,
                'project_id' => 3,
                'process_experiment_name' => 'Demoexperiment',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "test", "exp_unit": 3, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[17, 19, 29]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-11 21:09:18',
                'created_at' => '2022-03-10 23:50:56',
                'updated_at' => '2022-03-11 21:09:18',
            ),
            17 => 
            array (
                'id' => 18,
                'tenant_id' => 6,
                'project_id' => 1,
                'process_experiment_name' => 'test',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "test", "exp_unit": 1, "created_by": 2}]',
                'classification_id' => '[]',
                'chemical' => '[1]',
                'data_source' => NULL,
                'main_product_input' => '[1]',
                'main_product_output' => '[1]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 20:57:17',
                'updated_at' => '2022-03-11 20:57:17',
            ),
            18 => 
            array (
                'id' => 19,
                'tenant_id' => 1,
                'project_id' => 3,
                'process_experiment_name' => 'Demo experiment',
                'category_id' => 1,
                'experiment_unit' => '{"1": {"id": "2", "unit": "Demo experiment unit", "exp_unit": 22, "created_by": 27}}',
                'classification_id' => '[]',
                'chemical' => '[29, 45, 52]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 22:12:53',
                'updated_at' => '2022-03-11 23:10:11',
            ),
            19 => 
            array (
                'id' => 20,
                'tenant_id' => 1,
                'project_id' => 0,
                'process_experiment_name' => 'Demo experiment',
                'category_id' => 1,
                'experiment_unit' => '{"1": {"id": "2", "unit": "Demo experiment unit", "exp_unit": 22, "created_by": 27}}',
                'classification_id' => '[]',
                'chemical' => '[29, 45, 52]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => NULL,
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-11 23:28:20',
                'created_at' => '2022-03-11 23:16:51',
                'updated_at' => '2022-03-11 23:28:20',
            ),
            20 => 
            array (
                'id' => 21,
                'tenant_id' => 1,
                'project_id' => 3,
                'process_experiment_name' => 'test excel import',
                'category_id' => 1,
                'experiment_unit' => '[{"id": "1", "unit": "test 1", "exp_unit": 3, "created_by": 7}, {"id": "2", "unit": "test 2", "exp_unit": 22, "created_by": 7}]',
                'classification_id' => '[1]',
                'chemical' => '[17, 52, 54]',
                'data_source' => 'test',
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 7,
                'updated_by' => 7,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 08:26:23',
                'updated_at' => '2022-03-15 08:26:23',
            ),
            21 => 
            array (
                'id' => 22,
                'tenant_id' => 1,
                'project_id' => 3,
                'process_experiment_name' => 'testexcelimport2',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "test", "exp_unit": 2, "created_by": 12}]',
                'classification_id' => '[]',
                'chemical' => '[17, 19, 45]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 12,
                'updated_by' => 12,
                'deleted_at' => NULL,
                'created_at' => '2022-03-16 03:04:05',
                'updated_at' => '2022-03-16 03:04:05',
            ),
            22 => 
            array (
                'id' => 23,
                'tenant_id' => 21,
                'project_id' => 9,
                'process_experiment_name' => 'Test Experiment',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "Test", "exp_unit": 25, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[55, 56, 58]',
                'data_source' => NULL,
                'main_product_input' => '[55]',
                'main_product_output' => '[56]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-04-14 22:03:58',
                'updated_at' => '2022-04-18 23:35:46',
            ),
            23 => 
            array (
                'id' => 24,
                'tenant_id' => 21,
                'project_id' => 9,
                'process_experiment_name' => 'demo',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "unit", "exp_unit": 25, "created_by": 28}]',
                'classification_id' => '[3]',
                'chemical' => '[55, 56, 58]',
                'data_source' => NULL,
                'main_product_input' => '[]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-15 18:26:11',
                'updated_at' => '2022-04-15 18:26:45',
            ),
            24 => 
            array (
                'id' => 25,
                'tenant_id' => 21,
                'project_id' => 9,
                'process_experiment_name' => 'Experiment',
                'category_id' => 0,
                'experiment_unit' => '[{"id": "1", "unit": "test", "exp_unit": 25, "created_by": 27}]',
                'classification_id' => '[]',
                'chemical' => '[55]',
                'data_source' => NULL,
                'main_product_input' => '[55]',
                'main_product_output' => '[55]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-04-18 23:35:42',
                'created_at' => '2022-04-18 20:44:55',
                'updated_at' => '2022-04-18 23:35:42',
            ),
            25 => 
            array (
                'id' => 26,
                'tenant_id' => 21,
                'project_id' => 9,
                'process_experiment_name' => 'experiment1',
                'category_id' => 6,
                'experiment_unit' => '[{"id": "1", "unit": "dcd", "exp_unit": 25, "created_by": 1}]',
                'classification_id' => '[3]',
                'chemical' => '[55, 58, 59]',
                'data_source' => 'ds1',
                'main_product_input' => '[55]',
                'main_product_output' => '[]',
                'energy_id' => '[]',
                'description' => NULL,
                'tags' => '[]',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 11:38:47',
                'updated_at' => '2022-04-27 11:38:47',
            ),
        ));
        
        
    }
}