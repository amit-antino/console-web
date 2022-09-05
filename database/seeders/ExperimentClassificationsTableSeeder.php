<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExperimentClassificationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('experiment_classifications')->delete();
        
        \DB::table('experiment_classifications')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 1,
                'name' => 'Classification1',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-02-16 03:33:12',
                'updated_at' => '2022-02-16 03:33:12',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 10,
                'name' => 'demo classification',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-09 23:59:15',
                'updated_at' => '2022-03-09 23:59:31',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 21,
                'name' => 'test_classification',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-14 23:49:35',
                'updated_at' => '2022-04-14 23:49:35',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 21,
                'name' => 'demo_classification',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-15 16:56:55',
                'created_at' => '2022-04-14 23:49:47',
                'updated_at' => '2022-04-15 16:56:55',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 21,
                'name' => 'sdsdsds',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-15 16:56:55',
                'created_at' => '2022-04-15 16:56:23',
                'updated_at' => '2022-04-15 16:56:55',
            ),
        ));
        
        
    }
}