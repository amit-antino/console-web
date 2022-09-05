<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HazardCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hazard_categories')->delete();
        
        \DB::table('hazard_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Category 1',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Category 2',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Category 3',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Category 4',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Type A',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Type B',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Type C',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Type D',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Type E',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Type F',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Type G',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Div 1.1',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Div 1.2',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Div 1.3',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Div 1.4',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Div 1.5',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Div 1.6',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => '1A',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => '1B',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => '1C',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Additional category',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => '2A',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => '2B',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Compressed gas',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Liquefied gas',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Dissolved gas',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Refrigerated liquefied gas',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Unstable Explosive',
                'description' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-16 21:17:58',
                'updated_at' => '2021-02-16 21:17:58',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Chemically unstable gas A',
                'description' => 'Chemically unstable gas A',
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 00:36:10',
                'updated_at' => '2021-02-17 00:36:10',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Pyrophoric gas',
                'description' => 'Pyrophoric gas',
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 01:24:37',
                'updated_at' => '2021-02-17 01:24:37',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Category 5',
                'description' => 'Category 5',
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 03:06:14',
                'updated_at' => '2021-02-17 03:06:14',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Category 2A',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 08:52:55',
                'updated_at' => '2021-02-17 08:52:55',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Category 2B',
                'description' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2021-02-17 08:55:24',
                'updated_at' => '2021-02-17 08:55:24',
            ),
        ));
        
        
    }
}