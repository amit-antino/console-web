<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProcessStatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('process_statuses')->delete();
        
        \DB::table('process_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'name' => 'Data Report',
                'description' => 'Data Report',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
                'name' => 'Data Input',
                'description' => 'Data Input',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 0,
                'name' => 'Data Verification',
                'description' => 'Data Verification',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 0,
                'name' => 'Data Iteration',
                'description' => 'Data Iteration',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
        ));
        
        
    }
}