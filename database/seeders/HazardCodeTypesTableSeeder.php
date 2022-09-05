<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HazardCodeTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hazard_code_types')->delete();
        
        \DB::table('hazard_code_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'EU Hazard Statements',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-14 23:32:38',
                'updated_at' => '2020-10-15 02:54:17',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Safe Work Australia Hazard Statements',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-14 23:32:46',
                'updated_at' => '2020-10-15 02:54:56',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Precautionary Statements',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:55:19',
                'updated_at' => '2020-10-15 02:55:19',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'GHS Hazard Statements',
                'description' => NULL,
                'created_by' => 0,
                'updated_by' => 0,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2020-10-15 02:55:58',
                'updated_at' => '2020-10-15 02:55:58',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'R-Codes',
                'description' => 'R-Codes',
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-03-17 21:38:26',
                'updated_at' => '2021-03-17 21:38:26',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'NFPA Reactivity',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-03-17 23:07:00',
                'updated_at' => '2021-03-17 23:07:00',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'WGK substance Class',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-03-22 22:55:38',
                'updated_at' => '2021-03-22 22:55:38',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'GK Code',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-03-22 22:55:59',
                'updated_at' => '2021-03-22 22:55:59',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'NFPA flammability',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-03-22 23:17:42',
                'updated_at' => '2021-03-22 23:17:42',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'NFPA health',
                'description' => 'NFPA health',
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-03-22 23:18:00',
                'updated_at' => '2021-03-22 23:18:00',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'GHS Code',
                'description' => 'GHS Code',
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-03-23 01:09:02',
                'updated_at' => '2021-03-23 01:09:02',
            ),
        ));
        
        
    }
}