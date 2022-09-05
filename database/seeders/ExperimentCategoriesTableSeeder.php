<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExperimentCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('experiment_categories')->delete();
        
        \DB::table('experiment_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 1,
                'name' => 'category 1',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-02-16 03:33:34',
                'updated_at' => '2022-02-16 03:33:34',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 10,
                'name' => 'demo category',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-10 00:00:22',
                'updated_at' => '2022-03-10 00:00:22',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 10,
                'name' => 'demo_category1',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-10 00:01:32',
                'created_at' => '2022-03-10 00:00:43',
                'updated_at' => '2022-03-10 00:01:32',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 10,
                'name' => 'demo category 3',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-10 00:01:16',
                'updated_at' => '2022-03-10 00:05:35',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 10,
                'name' => 'demo category 1',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-10 00:01:52',
                'updated_at' => '2022-03-10 00:05:32',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 21,
                'name' => 'test_category',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-15 20:21:11',
                'updated_at' => '2022-04-15 20:21:30',
            ),
            6 => 
            array (
                'id' => 7,
                'tenant_id' => 21,
                'name' => 'test_category_123',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-15 20:21:44',
                'updated_at' => '2022-04-15 20:22:13',
            ),
        ));
        
        
    }
}