<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TenantMasterPlansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tenant_master_plans')->delete();
        
        \DB::table('tenant_master_plans')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '15 Days Trail',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:17',
                'updated_at' => '2021-12-02 05:23:17',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '30 Days Trail',
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
                'name' => 'Monthly Subscription',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:17',
                'updated_at' => '2021-12-02 05:23:17',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Yearly Subscription',
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
                'name' => 'Simreka Demo',
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