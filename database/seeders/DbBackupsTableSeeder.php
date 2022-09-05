<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DbBackupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('db_backups')->delete();
        
        
        
    }
}