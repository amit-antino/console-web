<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProcessCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('process_categories')->delete();
        
        \DB::table('process_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 0,
                'name' => 'Published Lab',
                'description' => 'This is Published Lab',
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
                'name' => 'Internal Lab',
                'description' => 'This Internal Lab',
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
                'name' => 'Conceptual',
                'description' => '',
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
                'name' => 'Optimized',
                'description' => '',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-12-02 01:53:19',
                'updated_at' => '2021-12-02 01:53:19',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 0,
                'name' => 'Stoichiometric',
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