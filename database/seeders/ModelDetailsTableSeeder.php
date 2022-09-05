<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModelDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_details')->delete();
        
        \DB::table('model_details')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'name' => 'ss',
                'version' => '1',
                'association' => '["undefined"]',
                'recommendations' => '["undefined"]',
                'list_of_models' => '["undefined"]',
                'assumptions' => '["undefined"]',
                'files' => '[]',
                'tags' => '["undefined"]',
                'process_experiment_id' => 26,
                'model_type' => 2,
                'configuration' => 0,
                'flag' => 0,
                'description' => NULL,
                'status' => 'requested',
                'operation_status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 11:43:08',
                'updated_at' => '2022-04-27 11:43:08',
            ),
        ));
        
        
    }
}