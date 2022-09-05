<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChemicalClassificationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('chemical_classifications')->delete();
        
        \DB::table('chemical_classifications')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
            'name' => 'Compound (Pure Chemical)',
            'description' => 'Compound (Pure Chemical)',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 03:53:18',
                'updated_at' => '2021-12-02 03:53:18',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 0,
            'name' => 'Commercial (Mixed Chemical)',
            'description' => 'Commercial (Mixed Chemical)',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 03:53:18',
                'updated_at' => '2021-12-02 03:53:18',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 0,
            'name' => 'Simulated (Mixed Chemical)',
            'description' => 'Simulated (Mixed Chemical)',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 03:53:18',
                'updated_at' => '2021-12-02 03:53:18',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 0,
            'name' => 'Generic (Mixed/Pure Chemical)',
            'description' => 'Generic (Mixed/Pure Chemical)',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 03:53:18',
                'updated_at' => '2021-12-02 03:53:18',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 0,
                'name' => 'Other',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 03:53:18',
                'updated_at' => '2021-12-02 03:53:18',
            ),
        ));
        
        
    }
}