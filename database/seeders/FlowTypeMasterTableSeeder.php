<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FlowTypeMasterTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('flow_type_master')->delete();
        
        \DB::table('flow_type_master')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'flow_type_name' => 'Main Feed',
                'type' => '1',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
                'flow_type_name' => 'Auxiliary Feed',
                'type' => '1',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 0,
                'flow_type_name' => 'Main Product',
                'type' => '2',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 0,
                'flow_type_name' => 'Co-product',
                'type' => '2',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 0,
                'flow_type_name' => 'Waste',
                'type' => '2',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 0,
                'flow_type_name' => 'Recycle',
                'type' => '2',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            6 => 
            array (
                'id' => 7,
                'tenant_id' => 0,
                'flow_type_name' => 'Intermediate feed',
                'type' => '3',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            7 => 
            array (
                'id' => 8,
                'tenant_id' => 0,
                'flow_type_name' => 'Intermediate stream',
                'type' => '3',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            8 => 
            array (
                'id' => 9,
                'tenant_id' => 0,
                'flow_type_name' => 'Intermediate product',
                'type' => '3',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            9 => 
            array (
                'id' => 10,
                'tenant_id' => 0,
                'flow_type_name' => 'Heat stream',
                'type' => '4',
                'description' => 'energy flow mass',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
            10 => 
            array (
                'id' => 11,
                'tenant_id' => 0,
                'flow_type_name' => 'Work stream',
                'type' => '4',
                'description' => 'energy flow mass',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:19',
                'updated_at' => '2021-12-02 05:23:19',
            ),
        ));
        
        
    }
}