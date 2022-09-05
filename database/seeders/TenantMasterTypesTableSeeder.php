<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TenantMasterTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tenant_master_types')->delete();
        
        \DB::table('tenant_master_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'name' => 'Academic Institute',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:17',
                'updated_at' => '2022-01-13 03:43:59',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
                'name' => 'Commercial Entity',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:17',
                'updated_at' => '2021-12-02 05:23:17',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 0,
                'name' => 'Independent Consultant',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:17',
                'updated_at' => '2022-01-13 03:53:41',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 0,
                'name' => 'Non-Profit Organization',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:17',
                'updated_at' => '2021-12-02 05:23:17',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 0,
                'name' => 'Simreka Demo',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:17',
                'updated_at' => '2022-01-13 04:18:32',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 0,
                'name' => 'Research Organization',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:17',
                'updated_at' => '2021-12-02 05:23:17',
            ),
            6 => 
            array (
                'id' => 7,
                'tenant_id' => 0,
                'name' => 'Other',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:17',
                'updated_at' => '2021-12-02 05:23:17',
            ),
        ));
        
        
    }
}