<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HazardSubCodeTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hazard_sub_code_types')->delete();
        
        \DB::table('hazard_sub_code_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code_type_id' => 4,
                'name' => 'Combined H-Codes',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:59:32',
                'updated_at' => '2020-10-15 02:59:32',
            ),
            1 => 
            array (
                'id' => 2,
                'code_type_id' => 3,
                'name' => 'General Precautionary Statements',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:59:53',
                'updated_at' => '2020-10-15 02:59:53',
            ),
            2 => 
            array (
                'id' => 3,
                'code_type_id' => 3,
                'name' => 'Prevention Precautionary Statements',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 03:00:06',
                'updated_at' => '2020-10-15 03:00:06',
            ),
            3 => 
            array (
                'id' => 4,
                'code_type_id' => 3,
                'name' => 'Response Precautionary Statements',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 03:00:21',
                'updated_at' => '2020-10-15 03:00:21',
            ),
            4 => 
            array (
                'id' => 5,
                'code_type_id' => 3,
                'name' => 'Storage Precautionary Statements',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 03:00:41',
                'updated_at' => '2020-10-15 03:00:41',
            ),
            5 => 
            array (
                'id' => 6,
                'code_type_id' => 3,
                'name' => 'Disposal Precautionary Statements',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 03:00:57',
                'updated_at' => '2020-10-15 03:00:57',
            ),
            6 => 
            array (
                'id' => 7,
                'code_type_id' => 5,
                'name' => 'Combined R-Codes',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-03-17 22:45:50',
                'updated_at' => '2021-03-17 22:45:50',
            ),
        ));
        
        
    }
}