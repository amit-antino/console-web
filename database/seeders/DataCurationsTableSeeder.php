<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataCurationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_curations')->delete();
        
        
        
    }
}