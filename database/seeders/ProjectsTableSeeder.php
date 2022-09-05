<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('projects')->delete();
        
        \DB::table('projects')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tenant_id' => 6,
                'name' => 'test_project',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": null, "state": null, "country": "", "location": "", "geo_cordinate": null}',
                'users' => '[41]',
                'status' => 'active',
                'created_by' => 70,
                'updated_by' => 70,
                'deleted_at' => NULL,
                'created_at' => '2022-02-01 02:50:26',
                'updated_at' => '2022-02-01 02:50:26',
            ),
            1 => 
            array (
                'id' => 2,
                'tenant_id' => 5,
                'name' => 'h2pro',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": null, "state": null, "country": "", "location": "", "geo_cordinate": null}',
                'users' => '[60, 51, 50]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-02-08 03:25:32',
                'updated_at' => '2022-02-08 03:25:32',
            ),
            2 => 
            array (
                'id' => 3,
                'tenant_id' => 1,
                'name' => 'Test Project',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": "Bengaluru", "state": "Karnataka", "country": 101, "location": 2, "geo_cordinate": "560078"}',
                'users' => '[61]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-02-16 02:33:29',
                'updated_at' => '2022-02-16 02:45:50',
            ),
            3 => 
            array (
                'id' => 4,
                'tenant_id' => 10,
                'name' => 'Test project',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": null, "state": null, "country": "", "location": "", "geo_cordinate": null}',
                'users' => '[74]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-03 03:56:30',
                'updated_at' => '2022-03-08 23:44:01',
            ),
            4 => 
            array (
                'id' => 5,
                'tenant_id' => 10,
                'name' => 'project test',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": null, "state": null, "country": "", "location": "", "geo_cordinate": null}',
                'users' => '[74]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-08 23:24:39',
                'created_at' => '2022-03-03 04:34:12',
                'updated_at' => '2022-03-08 23:24:39',
            ),
            5 => 
            array (
                'id' => 6,
                'tenant_id' => 10,
                'name' => 'test project 3',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": null, "state": null, "country": "", "location": "", "geo_cordinate": null}',
                'users' => '[74]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => '2022-03-08 23:24:39',
                'created_at' => '2022-03-04 00:03:09',
                'updated_at' => '2022-03-08 23:24:39',
            ),
            6 => 
            array (
                'id' => 7,
                'tenant_id' => 10,
                'name' => 'Demo project',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": "Bangalore", "state": "karnataka", "country": 101, "location": 4, "geo_cordinate": "560078"}',
                'users' => '[74]',
                'status' => 'active',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 23:30:07',
                'updated_at' => '2022-03-08 23:44:25',
            ),
            7 => 
            array (
                'id' => 8,
                'tenant_id' => 10,
                'name' => 'Demo project',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": null, "state": null, "country": "", "location": "", "geo_cordinate": null}',
                'users' => '[74]',
                'status' => 'inactive',
                'created_by' => 27,
                'updated_by' => 27,
                'deleted_at' => NULL,
                'created_at' => '2022-03-08 23:32:10',
                'updated_at' => '2022-03-08 23:44:16',
            ),
            8 => 
            array (
                'id' => 9,
                'tenant_id' => 21,
                'name' => 'Test_project',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": null, "state": null, "country": "", "location": "", "geo_cordinate": null}',
                'users' => '[30]',
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-14 22:03:04',
                'updated_at' => '2022-04-15 20:36:13',
            ),
            9 => 
            array (
                'id' => 10,
                'tenant_id' => 21,
                'name' => 'demo-project_123',
                'description' => NULL,
                'tags' => NULL,
                'location' => '{"city": "Bangalore", "state": "karnataka", "country": 101, "location": 2, "geo_cordinate": "1234567890"}',
                'users' => '[30]',
                'status' => 'active',
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => NULL,
                'created_at' => '2022-04-15 20:35:27',
                'updated_at' => '2022-04-15 20:35:40',
            ),
        ));
        
        
    }
}