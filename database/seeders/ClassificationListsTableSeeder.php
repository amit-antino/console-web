<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClassificationListsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('classification_lists')->delete();
        
        \DB::table('classification_lists')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 21,
                'classification_name' => 'Test classification123',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-14 23:15:10',
                'created_at' => '2022-04-14 23:14:33',
                'updated_at' => '2022-04-14 23:15:10',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 21,
                'classification_name' => 'test',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-14 23:16:00',
                'created_at' => '2022-04-14 23:15:16',
                'updated_at' => '2022-04-14 23:16:00',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 21,
                'classification_name' => 'test',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-15 15:21:08',
                'created_at' => '2022-04-14 23:16:07',
                'updated_at' => '2022-04-15 15:21:08',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 21,
                'classification_name' => 'test',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-14 23:17:27',
                'created_at' => '2022-04-14 23:16:12',
                'updated_at' => '2022-04-14 23:17:27',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 21,
                'classification_name' => 'classification',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-15 15:21:19',
                'updated_at' => '2022-04-15 15:21:43',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 21,
                'classification_name' => 'dvdfgf',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => '2022-04-27 15:55:46',
                'created_at' => '2022-04-27 15:55:17',
                'updated_at' => '2022-04-27 15:55:46',
            ),
            6 => 
            array (
                'id' => 7,
                'tenant_id' => 21,
                'classification_name' => 'bfgbf',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => '2022-04-27 15:55:46',
                'created_at' => '2022-04-27 15:55:23',
                'updated_at' => '2022-04-27 15:55:46',
            ),
            7 => 
            array (
                'id' => 8,
                'tenant_id' => 21,
                'classification_name' => 'dscd',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 15:57:02',
                'updated_at' => '2022-04-27 15:57:02',
            ),
            8 => 
            array (
                'id' => 9,
                'tenant_id' => 21,
                'classification_name' => 'ecdc',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 15:57:07',
                'updated_at' => '2022-04-27 15:57:07',
            ),
        ));
        
        
    }
}