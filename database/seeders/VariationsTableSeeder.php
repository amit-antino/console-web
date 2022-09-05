<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VariationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('variations')->delete();
        
        \DB::table('variations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'test_variation',
                'experiment_id' => 1,
                'process_flow_table' => '[1]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 70,
                'updated_by' => 70,
                'deleted_at' => '2022-02-01 03:27:20',
                'created_at' => '2022-02-01 02:51:35',
                'updated_at' => '2022-02-01 03:27:20',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'test_variation',
                'experiment_id' => 1,
                'process_flow_table' => '[2, 3]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 1, "experiment_units": [7]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 70,
                'updated_by' => 3,
                'deleted_at' => NULL,
                'created_at' => '2022-02-01 04:06:09',
                'updated_at' => '2022-03-22 02:18:43',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'test_variation_2',
                'experiment_id' => 2,
                'process_flow_table' => '[]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 70,
                'updated_by' => 70,
                'deleted_at' => NULL,
                'created_at' => '2022-02-01 04:55:33',
                'updated_at' => '2022-02-01 04:55:44',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'test-exp variation',
                'experiment_id' => 3,
                'process_flow_table' => '[4, 5, 6, 7, 14, 15]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 2, "experiment_units": [1]}',
                'models' => '[1, 2]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-02-28 21:37:34',
                'updated_at' => '2022-03-10 23:20:25',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Test experiment variation',
                'experiment_id' => 4,
                'process_flow_table' => '[8]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": [2]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-03 04:00:08',
                'updated_at' => '2022-03-03 05:12:35',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Experiment_variation_1',
                'experiment_id' => 5,
                'process_flow_table' => '[9]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-03 05:15:16',
                'updated_at' => '2022-03-03 05:15:44',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'experiment variation01',
                'experiment_id' => 6,
                'process_flow_table' => '[]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-04 01:03:51',
                'updated_at' => '2022-03-04 01:03:51',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'experiment variation01',
                'experiment_id' => 7,
                'process_flow_table' => '[10]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 3, "experiment_units": [3]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-04 01:20:28',
                'updated_at' => '2022-03-04 02:26:46',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'unit test variation',
                'experiment_id' => 9,
                'process_flow_table' => '[]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-07 21:00:07',
                'updated_at' => '2022-03-07 21:00:12',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Test experiment variation',
                'experiment_id' => 10,
                'process_flow_table' => '[8]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": [2]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 03:49:38',
                'updated_at' => '2022-03-08 03:49:38',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Expvariation',
                'experiment_id' => 11,
                'process_flow_table' => '[11, 12]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 4, "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 04:36:24',
                'updated_at' => '2022-03-08 04:45:22',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Test experiment variation',
                'experiment_id' => 12,
                'process_flow_table' => '[8]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": [2]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 20:58:03',
                'updated_at' => '2022-03-08 20:58:03',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Test experiment variation',
                'experiment_id' => 13,
                'process_flow_table' => '[8]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": [2]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 20:58:16',
                'updated_at' => '2022-03-08 20:58:16',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => '@@',
                'experiment_id' => 15,
                'process_flow_table' => '[13]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 5, "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-09 23:05:36',
                'updated_at' => '2022-03-09 23:06:28',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Demo variation',
                'experiment_id' => 17,
                'process_flow_table' => '[16]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-10 23:53:46',
                'updated_at' => '2022-03-11 01:57:55',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'tes1',
                'experiment_id' => 18,
                'process_flow_table' => '[17]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 6, "experiment_units": [4]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 20:57:28',
                'updated_at' => '2022-03-11 20:58:18',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'test2',
                'experiment_id' => 18,
                'process_flow_table' => '[]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 20:57:35',
                'updated_at' => '2022-03-11 20:57:35',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'new cln',
                'experiment_id' => 18,
                'process_flow_table' => '[17]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 6, "experiment_units": [4]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 20:58:48',
                'updated_at' => '2022-03-11 20:58:48',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Demo variation',
                'experiment_id' => 19,
                'process_flow_table' => '[18, 19, 20, 21]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 7, "experiment_units": []}',
                'models' => '[3]',
                'dataset' => '[1, 2, 3, 4, 5, 6]',
                'datamodel' => '[1]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 22:15:49',
                'updated_at' => '2022-03-11 22:59:54',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Demo variation',
                'experiment_id' => 19,
                'process_flow_table' => '[18, 19, 20, 21]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 7, "experiment_units": []}',
                'models' => '[3]',
                'dataset' => '[1, 2, 3, 4, 5, 6]',
                'datamodel' => '[1]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 23:11:45',
                'updated_at' => '2022-03-12 01:18:53',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Demo variation',
                'experiment_id' => 20,
                'process_flow_table' => '[18, 19, 20, 21]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 7, "experiment_units": []}',
                'models' => '[3]',
                'dataset' => '[1, 2, 3, 4, 5, 6]',
                'datamodel' => '[1]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 23:16:52',
                'updated_at' => '2022-03-11 23:16:52',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Demo variation',
                'experiment_id' => 20,
                'process_flow_table' => '[18, 19, 20, 21]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 7, "experiment_units": []}',
                'models' => '[3]',
                'dataset' => '[1, 2, 3, 4, 5, 6]',
                'datamodel' => '[1]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 23:16:52',
                'updated_at' => '2022-03-11 23:16:52',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'test',
                'experiment_id' => 21,
                'process_flow_table' => '[22, 23, 24, 25]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 8, "experiment_units": [5, 6]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 7,
                'updated_by' => 7,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 08:26:36',
                'updated_at' => '2022-03-15 08:28:20',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'sample',
                'experiment_id' => 19,
                'process_flow_table' => '[]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": "", "experiment_units": []}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'inactive',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-16 01:30:36',
                'updated_at' => '2022-03-16 01:30:36',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Test Variation',
                'experiment_id' => 23,
                'process_flow_table' => '[26, 27, 28, 29, 30, 31, 32]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 9, "experiment_units": [8]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-04-14 22:04:14',
                'updated_at' => '2022-04-15 18:31:13',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'sample',
                'experiment_id' => 24,
                'process_flow_table' => '[33, 34, 35]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 10, "experiment_units": [9]}',
                'models' => '[]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-15 18:28:21',
                'updated_at' => '2022-04-15 18:36:36',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'var1',
                'experiment_id' => 26,
                'process_flow_table' => '[36, 37]',
                'process_flow_chart' => NULL,
                'unit_specification' => '{"master_units": 11, "experiment_units": [10]}',
                'models' => '[1]',
                'dataset' => '[]',
                'datamodel' => '[]',
                'notes' => NULL,
                'description' => NULL,
                'note_urls' => NULL,
                'status' => 'active',
                'prev_status' => 'inactive',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 11:39:34',
                'updated_at' => '2022-04-28 16:28:19',
            ),
        ));
        
        
    }
}