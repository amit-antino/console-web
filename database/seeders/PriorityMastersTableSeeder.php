<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PriorityMastersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('priority_masters')->delete();
        
        \DB::table('priority_masters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'name' => 'High',
                'description' => 'High',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-03-05 23:26:28',
                'updated_at' => '2021-03-05 23:55:56',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
                'name' => 'Medium',
                'description' => 'Medium',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-03-05 23:56:07',
                'updated_at' => '2021-03-05 23:56:07',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 0,
                'name' => 'Low',
                'description' => 'Low',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-03-05 23:56:25',
                'updated_at' => '2021-03-05 23:56:25',
            ),
            3 => 
            array (
                'id' => 5,
                'tenant_id' => 3,
                'name' => 'High',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2021-12-08 23:54:43',
                'updated_at' => '2021-12-09 01:03:54',
            ),
            4 => 
            array (
                'id' => 6,
                'tenant_id' => 5,
                'name' => 'High',
                'description' => 'High',
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-25 04:13:02',
                'updated_at' => '2021-12-25 04:13:02',
            ),
            5 => 
            array (
                'id' => 7,
                'tenant_id' => 5,
                'name' => 'Medium',
                'description' => 'Medium',
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-25 04:13:18',
                'updated_at' => '2021-12-25 04:13:18',
            ),
            6 => 
            array (
                'id' => 8,
                'tenant_id' => 5,
                'name' => 'Low',
                'description' => 'Low',
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-25 04:13:40',
                'updated_at' => '2021-12-25 04:13:40',
            ),
            7 => 
            array (
                'id' => 9,
                'tenant_id' => 6,
                'name' => 'High',
                'description' => 'High',
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-25 04:24:35',
                'updated_at' => '2021-12-25 04:24:35',
            ),
            8 => 
            array (
                'id' => 10,
                'tenant_id' => 6,
                'name' => 'Medium',
                'description' => 'Medium',
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-25 04:24:48',
                'updated_at' => '2021-12-25 04:24:48',
            ),
            9 => 
            array (
                'id' => 11,
                'tenant_id' => 6,
                'name' => 'Low',
                'description' => 'Low',
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-25 04:24:59',
                'updated_at' => '2021-12-25 04:24:59',
            ),
            10 => 
            array (
                'id' => 13,
                'tenant_id' => 21,
                'name' => 'priority_test',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-14 23:47:19',
                'updated_at' => '2022-04-15 20:25:11',
            ),
        ));
        
        
    }
}