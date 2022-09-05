<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TenantUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('tenant_users')->delete();

        \DB::table('tenant_users')->insert(array());
    }
}
