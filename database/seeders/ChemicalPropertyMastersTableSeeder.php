<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChemicalPropertyMastersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('chemical_property_masters')->delete();
        
        \DB::table('chemical_property_masters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'property_name' => 'Primary Information',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 10:53:18',
                'updated_at' => '2021-12-02 10:53:18',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
                'property_name' => 'Composition / Associated Chemicals',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 10:53:18',
                'updated_at' => '2021-12-02 10:53:18',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 0,
                'property_name' => 'Physio-Chemical Properties',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 10:53:18',
                'updated_at' => '2021-12-02 10:53:18',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 0,
                'property_name' => 'Commercial Information',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 10:53:18',
                'updated_at' => '2021-12-02 10:53:18',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 0,
                'property_name' => 'Hazard / Material Safety Data Sheets',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 10:53:18',
                'updated_at' => '2021-12-02 10:53:18',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 0,
                'property_name' => 'Sustainability Information',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 10:53:18',
                'updated_at' => '2021-12-02 10:53:18',
            ),
            6 => 
            array (
                'id' => 7,
                'tenant_id' => 0,
                'property_name' => 'Applications / Benefits',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 10:53:18',
                'updated_at' => '2021-12-02 10:53:18',
            ),
            7 => 
            array (
                'id' => 8,
                'tenant_id' => 0,
                'property_name' => 'Production Information',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 10:53:18',
                'updated_at' => '2021-12-02 10:53:18',
            ),
            8 => 
            array (
                'id' => 9,
                'tenant_id' => 0,
                'property_name' => 'Notes / Files',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 10:53:18',
                'updated_at' => '2021-12-02 10:53:18',
            ),
        ));
        
        
    }
}