<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CriteriaMastersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('criteria_masters')->delete();

        \DB::table('criteria_masters')->insert(array(
            0 =>
            array(
                'id' => 1,
                'tenant_id' => 21,
                'name' => 'Fixed Value',
                'symbol' => 'Fixed Value',
                'is_range_type' => 'false',
                'description' => 'Fixed Value',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-03-05 23:38:49',
                'updated_at' => '2021-03-05 23:54:14',
            ),
            1 =>
            array(
                'id' => 2,
                'tenant_id' => 21,
                'name' => 'Less Than (<)',
                'symbol' => '<',
                'is_range_type' => 'false',
                'description' => 'Less Than (<)',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-03-05 23:39:31',
                'updated_at' => '2021-03-05 23:54:45',
            ),
            2 =>
            array(
                'id' => 3,
                'tenant_id' => 21,
                'name' => 'Greater Than (>)',
                'symbol' => '>',
                'is_range_type' => 'false',
                'description' => 'Greater Than (>)',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-03-05 23:55:03',
                'updated_at' => '2021-03-05 23:55:03',
            ),
            3 =>
            array(
                'id' => 4,
                'tenant_id' => 21,
                'name' => 'Range',
                'symbol' => 'Range',
                'is_range_type' => 'true',
                'description' => 'Range',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2021-03-05 23:55:16',
                'updated_at' => '2021-03-05 23:55:16',
            )
        ));
    }
}
