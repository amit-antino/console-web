<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChemicalCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('chemical_categories')->delete();
        
        \DB::table('chemical_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'name' => 'Company',
                'description' => '',
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
                'name' => 'Simreka',
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