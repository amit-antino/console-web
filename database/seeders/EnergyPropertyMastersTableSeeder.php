<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EnergyPropertyMastersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('energy_property_masters')->delete();
        
        \DB::table('energy_property_masters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'property_name' => 'Technical properties',
                'description' => 'Technical properties',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:33',
                'updated_at' => '2021-12-02 05:23:33',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
                'property_name' => 'Sustainability Information',
                'description' => 'Sustainability Information',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:33',
                'updated_at' => '2021-12-02 05:23:33',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 0,
                'property_name' => 'Commercial Information',
                'description' => 'Commercial Information',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:33',
                'updated_at' => '2021-12-02 05:23:33',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 0,
                'property_name' => 'Notes/Files',
                'description' => 'Notes/Files',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 05:23:33',
                'updated_at' => '2021-12-02 05:23:33',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 0,
                'property_name' => 'Electricity',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2021-12-23 00:37:25',
                'updated_at' => '2021-12-23 00:38:12',
            ),
        ));
        
        
    }
}