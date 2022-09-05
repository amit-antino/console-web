<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryListsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category_lists')->delete();
        
        \DB::table('category_lists')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 21,
                'category_name' => 'test category',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-15 15:21:52',
                'created_at' => '2022-04-14 23:17:58',
                'updated_at' => '2022-04-15 15:21:52',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 21,
                'category_name' => 'test category_123',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-14 23:19:47',
                'created_at' => '2022-04-14 23:19:24',
                'updated_at' => '2022-04-14 23:19:47',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 21,
                'category_name' => 'category123',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-15 15:22:03',
                'updated_at' => '2022-04-15 15:22:09',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 21,
                'category_name' => 'fgrtf',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => '2022-04-27 16:02:28',
                'created_at' => '2022-04-27 16:02:05',
                'updated_at' => '2022-04-27 16:02:28',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 21,
                'category_name' => 'bfgfg',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => '2022-04-27 16:02:28',
                'created_at' => '2022-04-27 16:02:11',
                'updated_at' => '2022-04-27 16:02:28',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 21,
                'category_name' => 'dedsfd',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 16:03:53',
                'updated_at' => '2022-04-27 16:03:53',
            ),
            6 => 
            array (
                'id' => 7,
                'tenant_id' => 21,
                'category_name' => 'vfdvfd',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 16:03:58',
                'updated_at' => '2022-04-27 16:03:58',
            ),
        ));
        
        
    }
}