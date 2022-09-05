<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProcessTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('process_types')->delete();
        
        \DB::table('process_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'name' => 'Bio Based',
                'description' => '',
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
                'name' => 'Fossil Based',
                'description' => '',
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
                'name' => 'Mixed',
                'description' => '',
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