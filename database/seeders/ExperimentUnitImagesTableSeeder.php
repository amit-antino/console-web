<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExperimentUnitImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('experiment_unit_images')->delete();
        
        \DB::table('experiment_unit_images')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 6,
                'name' => 'test_image',
            'image' => 'assets/uploads/experiment_base_unit/Screenshot (2).png',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 70,
                'updated_by' => 70,
                'deleted_at' => NULL,
                'created_at' => '2022-02-01 02:45:42',
                'updated_at' => '2022-02-01 02:45:42',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 1,
                'name' => 'test',
                'image' => 'assets/uploads/experiment_base_unit/a color.png',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-02-16 03:29:30',
                'updated_at' => '2022-03-11 20:42:39',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 10,
                'name' => 'Test unit',
                'image' => 'assets/uploads/experiment_base_unit/image.jpeg',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-03 21:07:29',
                'created_at' => '2022-03-03 03:46:28',
                'updated_at' => '2022-03-03 21:07:29',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 10,
                'name' => 'Test_unit_1',
                'image' => 'assets/uploads/experiment_base_unit/image1.jpeg',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-03 04:23:52',
                'updated_at' => '2022-03-04 03:45:05',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 10,
                'name' => 'Tes_unit_2',
                'image' => 'assets/uploads/experiment_base_unit/image.jpeg',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-03 20:51:32',
                'updated_at' => '2022-03-09 22:01:21',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 10,
                'name' => 'Test_unit_4',
                'image' => 'assets/uploads/experiment_base_unit/image1.jpeg',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-09 22:04:06',
                'created_at' => '2022-03-03 21:04:36',
                'updated_at' => '2022-03-09 22:04:06',
            ),
            6 => 
            array (
                'id' => 7,
                'tenant_id' => 10,
                'name' => '1234____',
                'image' => 'assets/uploads/experiment_base_unit/image.jpeg',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-09 22:04:00',
                'created_at' => '2022-03-04 03:29:03',
                'updated_at' => '2022-03-09 22:04:00',
            ),
            7 => 
            array (
                'id' => 8,
                'tenant_id' => 10,
                'name' => '!@#',
                'image' => 'assets/uploads/experiment_base_unit/image1.jpeg',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-09 22:15:01',
                'created_at' => '2022-03-09 22:12:27',
                'updated_at' => '2022-03-09 22:15:01',
            ),
            8 => 
            array (
                'id' => 9,
                'tenant_id' => 10,
                'name' => 'Demo image',
                'image' => 'assets/uploads/experiment_base_unit/image1.jpeg',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-10 05:03:24',
                'updated_at' => '2022-03-10 05:03:24',
            ),
            9 => 
            array (
                'id' => 10,
                'tenant_id' => 1,
                'name' => 'Demo',
                'image' => 'assets/uploads/experiment_base_unit/image.jpeg',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-11 20:42:33',
                'updated_at' => '2022-03-14 20:34:25',
            ),
            10 => 
            array (
                'id' => 11,
                'tenant_id' => 1,
                'name' => 'test unit image',
                'image' => 'assets/uploads/experiment_base_unit/image.jpeg',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-12 00:06:32',
                'updated_at' => '2022-03-12 00:06:32',
            ),
            11 => 
            array (
                'id' => 12,
                'tenant_id' => 1,
                'name' => 'Demo unit image',
                'image' => 'assets/uploads/experiment_base_unit/image.jpeg',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-17 01:19:50',
                'created_at' => '2022-03-17 01:19:28',
                'updated_at' => '2022-03-17 01:19:50',
            ),
            12 => 
            array (
                'id' => 13,
                'tenant_id' => 21,
                'name' => 'unit image_123',
                'image' => 'assets/uploads/experiment_base_unit/1mb image.jpeg',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-14 23:42:29',
                'created_at' => '2022-04-14 23:28:02',
                'updated_at' => '2022-04-14 23:42:29',
            ),
            13 => 
            array (
                'id' => 14,
                'tenant_id' => 21,
                'name' => 'unit_image',
                'image' => 'assets/uploads/experiment_base_unit/1mb image.jpeg',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-14 23:42:44',
                'updated_at' => '2022-04-14 23:42:44',
            ),
            14 => 
            array (
                'id' => 15,
                'tenant_id' => 21,
                'name' => 'ssds',
                'image' => 'assets/uploads/experiment_base_unit/1mb image.jpeg',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-15 17:01:26',
                'created_at' => '2022-04-15 17:00:59',
                'updated_at' => '2022-04-15 17:01:26',
            ),
            15 => 
            array (
                'id' => 16,
                'tenant_id' => 21,
                'name' => 'www',
                'image' => 'assets/uploads/experiment_base_unit/1mb image.jpeg',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-15 17:01:26',
                'created_at' => '2022-04-15 17:01:11',
                'updated_at' => '2022-04-15 17:01:26',
            ),
            16 => 
            array (
                'id' => 17,
                'tenant_id' => 21,
                'name' => 'unit_image_two',
                'image' => 'assets/uploads/experiment_base_unit/1mb image.jpeg',
                'description' => NULL,
                'status' => 'inactive',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-15 20:26:15',
                'created_at' => '2022-04-15 20:25:54',
                'updated_at' => '2022-04-15 20:26:15',
            ),
            17 => 
            array (
                'id' => 18,
                'tenant_id' => 21,
                'name' => 'sfed',
                'image' => 'assets/uploads/experiment_base_unit/Screenshot from 2022-04-26 12-01-45.png',
                'description' => NULL,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 15:42:10',
                'updated_at' => '2022-04-27 16:11:25',
            ),
        ));
        
        
    }
}